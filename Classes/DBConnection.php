<?php

class DBConnection
{
    public static function getConnection()
    {
        $path = 'C:\xampp\htdocs\WritingCentral\Author.db';
        $db = new SQLite3($path);
        return $db;
    }
}

?>