<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
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
        

    }
}
