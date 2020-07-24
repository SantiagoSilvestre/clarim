<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Campeonato extends Model {

        public function getCampeonato($id) {
            $query = "select ca.pontuacao, ca.saldo_gol, ca.gol_pro, 
                        ca.gol_contra, ca.cartao_ver, ca.cartao_amer,
                        ca.vitorias, ca.derrotas, ca.empates,
                        c.nome, t.time, c.regulamento
                        from cam_ativo ca 
                        inner join campeonato c on ca.id_campeonato = c.id
                        inner join time t on ca.id_time = t.id 
                        where c.finalizado = 0 and c.id = ".$id. "
                        order by ca.pontuacao desc, ca.vitorias desc, ca.saldo_gol desc,
                        ca.gol_pro desc, ca.gol_contra, ca.derrotas, ca.cartao_ver, ca.cartao_amer";

            return $this->db->query($query)->fetchAll();
        }

        public function getCampeonatos() {
            $query = "select * from campeonato where finalizado = 0";
            return $this->db->query($query)->fetchAll();
        }
    }


?>