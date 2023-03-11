<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Comment',
        'description' => 'A type of Comment'
    ];

    public function fields(): array
    {
        return [
            'body' => [
                'type' => Type::string(),
                'description' => 'context of the Comment'
            ],
            'approval' => [
                'type' => Type::boolean(),
                'description' => 'Show this comment or No'
            ]
        ];
    }
}
