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
            $this->render('login', 'head', 'menu_login' ,'body', 'footer_login');
        }

        public function cadastrarUsuarios()
        {
            $this->render('cad_usuario', 'head', 'menu_adm' ,'body', 'footer');
        }

        public function valida(){
            $user = Container::getModel('Usuario');
            $user->__set('email', $_POST['usuario']);
            $user->__set('senha', $_POST['senha']);
            $user->acessar();   
            if ( $user->__get('id') && $user->__get('nome')) {
                session_start();
                $_SESSION['id'] = $user->__get('id');
                $_SESSION['nome'] = $user->__get('nome') ;
                $_SESSION['logado'] = true;
                header('Location: /adm/home');
            } else {
                header('Location: /adm/login?login=erro');
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
            header('Location: /adm/login');
        }

        public function usuarios() {
            $this->render('listarUsuarios', 'head', 'menu_adm', 'body', 'footer');
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
            $retorno = $user->validarCadastro();
            if ($retorno['valido']) {
                $user->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Usuário cadastrado com sucesso! Necessita trocar a senha no primeiro acesso.
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/usuarios');
            } else {
                unset($retorno['valido']);
                $_SESSION['dados']['nome'] = $user->__get('nome');
                $_SESSION['dados']['email'] = $user->__get('email');
                $_SESSION['erros'] = $retorno;
                header('Location: /adm/cadastrar/cad_usuario');
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
            $retorno = $user->validarAtualizacao();
            if ($retorno['valido']) {
                $user->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Usuário Editado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/usuarios');
            } else {
                unset($retorno['valido']);
                $_SESSION['dados']['id'] = $user->__get('id');
                $_SESSION['dados']['nome'] = $user->__get('nome');
                $_SESSION['dados']['email'] = $user->__get('email');
                $_SESSION['erros'] = $retorno;
                header('Location: /adm/usuarios/edit_user');
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
            header('Location: /adm/usuarios');
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
            header('Location: /adm/usuarios');
        }

    }

?>