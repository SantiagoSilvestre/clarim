<?php

    namespace App\Controllers;
    // Recursos do miniframewor
    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    use App\Models\Produto;
    use App\Models\Info;
    use App\Models\Contato;

    class UserController extends Action 
    {
        
        public function login()
        {       
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('login', 'head', 'menu' ,'body', 'footer_login');
        }

        public function esqueceuSenha()
        {
            $this->render('esqueceuSenha', 'head', 'menu_login' ,'body', 'footer_login');
        }

        public function solicitarSenha()
        {
            $user = Container::getModel('Usuario');
            $user->__set('email', $_POST['email']);
            $result = $user->buscarPorEmail();
            if($result) {
                session_start();
                $_SESSION['msg'] = "<div class='alert alert-success'> Solicitação de nova senha concluída, aguarde nosso contato!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            }
            echo json_encode($result);
        }

        public function cadastrarUsuarios()
        {
            $this->render('cad_usuario', 'head', 'menu_adm' ,'body', 'footer');
        }

        public function listarSolicitacaoSenha()
        {
            $this->render('listarSolicitacaoSenha', 'head', 'menu_adm' ,'body', 'footer');
        }


        public function valida(){
            $senha = $_POST['senha'];
            $senha = $senha == '12345678' ? $senha : md5($senha);
            $user = Container::getModel('Usuario');
            $user->__set('email', $_POST['usuario']);
            $user->__set('senha', $senha);
            $user->acessar(); 
            if ( $user->__get('id') && $user->__get('nome')) {
                $permissoes = $user->getPermissoes();

                session_start();
                $_SESSION['id'] = $user->__get('id');
                $_SESSION['nome'] = $user->__get('nome') ;
                $_SESSION['logado'] = true;
                $_SESSION['permissoes'] = $permissoes;
                if ($user->__get('primeiroAcesso') == 0) {
                    header('Location: /clarim/adm/trocarSenha');
                } else {
                    header('Location: /clarim/adm/home');
                }
               
            } else {
                header('Location: /clarim/adm/login?login=erro');
            }         
        }

        public function home()
        {
            $this->render('home', 'head', 'menu_adm', 'body', 'footer');
        }   

        public function sair()
        {
            session_start();
            unset($_SESSION['id']);
            unset($_SESSION['nome']);
            unset($_SESSION['logado']);
            unset($_SESSION['permissoes']);
            header('Location: /clarim/adm/login');
        }

        public function usuarios() {
            $this->render('listarUsuarios', 'head', 'menu_adm', 'body', 'footer');
        }

        public function agenda() {
            $this->render('agenda', 'head', 'menu_adm', 'body', 'footer');
        }

        public function eventos() {
            $usuario = Container::getModel('Usuario');
            $eventos = $usuario->getEvents();
            echo json_encode($eventos);
        }

        public function visualizarUsuarios() {
            $user = Container::getModel('Usuario');
            $user->__set('id', $_GET['id']);
            $user->buscarPorId();
            $this->view->dados = $user;
            $this->render('visualizarUser', 'head', 'menu_adm', 'body', 'footer');
        }

        public function cadUsuarios() {
            session_start();
            $user = Container::getModel('Usuario');
            $user->__set('nome', $_POST['nome']);
            $user->__set('email', $_POST['email']);
            $user->__set('perfil', $_POST['perfil']);
            $user->__set('time', $_POST['time']);
            $retorno = $user->validarCadastro();
            if ($retorno['valido']) {
                $user->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Usuário cadastrado com sucesso! Necessita trocar a senha no primeiro acesso.
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/usuarios');
            } else {
                unset($retorno['valido']);
                $_SESSION['dados']['nome'] = $user->__get('nome');
                $_SESSION['dados']['email'] = $user->__get('email');
                $_SESSION['dados']['perfil'] = $user->__get('perfil');
                $_SESSION['dados']['time'] = $user->__get('time');
                $_SESSION['erros'] = $retorno;
                header('Location: /clarim/adm/cadastrar/cad_usuario');
            }
        }

        public function editUsuarios() {
            $id = null;
            if(isset($_SESSION['dados']['id'])) {
                $id = $_SESSION['dados']['id'];
            } else {
                $id = isset ($_GET['id']) ? $_GET['id'] : 1;
            }
            $user = Container::getModel('Usuario');
            $user->__set('id', $id);
            $user->buscarPorId();
            $this->view->dados = $user;
            $this->render('editarUser', 'head', 'menu_adm', 'body', 'footer');
        }

        public function editarUsuarios() {
            session_start();
            $user = Container::getModel('Usuario');
            $user->__set('nome', $_POST['nome']);
            $user->__set('email', $_POST['email']);
            $user->__set('id', $_POST['id']);
            $user->__set('perfil', $_POST['perfil']);
            $user->__set('time', $_POST['time']);
            $retorno = $user->validarAtualizacao();
            if ($retorno['valido']) {
                $user->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Usuário Editado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/usuarios');
            } else {
                unset($retorno['valido']);
                $_SESSION['dados']['id'] = $user->__get('id');
                $_SESSION['dados']['nome'] = $user->__get('nome');
                $_SESSION['dados']['email'] = $user->__get('email');
                $_SESSION['dados']['perfil'] = $user->__get('perfil');
                $_SESSION['dados']['time'] = $user->__get('time');
                $_SESSION['erros'] = $retorno;
                header('Location: /clarim/adm/usuarios/edit_user');
            }
        }

        public function resetarUsuario() {
            session_start();
            $user = Container::getModel('Usuario');
            $user->__set('id', $_GET['id']);
            $user->resetar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Usuário Resetado com sucesso! É necessário trocar a senha no novo login
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            header('Location: /clarim/adm/usuarios');
        }

        public function apagarUsuario() {
            session_start();
            $user = Container::getModel('Usuario');
            $user->__set('id', $_GET['id']);
            $user->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Usuário Deletado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
            header('Location: /clarim/adm/usuarios');
        }

        public function trocarSenha() {
            session_start();
            $id = $_SESSION['id'];
            $user = Container::getModel('Usuario');
            $user->__set('id', $id);
            $user->buscarPorId();
            $this->view->dados = $user;
            $this->render('trocarSenha', 'head', 'menu_login' ,'body', 'footer_login');
        }

        public function perfil() {
            $this->render('perfil', 'head', 'menu_adm', 'body', 'footer');
        }

        public function trocar() {
            session_start();
            $senha = $_POST['senha'];
            $senhaRepetida = $_POST['senhaRepetida'];
            $id = $_POST['id'];

            if(strlen($senha) < 8 ){
                $_SESSION['msg'] = "<div class='alert alert-danger'> A nova senha tem que ter no mínino 8 caracteres
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span>
               </button></div>";
               header('Location: /clarim/adm/trocarSenha'); 
            }

            if($senha == '12345678' ){
                $_SESSION['msg'] = "<div class='alert alert-danger'> A nova senha não pode ser igual a senha padrão
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span>
               </button></div>";
               header('Location: /clarim/adm/trocarSenha'); 
            }

            if ($senha != $senhaRepetida) {
                $_SESSION['msg'] = "<div class='alert alert-danger'> As senhas não são iguais
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/trocarSenha');
            } else {
                $user = Container::getModel('Usuario');
                $user->__set('id', $id);
                $senhaCriptografada = md5($senha);
                $user->__set('senha', $senhaCriptografada);
                $user->atualizarSenha();
                session_start();
                unset($_SESSION['id']);
                unset($_SESSION['nome']);
                unset($_SESSION['logado']);
                $_SESSION['msg'] = "<div class='alert alert-success'> Senha alterada com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/login');
            }

        }

    }

?>