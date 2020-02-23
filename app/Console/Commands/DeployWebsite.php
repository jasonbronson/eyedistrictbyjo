<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DeployWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:website {seed=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads latest version of site.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $path = base_path();
        $commandToRun = "cd {$path};git pull";
        $this->info($commandToRun);
        $process = new Process($commandToRun);
        $process->run();
        $output = $process->getOutput();
        $this->info($output);

        //should we run the seed of the database?
        $seed = $this->argument('seed');
        if($seed == "true"){
            $process = new Process("cd {$path};php artisan migrate:refresh");
            $process->run();
            $output = $process->getOutput();
            $this->info($output);
        }
        
        //php artisan cache:clear
        $final = array("cache:clear", "route:clear", "view:clear", "queue:flush", "config:clear", "auth:clear-resets", "clear-compiled");
        foreach($final as $run){
            $process = new Process("cd {$path};php artisan {$run}");
            $process->run();
            $output = $process->getOutput();
            $this->info($output);
        }
        
    }
}
