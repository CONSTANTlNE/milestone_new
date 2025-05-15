<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisan;
use Exception;
use League\Flysystem\Adapter\Local;
use Log;
use Response;
use Storage;

class BackupController extends Controller
{
    public function index()
    {
        $this->data['backups'] = [];

        foreach(config('backup.backup.destination.disks') as $disk_name) {

            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $k => $f) {
                // only take the zip files into account
                if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                    $this->data['backups'][] = [
                        'file_path'     => $f,
                        'file_name'     => str_replace('backups/', '', $f),
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                    ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';
        	    	
        return view('dashboard.backup', $this->data);
    }

    public function create()
    {
        $message = 'success';

        try {
            ini_set('max_execution_time', 600);

            Log::info('BackupManager -- Called backup:run from admin interface');

            Artisan::call('backup:run --only-files');
            $output = Artisan::output();
            if (strpos($output, 'Backup failed because')) {
                preg_match('/Backup failed because(.*?)$/ms', $output, $match);
                $message = "BackupManager -- backup process failed because ";
                $message .= isset($match[1]) ? $match[1] : '';
                Log::error($message.PHP_EOL.$output);
            } else {
                Log::info("BackupManager -- backup process has started");
            }
        } catch (Exception $e) {
            Log::error($e);
            return Response::make($e->getMessage(), 500);
        }

        return $message;
    }

    /**
     * Downloads a backup zip file.
     */
    public function download(Request $request, $lang)
    {
        $disk = Storage::disk($request->disk);
        $file_name = $request->file_name;
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, trans('backup.backup_doesnt_exist'));
            }
        } else {
            abort(404, trans('backup.only_local_downloads_supported'));
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete(Request $request, $lang)
    {
        $disk = Storage::disk($request->disk);

        if ($disk->exists($request->file_name)) {
            $disk->delete($request->file_name);
            return 'success';
        } else {
            abort(404, trans('backup.backup_doesnt_exist'));
        }
    }
}