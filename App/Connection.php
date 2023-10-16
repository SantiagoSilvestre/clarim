<?php
    
    namespace App;

    class Connection
    {
        public static function getDb()
        {
            try
            {
                $conn = new \PDO("mysql:host=localhost;dbname=clarim;charset=utf8",
                "user", "password");

                return $conn;

            } catch(\PDOException $e) {
                //Tratar falhas na conexão
            }
        }
    }

?>
