<?php

namespace App\Repositories\FileManager;


use App\Http\Requests\FileManager\CreateFile;
use App\Http\Requests\FileManager\CreateFolder;
use App\Http\Requests\FileManager\UpdateFile;
use App\Models\File;
use App\Models\Folder;
use App\Models\Thumbnail;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\DB;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class FileManagerRepository extends BaseRepository {
  private $uploadBehaviour = 'default';

  public function index(Request $request) {
    if ($request->ajax()) {
      $user = \Auth::user();
      $type = $request->type;
      $folderId = $request->folderId;

      $breadcrumb = [
        (object)['name' => __("admin.all"), 'id' => 0]
      ];



      $folder = null;

      if ($folderId) {

        // If listing specific folder

        $folder = Folder::where('id', $folderId)->first();

        $isTrash = $folder->name == 'trash';



        if($isTrash) {

          $folders = Folder::onlyTrashed()->get();
          $files = File::onlyTrashed()->with('thumbnails')->orderBy('id', 'desc');

        } else {

          $folders = $folder->children;
          $files = $folder->files()->with('thumbnails');

        }



        if($type){

          $files = $files->where('type', $type);

        }

        $files = $files->orderBy('id', 'desc')->paginate(18);


        if($isTrash) {

          foreach($files as $file) {

            $file->src = str_replace('storage/files/', 'storage/files/trash/', $file->src);



            foreach($file->thumbnails as $thumbnail) {

              $thumbnail->src = str_replace('storage/thumbnails/', 'storage/thumbnails/trash/', $thumbnail->src);

            }

          }

        }



        if(config('filemanager.self_editor_roles')) {

          for($index = 0; $index < $files->count(); $index++) {

            if(!$files[$index]->isOwnedByUser($user)) {

              $files->splice($index, 1);

              $index--;

            }

          }



          for($index = 0; $index < $folders->count(); $index++) {

            if(!$folders[$index]->isOwnedByUser($user)) {

              $folders->splice($index, 1);

              $index--;

            }

          }

        }



        $breadcrumb = array_merge($breadcrumb, $folder->ancestors->toArray());

        $breadcrumb[] = $folder;



        //$folders = [];

        //$files = [];

      } else {

        // If listing root folder

        $folders = Folder::where('parent_id', null)->get();

        $files = [];

      }



      // Make last child active

      $last = end($breadcrumb);

      $last->active = true;



      $fileTypes = File::select('type')->groupBy('type')->get();

      return [

        'currentFolder' => $folder,

        'folders' => $folders,

        'files' => $files,

        'fileTypes' => $fileTypes,

        'breadcrumb' => $breadcrumb

      ];

    }



    // Load view without data, data will be loaded later by ajax

    return view('backend.fileManager.index');

  }



  public function store($request, $inputName = 'files') {
    $user = \Auth::user();



    $folder = null; // to return recently used folder

    $this->uploadBehaviour = $request->upload_behaviour;

    $uploadType = $request->upload_type;

    $folderId = $request->folder_id;

    $uploadedFiles = $request->file($inputName);



    if ($uploadType == 'video') {

      $videoType = $request->video_type;

      $videoId = $request->video_id;



      if ($videoType == 'youtube') {

        $API_KEY = config('filemanager.youtube_api_key');

        if(!$API_KEY) throw new \Exception("Please set up youtube_api_key in config/filemanager.php file");

        Youtube::setApiKey($API_KEY);



        $videoInfo = Youtube::getVideoInfo($videoId);

        $useRemoteImage = (!$uploadedFiles || !count($uploadedFiles));

        $imageSrc = null;

        $extension = null;



        if ($useRemoteImage) {

          $imageSrc = $videoInfo->snippet->thumbnails->high->url;

          $extension = [];

          preg_match('#\.(\w{3,4})$#', $imageSrc, $extension);

          if ($extension && $extension[1]) $extension = $extension[1];

          else $extension = 'jpg';

        } else {

          $type = $this->getFileType($uploadedFiles[0]->getMimeType());

          if ($type != 'image') throw new \Exception("Please upload image for thumbnail");

        }



        $file = new File([

          'src' => 'not-downloaded-yet',

          'title' => $videoInfo->snippet->title,

          'caption' => $videoInfo->snippet->description,

          'width' => $videoInfo->snippet->thumbnails->high->width,

          'height' => $videoInfo->snippet->thumbnails->high->height,

          'video_id' => $videoId,

          'type' => 'youtube',

          'extension' => 'youtube',

        ]);



        DB::transaction(function () use ($file, $imageSrc, $extension, $useRemoteImage, $uploadedFiles) {

          $file->save();



          if ($useRemoteImage) {

            $filePath = 'storage/files/' . $file->title . '.' . $extension;

            file_put_contents(public_path($filePath), file_get_contents($imageSrc));

            $file->src = $filePath;

          } else {

            $extension = strtolower($uploadedFiles[0]->getClientOriginalExtension());



            if ($extension != 'svg') {

              list($width, $height) = getimagesize($uploadedFiles[0]->getPathName());

              $file->width = $width;

              $file->height = $height;

            }



            $file->src = 'storage/' . $uploadedFiles[0]->storeAs('files', $file->title . '.' . $extension, ['disk' => 'public']);

          }

          $file->save();

        });



        $folder = $this->placeFileToFolder($file, $folderId, 'video');

        $fileIds = [ $file->id ];



        if(config('filemanager.self_editor_roles')) {

          $file->owners()->attach($user);

        }

      }

    } else {

      $uploadedFiles = $uploadedFiles ?: [];

      $result = $this->uploadFiles($uploadedFiles, $folderId);

      $folder = $result['folder'];

      $fileIds = $result['uploadedFileIds'];

    }
    return ['success' => true, 'folder' => $folder, 'fileIds' => $fileIds];
  }



  public function update(File $file, UpdateFile $request){

    $user = \Auth::user();

    if(config('filemanager.self_editor_roles')) {

      if(!$file->isOwnedByUser($user)) {

        return $file;

      }

    }



    $oldSlug = $file->slug;



    $file->fill([

      'title' => $request->title,

      'caption' => $request->caption,

    ]);



    $file->save();



    $cropData = json_decode($request->crop);

    if ($cropData && $cropData->width && $cropData->height && $cropData->x && $cropData->y) {

      $file->width = round($cropData->width);

      $file->height = round($cropData->height);



      $image = Image::make($file->src);

      $image->crop($file->width, $file->height, round($cropData->x), round($cropData->y));

      $image->save();



      $file->save();

    }



    if ($file->slug != $oldSlug) {

      $newSrc = 'storage/files/' . $file->slug . '.' . $file->extension;

      $origSrc = storage_path(str_replace('storage/', '', $file->src));

      if(file_exists($origSrc)) {

        \File::move($origSrc, storage_path(str_replace('storage/', '', $newSrc)));

      }

      \File::move(public_path($file->src), public_path($newSrc));

      $file->src = $newSrc;

      $file->save();

    }



    if(config('filemanager.response_cache_enabled')) {

      ResponseCache::clear();

    }



    return $file;

  }


    //destroyFile, deleteFileForever
    public function deleteFile($fileID) {
        $user = \Auth::user();
        $file = File::findOrFail($fileID);
        
        if(config('filemanager.self_editor_roles') && $user->can(Right::SELF_EDITOR)) {
            if(!$file->isOwnedByUser($user)) {
                return ['deleted' => false];
            }
        }
        
        $folderID = $file->folders()->first()->id;
        return ['deleted' => $file->deleteFiles(), 'folderId' => $folderID];
    }
    
    public function deleteFileForever($id)
    {
        $file = File::withTrashed()->find($id);
        $folderTrashId = Folder::where('name','trash')->first();
        $user = \Auth::user();
        
        if(config('filemanager.self_editor_roles')) {
            if(!$file->isOwnedByUser($user)) {
                return ['deleted' => false];
            }
        }
        
        if($file && $file->trashed()) {
            $fileSrc = str_replace('storage/files/', '', $file->src);
            $file->forceDelete();
        }
        
        return [ 'deleted' => true, 'folderId' => $folderTrashId->id];
    }
    
    //deleteFolder, deleteFolderForever
    public function deleteFolder($folderID)
    {
        $user = \Auth::user();
        $folder = Folder::findOrFail($folderID);
        
        if(config('filemanager.self_editor_roles')) {
            if(!$folder->isOwnedByUser($user)) {
                return ['deleted' => false, 'error' => 'This folder can be deleted only by it\'s owners'];
            }
        }

        if($folder->name == '.tmp' || $folder->name == 'trash') {
            return ['deleted' => false, 'error' => 'Unable to delete system folder'];
        }

        $files = $folder->files;
        $returnData = ['error' => 'Files is used', 'description' => '', 'deleteFolder' => true];

        foreach ($files as $file) {
            $destroyedFile = $this->deleteFile($file->id);
            if (isset($destroyedFile['error'])) {
                $returnData['deleteFolder'] = false;
                $returnData['description'] .= $destroyedFile['description'];
            }
        }
        
        if(config('filemanager.response_cache_enabled')) {
            ResponseCache::clear();
        }
        
        if ($returnData['deleteFolder']) {
            return ['deleted' => $folder->delete(), 'folderId' => $folder->parent_id];
        } else {
            return $returnData;
        }
    }
    
    public function deleteFolderForever($id)
    {
        $folder = Folder::withTrashed()->find($id);
        $folderTrashId = Folder::where('name','trash')->first();
        $user = \Auth::user();
        
        if(config('filemanager.self_editor_roles')) {
            if(!$folder->isOwnedByUser($user)) {
                return ['deleted' => false];
            }
        }
        
        if($folder && $folder->trashed()) {
            $folder->forceDelete();
        }
        
        return [ 'deleted' => true, 'folderId' => $folderTrashId->id ];
    }
    //restoreFile
    public function restoreFile($id)
    {
        $file = File::withTrashed()->find($id);
        $folderTrashId = Folder::where('name','trash')->first();
        $user = \Auth::user();
        if(config('filemanager.self_editor_roles')) {
            if(!$file->isOwnedByUser($user)) {
                return ['restored' => false];
            }
        }
        if($file && $file->trashed()) {
            $file->restore();
        }
        return [ 'restored' => $file, 'folderId' => $folderTrashId->id  ];
    }
    //restoreFolder
    public function restoreFolder($id)
    {
        $folder = Folder::withTrashed()->findOrFail($id);
        $folderTrashId = Folder::where('name','trash')->first();
        $user = \Auth::user();
        if(config('filemanager.self_editor_roles')) {
            if(!$folder->isOwnedByUser($user)) {
                return ['restored' => false];
            }
        }
        if($folder && $folder->trashed()) {
            $folder->restore();
        }
        if(config('filemanager.response_cache_enabled')) {
            ResponseCache::clear();
        }
        return [ 'restored' => $folder, 'folderId' => $folderTrashId->id  ];
    }

public function createFolder(CreateFolder $request)
    {
        // Retrieve the authenticated user
        $user = \Auth::user();

        // Extract folder ID and name from the request
        $folderId = $request->folderId;
        $name = $request->name;

        // Check if the folder name is reserved
        if ($name === '.tmp' || $name === 'trash') {
            return ['created' => false, 'error' => 'Unable to create folder with reserved name'];
        }

        // Check if the parent folder is "trash"
        if (!is_null($folderId)) {
            // Attempt to find the parent folder by ID
            $parentFolder = Folder::find($folderId);

            // If the parent folder exists and its name is "trash", return an error
            if ($parentFolder && $parentFolder->name === "trash") {
                return ['created' => false, 'error' => 'Cannot create folder in the trash folder'];
            }
        }

        // Create a new folder instance
        $folder = new Folder([
            'name' => $name,
            'parent_id' => $folderId
        ]);

        // Save the new folder
        $folder->save();

        // Return success response with the created folder
        return ['created' => true, 'folder' => $folder];
    }

public function nestable(){

    $data = $_POST['sortData'];



    foreach ($data as $key => $value) {

      $fields = explode('-',$value);

      $file_id = $fields[0];

      $fileable_id = $fields[1];



      \DB::table('fileables')->where('file_id', $file_id)->where('fileable_id',$fileable_id)->update(['ord' => $key]);

    }

  }











  public function downloadOriginal($id)

  {

    $file = File::withTrashed()->find($id);



    if(!$file) throw new \Exception("File not found");



    $user = \Auth::user();

    if(config('filemanager.self_editor_roles')) {

      if(!$file->isOwnedByUser($user)) {

        throw new \Exception("Unauthorised");

      }

    }



    $FILE_PATH = '';



    $path = str_replace('storage/', '', $file->src);

    $path = storage_path($path);

    if (file_exists($path)) {

      $FILE_PATH = $path;

    } else if($file->trashed()) {

      $path = str_replace('storage/files/', 'storage/files/trash/', $file->src);

      $path = public_path($path);

      if (file_exists($path)) $FILE_PATH = $path;

    } else {

      $path = public_path($file->src);

      if (file_exists($path)) $FILE_PATH = $path;

    }



    if(!$FILE_PATH) throw new \Exception("File not found");



    return Response::download($FILE_PATH);

  }



  public function removeWatermark($id)

  {

    $file = File::withTrashed()->find($id);



    $user = \Auth::user();

    if(config('filemanager.self_editor_roles')) {

      if(!$file->isOwnedByUser($user)) {

        throw new \Exception("Unauthorised");

      }

    }



    if(!$file) throw new \Exception("File not found");



    File::removeWatermark($file);



    return [ 'success' => true ];

  }



  private function placeFileToFolder($file, $folderId, $type)

  {

    if($this->uploadBehaviour == 'related') {

      // Uploads in specific folder or /.tmp

      if ($folderId) {

        $folder = Folder::find($folderId);

      } else {

        $folder = Folder::where('name', 'Images')->where('parent_id', null)->first();

      }



      // if specified folder doesn't exist or /.tmp doesn't exist

      if (!$folder) throw new \Exception($folderId ? "Specified folder not found" : ".tmp folder not found");

    } else {

      // Uploads in specific folder or /[file-type]

      if ($folderId) {

        $folder = Folder::find($folderId);

      } else {

        $folderNameByType = ucfirst($type) . 's';

        $folder = Folder::where('name', $folderNameByType)->where('parent_id', null)->first();

        if (!$folder) {

          $folder = new Folder([ 'name' => $folderNameByType ]);

          $folder->save();

        }

      }



      // if specified folder doesn't exist or unable to create new folder by type

      if (!$folder) throw new \Exception($folderId ? "Specified folder not found" : "Unable to create folder in root");

    }



    $folder->files()->attach($file);



    return $folder;

  }



  private function uploadFiles($files, $folderId)
  {
    $user = \Auth::user();
    $folder = null;
    $uploadedFileIds = [];
    foreach ($files as $uploadedFile) {
      if (!$uploadedFile->isValid()) throw new \Exception("File is not valid");
      $extension = strtolower($uploadedFile->getClientOriginalExtension());
      $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
      $originalName = str::slug($originalName);
      $originalName = mt_rand(0,200).'-'.$originalName;
      $type = $this->getFileType($uploadedFile->getMimeType());
      $width = null;
      $height = null;
      if ($type == 'image' && $extension != 'svg') {
        list($width, $height) = getimagesize($uploadedFile->getPathName());
      }
      $uuid =  Str::uuid()->toString();
      $file = new File([
        'uuid' => $uuid,
        'src' => 'not-uploaded-yet',
        'title' => $originalName,
        'width' => $width,
        'height' => $height,
        'type' => $type,
        'extension' => $extension
      ]);

      DB::transaction(function () use ($file, $uploadedFile, $uuid) {
        if ($file->type == 'image'){
          $webpEncoder = new WebpEncoder();
            $manager = new ImageManager(new GdDriver());
            $webpImage = $manager->read($uploadedFile)->encode($webpEncoder);

          $webpImagePath = 'storage/files/' . $uuid . '.webp';
          $webpImage->save(public_path($webpImagePath));
          //$this->createProgressiveThumbnails($uploadedFile, $webpEncoder, $uuid);
//          if ($file->width > 320 or $file->width > 140 ){
//              $file->thumbs = $this->createProgressiveThumbnails($uploadedFile, $webpEncoder, $file->title);
//          }
          $file->src = $webpImagePath;
          $file->extension = 'webp';
        }else{
          $file->src = 'storage/' . $uploadedFile->storeAs('files', $uuid . '.' . $file->extension, ['disk' => 'public']);
        }
        $file->save();
      });
      $uploadedFileIds[] = $file->id;

      if(config('filemanager.self_editor_roles')) {
        $file->owners()->attach($user);
      }

      $folder = $this->placeFileToFolder($file, $folderId, $type);
    }

    return [ 'folder' => $folder, 'uploadedFileIds' => $uploadedFileIds ];
  }


    public function createProgressiveThumbnails($filePath, $webpEncoder, $fileName): bool|string
    {
        $image = Image::read($filePath);

        $progressiveThumbnail1200 = $image->cover(1200, 630)->encode($webpEncoder, 100);
        $progThumbnail1200 = 'storage/files/1200x630/' . $fileName . '.webp';
        $progressiveThumbnail4Path = public_path($progThumbnail1200);
        $progressiveThumbnail1200->save($progressiveThumbnail4Path);

        $progressiveThumbnail737 = $image->cover(737, 401)->encode($webpEncoder, 100);
        $progThumbnail737 = 'storage/files/737x401/' . $fileName . '.webp';
        $progressiveThumbnail3Path = public_path($progThumbnail737);
        $progressiveThumbnail737->save($progressiveThumbnail3Path);

        $progressiveThumbnail320 = $image->cover(320, 180)->encode($webpEncoder, 100);
        $progThumbnail320 = 'storage/files/320x180/' . $fileName . '.webp';
        $progressiveThumbnail2Path = public_path($progThumbnail320);
        $progressiveThumbnail320->save($progressiveThumbnail2Path);

        $progressiveThumbnail145 = $image->cover(145, 97)->encode($webpEncoder, 100);
        $progThumbnail145 = 'storage/files/145x97/' . $fileName . '.webp';
        $progressiveThumbnail1Path = public_path($progThumbnail145);
        $progressiveThumbnail145->save($progressiveThumbnail1Path);

        // Return paths to the created thumbnails
        return json_encode([
            '145x97' => $progThumbnail145,
            '320x180' => $progThumbnail320,
            '737x401' => $progThumbnail737,
            '1200x630' => $progThumbnail1200,
        ]);
    }


  private function getFileType($fileType)

  {

    $types = [

      'image/jpeg' => 'image',

      'image/gif' => 'image',

      'image/png' => 'image',

      'image/tiff' => 'image',

      'image/webp' => 'image',

      'application/msword' => 'document',

      'application/vnd.ms-excel' => 'document',

      'application/pdf' => 'document',

      'text/plain' => 'document',

      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'document',

      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'document',

      'application/xml' => 'document',

      'application/zip' => 'archive',

      'application/x-rar' => 'archive',

    ];



    if (isset($types[$fileType])) {

      return $types[$fileType];

    } else {

      throw new \Exception("File type is not supported");

    }

  }

}
