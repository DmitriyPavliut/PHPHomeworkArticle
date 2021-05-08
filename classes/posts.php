<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/DB.php';


class Posts extends DB
{
    /**
     * @param bool $active активность записи
     * @param string $title заголовок
     * @param string $content текст статьи
     * @param int $categoryId id категории
     * @param int $authorId id автора
     * @return bool
     */
    public static function setPost($active, $title, $content, $categoryId, $authorId): bool
    {
        return self::query("INSERT INTO `posts` (`ACTIVE`, `TITLE`, `CODE`, `CONTENT`, `CATEGORY_ID`,`AUTHOR_ID`,`DATE`) VALUES ('" . $active . "', '" . $title . "', '" . self::translitString($title) . "', '" . $content . "', '" . $categoryId . "', '" . $authorId . "', '" . date("Y-m-d H:i:s") . "')");

    }


    /**
     * @param array $arSelect массив возвращаемых полей
     * @param array $arFilter массив для фильтрации вида поле->значение
     * @param array $arOrder массив для сортировки вида поле->asc|desc
     * @param array $arLimit ограничение выборки параметры offset, limit
     * @return mixed возвращает массив публикаций
     */
    public static function getPostsList(array $arSelect, array $arFilter, array $arOrder, array $arLimit): array
    {

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `posts`";

        if (!empty($arFilter)) {
            $filter = self::editParameters($arFilter, '=', " AND ", '\'');

            $sql .= " WHERE {$filter}";
        }

        $order = !empty($arOrder) ? self::editParameters($arOrder, ' ', ",") : 'ID ASC';
        $sql .= " ORDER BY {$order}";

        if (!empty($arLimit) && isset($arLimit['limit'])) {
            $sql .= " LIMIT {$arLimit['limit']} ";
            $sql .= isset($arLimit['offset']) ? " OFFSET {$arLimit['offset']} " : "";
        }

        print_r($sql);

        return self::query($sql);

    }

    public static function getExpPostsList(array $arSelect, array $arFilter, array $arOrder, array $arLimit): array
    {

        $select = !empty($arSelect) ? 'posts.'.implode(", posts.", $arSelect) : 'posts.*';

        $sql = "SELECT {$select}, categories.NAME as CATEGORY_NAME, categories.CODE as CATEGORY_CODE FROM posts LEFT JOIN categories ON posts.CATEGORY_ID=categories.ID";

        if (!empty($arFilter)) {
            $filter = 'posts.'.self::editParameters($arFilter, '=', " AND posts.", '\'');

            $sql .= " WHERE {$filter}";
        }

        $order = !empty($arOrder) ? 'posts.'.self::editParameters($arOrder, ' ', ",") : 'posts.ID ASC';
        $sql .= " ORDER BY {$order}";

        if (!empty($arLimit) && isset($arLimit['limit'])) {
            $sql .= " LIMIT {$arLimit['limit']} ";
            $sql .= isset($arLimit['offset']) ? " OFFSET {$arLimit['offset']} " : "";
        }


        return self::query($sql);

    }


    /**
     * @param mixed $id id публикации
     * @param array $arSelect массив возвращаемых полей(необязательный)
     * @return array массив с полями публикации
     */
    public static function getPost($id, array $arSelect)
    {

        $select = !empty($arSelect) ? 'posts.'.implode(", posts.", $arSelect) : 'posts.*';

        $sql = "SELECT {$select}, categories.NAME as CATEGORY_NAME, categories.CODE as CATEGORY_CODE, authors.NAME as AUTHOR_NAME FROM posts, categories, authors WHERE posts.CATEGORY_ID=categories.ID AND posts.AUTHOR_ID=authors.ID AND posts.ID={$id}";

        $res = self::query($sql);

        return (count($res) == 1) ? $res[0] : false;

    }

    /**
     * @param mixed $id id публикации
     * @param array $arFields массив изменияемых полей и значений
     * @return bool результат выполнения
     */
    public static function updatePost($id, array $arFields): bool
    {
        if (is_array($arFields) && (array_keys($arFields) !== range(0, count($arFields) - 1))) {

            $fields = self::editParameters($arFields, '=', ", ", '\'');

            return self::query("UPDATE `posts` SET {$fields} WHERE `posts`.`ID` = {$id};");

        } else {
            die("Ошибка параметров метода updateProduct");
        }
    }

    /**
     * @param mixed $id id удаляемой публикации
     * @return bool результат выполнения
     */
    public static function deletePost($id): bool
    {
        return self::query("DELETE FROM `posts` WHERE `posts`.`ID` = {$id};");
    }


    public static function getFieldsPosts()
    {
        return self::getFieldsTable('posts');
    }

    public static function countPosts($arFilter = [])
    {
        $sql = "SELECT count(*) as COUNT FROM posts";
        if (!empty($arFilter)) {
            $filter = self::editParameters($arFilter, '=', " AND ", '\'');

            $sql .= " WHERE {$filter}";
        }
        return self::query($sql)[0];
    }


    private static function translitString($string)
    {
        $arRusLetters = [
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
            'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
            'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
            'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
            'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            ' ',
        ];

        $arTranslitLetters = [
            'A', 'B', 'V', 'G', 'D', 'E', 'IO', 'ZH', 'Z', 'I', 'I',
            'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
            'H', 'C', 'CH', 'SH', 'SH', '`', 'Y', '`', 'E', 'IU', 'IA',
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i',
            'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
            'h', 'c', 'ch', 'sh', 'sh', '`', 'y', '`', 'e', 'iu', 'ia',
            '_'
        ];

        return str_replace($arRusLetters, $arTranslitLetters, $string);
    }

    private static function editParameters($arParam, $connector, $separator, $otherConnector = '')
    {
        $array = [];
        foreach ($arParam as $key => $value) {
            $array[] = $key . $connector . $otherConnector . $value . $otherConnector;
        }
        return implode($separator, $array);
    }
}