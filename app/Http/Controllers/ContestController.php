<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContestDetailResource;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function index(){
        $contest = Contest::all();
        return ContestResource::collection($contest);
    }

    public function show($id){
        $contest = Contest::with('uploader:id,name')->findOrFail($id);
        return new ContestDetailResource($contest);
    }
    public function show2($id){
        $post = Contest::findOrFail($id);
        return new ContestDetailResource($post);
    }
}
