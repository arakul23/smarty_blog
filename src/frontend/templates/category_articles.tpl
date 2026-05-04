{include file='components/head.tpl'}

<div class="blog-container">
    {include file='components/header.tpl' title="{$categoryWithArticles.title} ({$categoryWithArticles.description})"}
    <div class="page-actions">
        <a class="home-button" href="/index.php">На главную</a>
    </div>

    <main class="blog-content">
        <section class="category-section">
            <div class="category-header">
                <h2 class="category-title">Статьи</h2>
                <div class="sort-controls">
                    <a href="/categoryArticles.php?category={$categoryWithArticles.id}&sort=date&page=1"
                       class="sort-link {if $currentSort === 'date'}active{/if}">
                        По дате публикации
                    </a>
                    <a href="/categoryArticles.php?category={$categoryWithArticles.id}&sort=views&page=1"
                       class="sort-link {if $currentSort === 'views'}active{/if}">
                        По просмотрам
                    </a>
                </div>
            </div>
            <div class="posts-grid">
                {foreach from=$categoryWithArticles.articles item=article}
                    <a href="/article.php?id={$article.id}" class="post-link">
                        <article class="post-card">
                            <b>{$article.title}</b>
                            <div class="post-image">
                                <img src="{$article.image}" alt="{$article.title}">
                            </div>
                            {$article.description}
                        </article>
                    </a>
                {/foreach}
            </div>
            {if $categoryWithArticles.pagination.total_pages > 1}
                <div class="pagination">
                    {if $categoryWithArticles.pagination.current_page > 1}
                        <a class="pagination-link"
                           href="/categoryArticles.php?category={$categoryWithArticles.id}&sort={$currentSort}&page={$categoryWithArticles.pagination.current_page - 1}">
                            Назад
                        </a>
                    {/if}
                    {for $pageNumber=1 to $categoryWithArticles.pagination.total_pages}
                        <a class="pagination-link {if $pageNumber === $categoryWithArticles.pagination.current_page}active{/if}"
                           href="/categoryArticles.php?category={$categoryWithArticles.id}&sort={$currentSort}&page={$pageNumber}">
                            {$pageNumber}
                        </a>
                    {/for}
                    {if $categoryWithArticles.pagination.current_page < $categoryWithArticles.pagination.total_pages}
                        <a class="pagination-link"
                           href="/categoryArticles.php?category={$categoryWithArticles.id}&sort={$currentSort}&page={$categoryWithArticles.pagination.current_page + 1}">
                            Вперед
                        </a>
                    {/if}
                </div>
            {/if}
        </section>
    </main>

    {include file='components/footer.tpl'}
</div>
