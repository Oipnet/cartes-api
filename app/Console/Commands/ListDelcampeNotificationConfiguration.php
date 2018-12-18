<?php

namespace App\Console\Commands;

use App\Http\Services\DelcampeService;
use App\NotificationConfig;
use Illuminate\Console\Command;

class ListDelcampeNotificationConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delcampe:notification_config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the notification config';
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
        $notifications = $this->delcampeService->getNotificationConfig();

        $notifications->each(function($notification) {
            NotificationConfig::updateOrCreate(
                [ 'id_notification' => $notification['id_notification']],
                [
                    'channel' => $notification['channel'],
                    'type' => $notification['type'],
                    'destination' => $notification['destination'],
                    'active' => $notification['active'] ?? false,
                ]
            );
        });
    }
}
