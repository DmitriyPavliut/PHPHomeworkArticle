<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/DB.php';


class Articles extends DB
{
    /**
     * @param mixed $id  id товара
     * @param string заголовок товара
     * @param numeric цена товара
     * @param string описание товара
     * @param string категория товара
     * @param string ссылка на изображение
     */
    public static function setArticle($id, $title, $price, $description, $category, $image): bool
    {
        return self::query("INSERT INTO `products` (`id`, `title`, `price`, `description`, `category`, `image`) VALUES ('" . $id . "', '" . str_replace('\'', '\\\'', $title) . "', '" . str_replace('\'', '\\\'', $price) . "', '" . str_replace('\'', '\\\'', $description) . "', '" . str_replace('\'', '\\\'', $category) . "', '" . str_replace('\'', '\\\'', $image) . "')");

    }


    /**
     * @param array $arSelect массив возвращаемых полей
     * @param array $arFilter массив для фильтрации вида поле->значение
     * @param array $arOrder массив для сортировки вида поле->asc|desc
     * @param array $arLimit ограничение выборки параметры offset, limit
     * @return mixed возвращает массив товаров
     */
    public static function getArticlesList($arSelect = [], $arFilter = [], $arOrder = ['id' => 'ASC'], $arLimit = []): array
    {
        $arParams = [$arSelect, $arFilter, $arOrder, $arLimit];
        foreach ($arParams as $param) {
            if (is_array($param) == false) {
                die("Ошибка параметров метода getProductsList");
            }

        }

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `products`";

        if (!empty($arFilter)) {
            $filter = self::editParameters($arFilter, '=', " AND ", '\'');

            $sql .= " WHERE {$filter}";
        }

        $order = self::editParameters($arOrder, ' ', ",");
        $sql .= " ORDER BY {$order}";

        if (!empty($arLimit) && isset($arLimit['limit'])) {
            $sql .= " LIMIT {$arLimit['limit']} ";
            $sql .= isset($arLimit['offset']) ? " OFFSET {$arLimit['offset']} " : "";
        }

        return self::query($sql);

    }


    /**
     * @param mixed $id id товара
     * @param array $arSelect массив возвращаемых полей(необязательный)
     * @return array массив с полями товара
     */
    public static function getArticle($id, $arSelect = [])
    {

        if (is_array($arSelect) == false) {
            die("Ошибка параметров метода getProductsList");
        }

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `products` WHERE id={$id}";

        $res = self::query($sql);

        return (count($res) == 1) ? $res[0] : false;

    }

    /**
     * @param mixed $id id товара
     * @param array $arFields массив изменияемых полей и значений
     * @return bool результат выполнения
     */
    public static function updateArticle($id, $arFields): bool
    {
        if (is_array($arFields) && (array_keys($arFields) !== range(0, count($arFields) - 1))) {

            $fields = self::editParameters($arFields, '=', ", ", '\'');

            return self::query("UPDATE `products` SET {$fields} WHERE `products`.`id` = {$id};");

        } else {
            die("Ошибка параметров метода updateProduct");
        }
    }

    /**
     * @param mixed $id id удаляемого товара
     * @return bool результат выполнения
     */
    public static function deleteArticle($id): bool
    {
        return self::query("DELETE FROM `products` WHERE `products`.`id` = {$id};");
    }


    public static function getFieldsArticle()
    {
        return self::getFieldsTable('products');
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