<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 18/12/18
 * Time: 16:38
 */

namespace App\Http\Controllers\Item;


use App\Http\Services\DelcampeService;
use App\Item;
use App\NotificationConfig;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;

class UpdateItemController
{
    /**
     * @var Factory
     */
    private $view;
    /**
     * @var Redirector
     */
    private $redirector;
    /**
     * @var DelcampeService
     */
    private $delcampeService;

    public function __construct(Factory $view, Redirector $redirector, DelcampeService $delcampeService)
    {
        $this->view = $view;
        $this->redirector = $redirector;
        $this->delcampeService = $delcampeService;
    }

    public function __invoke(Request $request, $id)
    {
        $item = Item::findByItemId($id)->firstOrFail();

        if ($request->isMethod('put')) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price_starting' => 'integer|required|min:5'
            ]);

            $item->update(
                $request->all()
            );

            $this->delcampeService->updateItem($item);

            return $this->redirector->route('item_index');
        }

        return $this->view->make('item.edit', compact('item'));
    }
}