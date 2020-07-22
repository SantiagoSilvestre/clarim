<?php

    namespace MF\Model;

    use App\Connection;

    class Container
    {
        public static function getModel($model)
        {
            $class = "\\App\\Models\\".ucfirst($model);            
            //instanciar a conexão
            $conn = Connection::getDb();
            return new $class($conn);
        }
    }

?>