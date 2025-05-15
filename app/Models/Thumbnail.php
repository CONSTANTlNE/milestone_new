<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thumbnail extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  public $timestamps = false;

  protected $fillable = [
    'src', 'title', 'width', 'height'
  ];

  // public function sluggable()
  // {
  //   return [
  //     'slug' => [
  //       'source' => 'title'
  //     ]
  //   ];
  // }

  public function delete()
  {
    $path = public_path($this->src);
    $src = str_replace('storage/thumbnails/', 'storage/thumbnails/trash/', $this->src);
    $newPath = public_path($src);

    if (file_exists($path)){
      \File::move($path, $newPath);
    }

    return parent::delete();
  }

  public function restore()
  {
    $src = str_replace('storage/thumbnails/', 'storage/thumbnails/trash/', $this->src);
    $path = public_path($src);
    $newPath = public_path($this->src);

    if (file_exists($path)){
      \File::move($path, $newPath);
    }

    DB::table('thumbnails')->where('id', $this->id)->update([ 'deleted_at' => null ]);

    return true;
  }

  public function forceDelete()
  {
    $src = str_replace('storage/thumbnails/', 'storage/thumbnails/trash/', $this->src);
    $path = public_path($src);

    if (file_exists($path)){
      \File::delete($path);
    }

    DB::table('files')->where('id', $this->id)->delete();

    return true;
  }

  public function original()
  {
    return $this->belongsTo(File::class, 'file_id');
  }
}
