<?php

    namespace App\Models;
    use MF\Model\Model;

    Class Usuario extends Model {

        private $id;
        private $nome;
        private $email;
        private $senha = '12345678';
        private $primeiroAcesso;
        private $perfil;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $value){
            $this->$atributo = $value;
        }

        //salvar
        public function salvar() {
            $query = "INSERT INTO usuario(nome, email, id_perfil) 
                      VALUES (:nome, :email, :perfil) ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':perfil', $this->__get('perfil'));
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

        public function listarUsuariosSenha($inicio, $qnt_result_pg){
            $query = "SELECT u.* FROM usuario u
            INNER JOIN solicitacao_senha s on u.id = s.id_usuario
            WHERE resetado = 0
            ORDER BY nome LIMIT $inicio, $qnt_result_pg";
            return $this->db->query($query)->fetchAll();
        }

        public function buscarPorId(){
            $query = "SELECT u.*, p.nome as perfil FROM usuario u 
            INNER JOIN perfil p on u.id_perfil = p.id
            where u.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($u['nome'] != '' && $u['email'] != '') {
                $this->__set('nome', $u['nome']);
                $this->__set('email', $u['email']);
                $this->__set('primeiro_acesso', $u['primeiro_acesso']);
                $this->__set('perfil', $u['perfil']);
            } 
            return $this;

        }

        public function buscarPorEmail()
        {
            $query = "SELECT * FROM usuario where email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($u != null) {

                
                $query = "SELECT * FROM solicitacao_senha  where id_usuario = :id_user AND resetado = 0";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id_user', $u['id']);
                $stmt->execute();
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if($user['id'] != null || $user['id'] != '') {
                    return true;
                }
                
                $query = "INSERT INTO solicitacao_senha (id_usuario) VALUES (:id_user)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id_user', $u['id']);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        }

        public function solicitacaoReset() {
            $query = "SELECT count(id) as qtd FROM solicitacao_senha WHERE resetado = 0";
            return $this->db->query($query)->fetchAll();
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

            if($this->__get('perfil') == 0) {
                
                $erros[] = "<div class='alert alert-danger'>Selecione um perfil para o usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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

            if ($this->__get('perfil') == 0) {
                $erros[] = "<div class='alert alert-danger'>Necessário selecionar um perfil <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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
            $query = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :perfil WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':perfil', $this->__get('perfil'));
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

            $query = "UPDATE solicitacao_senha SET resetado = '1' WHERE id_usuario = :id and resetado = 0";
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

        public function getPerfils() {
            $query = "SELECT * FROM perfil";
            return $this->db->query($query)->fetchAll();
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