<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 19/12/18
 * Time: 16:22
 */

namespace App\Console\Commands;


use App\Category;
use App\Category as CategoryResource;
use App\Http\Resources\Categories;
use App\Http\Services\DelcampeService;
use App\Jobs\ProcessGetCategories;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class ListDelcampeCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delcampe:categories {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all categories';
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
        ProcessGetCategories::dispatch(null);
    }
}