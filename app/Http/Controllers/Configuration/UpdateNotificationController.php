<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 18/12/18
 * Time: 16:38
 */

namespace App\Http\Controllers\Configuration;


use App\Http\Services\DelcampeService;
use App\NotificationConfig;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;

class UpdateNotificationController
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
        $notification = NotificationConfig::findByNotificationId($id)->firstOrFail();

        if ($request->isMethod('put')) {
            $request->validate([
                'destination' => 'required'
            ]);

            $this->delcampeService->deleteNotificationSetting($notification->id_notification);
            $this->delcampeService->setNotificationSetting($notification->type, $request->get('destination'));

            Artisan::call('delcampe:notification_config');

            return $this->redirector->route('notification_index');
        }

        return $this->view->make('config.notification.edit', compact('notification'));
    }
}