<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\CacheInterface;

class HomeController
{
    /**
     * @var Factory
     */
    private $view;


    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function __invoke()
    {
        $countItems = Item::all()->count();
        $countClosedItems = Item::isClosed()->count();

        $categories = Cache::get('categories');

        return $this->view->make('homepage', compact('countItems', 'countClosedItems', 'categories'));
    }
}