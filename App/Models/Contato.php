<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Contato extends Model {

        private $id;
        private $nome;
        private $email;
        private $telefone;
        private $assunto;
        private $mensagem;
        private $visualizada;
        private $respondida;
        private $data;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $value){
            $this->$atributo = $value;
        }

        public function getContatos() {
            $query = "select * from contato";
            return $this->db->query($query)->fetchAll();

        }

        //salvar
        public function salvar() {
            $query = "INSERT INTO contato(nome, email, telefone, assunto, mensagem, created) 
                      VALUES (:nome, :email, :telefone, :assunto, :mensagem, NOW()) ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':telefone', $this->__get('telefone'));
            $stmt->bindValue(':assunto', $this->__get('assunto'));
            $stmt->bindValue(':mensagem', $this->__get('mensagem'));
            $stmt->execute();
            return $this;
        }

        public function validarContato(){
            $valido = true;
            if(strlen($this->__get('nome')) < 3 ) {
                $valido = false;
            }
            if(strlen($this->__get('mensagem')) < 10) {
                $valido = false;
            }
            return $valido;
        }

        public function listarMensagens($inicio, $qtd) {
            $query = "SELECT * FROM contato WHERE visualizada = 0 or respondida = 0 ORDER BY created DESC LIMIT $inicio, $qtd ";
            return $this->db->query($query)->fetchAll();
        }

        public function getTotalMensagens() {
            $query = "SELECT count(id) as qtd FROM contato WHERE visualizada = 0 and respondida = 0";
            return $this->db->query($query)->fetchAll();
        }

        public function apagar() {
            $query = "DELETE FROM contato WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function buscarPorId() {
            $query = "SELECT * FROM contato where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($u['nome'] != '' && $u['email'] != '') {
                $this->__set('nome', $u['nome']);
                $this->__set('email', $u['email']);
                $this->__set('id', $u['id']);
                $this->__set('assunto', $u['assunto']);
                $this->__set('mensagem', $u['mensagem']);
                $this->__set('visualizada', $u['visualizada']);
                $this->__set('respondida', $u['respondida']);
                $this->__set('data', $u['created']);
            } 
            return $this;
        }

        public function marcarVisualizada() {
            $query = "UPDATE contato SET visualizada = 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function marcarRespondida() {
            $query = "UPDATE contato SET respondida = 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

        public function getNaoLidas() {
            $query = "SELECT count(id) as qtd FROM contato WHERE visualizada = 0";
            return $this->db->query($query)->fetchAll();
        }

        public function getNaoResp() {
            $query = "SELECT count(id) as qtd FROM contato WHERE respondida = 0";
            return $this->db->query($query)->fetchAll();
        }

        public function getTotal() {
            $query = "SELECT count(id) as qtd FROM contato";
            return $this->db->query($query)->fetchAll();
        }

        public function getLidasResp() {
            $query = "SELECT count(id) as qtd FROM contato WHERE visualizada = 1 and respondida = 1";
            return $this->db->query($query)->fetchAll();
        }


    }


?>