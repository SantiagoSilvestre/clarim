<?php

    namespace App\Controllers;
    // Recursos do miniframewor

use CompileError;
use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    class TimesController extends Action 
    {
        
        public function times() 
        {
            $time = Container::getModel('Time');
            $qtd = $time->getTotalTime();
            $this->view->dados = $qtd;
            $this->render('times', 'head','menu_adm' , 'body', 'footer');
        }
        

        public function visTimes() 
        {
            $time = Container::getModel('Time');
            $time->__set('id', $_GET['id']);
            $tim = $time->buscarPorId();
            $this->view->dados = $tim;
            $this->render('vis_time', 'head','menu_adm' , 'body', 'footer');
        }

        public function cadTimes() 
        {
            $this->render('cadastrar', 'head', 'menu_adm' , 'body', 'footer');
        }

        public function procTimes() 
        {
            session_start();
            $time = Container::getModel('Time');
            $time->__set('time', $_POST['nome']);
            
            $retorno = $time->validarDados();


            if($retorno['valido']) {
                $time->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Time cadastrado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/times');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $time->__get('nome');
                header('Location: /adm/times/cadastrar');
            }

        }

        public function editTimes() 
        {
            $id = null;
            if(isset($_SESSION['dados']['id'])) {
                $id = $_SESSION['dados']['id'];
            } else {
                $id = isset ($_GET['id']) ? $_GET['id'] : 1;
            }
            $time = Container::getModel('Time');
            $time->__set('id', $id);
            $time->buscarPorId();
            $this->view->dados = $time;
            $this->render('editarTime', 'head', 'menu_adm', 'body', 'footer');
        }

        
        public function procApagarTimes() 
        {
            session_start();
            $time = Container::getModel('Time');
            $time->__set('id', $_GET['id']);
            $time->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Time apagado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/times');
        }

        public function procEdiTimes()
        {
            session_start();
            $tim = Container::getModel('Time');
            $tim->__set('time', $_POST['time']);
            $tim->__set('id', $_POST['id']);
            $retorno = $tim->validarEditarDados();
            if ($retorno['valido']) {
                $tim->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Time atualizado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/times');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['time'] = $tim->__get('time');
                header('Location: /adm/times/edit_time');
            }
            
        }
    }

?>