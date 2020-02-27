<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function fileSave(Request $request){
        if(!$request->hasFile('photo')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('photo');
        if(!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/';
        $fileName = $file->getATime().'.'.$file->getClientOriginalExtension();
        $file->move($path, $fileName);
        $path = '/uploads/'.$fileName;
        return response()->json(['url'=>$path]);

//        $fileName=;
//        $path=$request->file('photo')->move(public_path('/'),$fileName);
//        $photoUrl = url('/'.$fileName);
//        return response()->json(['url'=>$photoUrl]);
    }
}
