<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Campeonato extends Model {

        private $id;
        private $nome;
        private $finalizado = 0;
        private $regulamento;
        private $created;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $value) {
            $this->$atributo = $value;
        }

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
        public function getTotalCamp() {
            $query = "select count(id) as qtd from campeonato where finalizado = 0";
            return $this->db->query($query)->fetchAll();
        }
        public function listarCampeonatos($inicio, $qnt_result_pg) {
            $query = "SELECT * FROM campeonato WHERE finalizado = 0 ORDER BY nome LIMIT $inicio, $qnt_result_pg ";
            return $this->db->query($query)->fetchAll();
        }

        public function buscarPorId() {
            $query = "SELECT * FROM campeonato where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $c = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($c['nome'] != '' && $c['finalizado'] == 0) {
                $this->__set('nome', $c['nome']);
                $this->__set('finalizado', $c['finalizado']);
                $this->__set('regulamento', $c['regulamento']);
            } 
            return $this;
        }

        public function salvar() {
            $query = "INSERT INTO campeonato(nome, regulamento, created) 
            VALUES (:nome, :regulamento, NOW()) ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':regulamento', $this->__get('regulamento'));
            $stmt->execute();
            return $this;
        }

        public function inserirJogo($time) 
        {
            $query = "SELECT vitorias from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $vitorias =  $this->db->query($query)->fetchAll();
            $vitorias = $vitorias[0]['vitorias'] + $time['vitoria'];

            $query = "SELECT derrotas from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $derrotas =  $this->db->query($query)->fetchAll();
            $derrotas = $derrotas[0]['derrotas'] + $time['derrota'];

            $query = "SELECT empates from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $empates =  $this->db->query($query)->fetchAll();
            $empates = $empates[0]['empates'] + $time['empate'];

            $query = "SELECT pontuacao from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $pontuacao =  $this->db->query($query)->fetchAll();
            $pontuacao = $pontuacao[0]['pontuacao'] + $time['pontos'];

            $query = "SELECT gol_pro from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $gol_pro =  $this->db->query($query)->fetchAll();
            $gol_pro = $gol_pro[0]['gol_pro'] + $time['gol'];

            $query = "SELECT gol_contra from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $gol_contra =  $this->db->query($query)->fetchAll();
            $gol_contra = $gol_contra[0]['gol_contra'] + $time['golContra'];

            $saldo_gol = $gol_pro - $gol_contra;

            $query = "SELECT cartao_ver from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $cartao_ver =  $this->db->query($query)->fetchAll();
            $cartao_ver = $cartao_ver[0]['cartao_ver'] + $time['vermelho'];

            $query = "SELECT cartao_amer from cam_ativo 
            WHERE id_campeonato = '".$this->__get('id')."' AND id_time = '".$time['id']."'";
            $cartao_amer =  $this->db->query($query)->fetchAll();
            $cartao_amer = $cartao_amer[0]['cartao_amer'] + $time['amarelo'];

            
            $query = "UPDATE cam_ativo SET vitorias = '".$vitorias."', derrotas = '".$derrotas."',
                    empates = '".$empates."', pontuacao = '".$pontuacao."', saldo_gol = '".$saldo_gol."',
                    gol_pro = '".$gol_pro."', gol_contra = '".$gol_contra."', cartao_ver = '".$cartao_ver."',
                    cartao_amer = '".$cartao_amer."'
                    WHERE id_campeonato = :idc AND id_time = :idt
                ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idc', $this->__get('id') );
            $stmt->bindValue(':idt', $time['id']);
            $stmt->execute();
        }

        public function atualizar() {
            $query = "UPDATE campeonato SET nome = :nome, regulamento = :regulamento WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':regulamento', $this->__get('regulamento'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function apagar() {
            $query = "DELETE FROM campeonato WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function validarDados() {
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            }

            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do campeonato está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM campeonato WHERE nome = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse campeonato já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function validarEdicaoDados() {
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            }

            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do campeonato está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM campeonato WHERE nome = :nome and id != :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse campeonato já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function finalizar() {
            $query = "UPDATE campeonato set finalizado = 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function getTotalCampFinalizado() {
            $query = "select count(id) as qtd from campeonato where finalizado = 1";
            return $this->db->query($query)->fetchAll();
        }

        public function inserirTime($idt, $idc) {
            $query = "INSERT INTO cam_ativo (id_campeonato, id_time, vitorias, derrotas,
             empates, pontuacao, saldo_gol, gol_pro, gol_contra, cartao_ver, cartao_amer, created) 
             VALUES ('".$idc."', '".$idt."', 0,0,0,0,0,0,0,0,0,NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

        }

    }


?>