<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

readonly class CategoryRepository
{
    public function __construct(private PDO $connection)
    {}

    public function findCategoriesWithArticles(): array
    {
        $statement = $this->connection->prepare(
            'SELECT
                c.id AS category_id,
                c.title AS category_title,
                c.description AS category_description,
                a.id AS article_id,
                a.title AS article_title,
                a.description AS article_description,
                a.text,
                a.image,
                a.views,
                a.created_at
            FROM categories c
            LEFT JOIN article_categories ac ON ac.category_id = c.id
            LEFT JOIN articles a ON a.id = ac.article_id
            ORDER BY c.id, a.created_at DESC, a.id DESC'
        );

        $statement->execute();
        $rows = $statement->fetchAll();
        $categoriesById = [];

        foreach ($rows as $row) {
            $categoryId = (int)$row['category_id'];

            if (!isset($categoriesById[$categoryId])) {
                $categoriesById[$categoryId] = [
                    'id' => $categoryId,
                    'title' => $row['category_title'],
                    'description' => $row['category_description'],
                    'posts' => [],
                ];
            }

            if ($row['article_id'] === null || count($categoriesById[$categoryId]['posts']) >= 3) {
                continue;
            }

            $categoriesById[$categoryId]['articles'][] = [
                'id' => (int)$row['article_id'],
                'title' => $row['article_title'],
                'description' => $row['article_description'],
                'text' => $row['text'],
                'image' => $row['image'],
                'views' => (int)$row['views'],
                'created_at' => $row['created_at'],
            ];
        }

        return array_values($categoriesById);
    }

    public function findCategoryByIdWithArticles(
        int $categoryId,
        string $sortBy = 'date',
        int $page = 1,
        int $perPage = 3
    ): ?array
    {
        $orderBy = match ($sortBy) {
            'views' => 'a.views DESC, a.created_at DESC, a.id DESC',
            default => 'a.created_at DESC, a.id DESC',
        };

        $categoryStatement = $this->connection->prepare(
            'SELECT
                c.id AS category_id,
                c.title AS category_title,
                c.description AS category_description
            FROM categories c
            WHERE c.id = :category_id
            LIMIT 1'
        );
        $categoryStatement->execute([':category_id' => $categoryId]);
        $categoryRow = $categoryStatement->fetch();

        if ($categoryRow === false) {
            return null;
        }

        $countStatement = $this->connection->prepare(
            'SELECT COUNT(*) AS total_articles
            FROM article_categories ac
            INNER JOIN articles a ON a.id = ac.article_id
            WHERE ac.category_id = :category_id'
        );
        $countStatement->execute([':category_id' => $categoryId]);
        $totalArticles = (int)$countStatement->fetchColumn();

        $perPage = max(1, $perPage);
        $totalPages = max(1, (int)ceil($totalArticles / $perPage));
        $currentPage = max(1, min($page, $totalPages));
        $offset = ($currentPage - 1) * $perPage;

        $articlesStatement = $this->connection->prepare(
            'SELECT
                a.id AS article_id,
                a.title AS article_title,
                a.description AS article_description,
                a.text,
                a.image,
                a.views,
                a.created_at
            FROM article_categories ac
            INNER JOIN articles a ON a.id = ac.article_id
            WHERE ac.category_id = :category_id
            ORDER BY ' . $orderBy . '
            LIMIT :limit OFFSET :offset'
        );
        $articlesStatement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $articlesStatement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $articlesStatement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $articlesStatement->execute();
        $rows = $articlesStatement->fetchAll();

        $category = [
            'id' => (int)$categoryRow['category_id'],
            'title' => $categoryRow['category_title'],
            'description' => $categoryRow['category_description'],
            'articles' => [],
            'pagination' => [
                'current_page' => $currentPage,
                'per_page' => $perPage,
                'total_articles' => $totalArticles,
                'total_pages' => $totalPages,
            ],
        ];

        foreach ($rows as $row) {
            $category['articles'][] = [
                'id' => (int)$row['article_id'],
                'title' => $row['article_title'],
                'description' => $row['article_description'],
                'text' => $row['text'],
                'image' => $row['image'],
                'views' => (int)$row['views'],
                'created_at' => $row['created_at'],
            ];
        }

        return $category;
    }
}
