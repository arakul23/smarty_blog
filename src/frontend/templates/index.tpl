{include file='components/head.tpl'}

<div class="blog-container">
    {include file='components/header.tpl' title="Главная"}

    <main class="blog-content">
        {foreach from=$categories item=category}
            <section class="category-section">
                <div class="category-header">
                    <h2 class="category-title">{$category.title|upper}</h2>
                    <a href="/categoryArticles.php?category={$category.id}" class="view-all">View All</a>
                </div>

                <div class="posts-grid">
                    {foreach from=$category.articles item=article}
                        <a href="/article.php?id={$article.id}" class="post-link">
                            <article class="post-card">
                                <div class="post-image">
                                    <img src="{$article.image}" alt="{$article.title}">
                                </div>
                                <b>{$article.title}</b>
                            </article>
                        </a>
                    {/foreach}
                </div>
            </section>
        {/foreach}
    </main>

    {include file='components/footer.tpl'}
</div>
