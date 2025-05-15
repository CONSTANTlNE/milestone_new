<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class File extends Model
{
  use SoftDeletes;

    /**
     * @var mixed|string
     */
    public mixed $uuid;
    protected $dates = ['deleted_at'];
  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function __construct(array $attributes = array())
  {
    if(config('filemanager.localization')) {
      $this->localeSuffixed = [ 'caption' ];
    }

    parent::__construct($attributes);
  }

  protected $localeSuffixed = [];

  protected $fillable = [
    'src', 'title', 'width', 'height', 'type', 'extension', 'uuid', 'caption','video_link','video_id', 'metadata', 'thumbs'
  ];

    public function users()
  {
    return $this->morphToMany(User::class, 'fileable');
  }

  public function pages()
  {
    return $this->morphToMany(Page::class, 'fileable');
  }

  public function projects()
  {
    return $this->morphToMany(Project::class, 'fileable');
  }

  public function locales()
  {
    return $this->morphToMany(Locale::class, 'fileable');
  }

  public function folders()
  {
    return $this->morphToMany(Folder::class, 'folderable');
  }

  public function thumbnails()
  {
    return $this->hasMany(Thumbnail::class, 'file_id');
  }

  public function deleteFiles()
  {
    foreach($this->thumbnails as $thumbnail) {
      $thumbnail->delete();
    }

    $path = public_path($this->src);

    $src = str_replace('storage/files/', 'storage/files/trash/', $this->src);
    $newPath = public_path($src);

    if (file_exists($path)){
      \File::move($path, $newPath);
    }

    return parent::delete();
  }

  public function restore()
  {
    $thumbnails = $this->thumbnails()->withTrashed()->get();
    foreach($thumbnails as $thumbnail) {
      $thumbnail->restore();
    }

    $src = str_replace('storage/files/', 'storage/files/trash/', $this->src);
    $path = public_path($src);
    $newPath = public_path($this->src);

    if (file_exists($path)){
      \File::move($path, $newPath);
    }

    DB::table('files')->where('id', $this->id)->update([ 'deleted_at' => null ]);

    return true;
  }

  public function forceDelete()
  {
      if ($this->thumbs){
          $thumbs = json_decode($this->thumbs, true);
          foreach ($thumbs as $thumb) {
              if (file_exists(public_path($thumb))) \File::delete(public_path($thumb));
          }
      }

    $thumbnails = $this->thumbnails()->withTrashed()->get();
    foreach($thumbnails as $thumbnail) {
      $thumbnail->forceDelete();
    }

    $src = str_replace('storage/files/', 'storage/files/trash/', $this->src);
    $path = public_path($src);

    $src2 = str_replace('storage/', '', $this->src);
    $original = storage_path($src2);

    if (file_exists($path)) \File::delete($path);
    if (file_exists($original)) \File::delete($original);

    DB::table('files')->where('id', $this->id)->delete();

    return true;
  }

  public function render($styles = [], $class = false, $maxSize = 1920, $minSize = 360, $fullUrl = false) {
    $output = '';

    $allStyles = [];
    foreach($styles as $property => $value) {
      $allStyles[] = $property.':'.$value;
    }

    if($this->type == 'image') {
      $output .= '<picture'.($class ? ' class="'.$class.'"' : '').'>';
      $orig = null;

      if($maxSize >= 1920) { // Include original
        $this->thumbnails->prepend($this);
      }

      foreach($this->thumbnails as $k => $thumbnail) {
        if($thumbnail->width > $maxSize) continue;
        else if($thumbnail->width < $minSize) continue;
        else if($thumbnail->width == $maxSize) $orig = $thumbnail;

        $w = isset($this->thumbnails[$k + 1]) ? $this->thumbnails[$k + 1]->width : 1;
        $output .= '<source srcset="'.($fullUrl ? \URL::to('/').'/'.$thumbnail->src : $thumbnail->src).'" media="(min-width: ' . $w . 'px)">';
      }

      $imageSrc = $orig ? $orig->src : $this->src;
      $output .= '<img'.($allStyles ? ' style="'.implode(';', $allStyles).'"' : '').' src="'.($fullUrl ? \URL::to('/').'/'.$imageSrc : $imageSrc).'" alt="'.addslashes($this->title).'">';
      $output .= '</picture>';
    } else {
      $output .= '<a'.($class ? ' class="'.$class.'"' : '').($allStyles ? ' style="'.implode(';', $allStyles).'"' : '').' href="'.$this->src.'">'.$this->title.'</a>';
    }

    return $output;
  }

  public static function resizeTo1920($file) {
    if($file->type == 'image' && $file->extension != 'svg' && $file->src != 'not-uploaded-yet') {
      $size = 1920;
      if($file->width > $size) {
        $img = Image::read(public_path($file->src));
        $img->resize($size, null, function ($constraint) {
          $constraint->aspectRatio();
        });

        $img->save(public_path($file->src));
        ImageOptimizer::optimize($file->src);
      }
    }
  }

  public static function generateThumbnails($file, $uploadedFile) {
    $sizes = [ 1600, 1440, 1024, 768, 360 ];

    if($file->type == 'image' && $file->extension != 'svg' && $file->src != 'not-uploaded-yet') {

      if(!$file->thumbnails->count()) {
        foreach($sizes as $size) {
          if($size >= $file->width) continue;

          $thumbnail = new Thumbnail([ 'title' => $file->title, 'src' => 'not-resized-yet' ]);
          $thumbnail->original()->associate($file);
          $thumbnail->save();

          $Path = $file->title;

          $img = Image::make($uploadedFile->getRealPath());

          $img->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
          });

          $thumbnail->src = public_path('storage/thumbnails/'.$thumbnail->title.'.'.$file->extension);

          $img->save($thumbnail->src);

          //ImageOptimizer::optimize($thumbnail->src);
          $thumbnail->width = $img->width();
          $thumbnail->height = $img->height();
          $thumbnail->save();
        }
      } else {
        foreach($file->thumbnails as $thumbnail) {
          if($thumbnail->title != $file->title) {
            $thumbnail->title = $file->title;
            $thumbnail->save();
            $newSrc = 'storage/thumbnails/' . $thumbnail->title . '.' . $file->extension;
            \File::move(public_path($thumbnail->src), public_path($newSrc));
            $thumbnail->src = $newSrc;
            $thumbnail->save();
          }
        }
      }
    }
  }

  public static function addWatermarkOnOriginal($file, $watermark) {
    if($file->type == 'image' && $file->extension != 'svg' && $file->src != 'not-uploaded-yet') {
      $watermarkImg = Image::make(public_path($watermark));
      $originalImg = Image::make(public_path($file->src));

      $watermarkSize = round($originalImg->width() / 100 * 25);

      if($watermarkImg->width() > $watermarkSize) {
        $watermarkImg->resize($watermarkSize, null, function ($constraint) {
          $constraint->aspectRatio();
        });
      }

      if($watermarkSize >= 200) {
        $originalImg->insert($watermarkImg, 'bottom-right', 0, 0);
        $originalImg->save(public_path($file->src));
        ImageOptimizer::optimize($file->src);
      }
    }
  }

  public static function removeWatermark($file) {
    $path = str_replace('storage/', '', $file->src);
    $path = storage_path($path);
    if (file_exists($path)) {
      \File::copy($path, public_path($file->src));
      self::resizeTo1920($file);
      ImageOptimizer::optimize($file->src);
    }
  }

  public static function renderText($text, $forSummernote = false, $fullUrl = false) {
    $ms = [];

    if(preg_match_all('#<img.*?data-fm-association="(.*?)".*?>#', $text, $ms)) {
      $l = count($ms[0]);
      for($i = 0; $i < $l; $i++) {
        $img = $ms[0][$i];
        $fileId = $ms[1][$i];

        $file = File::find($fileId);
        if($file) {
          if($forSummernote) {
            $src_ms = [];
            if(preg_match('#src="(.*?)"#', $img, $src_ms)) {
              $replacement = str_replace($src_ms[0], 'src="'.$file->src.'"', $img);
              $text = str_replace($img, $replacement, $text);
            }
          } else {
            $styles = [];

            $style_ms = [];
            if(preg_match('#style="(.*?)"#', $img, $style_ms)) {
              $css = explode(';', $style_ms[1]);

              foreach($css as $cssItem) {
                $cssItem = trim($cssItem);
                if(!$cssItem) continue;
                $props = explode(':', $cssItem);

                if(count($props) == 2) {
                  $styles[trim($props[0])] = trim($props[1]);
                }
              }
            }

            $replacement = $file->render($styles, false, 1440, 360, $fullUrl);
            $text = str_replace($img, $replacement, $text);
          }
        }
      }
    }

    return $text;
  }

  public function owners()
  {
    return $this->morphToMany(User::class, 'ownable');
  }

  public function isOwnedByUser($user)
  {
    return $this->owners->pluck('id')->contains($user->id);
  }
}
