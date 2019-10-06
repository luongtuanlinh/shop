<?php
/**
 * Created by PhpStorm.
 * User: paditech
 * Date: 7/19/19
 * Time: 10:16 AM
 */

namespace Modules\Core\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Modules\Core\Lib\PushNotification;

class SendPushExpo implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    protected $deviceTokens;
    protected $message;
    protected $extraData;

    /**
     * SendPush constructor.
     * @param $deviceTokens
     * @param $message
     * @param $extraData
     */
    public function __construct($deviceTokens, $message, $extraData)
    {
        $this->deviceTokens = $deviceTokens;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            PushNotification::sendPushExpoMulti($this->deviceTokens, $this->message);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . '. File: ' . $ex->getFile() . '. Line: ' . $ex->getLine());
        }
    }
}
