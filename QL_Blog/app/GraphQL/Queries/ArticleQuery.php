<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Article;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as QL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class ArticleQuery extends Query
{
    protected $attributes = [
        'name' => 'article',
        'description' => 'A query of a Article'
    ];

    public function type(): Type
    {
        return QL::type('Article');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Article::findOr($args['id'],function (){
            return new Error('Article not found!');
        });

    }
}
