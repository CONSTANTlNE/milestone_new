<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Routing\Controller;

use App\Repositories\FileManager\FileManagerRepository;

use App\Http\Requests\FileManager\CreateFolder;

use App\Models\Folder;

use App\Models\File;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests\FileManager\CreateFile;

use App\Http\Requests\FileManager\UpdateFile;

use DB;



class FileManagerController extends Controller

{

  protected $fileManagerRepository;



  public function __construct(FileManagerRepository $fileManagerRepository){

    $this->fileManagerRepository = $fileManagerRepository;

  }



  public function index(Request $request){

    return $this->fileManagerRepository->index($request);

  }



  public function store(CreateFile $request){
    return $this->fileManagerRepository->store($request);

  }



  public function update(Request $request, File $file, UpdateFile $req){

    return $this->fileManagerRepository->update($file, $req);

  }



  public function destroy(Request $request){

    return $this->fileManagerRepository->deleteFile($request->id);

  }



  public function deleteFolder(Request $request)

  {

    return $this->fileManagerRepository->deleteFolder($request->folder);

  }



  public function createFolder(CreateFolder $request)

  {

    return $this->fileManagerRepository->createFolder($request);

  }



  public function nestable(){

    return $this->fileManagerRepository->nestable();

  }



  public function restoreFolder(Request $request){

    return $this->fileManagerRepository->restoreFolder($request->id);

  }



  public function restoreFile(Request $request){

    return $this->fileManagerRepository->restoreFile($request->id);

  }



  public function deleteFolderForever(Request $request){

    return $this->fileManagerRepository->deleteFolderForever($request->id);

  }



  public function deleteFileForever(Request $request){

    return $this->fileManagerRepository->deleteFileForever($request->id);

  }



  public function downloadOriginal(Request $request){

    return $this->fileManagerRepository->downloadOriginal($request->id);

  }



  public function removeWatermark(Request $request){

    return $this->fileManagerRepository->removeWatermark($request->id);

  }

}

