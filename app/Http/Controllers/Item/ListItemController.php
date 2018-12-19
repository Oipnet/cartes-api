<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 19/12/18
 * Time: 09:29
 */

namespace App\Http\Controllers\Item;


use App\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class ListItemController
{
    /**
     * @var Factory
     */
    private $view;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request)
    {
        switch ($request->get('filter')) {
            case 'closed':
                $items = Item::isClosed()->get();
                break;
            default:
                $items = Item::all();
                break;
        }

        return $this->view->make('item.index', compact('items'));
    }
}