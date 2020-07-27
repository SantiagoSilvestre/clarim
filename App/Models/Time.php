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
            $query = "SELECT t.*, c.id_campeonato FROM time t
                      INNER JOIN cam_ativo c ON c.id_time = t.id
                      WHERE c.id_campeonato = '".$idc."'
                      ORDER BY time";
            return $this->db->query($query)->fetchAll();
        }

        public function listarTimesSemFiltro() {
            $query = "SELECT t.* FROM time t
            left JOIN cam_ativo c on t.id = c.id_time 
            WHERE c.id_time is null           
            ORDER BY time";
            return $this->db->query($query)->fetchAll();
        }


    }

?>