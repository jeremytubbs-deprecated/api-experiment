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