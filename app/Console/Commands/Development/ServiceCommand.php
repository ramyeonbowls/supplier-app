<?php

namespace App\Console\Commands\Development;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class for Development';

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
        $name       = $this->argument('name');
        $name_array = explode("/", str_replace('\\', '/', $name));

        $classname  = Arr::last($name_array);
        $namespace  = '';
        if(count($name_array) > 1) {
            $namespace  = '\\';
            for($i=0; $i < count($name_array); $i++) {
                if($name_array[$i] != $classname) {
                    $namespace .= $name_array[$i] .'\\';
                }
            }
            $namespace = substr($namespace, 0, -1);
        }

        // $this->info($namespace);
        // $this->info($classname);
        // exit();
    
        try {
            @mkdir(app_path('Services/'.$namespace), 0777, true);

            $fileContents  = "<?php\n\nnamespace App\Services".$namespace.";";
            $fileContents .= "\n\nclass ". $classname ." \n{\n\t//\n}";

            $file_path = file_exists(app_path('Services/'. $name .'.php'));
            if($file_path) {
                $this->error("Service already exists!");
            } else {
                file_put_contents(app_path('Services/'. $name .'.php'), $fileContents);
                $this->info("Service created successfully!");
            }
        } catch (\Throwable $th) {
            $this->error($th->getMessage() ."\n");

            if(config('app.env') != 'production') {
                $this->error($th->getTraceAsString() ."\n");
            }
        }
    }
}
