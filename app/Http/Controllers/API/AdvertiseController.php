<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Advertise::paginate(15));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg'
        ]);
        $all = $request->all();
        if ($request->file('image')) {
            $all['info_image'] = true;

            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/advertises/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/advertises/' . $fileName;

            $all['image'] = $path;
            $all['thumb_128'] = '/uploads/advertises/128_' . $fileName;
            $all['thumb_255'] = '/uploads/advertises/255_' . $fileName;
            $all['thumb_1024'] = '/uploads/advertises/1024_' . $fileName;
            Image::make(public_path($path))->fit(128)->save(public_path('/uploads/advertises/') . '128_' . $fileName)->save();
            Image::make(public_path($path))->fit(255)->save(public_path('/uploads/advertises/') . '255_' . $fileName)->save();
            Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/advertises/') . '1024_' . $fileName)->save();
        }
        else{
            $all['info_image'] = false;
        }

        $data = Advertise::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New Advertise created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = Advertise::where('id', '=', $id)->first();

        if(!empty($data->image))
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data
        ]);
        else{
            $data = Advertise::where('id', '=', $id)->with('shop')->first();
//            $image = $data->shop;
            return \response()->json([
                'status' => 'ok',
                'message' => '',
                'data' =>  $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Advertise $id
     * @return JsonResponse
     */
    public function update(Request $request, Advertise $id)
    {
        $request->validate([
            'title' => 'nullable',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg'
        ]);

        $all = $request->all();
        if ($request->file('image')) {
            @unlink(public_path() . $id->image);
            @unlink(public_path() . $id->thumb_255);
            @unlink(public_path() . $id->thumb_1024);
            if (!$request->hasFile('image')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('image');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/' . $fileName;

            $all['image'] = $path;
            $all['thumb_128'] = '/uploads/128_' . $fileName;
            $all['thumb_255'] = '/uploads/255_' . $fileName;
            $all['thumb_1024'] = '/uploads/1024_' . $fileName;
            $image128 = Image::make(public_path($path))->fit(128)->save(public_path('/uploads/') . '128_' . $fileName);
            $image256 = Image::make(public_path($path))->fit(255)->save(public_path('/uploads/') . '255_' . $fileName);
            $image1024 = Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/') . '1024_' . $fileName);
            $image128->save();
            $image256->save();
            $image1024->save();
        }
        $id->update($all);

        return response()->json([
            'message' => 'Great success! updated',
            'data' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Advertise $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Advertise $id)
    {
        @unlink(public_path() . $id->image);
        @unlink(public_path() . $id->thumb_255);
        @unlink(public_path() . $id->thumb_1024);
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => ''
        ]);
    }
}
