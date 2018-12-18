<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;

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

        return $this->view->make('homepage', compact('countItems'));
    }
}