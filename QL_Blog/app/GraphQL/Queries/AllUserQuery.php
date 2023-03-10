<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL as QL;
use Rebing\GraphQL\Support\SelectFields;

class AllUserQuery extends Query
{
    protected $attributes = [
        'name' => 'allUser',
        'description' => 'A query for all of users'
    ];

    public function type(): Type
    {
        return Type::listOf(QL::type('User'));
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();


        return User::all();
    }
}
