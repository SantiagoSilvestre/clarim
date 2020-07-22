<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Contato extends Model {

        public function getContatos() {
            $query = "select * from contato";
            return $this->db->query($query)->fetchAll();

        }
    }


?>