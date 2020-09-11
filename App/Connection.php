<?php
    
    namespace App;

    class Connection
    {
        public static function getDb()
        {
            try
            {
                $conn = new \PDO("mysql:host=localhost;dbname=clarim;charset=utf8",
                "root@177.62.96.82", "s0202903526@");

                return $conn;

            } catch(\PDOException $e) {
                //Tratar falhas na conexão
            }
        }
    }

?>