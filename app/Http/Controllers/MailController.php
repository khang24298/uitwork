<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TestMailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailController extends Controller
{
    public function sendEmail()
    {
        try {
            $details = [
                'title' => 'Mail notification.',
                'body'  => 'This is for testing mail using gmail.'
            ];

            Mail::to("caotanan1234@gmail.com")->send(new TestMailNotification($details));
            return response()->json([
                'message' => 'Email sent!'
            ], 200);
        }
        catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
