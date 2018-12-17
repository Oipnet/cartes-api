<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 17/12/18
 * Time: 11:40
 */

namespace App\Http\Controllers;

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
        return $this->view->make('homepage');
    }
}