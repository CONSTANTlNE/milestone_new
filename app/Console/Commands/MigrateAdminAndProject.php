<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAdminAndProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:project {project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $project = $this->argument('project');

        $path = "database/migrations/{$project}";

        if (!is_dir(base_path($path))) {
            $this->error("Migration folder for '{$project}' not found.");
            return 1;
        }

        $this->info("Running migrations for: {$project}");

        $this->call('migrate', [
            '--path' => $path,
        ]);
    }
}
