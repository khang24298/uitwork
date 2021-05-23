<?php

namespace App\Http\Controllers;

use App\NotificationType;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationTypeController extends Controller
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
            $notificationTypes = NotificationType::get();

            return response()->json([
                'data'      => $notificationTypes,
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
                'type_name'     => 'required|max:255',
                'type_id'       => 'required',
            ]);
            try{
                $notificationTypes = NotificationType::create([
                    'type_name'     => request('type_name'),
                    'type_id'       => request('type_id'),
                ]);
                return response()->json([
                    'data'      => $notificationTypes,
                    'message'   => 'Success'
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
     * @param  \App\NotificationType  $notificationType
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationType $notificationType)
    {
        try{
            return response()->json([
                'data'      => $notificationType,
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
     * @param  \App\NotificationType  $notificationType
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationType $notificationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationType  $notificationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationType $notificationType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'type_name' => 'required|max:255',
                'type_id'   => 'required',
            ]);

            try{
                $notificationType->type_name = request('type_name');
                $notificationType->type_id = request('type_id');
                $notificationType->save();

                return response()->json([
                    'data'      => $notificationType,
                    'message'   => 'NotificationType type updated successfully!'
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
     * @param  \App\NotificationType  $notificationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationType $notificationType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $notificationType->delete();
                return response()->json([
                    'message' => 'NotificationType deleted successfully!'
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
}
