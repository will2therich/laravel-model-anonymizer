<?php
namespace will2therich\LaravelModelAnonymizer\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class AnonymizeCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:model-anonymize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonymize the database models';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (env("APP_ENV") !== 'production') {
            $services = $this->getAllClassesInAnonymizeFolder();
            foreach ($services as $service) {
                $anonymizer = new $service;
                $this->info('Anonymizing ' . $anonymizer::$name);
                $modelClass = $anonymizer::$model;
                $allItems = $modelClass::all();

                $this->withProgressBar($allItems, function (Model $model) use ($anonymizer) {
                    $anonymizer->anonymize($model);
                });

                $this->info("\n Completed");
            }
        } else {
            $this->error('You cannot run this command on production');
        }

        return Command::SUCCESS;
    }

    /**
     * Get all classes in the 'app/Anonymize' directory
     *
     * @return array
     */
    function getAllClassesInAnonymizeFolder()
    {
        $namespace = 'App\\Anonymize\\';  // Adjust the namespace based on your actual namespace structure
        $interface = \Contracts\AnonymizeInterface::class;
        $dir = app_path('Anonymize');     // Path to the Anonymize folder within the app directory
        $classes = [];

        // Scan files in the directory
        foreach (File::allFiles($dir) as $file) {
            $filename = $file->getFilenameWithoutExtension();

            // Construct the full class name including namespace
            $class = $namespace . $filename;

            // Check if class exists and is a valid class
            if (class_exists($class)) {
                try {
                    $reflection = new ReflectionClass($class);
                    if ($reflection->isInstantiable() && $reflection->implementsInterface($interface)) {
                        $classes[] = $class;
                    }
                } catch (\ReflectionException $e) {
                    // Handle the exception if the class could not be reflected
                    continue;
                }
            }
        }

        return $classes;
    }

}
