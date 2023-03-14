<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Article;

use App\Models\Article;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteArticle extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteArticle',
        'description' => 'A mutation for deleting Article'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'the id of article for deleting'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required', 'integer']
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Article::findOr($args['id'],
        function (){
            throw new Error('Article not found!');
        })->delete();
    }
}
