{include file='components/head.tpl'}

<div class="blog-container">
    {include file='components/header.tpl' title=$article.title}
    <div class="page-actions">
        <a class="home-button" href="/index.php">На главную</a>
    </div>

    <main class="blog-content">
        <section class="article-page">
            {if isset($article)}
                <div class="article-top">
                    <a class="back-link" href="/index.php">Назад к списку</a>
                    <h1 class="article-title">{$article.title}</h1>
                    <div class="article-meta">
                        {if isset($article.category) && $article.category !== null}
                            <span>Категория: {$article.category.title}</span>
                        {/if}
                        <span>Дата: {$article.created_at|date_format:"%d.%m.%Y %H:%M"}</span>
                        <span>Просмотры: {$article.views}</span>
                    </div>
                </div>

                <div class="article-cover">
                    <img src="{$article.image}" alt="{$article.title}">
                </div>

                <div class="article-description">{$article.description}</div>
                <div class="article-text">{$article.text}</div>

                {if isset($relatedArticles) && $relatedArticles|@count > 0}
                    <section class="related-section">
                        <h2 class="related-title">Похожие статьи</h2>
                        <div class="related-grid">
                            {foreach from=$relatedArticles item=related}
                                <article class="related-card">
                                    <a class="related-card-link" href="/article.php?id={$related.id}">
                                        <div class="related-image">
                                            <img src="{$related.image}" alt="{$related.title}">
                                        </div>
                                        <div class="related-body">
                                            <h3 class="related-card-title">{$related.title}</h3>
                                            <p class="related-card-description">{$related.description}</p>
                                            <div class="related-meta">
                                                <span>{$related.created_at|date_format:"%d.%m.%Y"}</span>
                                                <span>{$related.views} просмотров</span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            {/foreach}
                        </div>
                    </section>
                {/if}
            {else}
                <h1 class="article-title">Статья не найдена</h1>
            {/if}
        </section>
    </main>

    {include file='components/footer.tpl'}
</div>
