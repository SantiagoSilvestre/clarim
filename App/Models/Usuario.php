<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Usuario extends Model {

        private $id;
        private $nome;
        private $email;
        private $senha = '12345678';
        private $primeiroAcesso;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $value){
            $this->$atributo = $value;
        }

        //salvar
        public function salvar() {
            $query = "INSERT INTO usuario(nome, email) 
                      VALUES (:nome, :email) ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            return $this;
        }

        //pesquisar e-mail
        public function acessar() {
            $query = "SELECT * from usuario where email = :email and senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($u['id'] != '' && $u['nome'] != '') {
                $this->__set('id', $u['id']);
                $this->__set('nome', $u['nome']);
                $this->__set('email', $u['email']);
                $this->__set('primeiroAcesso', $u['primeiro_acesso']);
                $this->__set('senha', $u['senha']);
            }
            return $this;
        }

        public function listarUsuarios($inicio, $qnt_result_pg){
            $query = "SELECT * FROM usuario ORDER BY nome LIMIT $inicio, $qnt_result_pg";
            return $this->db->query($query)->fetchAll();
        }

        public function buscarPorId(){
            $query = "SELECT * FROM usuario where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($u['nome'] != '' && $u['email'] != '') {
                $this->__set('nome', $u['nome']);
                $this->__set('email', $u['email']);
                $this->__set('primeiro_acesso', $u['primeiro_acesso']);
            } 
            return $this;

        }

        
        public function validarCadastro(){
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '' || $this->__get('email') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            }

            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome de usuário está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $query = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>O e-mail já existe e não pode ser cadastrado novamente <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function validarAtualizacao(){
            $valido = true;
            $erros = array();

            if($this->__get('nome') == '' || $this->__get('email') == '') {
                $erros[] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            }

            if(strlen($this->__get('nome')) < 3 ) {
                $erros[] = "<div class='alert alert-danger'>O nome de usuário está muito curto <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $query = "SELECT * FROM usuario WHERE email = :email and id != :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $u = $stmt->fetch((\PDO::FETCH_ASSOC));

            if($u['id'] != '') {
                
                $erros[] = "<div class='alert alert-danger'>O e-mail já existe e não pode ser cadastrado novamente <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
            }
            $erros['valido'] = $valido;

            return $erros;
        }

        public function atualizar() {
            $query = "UPDATE usuario SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $this;
        }

        public function resetar() {
            $query = "UPDATE usuario SET senha = '12345678', primeiro_acesso = '0' WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $stmt->fetch(\PDO::FETCH_ASSOC);
            return $this;
        }

        public function apagar() {
            $query = "DELETE FROM usuario WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $stmt->fetch(\PDO::FETCH_ASSOC);
            return $this;
        }

        public function getTotalRegistros(){
            $query = "SELECT count(id) as qtd FROM usuario";
            return $this->db->query($query)->fetchAll();
        }

        public function atualizarSenha() {
            $query = "UPDATE usuario SET senha = :senha, primeiro_acesso = 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $this;
        }


    }


?>