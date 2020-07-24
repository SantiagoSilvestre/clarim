<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Campeonato extends Model {

        public function getCampeonato() {
            $query = "select ca.pontuacao, ca.saldo_gol, ca.gol_pro, 
                        ca.gol_contra, ca.cartao_ver, ca.cartao_amer,
                        c.nome, t.time
                        from cam_ativo ca 
                        inner join campeonato c on ca.id_campeonato = c.id
                        inner join time t on ca.id_time = t.id";

            return $this->db->query($query)->fetchAll();
        }

        public function getCampeonatos() {
            $query = "select * from campeonato where finalizado = 0";
            return $this->db->query($query)->fetchAll();
        }
    }


?>