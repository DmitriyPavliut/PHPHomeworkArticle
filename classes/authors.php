<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/DB.php';


class Authors extends DB
{
    /**
     * @param string $name имя автора
     * @return bool
     */
    public static function setAuthor($name): bool
    {
        return self::query("INSERT INTO `authors` (`NAME`) VALUES ('" . $name ."')");

    }


    /**
     * @param array $arSelect массив возвращаемых полей
     * @param array $arFilter массив для фильтрации вида поле->значение
     * @param array $arOrder массив для сортировки вида поле->asc|desc
     * @param array $arLimit ограничение выборки параметры offset, limit
     * @return mixed возвращает массив авторов
     */
    public static function getAuthorsList( array $arSelect, array $arFilter,array $arOrder, array $arLimit): array
    {
        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `authors`";

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

        return self::query($sql);

    }


    /**
     * @param mixed $id id автора
     * @param array $arSelect массив возвращаемых полей(необязательный)
     * @return array массив с полями товара
     */
    public static function getAuthor($id, array $arSelect)
    {

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `authors` WHERE ID={$id}";

        $res = self::query($sql);

        return (count($res) == 1) ? $res[0] : false;

    }

    /**
     * @param mixed $id id автора
     * @param array $arFields массив изменияемых полей и значений
     * @return bool результат выполнения
     */
    public static function updateAuthor($id, $arFields): bool
    {
        if (is_array($arFields) && (array_keys($arFields) !== range(0, count($arFields) - 1))) {

            $fields = self::editParameters($arFields, '=', ", ", '\'');

            return self::query("UPDATE `authors` SET {$fields} WHERE `authors`.`ID` = {$id};");

        } else {
            die("Ошибка параметров метода updateProduct");
        }
    }

    /**
     * @param mixed $id id удаляемого товара
     * @return bool результат выполнения
     */
    public static function deleteAuthor($id): bool
    {
        return self::query("DELETE FROM `authors` WHERE `products`.`id` = {$id};");
    }


    public static function getFieldsAuthor()
    {
        return self::getFieldsTable('authors');
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