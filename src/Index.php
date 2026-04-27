<?php

declare(strict_types=1);

namespace Index;

use Smarty\Smarty;

class Index extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(__DIR__ . '/frontend/templates/');
        $this->setEscapeHtml(true);

        $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        $this->assign('app_name', 'Guest Book');
    }

    /**
     * @throws \Smarty\Exception
     */
    public function index(): void
    {
        $this->assign('name', 'Ned');
        $this->display('index.tpl');
    }
}