<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContestDetailResource;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function index(){
        $contest = Contest::all();
        return ContestResource::collection($contest->loadMissing('uploader:id,name','comments:id,contest_id,user_id,comment_content'));
    }

    public function show($id){
        $contest = Contest::with('uploader:id,name', 'comments:id,contest_id,user_id,comment_content')->findOrFail($id);
        return new ContestDetailResource($contest);
    }
    public function show2($id){
        $contest = Contest::findOrFail($id);
        return new ContestDetailResource($contest);
    }

    public function store(Request $request){
        $request-> validate([
            'title' => 'required',
            'level' => 'required',
            'file' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        $image = null;
        if($request-> file){
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName . '.' .$extension;
            Storage::putFileAs('image',$request->file, $image);
        }

        $request['image'] = $image;

        $request['author'] = Auth::user()->id;
        
        $contest = Contest::create($request->all());
        return new ContestDetailResource($contest->loadMissing('uploader:id,name'));
    }
    public function update(Request $request, $id){
        $request -> validate([
            'title' => 'required|max:255',
            'level' => 'required'
        ]);

        $image = null;
        if($request-> file){
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName . '.' .$extension;
            Storage::putFileAs('image',$request->file,$image);
        }

        $request['image'] = $image;

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
