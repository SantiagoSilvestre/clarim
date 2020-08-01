<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Time extends Model {

        private $id;
        private $time;
        private $creted;

        public function __get($atrituto) {
            return $this->$atrituto;
        }
        
        public function __set($atributo, $value) {
            $this->$atributo = $value;
        }

        public function salvar() {
            $query = "INSERT INTO time(time, created) VALUES (:time, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':time', $this->__get('time'));
            $stmt->execute();
            return $this;
        }

        public function atualizar() {
            $query = "UPDATE time SET time = :time WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':time', $this->__get('time'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function apagar() {
            $query = "DELETE FROM time WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function listarTimes($inicio, $qtd) {
            $query = "SELECT * FROM time ORDER BY time LIMIT $inicio, $qtd ";
            return $this->db->query($query)->fetchAll();
        }

        public function getTotalTime() {
            $query = "SELECT count(id) as qtd FROM time";
            return $this->db->query($query)->fetchAll();
        }

        public function getTotal() {
            $query = "SELECT count(id) as qtd FROM time";
            return $this->db->query($query)->fetchAll();
        }

        public function buscarPorId() {
            $query = "SELECT * FROM time where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $t = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($t['time'] != '') {
                $this->__set('time', $t['time']);
                $this->__set('id', $t['id']);
                $this->__set('created', $t['created']);
            } 
            return $this;
        }

        public function validarDados() {
            $valido = true;
            $erros = array();

            if($this->__get('time') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                $valido = false; 
            } 
            if(strlen($this->__get('time')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do Time está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM time WHERE time = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('time'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse time já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function validarEditarDados() {
            $valido = true;
            $erros = array();

            if($this->__get('time') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                $valido = false; 
            } 
            if(strlen($this->__get('time')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do Time está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM time WHERE time = :time and id != :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':time', $this->__get('time'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse time já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function listarTodosTimes($idc) {
                $query = "SELECT id_fase FROM jogo_mata
                where id_campeonato = '".$idc."'
                ORDER BY id_fase desc LIMIT 1";
                $result = $this->db->query($query)->fetchAll();
            $limite = 0;
            if(count($result) > 0) {
                switch ($result[0]['id_fase'] + 1) {
                    case 1:
                        $limite = 32;
                    break;
                    case 2:
                        $limite = 16;
                    case 3:
                        $limite = 8;
                    break;
                    case 4:
                        $limite = 4;
                    break;
                    case 5:
                        $limite = 2;
                }
                $query = "SELECT t.* FROM time t
                        JOIN jogo_mata jm on jm.resultado = t.id
                        where id_campeonato = '".$idc."'
                      ORDER BY id_fase desc, time LIMIT ".$limite."";
                $result = $this->db->query($query)->fetchAll();
                return $result;
            }else {
                $query = "SELECT t.* FROM time t
                        JOIN cam_ativo c on c.id_time = t.id
                        where id_campeonato = '".$idc."'
                      ORDER BY time";
                return $this->db->query($query)->fetchAll();
            }
        }

        public function listarTimesSemFiltro() {
            $query = "SELECT * FROM time 
            ORDER BY time";
            return $this->db->query($query)->fetchAll();
        }

        public function validarTime($idc, $idt) {
            $query = "SELECT c.* FROM cam_ativo c
            INNER JOIN time t on t.id = c.id_time
            INNER JOIN campeonato cp on c.id_campeonato = cp.id
            WHERE id_campeonato = '".$idc."' and id_time =  '".$idt."'
            ORDER BY time";
            return $this->db->query($query)->fetchAll();
        }

        public function buscarPorIdFiltro($id) {
            $query = "SELECT * FROM time where id != '".$id."'";
            return $this->db->query($query)->fetchAll();
        }

        public function cadastrarJogoMata($jogo) {
            $query = "INSERT INTO jogo_mata(id_time1, id_time2, id_fase, id_campeonato)
                    VALUES ('".$jogo[0]."','".$jogo[1]."', '".$jogo[3]."', '".$jogo[2]."')
                    ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $this;
        }

        public function validarMata($jogo) {
            $query = "SELECT * FROM jogo_mata 
            WHERE (id_time1 = '".$jogo[0]."' OR id_time1 = '".$jogo[1]."'
            OR id_time2 = '".$jogo[0]."' OR id_time2 = '".$jogo[1]."') 
            AND '".$jogo[3]."' = id_fase 
            AND id_campeonato = '".$jogo['2']."'";
            $result = $this->db->query($query)->fetchAll();
            if(count($result) > 0 ){
                return false;
            } else {
                return true;
            }
           
        }

        public function listarTimesFase($id) {
            $query = "SELECT t.* FROM time t
                        JOIN cam_ativo c on c.id_time = t.id
                        where id_campeonato = '".$id."' AND eliminado = 0
                      ORDER BY time";
            return $this->db->query($query)->fetchAll();
        }

        
    }

?>