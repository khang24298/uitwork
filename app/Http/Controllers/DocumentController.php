<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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
            $documents = Document::latest()->get();

            return response()->json([
                'documents' => $documents,
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
        return view('documents.create');
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

            $file = $request->file('fileUpload');

            $file_name = $file->getClientOriginalName();
            $file_type = $file->getClientMimeType();
            $size = $file->getSize() / 1000 .'KB';

            // dd($file);
            $path = $file->storeAs('upload', $file_name);

            try{
                $document = Document::create([
                    'file_name'     => $file_name,
                    'file_type'     => $file_type,
                    'path'          => $path,
                    'size'          => $size,
                    'task_id'       => request('task_id'),
                    'user_id'       => Auth::user()->id,
                ]);
                return response()->json([
                    'document'  => $document,
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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        try{
            return response()->json([
                'document' => $document,
                'message'  => 'Success'
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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $document->file_name = request('file_name');
                $document->file_type = request('file_type');
                $document->path = request('path');
                $document->size = request('size');
                $document->task_id = request('task_id');
                $document->user_id = Auth::user()->id;
                $document->save();

                return response()->json([
                    'document' => $document,
                    'message'  => 'Document updated successfully!'
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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $document->delete();
                return response()->json([
                    'message' => 'Document deleted successfully!'
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

    // public function getDocumentInfoByTaskID(int $task_id)
    // {
    //     try {
    //         $documentByTask = DB::table('documents')->where('task_id', $task_id)->get();

    //         return response()->json([
    //             'documentByTask'    => $documentByTask,
    //             'message'           => 'Success'
    //         ], 200);
    //     }
    //     catch(Exception $e){
    //         return response()->json([
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
