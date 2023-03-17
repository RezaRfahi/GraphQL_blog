<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Auth;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class RegisterUser extends Mutation
{
    protected $attributes = [
        'name' => 'RegisterUser',
        'description' => 'A mutation for Register new User'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'the Name of user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'the email of user'
            ],
            'password' => [
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return [];
    }
}
