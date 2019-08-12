<?php

namespace TimeHunter\LaravelDTOGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use TimeHunter\LaravelDTOGenerator\DTOGeneratorFactory;

class JsonToClassGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate DTO based on Array schema';

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
            DTOGeneratorFactory::generate(config('dto-generator.driver'));
            $this->info('Classes generated. Please check them.');
        } catch (\Exception $e) {
            Log::error($e);
            $this->warn('Error happens, please check log file.');
        }
    }
}
