<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $params = config('api.params');
        $fitler_relations = config('api.contents.filter_relations');
        $is_boolean = config('api.contents.is_boolean');
        $search_fields = config('api.contents.search_fields');
        $sort_fields = config('api.contents.sort_fields');
        // check that all params are valid.
        foreach ($request->all() as $key => $value) {
            if (! in_array($key, $params)) {
                return response()->json($key . ' is not a valid request parameter.', 400);
            }
            switch ($key) {
                case 'include':
                    //example ?include=category,type
                    break;
                case 'fields':
                    //example ?fields[category]=title
                    break;
                case 'q':
                    // example: ?q[title]=hello
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (! in_array($k, $search_fields)) {
                                return response()->json('q[' . $k . '] is not a valid request parameter.', 400);
                            }
                        }
                    }
                    // example: ?q=hello
                    // will always pass but may return 'no results'
                    break;
                case 'filter':
                    // example: ?filter[users.id]=2
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (preg_match("/\./", $k)) {
                                if (! in_array($k, $fitler_relations)) {
                                    return response()->json('filter[' . $k . '] is not a valid request parameter.', 400);
                                }
                            }
                        }
                    }
                    if (! is_array($value)) {
                        return response()->json('filter request parameter must be an array.', 400);
                    }
                    break;
                case 'is':
                    // example: ?is[featured]=True
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (! in_array($k, $is_boolean)) {
                                return response()->json('is[' . $k . '] is not a valid request parameter.', 400);
                            }
                            $vl = strtolower($v);
                            if ($vl != 'true' && $vl != 'false') {
                                return response()->json('is[' . $k . ']='. $v .' is not a valid request parameter.', 400);
                            }
                        }
                    }
                    // example: ?is=!featured || ?is=featured
                    if (! is_array($value)) {
                        $vl = (substr($value, 0, 1) == '!') ? substr($value, 1) : $value;
                        if (! in_array($vl, $is_boolean)) {
                            return response()->json('is=' . $value . ' is not a valid request parameter.', 400);
                        }
                    }
                    break;
                case 'sort':
                    // example: ?sort[publishedAt]=true
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (! in_array($k, $sort_fields)) {
                                return response()->json('sort[' . $k . '] is not a valid request parameter.', 400);
                            }
                            $vl = strtolower($v);
                            if ($vl != 'true' && $vl != 'false') {
                                return response()->json('sort[' . $k . ']='. $v .' is not a valid request parameter.', 400);
                            }
                        }
                    }
                    // example: ?sort=-publishedAt || ?sort=published
                    if (! is_array($value)) {
                        $vl = (substr($value, 0, 1) == '-') ? substr($value, 1) : $value;
                        if (! in_array($vl, $sort_fields)) {
                            return response()->json('sort=' . $value . ' is not a valid request parameter.', 400);
                        }
                    }
                    break;
            }
        }

        return $request->all();

        $content = App\Models\Content::with(['type', 'category'])->paginate($offset);
        return Fractal::collection($content, new App\Transformers\ContentTransformer)->responseJson(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $content = App\Models\Content::with(['type', 'category'])->find($id);
        return Fractal::item($content, new App\Transformers\ContentTransformer)->responseJson(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
