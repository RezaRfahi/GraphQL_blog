<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Article;

use App\Models\Article;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdateArticle extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateArticle',
        'description' => 'A mutation for Updating Articles data'
    ];

    public function type(): Type
    {
        return GraphQL::type('Article');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'the id of a Article for finding it'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of article'
            ],
            'body' => [
                'type' => Type::string(),
                'description' => 'The context of article'
            ],
            'like_count' => [
                'type' => Type::int(),
                'description' => 'The count of likes'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'title' => ['string', 'max:60'],
            'like_count' => ['integer']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $article=Article::findOr($args['id'],function (){
            throw new Error('Article not found!');
        });
        $article->update($args);
        return $article;
    }
}
