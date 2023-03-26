<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class RegisterUser extends Mutation
{
    protected $attributes = [
        'name' => 'RegisterUser',
        'description' => 'A mutation User Register'
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
                'description' => 'the Name of User'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'the email of User'
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'the password of User'
            ],
            'password_confirmation' => [
                'type' => Type::string(),
                'description' => 'second password input for confirmation'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:24'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:4', 'max:32', 'confirmed']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $args['password']
        ]);
        return $user ;
    }
}
