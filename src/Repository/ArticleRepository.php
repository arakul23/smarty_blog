<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

readonly class ArticleRepository
{
    public function __construct(private PDO $connection)
    {}

    public function findArticleById(int $id): array
    {
        $statement = $this->connection->prepare(
            'SELECT
                a.id,
                a.title,
                a.description,
                a.text,
                a.image,
                a.views,
                a.created_at,
                c.id AS category_id,
                c.title AS category_title
            FROM articles a
            LEFT JOIN article_categories ac ON ac.article_id = a.id
            LEFT JOIN categories c ON c.id = ac.category_id
            WHERE a.id = :id
            ORDER BY c.id
            LIMIT 1'
        );
        $statement->execute([':id' => $id]);
        $row = $statement->fetch();

        if ($row === false) {
            return [];
        }

        return [
            'id' => (int)$row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'text' => $row['text'],
            'image' => $row['image'],
            'views' => (int)$row['views'],
            'created_at' => $row['created_at'],
            'category' => $row['category_id'] === null ? null : [
                'id' => (int)$row['category_id'],
                'title' => $row['category_title'],
            ],
        ];
    }

    public function findRelatedArticlesByArticleId(int $articleId, int $limit = 3): array
    {
        $limit = max(1, $limit);

        $statement = $this->connection->prepare(
            'SELECT
                a.id,
                a.title,
                a.description,
                a.text,
                a.image,
                a.views,
                a.created_at
            FROM articles a
            INNER JOIN article_categories ac ON ac.article_id = a.id
            WHERE ac.category_id IN (
                SELECT ac2.category_id
                FROM article_categories ac2
                WHERE ac2.article_id = :article_id
            )
            AND a.id <> :article_id
            GROUP BY
                a.id,
                a.title,
                a.description,
                a.text,
                a.image,
                a.views,
                a.created_at
            ORDER BY
                COUNT(*) DESC,
                a.created_at DESC,
                a.id DESC
            LIMIT :limit'
        );
        $statement->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll();

        return array_map(
            static fn(array $row): array => [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'text' => $row['text'],
                'image' => $row['image'],
                'views' => (int)$row['views'],
                'created_at' => $row['created_at'],
            ],
            $rows
        );
    }
}
