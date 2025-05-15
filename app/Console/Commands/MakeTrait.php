<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait class';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $name = ucfirst($this->argument('name'));
        $traitNamespace = 'App\\Traits';

        $traitPath = app_path("Traits/{$name}Trait.php");

        // Create Traits directory if not exists
        if (!File::exists(app_path('Traits'))) {
            File::makeDirectory(app_path('Traits'), 0755, true);
        }

        // Generate Trait
        if (!File::exists($traitPath)) {
            File::put($traitPath, "<?php\n\nnamespace {$traitNamespace};\n\ntrait {$name}Trait\n{\n    // Define logic\n}\n");
            $this->info("Created: Traits/{$name}Trait.php");
        } else {
            $this->warn("Trait already exists: {$name}Trait.php");
        }

        $this->info("Trait created successfully!");
    }
}
