<?php

namespace Database\Seeders\Improved;

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

        try {
            if (!Storage::exists($basePath)) {
                Storage::disk('public')->makeDirectory($basePath);
            }
        } catch (\Throwable $e) {
            // Log or handle error
        }

        try {
            if (!Storage::exists($baseTrashPath)) {
                Storage::disk('public')->makeDirectory($baseTrashPath);
            }
        } catch (\Throwable $e) {
            // Log or handle error
        }

        foreach ($sizes as $folderName) {
            $path = "$basePath/$folderName";
            try {
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
            } catch (\Throwable $e) {
                // Log or handle error
            }
        }
    }
} 