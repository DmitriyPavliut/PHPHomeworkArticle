<?php


class DB
{
    private static $host = 'localhost';
    private static $database = 'articles';
    private static $user = 'test';
    private static $password = 'test';


    protected static function query($query)
    {

        try {
            $dsn = "mysql:dbname=" . self::$database . ";host=" . self::$host;
            $dbh = new PDO($dsn, self::$user, self::$password);
            $dbh->exec("set names utf8");
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die ('Ошибка подключения:' . $e->getMessage());
        }

        $resQuery = [];
        foreach ($dbh->query($query, PDO::FETCH_ASSOC) as $row) {
            $resQuery[] = $row;
        }

        return $resQuery;
    }


    protected static function clearTable($table): bool
    {
        return self::query("TRUNCATE TABLE " . $table);
    }


    protected static function getFieldsTable($table): array
    {
        return DB::query("SELECT `COLUMN_NAME`, COLUMN_TYPE FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='" . self::$database . "' AND `TABLE_NAME`='{$table}'");
    }
}