<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LoginUser extends Mutation
{
    protected $attributes = [
        'name' => 'LoginUser',
        'description' => 'A mutation for User Logining'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::string(),
                'description' => 'email for login'
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'password for login'
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
        if (!Auth::attempt(['email' => $args['email'], 'password' => $args['password']])){
            throw new Error('email or password is not correct');
        }
        $user = Auth::user();
        $user->remember_token = Str::random(30);
        $user->save();
        return $user;
    }
}
