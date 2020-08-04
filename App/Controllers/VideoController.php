<?php

    namespace App\Controllers;
    // Recursos do miniframewor

use CompileError;
use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    class VideoController extends Action 
    {
        
        public function videos() 
        {
            $video = Container::getModel('Video');
            $qtd = $video->getTotalVideos();
            $this->view->dados = $qtd;
            $this->render('videos', 'head','menu_adm' , 'body', 'footer');
        }

        public function cadVideos() 
        {
            $this->render('cadastrar', 'head', 'menu_adm' , 'body', 'footer');
        }
        public function proCadVideos() 
        {
            session_start();
            $video = Container::getModel('Video');
            $video->__set('nome', $_POST['nome']);
            $video->__set('link', $_POST['link'] );
            
            $retorno = $video->validarDados();


            if($retorno['valido']) {
                $video->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Video cadastrado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/videos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $video->__get('nome');
                $_SESSION['dados']['link'] = $video->__get('link');
                header('Location: /clarim/adm/video/cadastrar');
            }

        }

        public function apagarVideos() 
        {
            session_start();
            $video = Container::getModel('Video');
            $video->__set('id', $_GET['id']);
            $video->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> video apagado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /clarim/adm/videos');
        }

        public function editVideos() 
        {
            $id = null;
            if(isset($_SESSION['dados']['id'])) {
                $id = $_SESSION['dados']['id'];
            } else {
                $id = isset ($_GET['id']) ? $_GET['id'] : 1;
            }
            $video = Container::getModel('Video');
            $video->__set('id', $id);
            $video->buscarPorId();
            $this->view->dados = $video;
            $this->render('editarVideo', 'head', 'menu_adm', 'body', 'footer');
        }

        public function procEditVideos()
        {
            session_start();

            $video = Container::getModel('Video');
            $video->__set('nome', $_POST['nome']);
            $video->__set('id', $_POST['id']);
            $retorno = $video->validarEditarDados();
            if ($retorno['valido']) {
                $video->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Video atualizado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /clarim/adm/videos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $video->__get('nome');
                header('Location: /clarim/adm/video/edit_video');
            }
            
        }
        
        public function visVideos() 
        {
            $video = Container::getModel('Video');
            $video->__set('id', $_GET['id']);
            $video = $video->buscarPorId();
            $this->view->dados = $video;
            $this->render('vis_video', 'head','menu_adm' , 'body', 'footer');
        }
    }

?>