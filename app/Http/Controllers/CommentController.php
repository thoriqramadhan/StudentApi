<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $request -> validate([
            'contest_id' => 'required|exists:contests,id',
            'comment_content' => 'required:max:80'
        ]);

        $request['user_id'] = auth()->user()->id;
        $comment = Comment::create($request->all());
        return new CommentResource($comment->loadMissing(['commentator:id.name']));
    }
}
