<?php
    
    namespace App;

    class Connection
    {
        public static function getDb()
        {
            try
            {
                $conn = new \PDO("mysql:host=localhost;dbname=clarim;charset=utf8",
                "root", "teste");

                return $conn;

            } catch(\PDOException $e) {
                //Tratar falhas na conexão
            }
        }
    }

?>