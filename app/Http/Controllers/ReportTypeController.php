<?php

namespace App\Http\Controllers;

use App\ReportType;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReportTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function index()
    {
        try{
            $reportTypes = ReportType::get();

            return response()->json([
                'data'      => $reportTypes,
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
        //
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'type_name'     => 'required|max:255',
                'description'   => 'required',
            ]);
            try{
                $reportType = ReportType::create([
                    'type_id'     => request('type_id'),
                    'type_name'   => request('type_name'),
                    'description' => request('description')
                ]);
                return response()->json([
                    'data'      => $reportType,
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
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function show(ReportType $reportType)
    {
        //
        try{
            return response()->json([
                'data'      => $reportType,
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
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportType $reportType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportType $reportType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'type_name'     => 'required|max:255',
                'description'   => 'required',
            ]);

            try{
                $reportType->type_name = request('type_name');
                $reportType->description = request('description');
                $reportType->type_id = request('type_id');
                $reportType->save();

                return response()->json([
                    'data'      => $reportType,
                    'message'   => 'Report type updated successfully!'
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
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportType $reportType)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $reportType->delete();
                return response()->json([
                    'message' => 'Report type deleted successfully!'
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
