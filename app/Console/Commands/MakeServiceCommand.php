<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command as CommandAlias;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a service and its corresponding contract interface';

    public function handle(): int
    {
        $name = ucfirst($this->argument('name'));
        $contractNamespace = 'App\\Contracts';
        $serviceNamespace = 'App\\Services';

        $interfacePath = app_path("Contracts/{$name}Interface.php");
        $servicePath = app_path("Services/{$name}Service.php");

        // Create Contracts directory if not exists
        if (!File::exists(app_path('Contracts'))) {
            File::makeDirectory(app_path('Contracts'), 0755, true);
        }

        // Create Services directory if not exists
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        // Generate Interface
        if (!File::exists($interfacePath)) {
            File::put($interfacePath, "<?php\n\nnamespace {$contractNamespace};\n\ninterface {$name}Interface\n{\n    // Define methods\n}\n");
            $this->info("Created: Contracts/{$name}Interface.php");
        } else {
            $this->warn("Interface already exists: {$name}Interface.php");
        }

        // Generate Service
        if (!File::exists($servicePath)) {
            File::put($servicePath, "<?php\n\nnamespace {$serviceNamespace};\n\nuse {$contractNamespace}\\{$name}Interface;\n\nclass {$name}Service implements {$name}Interface\n{\n    // Implement methods\n}\n");
            $this->info("Created: Services/{$name}Service.php");
        } else {
            $this->warn("Service already exists: {$name}Service.php");
        }

        return CommandAlias::SUCCESS;
    }
}
