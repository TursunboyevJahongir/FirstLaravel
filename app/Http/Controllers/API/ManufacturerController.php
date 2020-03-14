<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return \response()->json(Manufacturer::paginate(15));
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
            'name' => 'required',
            'ico' => 'nullable',
        ]);

        if (!$request->hasFile('ico')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('ico');
        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/manufacturers/';
        $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $fileName);
        $path = '/uploads/manufacturers/' . $fileName;

        $all = $request->all();
        $all['ico'] = $path;
        $image = Image::make(public_path($path))->fit(300);
        $image->save();
        $data = Manufacturer::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New Manufacturer created',
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
        $data = Manufacturer::where('id', '=', $id)->first();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Manufacturer $id
     * @return JsonResponse
     */
    public function update(Request $request, Manufacturer $id)
    {
        $request->validate([
            'name' => 'nullable',
            'ico' => 'nullable',
        ]);

        $all = $request->all();
        if ($request->file()) {
            if (!$request->hasFile('ico')) {
                return response()->json(['upload_file_not_found'], 400);
            }
            $file = $request->file('ico');
            if (!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $path = public_path() . '/uploads/manufacturers/';
            $fileName = $file->getATime() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $path = '/uploads/manufacturers/' . $fileName;

            $all['ico'] = $path;
            $image = Image::make(public_path($path))->fit(300);
            $image->save();
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
     * @param Manufacturer $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Manufacturer $id)
    {

        @unlink(public_path().$id->ico);
        $products = Product::where('manufacturer_id', '=', $id->id)->get();
        foreach ($products as $product):
            $images = \App\Models\Image::where('product_id', '=', $product->id)->get();
            foreach ($images as $image):
                @unlink(public_path() . $image->path);
                @unlink(public_path() . $image->thumb_255);
                @unlink(public_path() . $image->thumb_1024);
                $image->delete();
            endforeach;
            $product->delete();
        endforeach;
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => null
        ]);
    }
}
