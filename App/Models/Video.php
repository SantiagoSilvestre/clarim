<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Video extends Model {

        private $id;
        private $nome;
        private $link;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $value) {
            $this->$atributo = $value;
        }

        public function salvar(){
            $query = "INSERT INTO videos(nome, link) VALUES (:nome, :link)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':link', $this->__get('link'));
            $stmt->execute();
            return $this;
        }

        public function apagar() {
            $query = "DELETE FROM videos WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function atualizar() {
            $query = "UPDATE videos SET nome = :nome WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function listarVideos($inicio, $qtd) {
            $query = "SELECT * FROM videos ORDER BY nome LIMIT $inicio, $qtd ";
            return $this->db->query($query)->fetchAll();
        }

        public function getTotalVideos() {
            $query = "SELECT count(id) as qtd FROM videos";
            return $this->db->query($query)->fetchAll();
        }

        public function validarDados() {
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '' || $this->__get('link') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                $valido = false; 
            } 
            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do vídeo está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM videos WHERE time = :nome";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('time'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse vídeo já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function buscarPorId() {
            $query = "SELECT * FROM videos where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $v = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($v['nome'] != '') {
                $this->__set('nome', $v['nome']);
                $this->__set('id', $v['id']);
                $this->__set('link', $v['link']);
            } 
            return $this;
        }

        public function validarEditarDados() {
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                $valido = false; 
            } 
            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome do Vídeo está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }

            $query = "SELECT * FROM videos WHERE nome = :nome and id != :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>Esse Vídeo já foi cadastrado <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function listarUltimos() {
            $query = "SELECT * FROM videos ORDER BY id DESC LIMIT 3 ";
            return $this->db->query($query)->fetchAll();
        }

    }

?>