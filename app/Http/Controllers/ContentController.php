<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transformers\ContentTransformer;
use App\Transformers\Collection;
use App\Transformers\Item;

class ContentController extends Controller
{
    use \App\Traits\ApiQueryTrait;

    public function __construct(ContentTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $results = $this->apiQuery('\\App\\Models\\Content', 'contents', $params);

        if (isset($results['error'])) {
            return response()->json($results['error'], 400);
        }

        //return $results;

        $results = $this->transformer->transform($results);

        return response()->json($results, 200);
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
