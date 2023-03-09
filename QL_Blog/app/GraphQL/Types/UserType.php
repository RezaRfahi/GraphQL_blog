<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A User'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'the id of user'
            ],

            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],

            'isAdmin' => [
                'type' => Type::boolean(),
                'description' => 'User Level',
            ]
        ];
    }
}
