<?php

namespace App\Transformers;

class ContentTransformer
{
    /**
     * Turn this object into a generic array
     *
     * @return array
     */
    public function transform($contents)
    {
        foreach ($contents as $content) {
            $data[] = [
                'type'    => 'contents',
                'id'      => (int) $content->id,
                'attributes' => [
                    'title'   => $content->title,
                    'description'   => $content->description
                ],
                'relationships' => [
                    'type' => [
                        'data' => [
                            'id' => $content->type_id,
                            'type' => 'type'
                        ]
                    ],
                    'category' => [
                        'data' => [
                            'id' => $content->category_id,
                            'type' => 'category'
                        ]
                    ]
                ],
                'links'   => [
                    [
                        'self' => '/contents/'.$content->id,
                    ]
                ],
            ];
        }
        return ['data' => $data];
    }
}