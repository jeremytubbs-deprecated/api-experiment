<?php

namespace App\Transformers;

use App\Models\Content;
use League\Fractal\TransformerAbstract;

class ContentTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Content $content)
    {
        return [
            'type'    => 'contents',
            'id'      => (int) $content->id,
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