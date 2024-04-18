<?php

namespace will2therich\LaravelModelAnonymizer\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'model-anonymizer:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install anonymization boilerplate';

    /**
     * The Composer instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The Composer instance.
     *
     * @var Composer
     */
    protected $composer;

    /**
     * Constructor.
     *
     * @param Filesystem $files
     * @param Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    public function handle()
    {
        $dir = app_path('Anonymize');

        $this->createDirectory($dir);
        $this->composer->dumpAutoloads();

        $this->info("Installation completed");
    }

    /**
     * Create directory for model anonymizers.
     *
     * @param string $dir
     */
    protected function createDirectory($dir)
    {
        if ($this->files->isDirectory($dir)) {
            $this->error("Directory {$dir} already exists");

            return;
        }

        $this->files->makeDirectory($dir);
    }

}