<?php

declare(strict_types=1);

namespace App\Container;

use App\Article;
use App\CategoryArticles;
use App\Database\ConnectionFactory;
use App\Database\ConnectionRegistry;
use App\Index;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;

class AppContainer
{
    private ?ConnectionRegistry $connectionRegistry = null;

    private ?CategoryRepository $categoryRepository = null;

    private ?ArticleRepository $articleRepository = null;

    private ?Index $index = null;

    private ?CategoryArticles $categoryArticles = null;

    private ?Article $article = null;

    public function getIndex(): Index
    {
        if ($this->index === null) {
            $this->index = new Index($this->getCategoryRepository());
        }

        return $this->index;
    }

    public function getCategoryArticles(): CategoryArticles
    {
        if ($this->categoryArticles === null) {
            $this->categoryArticles = new CategoryArticles($this->getCategoryRepository());
        }

        return $this->categoryArticles;
    }

    public function getArticle(): Article
    {
        if ($this->article === null) {
            $this->article = new Article($this->getArticleRepository());
        }

        return $this->article;
    }

    private function getCategoryRepository(): CategoryRepository
    {
        if ($this->categoryRepository === null) {
            $this->categoryRepository = new CategoryRepository($this->getConnectionRegistry()->getConnection());
        }

        return $this->categoryRepository;
    }

    private function getArticleRepository(): ArticleRepository
    {
        if ($this->articleRepository === null) {
            $this->articleRepository = new ArticleRepository(
                $this->getConnectionRegistry()->getConnection()
            );
        }

        return $this->articleRepository;
    }

    private function getConnectionRegistry(): ConnectionRegistry
    {
        if ($this->connectionRegistry === null) {
            $this->connectionRegistry = new ConnectionRegistry(new ConnectionFactory());
        }

        return $this->connectionRegistry;
    }
}
