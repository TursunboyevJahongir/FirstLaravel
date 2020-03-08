<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'path' => 'required',
        ]);
//        $data = News::create($request->all());

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/news/';
        $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $fileName);
        $path = '/uploads/products/' . $fileName;

        $all = $request->all();
        $all['path'] = $path;
        $all['thumb_255'] = '/uploads/products/255_' . $fileName;
        $all['thumb_1024'] = '/uploads/products/1024_' . $fileName;
        Image::make(public_path($path))->fit(255)->save(public_path('/uploads/products/') . '255_' . $fileName)->save();
        Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/products/') . '1024_' . $fileName)->save();
        $data = Image::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New News created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
