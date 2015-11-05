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
        $include_relations = config('api.contents.include_relations');

        foreach ($contents as $content) {
            $included = null;
            foreach ($include_relations as $relation) {
                if (isset($content->$relation)) {
                    $included[]  = [
                        'type' => $relation,
                        'id' => $content->$relation->id,
                        'attributes' => [
                            'name' => $content->$relation->title,
                            'description' => $content->$relation->description
                        ]
                    ];
                }
            }

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
                'included' => $included,
                'links'   => [
                    [
                        'self' => '/api/contents/'.$content->id,
                    ]
                ],
            ];
        };

        $links[] = [
            'self' => '/api/contents?' . $_SERVER['QUERY_STRING'],
            'next' => $contents->currentPage() < $contents->lastPage() ? '/api/contents?page='. ($contents->currentPage() + 1) . '&' . $_SERVER['QUERY_STRING'] : null,
            'last' => $contents->lastPage() > 1 ? '/api/contents?page='.$contents->lastPage() . '&' . $_SERVER['QUERY_STRING'] : null
        ];

        return ['links' => $links, 'data' => $data];
    }
}