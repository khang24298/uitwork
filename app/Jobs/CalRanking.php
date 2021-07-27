<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalRanking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $user_id;
    public $month;
    public $year;

    public function __construct($user_id,$month,$year)
    {
        //
        $this->user_id = $user_id;
        $this->month = $month;
        $this->year = $year;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = env('APP_URL','http://uitwork').'/api/insertUserRankByMonthByUserID/'
        .$this->user_id.'/'.$this->month.'/'.$this->year;
        echo $url;
        $output = $this->curlPost($url);
        print_r(json_encode($output)).PHP_EOL;
        return;
    }

    public function curlPost($url, $params = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC91aXR3b3JrXC9hcGlcL2xvZ2luIiwiaWF0IjoxNjI3MDU4MzA4LCJuYmYiOjE2MjcwNTgzMDgsImp0aSI6ImRqVGNNWXc4b3FrbGFQYkkiLCJzdWIiOjEzLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.2ZUzekCScSTBYbnyJF-5nCFCOYJZoxrGmxx2cXG3kkY'
            )
        );
    
        $output = curl_exec($ch);
        return $output;
    }
}
