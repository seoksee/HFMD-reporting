<?php

namespace App\Console\Commands;

use App\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS Notifications to Users via Twilio';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = Notification::whereNotNull('when_to_send')->get();
        foreach($notifications as $notification) {
            $fiveMinutesBefore = Carbon::now()->subMinutes(5);
            $inOneMinute = Carbon::now()->addMinutes(1);
            if($notification->when_to_send >= Carbon::now() && $notification->when_to_send <= $inOneMinute){
                if ($notification->recipients == "all") {
                    // $recipients = User::select('phone')->get();
                    $recipients = DB::table('users')->select('phone')->get();
                } else {
                    $recipients = DB::table('users')->select('phone')->where('state', '=', $notification->recipients)->get();
                }

                foreach($recipients as $recipient) {
                    $this->sendMessage($notification->content, $recipient->phone);
                }
            }
        }
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $recipients,
            ['from' => $twilio_number, 'body' => $message]
        );
    }
}
