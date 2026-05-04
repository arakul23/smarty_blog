<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use RuntimeException;

readonly class SeederService
{
    public function __construct(private PDO $pdo)
    {}

    /**
     * @throws \Throwable
     */
    public function seed(): void
    {
        $this->pdo->beginTransaction();

        try {
            $this->cleanTables();

            $categories = SeedData::categories();

            $categoryIds = [];
            foreach ($categories as $category) {
                $categoryIds[$category['title']] = $this->insertCategory($category);
            }

            $articles = SeedData::articles();

            foreach ($articles as $article) {
                $articleId = $this->insertArticle($article);

                foreach ($article['categories'] as $categoryName) {
                    if (!isset($categoryIds[$categoryName])) {
                        throw new RuntimeException(sprintf('Unknown category "%s".', $categoryName));
                    }

                    $this->linkArticleToCategory($articleId, $categoryIds[$categoryName]);
                }
            }

            $this->pdo->commit();
        } catch (\Throwable $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $exception;
        }
    }

    private function cleanTables(): void
    {
        $this->pdo->exec('DELETE FROM article_categories');
        $this->pdo->exec('DELETE FROM articles');
        $this->pdo->exec('DELETE FROM categories');
    }

    /**
     * @param array{title:string,description:string} $category
     */
    private function insertCategory(array $category): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO categories (title, description) VALUES (:title, :description)'
        );
        $statement->execute([
            ':title' => $category['title'],
            ':description' => $category['description'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param array{image:string,title:string,description:string,text:string,views:int,created_at:string,categories:list<string>} $article
     */
    private function insertArticle(array $article): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO articles (image, title, description, text, views, created_at) VALUES (:image, :title, :description, :text, :views, :created_at)'
        );
        $statement->execute([
            ':image' => $article['image'],
            ':title' => $article['title'],
            ':description' => $article['description'],
            ':text' => $article['text'],
            ':views' => $article['views'],
            ':created_at' => $article['created_at'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    private function linkArticleToCategory(int $articleId, int $categoryId): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO article_categories (article_id, category_id) VALUES (:article_id, :category_id)'
        );
        $statement->execute([
            ':article_id' => $articleId,
            ':category_id' => $categoryId,
        ]);
    }
}
