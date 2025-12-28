<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function saveComment(Request $request){
        $videoId = $request->videoId;
        $userComment = $request->comment;

        $video = Video::findOrFail($videoId);
        $comment = new Comment();
        $user = Auth::user();
        $comment->body = $userComment;
        $comment->video_id = $videoId;
        $comment->user_id = $user->id;


        $comment->save();
        
        
        $userName = Auth::user()->name;
        $userImage = Auth::user()->profile_photo_url;
        $commentDate = Carbon::now()->diffForHumans();
        $commentId = $comment->id;

        return response()->json(['userName'=>$userName,'userImage'=>$userImage,'commentDate'=>$commentDate,'commentId'=>$commentId]);

        

    }
    public function destroy($id){
        $comment = Comment::where('id',$id)->first();
        $comment->delete();
        return back()->with('success','تم حذف التعليق بنجاح');
    }
    public function edit($id){
        $comment = Comment::where('id',$id)->first();
        return view('edit-comment',compact('comment'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'comment'=>'required',
        ]);
        $comment = Comment::where('id',$id)->first();
        $video_id = $comment->video->id;
        $comment->body = $request->comment;
        $comment->save();
        return redirect('videos/'.$video_id)->with('sucess','تم تعديل التعليق بنجاح');
    }
}
