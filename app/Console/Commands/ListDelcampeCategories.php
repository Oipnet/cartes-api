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
        $categories = $this->delcampeService->getCategories($this->option('parent') ?? 0);

        $categories->each(function($categorie) {
            $categ = Category::updateOrCreate([
                'id_category' => $categorie['id']
            ],[
                'id_site' => $categorie['id_site'] ?? null,
                'name' => $categorie['name'],
                'id_parent' => $categorie['id_parent'] ?? null,
                'child' => $categorie['child'] ?? false,
                'selectable' => $categorie['selectable'] ?? false,
            ]);

            if (! $categ->selectable) {
                Artisan::call('delcampe:categories', [
                    '--parent' => $categ->id_category
                ]);
            }
        });

        $categories = (new Categories(CategoryResource::whereNull('id_parent')->get()))->response();

        Cache::forever('categories', $categories);
    }
}