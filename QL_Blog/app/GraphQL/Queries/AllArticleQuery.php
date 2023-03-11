<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Article;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as QL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class AllArticleQuery extends Query
{
    protected $attributes = [
        'name' => 'allArticle',
        'description' => 'A query for all of Articles'
    ];

    public function type(): Type
    {
        return QL::paginate('Article');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int()
            ],
            'page' =>  [
                'name' => 'page',
                'type' => Type::int()
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
//        $fields = $getSelectFields();
//        $select = $fields->getSelect();
//        $with = $fields->getRelations();

        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;

        return Article::paginate($limit, ['*'], 'page', $page);
    }
}
