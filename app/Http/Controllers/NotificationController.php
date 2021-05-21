<?php

namespace App\Http\Controllers;

use App\Notification;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
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
        try{
            $notification = Notification::get();

            return response()->json([
                'data'      => $notification,
                'message'   => 'Success'
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
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
        $role = Auth::user()->role;

        if($role > 2){
            $this->validate($request, [
                'type_id'   => 'required',
                'message'   => 'required',
                'content'   => 'required',
            ]);

            try{
                $notification = Notification::create([
                    'type_id'   => request('type_id'),
                    'user_id'   => Auth::user()->id,
                    'message'   => request('message'),
                    'content'   => request('content'),
                ]);
                return response()->json([
                    'data'    => $notification,
                    'message' => 'Success'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        try{
            return response()->json([
                'data'      => $notification,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'type_id'   => 'required',
                'message'   => 'required',
                'content'   => 'required',
            ]);

            try{
                $notification->user_id = Auth::user()->id;
                $notification->type_id = request('type_id');
                $notification->message = request('message');
                $notification->content = request('content');
                $notification->save();

                return response()->json([
                    'data'      => $notification,
                    'message'   => 'Notification updated successfully!'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $notification->delete();
                return response()->json([
                    'message' => 'Notification deleted successfully!'
                ], 200);
            }
            catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json([
                'message' => "You don't have access to this resource! Please contact with administrator for more information!"
            ], 403);
        }
    }

    public function getNotificationByUserID(int $user_id)
    {
        try {
            $userNotification = Notification::where('user_id', $user_id)->get();

            return response()->json([
                'data'      => $userNotification,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
