CREATE DATABASE smarty_blog;

USE smarty_blog;

CREATE TABLE categories (
             id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
             title VARCHAR(255) NOT NULL,
             description VARCHAR(255) NOT NULL
);

CREATE TABLE articles (
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            image TEXT,
            title VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            text TEXT NOT NULL,
            views BIGINT NOT NULL DEFAULT 0
);

CREATE TABLE article_categories (
           article_id INT NOT NULL,
           category_id INT NOT NULL,
           FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
           FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

