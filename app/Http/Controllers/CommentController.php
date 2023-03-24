<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $request -> validate([
            'contest_id' => 'required|exist:contests,id',
            'comment_content' => 'required:max:80'
        ]);
    }
}
