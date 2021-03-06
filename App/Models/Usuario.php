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
        private $time;
        private $creditos;

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $value){
            $this->$atributo = $value;
        }

        //salvar
        public function salvar() {
            if ( $this->__get('time') == 0) {
                $id_time = NULL;
            } else {
                $id_time = $this->__get('time');
            }
            if ( $this->__get('creditos') == 0) {
                $cred = NULL;
            } else {
                $cred = $this->__get('creditos');
            }
            $query = "INSERT INTO usuario(nome, email, id_perfil, id_time, creditos) 
                      VALUES (:nome, :email, :perfil, :timee, :creditos) ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':perfil', $this->__get('perfil'));
            $stmt->bindValue(':timee', $id_time);
            $stmt->bindValue(':creditos', $cred);
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
                $this->__set('perfil', $u['id_perfil']);
                $this->__set('time', $u['id_time']);
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
            $query = "SELECT u.*, p.nome as perfil, t.time as nome_time, creditos FROM usuario u 
            INNER JOIN perfil p on u.id_perfil = p.id
            LEFT JOIN time t on u.id_time = t.id
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
                $this->__set('time', $u['nome_time']);
                $this->__set('creditos', $u['creditos']);
                
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

            if($this->__get('time') == 0 && $this->__get('perfil') > 1) {
                
                $erros[] = "<div class='alert alert-danger'>Selecione um time para o usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button></div>";
                $valido = false;
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
                $valido = false;
            }


            if ($this->__get('time') == 0 && $this->__get('perfil') > 1 ) {
                $erros[] = "<div class='alert alert-danger'>Necessário selecionar um time para o usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                $valido = false;
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
            $tim = $this->__get('time');
            $cred =  $this->__get('creditos');
            if ($tim == 0 ) {
                $tim = NULL;
                $cred = NULL;
            } 
            $query = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :perfil, id_time = :timee, creditos = :creditos WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':perfil', $this->__get('perfil'));
            $stmt->bindValue(':timee', $tim);
            $stmt->bindValue(':creditos', $cred);
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

        public function validarDel() {
            $query = "SELECT *  FROM events WHERE id_user_check = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($u != NULL) {
                return false;
            }else {
                return true;
            }
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

        public function getPermissoes() {
            $query = "SELECT p.descricao as permissao 
            FROM perfil_permissao pf
            INNER JOIN permissao p on pf.id_permissao = p.id
            WHERE pf.id_perfil = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('perfil'));
            $stmt->execute();
            $u = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $permissoes['permissao'] = [];
            foreach ($u as $p) {
                array_push($permissoes['permissao'], $p['permissao']);
            }
            return $permissoes;
        }

        public function getTime() {
            $query = "SELECT t.time as time FROM usuario u
            INNER JOIN time t ON u.id_time = t.id
            WHERE u.id = ". $this->__get('id');
            return $this->db->query($query)->fetchAll();
        }

        public function getEvents() {
            $query = "SELECT id, title, time1, time2, id_horario, data, start, end, gol_time1, gol_time2 FROM events";
            $result = $this->db->query($query)->fetchAll();
            $eventos = [];
            foreach($result as $r) {
                $id = $r['id'];
                $title = $r['title'];
                $time1 = $r['time1'];
                $time2 = $r['time2'];
                $id_horario = $r['id_horario'];
                $data = $r['data'];
                $start = $r['start'];
                $end = $r['end'];
                
                $eventos[] = [
                    'id' => $id,
                    'title' => $title,
                    'start' => $start,
                    'end' => $end,
                    'extendedProps' => [
                        'time1' => $time1,
                        'time2' => $time2,
                        'id_horario' => $id_horario,
                        'data' => $data,
                        'gol1' => $r['gol_time1'],
                        'gol2' => $r['gol_time2']
                    ]  
                ];
            }

            return $eventos;
        }

        public function getCreditos() {
            $query = "SELECT creditos FROM usuario where id = :id AND id_perfil != 1 ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $u;
        }

        public function atualizarCreditos($creditos) {
            $query = "UPDATE usuario SET creditos = :creditos WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':creditos', $creditos);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $u = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $this;
        }


    }


?>