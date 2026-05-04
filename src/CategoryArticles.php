<?php
declare(strict_types=1);

namespace App;

use App\Repository\CategoryRepository;
use Smarty\Smarty;

class CategoryArticles extends Smarty
{
    public function __construct(readonly private CategoryRepository $categoryRepository)
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

    public function categoryArticles(int $categoryId, string $sortBy = 'date', int $page = 1): void
    {
        if (getenv('APP_ENV') === 'local') {
            $this->clearCompiledTemplate();
            $this->clearAllCache();
        }

        $categoryWithArticles = $this->categoryRepository->findCategoryByIdWithArticles(
            $categoryId,
            $sortBy,
            $page
        );
        $this->assign('categoryWithArticles', $categoryWithArticles);
        $this->assign('currentSort', $sortBy);
        $this->display('category_articles.tpl');
    }
}
