<div class="blog-container">
    <header class="blog-header">
        <div class="logo">Blogy<span>.</span></div>
    </header>

    <main class="blog-content">
        {* Цикл по категориям *}
        {foreach from=$categories item=category}
        <section class="category-section">
            <div class="category-header">
                <h2 class="category-title">{$category.name|upper}</h2>
                <a href="{$category.url}" class="view-all">View All</a>
            </div>

            <div class="posts-grid">
                {* Цикл по статьям внутри категории *}
                {foreach from=$category.posts item=post}
                <article class="post-card">
                    <div class="post-image">
                        <img src="{$post.image}" alt="{$post.title}">
                    </div>
                    <div class="post-body">
                        <h3 class="post-title">{$post.title}</h3>
                        <time class="post-date">{$post.date|date_format:"%B %e, %Y"}</time>
                        <p class="post-excerpt">{$post.excerpt|truncate:150}</p>
                        <a href="{$post.url}" class="continue-reading">Continue Reading</a>
                    </div>
                </article>
                {/foreach}
            </div>
        </section>
        {/foreach}
    </main>

    <footer class="blog-footer">
        <p>Copyright &copy; 2023. All Rights Reserved.</p>
    </footer>
</div>