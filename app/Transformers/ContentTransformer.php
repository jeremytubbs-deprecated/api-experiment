<?php

namespace App\Transformers;

use App\Models\Content;
use League\Fractal\TransformerAbstract;

class ContentTransformer extends TransformerAbstract
{
    public function transform(Content $content)
    {
        $fields = ['title'];

        return [
            'id'      => (int) $content->id,
            'type'    => $content->type['title'],
            'attributes' => [
                [
                    'title'   => $content->title,
                    'description'   => $content->description
                ]
            ],
            'links'   => [
                [
                    'self' => '/contents/'.$content->id,
                ]
            ],
        ];
    }
}