<?php

namespace kallbuloso\Packager\Commands;

use kallbuloso\Packager\Conveyor;
use kallbuloso\Packager\Wrapping;
use Illuminate\Console\Command;
use kallbuloso\Packager\ProgressBar;

/**
 * remove an existing package.
 *
 * @author JeroenG
 **/
class RemovePackage extends Command
{
    use ProgressBar;

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'packager:remove {vendor} {name}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Remove an existing package.';

    /**
     * Packages roll off of the conveyor.
     * @var object \kallbuloso\Packager\Conveyor
     */
    protected $conveyor;

    /**
     * Packages are packed in wrappings to personalise them.
     * @var object \kallbuloso\Packager\Wrapping
     */
    protected $wrapping;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Conveyor $conveyor, Wrapping $wrapping)
    {
        parent::__construct();
        $this->conveyor = $conveyor;
        $this->wrapping = $wrapping;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Start the progress bar
        $this->startProgressBar(4);

        // Defining vendor/package
        $this->conveyor->vendor($this->argument('vendor'));
        $this->conveyor->package($this->argument('name'));

        // Start removing the package
        $this->info('Removing package '.$this->conveyor->vendor().'\\'.$this->conveyor->package().'...');
        $this->makeProgress();

        // Composer dump-autoload to remove service provider
        $this->info('Dumping autoloads and undiscovering package...');
        $this->wrapping->removeFromComposer($this->conveyor->vendor(), $this->conveyor->package());
        $this->wrapping->removeFromProviders($this->conveyor->vendor(), $this->conveyor->package());

        $this->makeProgress();

        // Uninstall the package
        $this->info('Uninstalling package...');
        $this->conveyor->uninstallPackage();
        $this->makeProgress();

        // remove the package directory
        $this->info('Removing packages directory...');
        $this->conveyor->removeDir($this->conveyor->packagePath());
        $this->conveyor->dumpAutoloads();
        $this->makeProgress();

        // Remove the vendor directory, if agreed to
        // if ($this->confirm('Do you want to remove the vendor directory? [y|N]')) {
        //     $this->info('removing vendor directory...');
        //     $this->conveyor->removeDir($this->conveyor->vendorPath());
        // } else {
        //     $this->info('Continuing...');
        // }
        // $this->makeProgress();

        // Finished removing the package, end of the progress bar
        $this->finishProgress('Package removed successfully!');
    }
}
