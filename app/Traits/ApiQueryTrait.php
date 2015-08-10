<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\Content;

trait ApiQueryTrait {

    public function apiQuery($table, $request) {
        $params = config('api.params');
        $fitler_relations = config('api.' . $table . '.filter_relations');
        $include_relations = config('api.' . $table . '.include_relations');
        $is_boolean = config('api.' . $table . '.is_boolean');
        $search_fields = config('api.' . $table . '.search_fields');
        $sort_fields = config('api.' . $table . '.sort_fields');

        // TODO: Make Eloquent Dynamic?
        if ($table == 'contents') $query = Content::select();
        // $query = DB::table($table);

        // check that all params are valid.
        foreach ($request as $key => $value) {
            if (! in_array($key, $params)) {
                return ['error' => $key . ' is not a valid request parameter.'];
            }
            switch ($key) {
                case 'include':
                    if (is_array($value)) {
                        return ['error' => 'include request parameters should be comma delimited.'];
                    }
                    //example ?include=category,type
                    $split = explode(',', $value);
                    foreach ($split as $v) {
                        if (! in_array($v, $include_relations)) {
                            return ['error' => 'include=' . $v . ' is not a valid request parameter.'];
                        }
                        $query->with($v);
                    }
                    break;
                case 'fields':
                    //example ?fields[category]=title
                    break;
                case 'q':
                    // example: ?q[title]=hello
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (! in_array($k, $search_fields)) {
                                return ['error' => 'q[' . $k . '] is not a valid request parameter.'];
                            }
                            $query->where($table.'.'.$k, 'LIKE', "%$v%");
                        }
                    }
                    // example: ?q=hello
                    // will always pass but may return 'no results'
                    if (! is_array($value)) {
                        // foreach ($search_fields as $v) {
                        //     $query->orWhere($table.'.'.$v, 'LIKE', "%$value%");
                        // }
                        return ['error' => 'q request parameter must be an array.'];
                    }
                    break;
                case 'filter':
                    // example: ?filter[users.id]=2 || ?filter[categories.slug]=art
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (preg_match("/\./", $k)) {
                                if (! in_array($k, $fitler_relations)) {
                                    return ['error' => 'filter[' . $k . '] is not a valid request parameter.'];
                                }
                            }
                            $split = explode('.', $k);
                            $query->whereHas($split[0], function ($relation) use ($split, $v) {
                                $relation->where($split[1], '=', $v);
                            });
                        }
                    }
                    if (! is_array($value)) {
                        return ['error' => 'filter request parameter must be an array.'];
                    }
                    break;
                case 'is':
                    // example: ?is[featured]=True
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if (! in_array($k, $is_boolean)) {
                                return ['error' => 'is[' . $k . '] is not a valid request parameter.'];
                            }
                            $vl = strtolower($v);
                            if ($vl != 'true' && $vl != 'false') {
                                return ['error' => 'is[' . $k . ']='. $v .' is not a valid request parameter.'];
                            }
                            $boolean = ($vl != 'true') ? 0 : 1;
                            $query->where($table.'.'.$k, '=', $boolean);
                        }
                    }
                    // example: ?is=!featured || ?is=featured
                    if (! is_array($value)) {
                        $vl = (substr($value, 0, 1) == '!') ? substr($value, 1) : $value;
                        $boolean = (substr($value, 0, 1) == '!') ? 0 : 1;
                        if (! in_array($vl, $is_boolean)) {
                            return ['error' => 'is=' . $value . ' is not a valid request parameter.'];
                        }
                        $query->where($table.'.'.$vl, '=', $boolean);
                    }
                    break;
                case 'sort':
                    // example: ?sort[publishedAt]=desc || ?sort[publishedAt]=asc
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $k = snake_case($k);
                            if (! in_array($k, $sort_fields)) {
                                return ['error' => 'filter request parameter must be an array.'];
                            }
                            $vl = strtolower($v);
                            if ($vl != 'desc' && $vl != 'asc') {
                                return ['error' => 'sort[' . $k . ']='. $v .' is not a valid request parameter.'];
                            }
                            $query->orderBy($table.'.'.$k, $vl);
                        }
                    }
                    // example: ?sort=-publishedAt || ?sort=published
                    if (! is_array($value)) {
                        $vl = (substr($value, 0, 1) == '-') ? substr($value, 1) : $value;
                        $vl = snake_case($vl);
                        $direction = (substr($value, 0, 1) == '-') ? 'desc' : 'asc';
                        if (! in_array($vl, $sort_fields)) {
                            return ['error' => 'sort=' . $value . ' is not a valid request parameter.'];
                        }
                        $query->orderBy($table.'.'.$vl, $direction);
                    }
                    break;
            }
        }

        $request = $query->paginate();

        return $request;
    }
}
