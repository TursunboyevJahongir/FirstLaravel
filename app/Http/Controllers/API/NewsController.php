<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        /**
         * select All news
         */
        return \response()->json(News::paginate(15));
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
            'body' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg',
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
        $path = '/uploads/news/' . $fileName;

        $all = $request->all();
        $all['image'] = $path;
        $all['thumb_128'] = '/uploads/news/128_' . $fileName;
        $all['thumb_255'] = '/uploads/news/255_' . $fileName;
        $all['thumb_1024'] = '/uploads/news/1024_' . $fileName;
        Image::make(public_path($path))->fit(128)->save(public_path('/uploads/news/') . '128_' . $fileName)->save();
        Image::make(public_path($path))->fit(255)->save(public_path('/uploads/news/') . '255_' . $fileName)->save();
        Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/news/') . '1024_' . $fileName)->save();
        $data = News::create($all);

        return response()->json([
            'status' => 'ok',
            'message' => 'Great success! New News created',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        /**
         * view Counter
         *
         * UPDATE `news` SET `view` = `view`+1 WHERE id = 36
         */
        $view = News::where('id', '=', $id)->first();
        $view->view_count += 1;
        DB::table('news')
            ->where('id', $id)
            ->update(['view_count' => $view->view_count]);

        /**
         * select one news
         */
        $data = News::where('id', '=', $id)->with('shop')->first();
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
     * @param News $id
     * @return JsonResponse
     */
    public function update(Request $request, News $id)
    {
        $request->validate([
            'shop_id' => 'nullable',
            'title' => 'nullable',
            'body' => 'nullable',
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg',
            'view' => 'nullable',
        ]);
        $all = $request->all();
        if ($request->file('image')) {
            @unlink(public_path() . $id->image);
            @unlink(public_path() . $id->thumb_128);
            @unlink(public_path() . $id->thumb_255);
            @unlink(public_path() . $id->thumb_1024);
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
            $path = '/uploads/news/' . $fileName;

            $all['image'] = $path;
            $all['thumb_128'] = '/uploads/news/128_' . $fileName;
            $all['thumb_255'] = '/uploads/news/255_' . $fileName;
            $all['thumb_1024'] = '/uploads/news/1024_' . $fileName;
            $image128 = Image::make(public_path($path))->fit(128)->save(public_path('/uploads/news/') . '128_' . $fileName);
            $image256 = Image::make(public_path($path))->fit(255)->save(public_path('/uploads/news/') . '255_' . $fileName);
            $image1024 = Image::make(public_path($path))->fit(1024)->save(public_path('/uploads/news/') . '1024_' . $fileName);
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
     * @param News $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(News $id)
    {
        @unlink(public_path() . $id->image);
        @unlink(public_path() . $id->thumb_255);
        @unlink(public_path() . $id->thumb_1024);
        $id->delete();
        return \response()->json([
            'status' => 'ok',
            'message' => ' deleted',
            'data' => null
        ]);
    }
}
