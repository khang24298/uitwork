<?php

namespace App\Jobs;

use App\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $notification)
    {
        $this->notification = $notification;
    }

    public $tries = 3;
    public $timeout = 120;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = $this->notification;
        Notification::create($notification);
    }
}
