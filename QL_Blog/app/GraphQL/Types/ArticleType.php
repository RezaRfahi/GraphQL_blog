<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;


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
            ],
            'comments' => [
                'type' => Type::listOf(GraphQL::type('Comment')),
                'description' => 'the Comments belongs to article',

                // for showing only approved comments
                'resolve' => function ($data) {
                    return $data->comments()->where('approval', true)->get();
                }
            ],
            'user' =>[
                'type' => GraphQL::type('User'),
                'description' => 'Commenter user'
            ]
        ];
    }
}
