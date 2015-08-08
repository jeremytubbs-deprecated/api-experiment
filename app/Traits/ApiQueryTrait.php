<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait ApiQueryTrait {

	public function apiQuery($table, $request) {
        $params = config('api.params');
        $fitler_relations = config('api.' . $table . '.filter_relations');
        $is_boolean = config('api.' . $table . '.is_boolean');
        $search_fields = config('api.' . $table . '.search_fields');
        $sort_fields = config('api.' . $table . '.sort_fields');
        // check that all params are valid.
        foreach ($request as $key => $value) {
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

        return $request;
	}
}
