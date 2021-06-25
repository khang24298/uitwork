<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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
            $comments = Comment::latest()->get();

            return response()->json([
                'data'      => $comments,
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
        $this->validate($request, [
            'content'   => 'required',
            'parent_id' => 'nullable'
        ]);

        try{
            $comment = Comment::create([
                'content'       => request('content'),
                'user_id'       => Auth::user()->id,
                'task_id'       => request('task_id'),
                'parent_id'     => request('parent_id'),
            ]);
            return response()->json([
                'data'      => $comment,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        try{
            return response()->json([
                'data'      => $comment,
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
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $role = Auth::user()->role;
        if($role > 2){
            $this->validate($request, [
                'content'   => 'required',
                'parent_id' => 'nullable'
            ]);

            try{
                $comment->content = request('content');
                $comment->user_id = Auth::user()->id;
                $comment->task_id = request('task_id');
                $comment->parent_id = request('parent_id');
                $comment->save();

                return response()->json([
                    'data'      => $comment,
                    'message'   => 'Comment updated successfully!'
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
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $role = Auth::user()->role;
        if($role > 2){
            try{
                $comment->delete();
                return response()->json([
                    'message' => 'Comment deleted successfully!'
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

    public function getCommentByUserID(int $user_id)
    {
        try {
            $userComment = Comment::where('user_id', $user_id)->get();

            // Add user_name field.
            foreach ($userComment as $usrCmt) {
                $userName = DB::table('users')->select('name')->where('id', $usrCmt['user_id'])->first()->name;
                $usrCmt['user_name'] = $userName;
            }

            return response()->json([
                'data'      => $userComment,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getCommentByTaskID(int $task_id)
    {
        try {
            $taskComment = Comment::where('task_id', $task_id)->get();

            // Add user_name field.
            foreach ($taskComment as $tskCmt) {
                $userName = DB::table('users')->select('name')->where('id', $tskCmt['user_id'])->first()->name;
                $tskCmt['user_name'] = $userName;
            }

            return response()->json([
                'data'      => $taskComment,
                'message'   => 'Success'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getReplyComment(int $parent_id)
    {
        try {
            $childComment = Comment::where('parent_id', $parent_id)->get();

            // Add user_name field.
            foreach ($childComment as $childCmt) {
                $userName = DB::table('users')->select('name')->where('id', $childCmt['user_id'])->first()->name;
                $childCmt['user_name'] = $userName;
            }

            return response()->json([
                'data'      => $childComment,
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
