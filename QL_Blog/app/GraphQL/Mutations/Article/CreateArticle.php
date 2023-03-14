<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Article;

use App\Models\Article;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateArticle extends Mutation
{
    protected $attributes = [
        'name' => 'CreateArticle',
        'description' => 'A mutation for Article Creation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Article');
    }

    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of article'
            ],
            'body' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The context of article'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'title' => ['required' ,'string', 'max:60'],
            'body' => ['required']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Article::create([
            'title' => $args['title'],
            'body' => $args['body'],
            'user_id' => rand(1,10)
        ]);
    }
}
