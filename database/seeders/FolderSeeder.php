<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Folder;

class FolderSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = config('filemanager.base_path');
        $baseTrashPath = config('filemanager.base_trash_path');
        $sizes = config('filemanager.sizes');

        $folders = [
            ['id' => 1, 'name' => '.tmp'],
            ['id' => 2, 'name' => 'trash'],
            ['id' => 3, 'name' => 'Documents'],
            ['id' => 4, 'name' => 'Images'],
        ];

        foreach ($folders as $folder) {
            Folder::updateOrCreate(['id' => $folder['id']], [
                'name' => $folder['name'],
            ]);
        }

        if (!Storage::exists($basePath)) {
            Storage::disk('public')->makeDirectory($basePath);
        }

        if (!Storage::exists($baseTrashPath)) {
            Storage::disk('public')->makeDirectory($baseTrashPath);
        }

        foreach ($sizes as $folderName) {
            $path = "$basePath/$folderName";
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
        }
    }
}
