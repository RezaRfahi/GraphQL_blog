<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
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
        return Type::listOf(Type::string());
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'the Name of user'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'the email of user'
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'the password of User'
            ],
            'password_confirmation' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'password confirmation'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
          'name' => ['required', 'min:3', 'max:16'],
          'email' => ['required', 'email', 'unique:users'],
          'password' => ['required', 'min:8', 'max:32', 'confirmed']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
            $user = User::create([
                'name' => $args['name'],
                'email' => $args['email'],
                'password' => Hash::make($args['password'])
            ]);

            $token = $user->createToken()->accessToken;

            return [
                'user' => $user,
                'token' => $token
            ];

    }
}
