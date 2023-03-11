<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;

class ArticleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Article',
        'description' => 'A type of article'
    ];

    public function fields(): array
    {
        return [
            'title' => [
                'type' => Type::string(),
                'description' => 'the title of article'
            ],
            'body' => [
                'type' => Type::string(),
                'description' => 'article context'
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'article creator identity'
            ],
            'like_count' => [
                'type' => Type::int(),
                'description' => 'count of likes'
            ]
        ];
    }
}
