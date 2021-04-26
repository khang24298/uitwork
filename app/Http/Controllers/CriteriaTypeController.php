<?php

namespace App\Http\Controllers;

use App\CriteriaType;
use Exception;
use Illuminate\Http\Request;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CriteriaTypeController extends Controller
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
            $criteriaTypes = CriteriaType::get();

            return response()->json([
                'data'      => $criteriaTypes,
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
                'description'   => 'required',
            ]);
            try{
                $criteriaTypes = CriteriaType::create([
                    'type_name'     => request('type_name'),
                    'type_id'       => request('type_id'),
                    'description'   => request('description'),
                ]);
                return response()->json([
                    'data'      => $criteriaTypes,
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
     * @param  \App\CriteriaType  $criteriaType
     * @return \Illuminate\Http\Response
     */
    public function show(CriteriaType $criteriaType)
    {
        try{
            return response()->json([
                'data'      => $criteriaType,
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
     * @param  \App\CriteriaType  $criteriaType
     * @return \Illuminate\Http\Response
     */
    public function edit(CriteriaType $criteriaType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CriteriaType  $criteriaType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CriteriaType $criteriaType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'type_name'     => 'required|max:255',
                'type_id'       => 'required',
                'description'   => 'required',
            ]);

            try{
                $criteriaType->type_name = request('type_name');
                $criteriaType->type_id = request('type_id');
                $criteriaType->description = request('description');
                $criteriaType->save();

                return response()->json([
                    'data'      => $criteriaType,
                    'message'   => 'Criteria type updated successfully!'
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
     * @param  \App\CriteriaType  $criteriaType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CriteriaType $criteriaType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $criteriaType->delete();
                return response()->json([
                    'message' => 'Criteria type deleted successfully!'
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
