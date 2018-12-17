<?php

namespace App\Console\Commands;

use App\Http\Services\DelcampeService;
use Illuminate\Console\Command;

class ListDelcampeFixedPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delcampe:fixedprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all fixed price in a csv file';
    /**
     * @var DelcampeService
     */
    private $delcampeService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DelcampeService $delcampeService)
    {
        parent::__construct();
        $this->delcampeService = $delcampeService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->delcampeService->getFixedPrice();
    }
}
