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

        if (strpos($_SERVER['QUERY_STRING'], 'page=') === false) {
            $links[] = [
                'self' => '/api/contents?' . $_SERVER['QUERY_STRING'],
                'next' => $contents->currentPage() < $contents->lastPage() ? '/api/contents?page='. ($contents->currentPage() + 1) . '&' . $_SERVER['QUERY_STRING'] : null,
                'last' => $contents->lastPage() > 1 ? '/api/contents?page='.$contents->lastPage() . '&' . $_SERVER['QUERY_STRING'] : null
            ];
        }

        if (strpos($_SERVER['QUERY_STRING'], 'page=') !== false) {
            $next_query_string = str_replace('page='.$contents->currentPage(), 'page='.($contents->currentPage()+1), $_SERVER['QUERY_STRING']);
            $last_query_string = str_replace('page='.$contents->currentPage(), 'page='.$contents->lastPage(), $_SERVER['QUERY_STRING']);
            $links[] = [
                'self' => '/api/contents?' . $_SERVER['QUERY_STRING'],
                'next' => $contents->currentPage() < $contents->lastPage() ? '/api/contents?' . $next_query_string  : null,
                'last' => $contents->lastPage() > 1 ? '/api/contents?' . $last_query_string : null
            ];
        }

        return ['links' => $links, 'data' => $data];
    }
}