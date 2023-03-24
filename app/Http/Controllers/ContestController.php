<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContestDetailResource;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    public function index(){
        $contest = Contest::all();
        return ContestResource::collection($contest->loadMissing('uploader:id,name','comments:id,contest_id,user_id,comment_content'));
    }

    public function show($id){
        $contest = Contest::with('uploader:id,name')->findOrFail($id);
        return new ContestDetailResource($contest);
    }
    public function show2($id){
        $contest = Contest::with('uploader:id,name', 'comments:id,contest_id,user_id,comment_content')->findOrFail($id);
        return new ContestDetailResource($contest);
    }

    public function store(Request $request){
        $request-> validate([
            'title' => 'required',
            'level' => 'required'
        ]);

        $request['author'] = Auth::user()->id;
        
        $contest = Contest::create($request->all());
        return new ContestDetailResource($contest->loadMissing('uploader:id,name'));
    }
    public function update(Request $request, $id){
        $request -> validate([
            'title' => 'required|max:255',
            'level' => 'required'
        ]);

        $contest = Contest::findOrFail($id);
        $contest -> update($request->all());

        return new ContestDetailResource($contest -> loadMissing('uploader:id,name'));
    }

    public function delete($id){
        $contest = Contest::findOrFail($id);
        $contest -> delete();

        return response()->json([
            'message' => 'data berhasil terhapus'
        ]);
    }
}
