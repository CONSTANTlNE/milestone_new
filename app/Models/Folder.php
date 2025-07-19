<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class Folder extends Model
{
  use NodeTrait, SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name', 'parent_id'
  ];

  // public function destinations()
  // {
  //   return $this->morphedByMany(Destination::class, 'folderable');
  // }

  public function files(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(File::class, 'file_folder');
  }

  public function delete()
  {
    $folders = $this->children()->withTrashed()->get();
    $files = $this->files;

    foreach($folders as $folder) {
      if(!$folder->trashed()) $folder->delete();
    }

    foreach($files as $file) {
      if(!$file->trashed()) $file->deleteFiles();
    }

    return parent::delete();
  }

  public function forceDelete()
  {
    $folders = $this->children()->withTrashed()->get();
    $files = $this->files()->withTrashed()->get();

    foreach($folders as $folder) {
      $folder->forceDelete();
    }

    foreach($files as $file) {
      $file->forceDelete();
    }

    DB::table('folders')->where('id', $this->id)->delete();

    return true;
  }

    public function restore()
    {
        $folders = $this->children()->withTrashed()->get();
        $files = $this->files()->withTrashed()->get();

        if (!$folders->isEmpty()) {
            foreach ($folders as $folder) {
                if ($folder->trashed() && $folder->parent_id == $this->id) {
                    $folder->restore();
                }
            }
        }

        if (!$files->isEmpty()) {
            foreach ($files as $file) {
                 $file->restore();
            }
        }

        if ($folders->isEmpty()){
            $this->deleted_at = null;
            $this->save();

            return true;
        }else{
            // Finally, restore the parent folder
            return parent::restore();
        }
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
