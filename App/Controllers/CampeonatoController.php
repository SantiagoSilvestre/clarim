<?php

    namespace App\Controllers;
    // Recursos do miniframewor

use CompileError;
use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    class CampeonatoController extends Action 
    {
        
        public function campeonato() 
        {
            $this->render('campeonato', 'head','menu' , 'body', 'footer');
        }
        
        public function campeonatoAdm()
        {
            $campeonato = Container::getModel('Campeonato');
            $campeonatos = $campeonato->getTotalCamp();
            $this->view->dados = $campeonatos;
            $this->render('list_campeonato', 'head','menu_adm' , 'body', 'footer');
        }

        public function visualizarCampeonato() 
        {
            $campeonato = Container::getModel('Campeonato');
            $campeonato->__set('id', $_GET['id']);
            $camp = $campeonato->buscarPorId();
            $this->view->dados = $camp;
            $this->render('vis_campeonato', 'head','menu_adm' , 'body', 'footer');
        }

        public function cadastrarCampeonato() 
        {
            $this->render('cadastrar', 'head', 'menu_adm' , 'body', 'footer');
        }

        public function cadCampeonatos() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('nome', $_POST['nome']);
            $camp->__set('regulamento', $_POST['regulamento']);
            $retorno = $camp->validarDados();

            if($retorno['valido']) {
                $camp->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato cadastrado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $camp->__get('nome');
                $_SESSION['dados']['regulamento'] = $camp->__get('regulamento');
                header('Location: /adm/campeonatos/cadastrar');
            }

        }

        public function editCampeonato() 
        {
            $id = null;
            if(isset($_SESSION['dados']['id'])) {
                $id = $_SESSION['dados']['id'];
            } else {
                $id = isset ($_GET['id']) ? $_GET['id'] : 1;
            }
            $campeonato = Container::getModel('Campeonato');
            $campeonato->__set('id', $id);
            $campeonato->buscarPorId();
            $this->view->dados = $campeonato;
            $this->render('editarCampeonato', 'head', 'menu_adm', 'body', 'footer');
        }

        public function procCampeonato() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_POST['id']);
            $camp->__set('nome', $_POST['nome']);
            $camp->__set('regulamento', $_POST['regulamento']);
            $retorno = $camp->validarEdicaoDados();
            if($retorno['valido']) {
                $camp->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato atualizado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $camp->__get('nome');
                $_SESSION['dados']['regulamento'] = $camp->__get('regulamento');
                header('Location: /adm/campeonatos/edit_campeonato');
            }
        }

        public function apagarCampeonato() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $camp->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato apagado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/campeonatos');
        }

        public function finalizarCampeonato()
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $camp->finalizar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato finalizado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/campeonatos');
        }
    }

?>