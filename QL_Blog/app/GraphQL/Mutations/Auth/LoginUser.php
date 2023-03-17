<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Auth;

use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class LoginUser extends Mutation
{
    protected $attributes = [
        'name' => 'LoginUser',
        'description' => 'A mutation for User Logging'
    ];

    public function type(): Type
    {
        return Type::listOf(Type::string());
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'email for checking user'
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'password for checking user'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required'],
            'password' => ['required']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (!Auth::attempt(['email' => $args['email'], 'password' => $args['password']])) {
            throw new Error('Invalid email or password.');
        }

        $user = Auth::user();

        // Generate a personal access token and return it and the user information
        $token = $user->createToken('graphql')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration'),
            'user' => $user,
        ];
    }
}
