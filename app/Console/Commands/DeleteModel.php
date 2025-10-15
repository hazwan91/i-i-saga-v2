<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteModel extends Command
{
    protected $signature = 'delete:model {name}';
    protected $description = 'Delete a model and its related files (factory, policy, migration, seeder)';

    public function handle()
    {
        $name = $this->argument('name');
        $modelPath = app_path("Models/{$name}.php");
        $factoryPath = base_path("database/factories/{$name}Factory.php");
        $policyPath = base_path("app/Policies/{$name}Policy.php");
        $seederPath = base_path("database/seeders/{$name}Seeder.php");

        // Find and delete the migration file
        $migrationFiles = glob(base_path("database/migrations/*_create_" . Str::snake(Str::plural($name)) . "_table.php"));

        $filesToDelete = [
            $modelPath,
            $factoryPath,
            $policyPath,
            $seederPath,
        ];

        $filesToDelete = array_merge($filesToDelete, $migrationFiles);

        foreach ($filesToDelete as $file) {
            if (File::exists($file)) {
                File::delete($file);
                $this->info("Deleted: {$file}");
            }
        }

        $this->info("✅ Model '{$name}' and its related files have been deleted.");
    }
}
