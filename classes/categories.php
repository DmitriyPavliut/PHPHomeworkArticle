<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/DB.php';


class Categories extends DB
{
    /**
     * @param $name название категории
     * @return bool
     */
    public static function setСategory($name): bool
    {
        return self::query("INSERT INTO `categories` (`NAME`, `CODE`) VALUES ('" . $name . "', '" . self::translitString($name) . "')");

    }


    /**
     * @param array $arSelect массив возвращаемых полей
     * @param array $arFilter массив для фильтрации вида поле->значение
     * @param array $arOrder массив для сортировки вида поле->asc|desc
     * @param array $arLimit ограничение выборки параметры offset, limit
     * @return mixed возвращает массив товаров
     */
    public static function getCategoriesList( array $arSelect, array $arFilter, array $arOrder = ['id' => 'ASC'], array $arLimit): array
    {

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `categories`";

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
     * @param mixed $id id категории
     * @param array $arSelect массив возвращаемых полей(необязательный)
     * @return array массив с полями категории
     */
    public static function getСategory($id, array $arSelect)
    {

        $select = !empty($arSelect) ? implode(",", $arSelect) : '*';

        $sql = "SELECT {$select} FROM `categories` WHERE ID={$id}";

        $res = self::query($sql);

        return (count($res) == 1) ? $res[0] : false;

    }

    /**
     * @param mixed $id id категории
     * @param array $arFields массив изменияемых полей и значений
     * @return bool результат выполнения
     */
    public static function updateСategory($id, array $arFields): bool
    {
        if (is_array($arFields) && (array_keys($arFields) !== range(0, count($arFields) - 1))) {

            $fields = self::editParameters($arFields, '=', ", ", '\'');

            return self::query("UPDATE `categories` SET {$fields} WHERE `categories`.`ID` = {$id};");

        } else {
            die("Ошибка параметров метода updateProduct");
        }
    }

    /**
     * @param mixed $id id удаляемого товара
     * @return bool результат выполнения
     */
    public static function deleteСategory($id): bool
    {
        return self::query("DELETE FROM `categories` WHERE `categories`.`ID` = {$id};");
    }


    public static function getFieldsСategories()
    {
        return self::getFieldsTable('categories');
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