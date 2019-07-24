<?php

namespace TimeHunter\LaravelJsonToClassGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use TimeHunter\LaravelJsonToClassGenerator\JsonGeneratorFactory;
use TimeHunter\LaravelJsonToClassGenerator\Services\JsonToClassGenerator;

class JsonToClassGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:jsontoclass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate classes based on JSON';

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
        try {
            JsonGeneratorFactory::generate(config('jsontoclassgenerator.driver'));
            $this->info('Classes generated. Please check them.');
        } catch (\Exception $e) {
            Log::error($e);
            $this->warn('Error happens, please check log file.');
        }
    }
}
