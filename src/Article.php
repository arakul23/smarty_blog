<?php

declare(strict_types=1);

namespace App;

use App\Repository\ArticleRepository;
use Smarty\Smarty;

class Article extends Smarty
{
    public function __construct(readonly private ArticleRepository $articleRepository)
    {
        parent::__construct();

        $this->setTemplateDir(__DIR__ . '/frontend/templates/');
        $this->setCompileDir(__DIR__ . '/templates_c/');
        $this->setCacheDir(__DIR__ . '/cache/');
        $this->setEscapeHtml(true);

        if (getenv('APP_ENV') === 'local') {
            $this->caching = Smarty::CACHING_OFF;
            $this->compile_check = true;
            $this->force_compile = true;
        } else {
            $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        }
    }

    public function article(int $id): void
    {
        if (getenv('APP_ENV') === 'local') {
            $this->clearCompiledTemplate();
            $this->clearAllCache();
        }

        $article = $this->articleRepository->findArticleById($id);
        $relatedArticles = $this->articleRepository->findRelatedArticlesByArticleId($article['id']);

        $this->assign('article', $article);
        $this->assign('relatedArticles', $relatedArticles);
        $this->display('article.tpl');
    }
}
