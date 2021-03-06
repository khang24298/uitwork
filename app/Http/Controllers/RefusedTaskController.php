<?php

namespace App\Http\Controllers;

use App\RefusedTask;
use Illuminate\Http\Request;
use App\Task;
use App\Notification;
use App\Jobs\NotificationJob;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotification;

class RefusedTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function show(RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function edit(RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefusedTask $refusedTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefusedTask  $refusedTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefusedTask $refusedTask)
    {
        //
    }

    public function refuseTask(Request $request)
    {
        $this->validate($request,[
            'task_id'     => 'required|numeric',
            'status_id'   => 'required|in:0',
            'content'     => 'required'
        ]);

        try {
            $task = Task::findOrFail($request['task_id']);
            $task->status_id = 5;
            $task->save();

            // Create Notification.
            $message = Auth::user()->name.' refused the '.$task->task_name.' task.';

            $notification = ([
                'user_id'       => Auth::user()->id,
                'type_id'       => 2,
                'message'       => $message,
                'content'       => json_encode($task),
                'receiver_id'   => $task->user_id,
                'has_seen'      => false,
            ]);

            // Dispatch to NotificationJob.
            NotificationJob::dispatch($notification);

            // Test mail notification.
            // $receiverEmail = User::select('email')->where('id', $task->user_id)->first()->email;

            // $details = [
            //     'subject'   => 'Refuse task',
            //     'title'     => 'Refuse '.$task->task_name,
            //     'body'      => $message,
            //     'url'       => route('admin.login'),
            // ];

            // Mail::to($receiverEmail)->send(new MailNotification($details));

            return response()->json([
                'data'      => true,
                'message'   => 'Refuse Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'data'      => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }
}
