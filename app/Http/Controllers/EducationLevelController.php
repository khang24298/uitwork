<?php

namespace App\Http\Controllers;

use App\EducationLevel;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EducationLevelController extends Controller
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
            $educationLevel = EducationLevel::latest()->get();

            return response()->json([
                'educationLevel' => $educationLevel,
                'message'        => 'Success'
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
                'name'          => 'required|max:255',
                'expertise'     => 'required|max:255',
            ]);
            try{
                $educationLevel = EducationLevel::create([
                    'name'           => request('name'),
                    'expertise'      => request('expertise'),
                ]);
                return response()->json([
                    'educationLevel'    => $educationLevel,
                    'message'           => 'Success'
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
     * @param  \App\EducationLevel  $educationLevel
     * @return \Illuminate\Http\Response
     */
    public function show(EducationLevel $educationLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EducationLevel  $educationLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationLevel $educationLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EducationLevel  $educationLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationLevel $educationLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EducationLevel  $educationLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationLevel $educationLevel)
    {
        //
    }

    public function getUserEducationLevel(int $user_id)
    {
        try {
            $userEducation = DB::table('education_levels')
                ->join('users', 'education_levels.id', '=', 'users.education_level_id')
                ->select('education_levels.name', 'expertise')->where('users.id', $user_id)->get();

            return response()->json([
                'userEducation'     => $userEducation,
                'message'           => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
