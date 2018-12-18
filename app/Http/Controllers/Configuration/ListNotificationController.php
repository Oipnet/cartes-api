<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 18/12/18
 * Time: 16:38
 */

namespace App\Http\Controllers\Configuration;


use App\NotificationConfig;
use Illuminate\Contracts\View\Factory;

class ListNotificationController
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
        $notifications = NotificationConfig::isActive()->get();

        return $this->view->make('config.notification.index', compact('notifications'));
    }
}