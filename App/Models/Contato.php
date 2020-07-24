<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Contato extends Model {

        private $id;
        private $nome;
        private $mail;
        private $telefone;
        private $assunto;
        private $mensagem;
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


    }


?>