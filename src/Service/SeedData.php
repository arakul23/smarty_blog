<?php

declare(strict_types=1);

namespace App\Service;

use DateInterval;
use DateTimeImmutable;

final class SeedData
{
    /**
     * @return list<array{title:string,description:string}>
     */
    public static function categories(): array
    {
        return [
            [
                'title' => 'PHP',
                'description' => 'Практика и новости по PHP-разработке',
            ],
            [
                'title' => 'MySQL',
                'description' => 'Работа с SQL, индексами и оптимизацией',
            ],
            [
                'title' => 'Frontend',
                'description' => 'Шаблоны, UI и клиентская часть',
            ],
        ];
    }

    /**
     * @return list<array{image:string,title:string,description:string,text:string,views:int,created_at:string,categories:list<string>}>
     */
    public static function articles(): array
    {
        $baseDate = new DateTimeImmutable('2026-05-03 12:00:00');
        $articles = [
            [
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085',
                'title' => 'Как организовать структуру PHP-проекта без фреймворка',
                'description' => 'Простой каркас слоёв: controller, service, repository.',
                'text' => 'Даже без тяжёлого фреймворка проект стоит разделять по ответственности. Это упрощает тесты, поддержку и добавление новых сценариев.',
                'views' => 134,
                'categories' => ['PHP'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4',
                'title' => 'Почему strict_types снижает количество багов',
                'description' => 'Где строгая типизация особенно полезна в реальном коде.',
                'text' => 'strict_types делает поведение функций предсказуемым и не даёт молча приводить типы. Ошибки проявляются раньше, а значит исправляются дешевле.',
                'views' => 177,
                'categories' => ['PHP'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998',
                'title' => 'Value Object в PHP: когда это действительно нужно',
                'description' => 'Убираем невалидные значения на уровне модели.',
                'text' => 'Value Object полезен там, где есть бизнес-ограничения. Вместо проверок по коду лучше валидировать значение один раз при создании объекта.',
                'views' => 98,
                'categories' => ['PHP'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c',
                'title' => 'Исключения в PHP: где бросать, а где обрабатывать',
                'description' => 'Минимум хаоса в error handling.',
                'text' => 'Исключения стоит ловить у границ приложения, а не в каждой функции подряд. Так проще контролировать логику отката и формирование ответа.',
                'views' => 111,
                'categories' => ['PHP'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97',
                'title' => 'DTO против массивов: что лучше для передачи данных',
                'description' => 'Плюсы и минусы каждого подхода.',
                'text' => 'DTO даёт автодополнение и предсказуемую структуру, а массивы проще на старте. На росте проекта DTO обычно выигрывают по поддерживаемости.',
                'views' => 156,
                'categories' => ['PHP'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d',
                'title' => 'EXPLAIN в MySQL: читаем план выполнения',
                'description' => 'Как быстро находить узкие места в запросе.',
                'text' => 'План выполнения показывает, какие индексы реально используются и где происходит лишнее сканирование таблиц. Это базовый инструмент оптимизации.',
                'views' => 165,
                'categories' => ['MySQL'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                'title' => 'Составные индексы: порядок колонок имеет значение',
                'description' => 'Почему индекс (a, b) не равен индексу (b, a).',
                'text' => 'При проектировании составных индексов учитывай селективность и порядок фильтрации. Неправильный порядок может сделать индекс бесполезным.',
                'views' => 141,
                'categories' => ['MySQL'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa',
                'title' => 'Когда LIMIT не ускоряет запрос',
                'description' => 'Типовые случаи, где LIMIT не спасает.',
                'text' => 'Если сервер сначала сортирует большой набор, а потом применяет LIMIT, запрос всё равно остаётся тяжёлым. Нужен индекс под ORDER BY.',
                'views' => 93,
                'categories' => ['MySQL'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174',
                'title' => 'Нормализация и денормализация: практический компромисс',
                'description' => 'Как балансировать между чистотой схемы и скоростью.',
                'text' => 'Нормализация упрощает целостность данных, но для аналитики иногда нужна денормализация. Решение зависит от типа нагрузки и частоты обновлений.',
                'views' => 122,
                'categories' => ['MySQL'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd',
                'title' => 'Пагинация в MySQL без деградации на больших данных',
                'description' => 'Почему OFFSET перестаёт работать и что с этим делать.',
                'text' => 'Для больших таблиц стоит переходить на пагинацию по курсору или по последнему id. Это убирает полный перебор пропущенных строк.',
                'views' => 187,
                'categories' => ['MySQL'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6',
                'title' => 'Компонентный UI без лишней сложности',
                'description' => 'Как держать шаблоны читаемыми и переиспользуемыми.',
                'text' => 'Разделяй UI на повторяемые блоки и задавай им ясные входные параметры. Это уменьшает дублирование и делает верстку устойчивой к изменениям.',
                'views' => 152,
                'categories' => ['Frontend'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1523437113738-bbd3cc89fb19',
                'title' => 'CSS Grid для карточек: стабильная сетка без костылей',
                'description' => 'Настройки grid, которые работают в большинстве кейсов.',
                'text' => 'Используй фиксированный gap и адаптивные колонки через media query. Это помогает избежать прыжков layout и сохраняет ровный ритм карточек.',
                'views' => 129,
                'categories' => ['Frontend'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8',
                'title' => 'Семантика HTML в блоге: что реально важно',
                'description' => 'article, header, main и их влияние на поддержку.',
                'text' => 'Семантические теги упрощают работу со структурой страницы и делают шаблон понятнее. Это особенно заметно при росте проекта и рефакторинге.',
                'views' => 88,
                'categories' => ['Frontend'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1515876305429-1f3f24f8e6c2',
                'title' => 'Как организовать дизайн-токены в небольшом проекте',
                'description' => 'Цвета, отступы, типографика без хаоса.',
                'text' => 'Даже в простом UI стоит вынести базовые значения в переменные. Это ускоряет правки и снижает риск визуальных расхождений между блоками.',
                'views' => 117,
                'categories' => ['Frontend'],
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1484417894907-623942c8ee29',
                'title' => 'Мобильная адаптация: сначала контент, потом декор',
                'description' => 'Что резать в первую очередь для узких экранов.',
                'text' => 'На мобильном экране важнее скорость чтения и действия пользователя. Оставляй ключевые блоки, а второстепенные элементы упрощай или убирай.',
                'views' => 173,
                'categories' => ['Frontend'],
            ],
        ];

        foreach ($articles as $index => &$article) {
            $article['created_at'] = $baseDate->sub(new DateInterval('P' . $index . 'D'))
                ->format('Y-m-d H:i:s');
        }
        unset($article);

        return $articles;
    }
}
