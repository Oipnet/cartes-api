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
use Illuminate\Routing\Redirector;

class DeleteNotificationController
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

    public function __invoke($id)
    {
        $notification = NotificationConfig::findByNotificationId($id)->firstOrFail();
        $this->delcampeService->deleteNotificationSetting($notification->id_notification);

        $notification->update(['active' => false]);

        return $this->redirector->route('notification_index');
    }
}