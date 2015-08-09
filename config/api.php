<?php

return [
    'params' => ['q', 'take', 'page', 'sort', 'fields', 'filter', 'is', 'include'],

    'contents' => [
        'public_fields' => ['title', 'description'],
        'filter_relations' => ['type.id', 'type.slug', 'categories.id', 'categories.slug', 'users.id'],
        'include_relations' => ['type', 'category', 'user'],
        'is_boolean' => ['featured'],
        'search_fields' => ['title', 'description'],
        'sort_fields' => ['title', 'publishedAt'],
        'sort_default' => ['publishedAt']
    ],

    'users' => [
        'public_fields' => ['name'],
    ],

    'categories' => [
        'public_fields' => ['title', 'description'],
    ],

    'types' => [
        'public_fields' => ['title', 'description'],
    ]
];
