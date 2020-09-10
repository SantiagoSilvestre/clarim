<?php

    namespace App\Controllers;
    // Recursos do miniframewor
    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    use App\Models\Produto;
    use App\Models\Info;
    use App\Models\Contato;

    class ContatoController extends Action 
    {
        public function contato()
        {
            $this->view->erroCadastro = false;
            $this->render('contato', 'head', 'menu' , 'body', 'footer');
        }    

        public function salvarContato()
        {
            //receber dados do form
            $contato = Container::getModel('Contato');
            $contato->__set('nome', $_POST['nome']);
            $contato->__set('email', $_POST['email']);
            $contato->__set('telefone', $_POST['telefone']);
            $contato->__set('assunto', $_POST['assunto']);
            $contato->__set('mensagem', $_POST['mensagem']);
            
            if ($contato->validarContato()){
                $contato->salvar();
                $this->render('cadastro', 'head', 'menu' , 'body', 'footer');
            } else {
                $this->view->erroCadastro = true;
                $this->render('contato', 'head', 'menu' , 'body', 'footer');
            }
        }

        public function listContato() 
        {
            $contato = Container::getModel('Contato');
            $qtd = $contato->getTotalMensagens();
            $this->view->dados = $qtd;
            $this->render('listarMensagens', 'head', 'menu_adm' , 'body', 'footer');
        }

        public function apagarContato()
        {
            session_start();
            $contato = Container::getModel('Contato');
            $contato->__set('id', $_GET['id']);
            $contato->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Mensagem apagado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /clarim/adm/contato');
        }

        public function visContato()
        {
            $contato = Container::getModel('Contato');
            $contato->__set('id', $_GET['id']);
            $contato = $contato->buscarPorId();
            $this->view->dados = $contato;
            $this->render('vis_contato', 'head', 'menu_adm', 'body', 'footer');
        }

        public function visualizarContato() 
        {
            session_start();
            $contato = Container::getModel('Contato');
            $contato->__set('id', $_GET['id']);
            $contato->marcarVisualizada();
            $_SESSION['msg'] = "<div class='alert alert-success'> Mensagem foi marcada como visualizada!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /clarim/adm/contato');
        }

        
        public function responderContato() 
        {
            session_start();
            $contato = Container::getModel('Contato');
            $contato->__set('id', $_GET['id']);
            $contato->marcarRespondida();
            $_SESSION['msg'] = "<div class='alert alert-success'> Mensagem foi marcada como respondida!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /clarim/adm/contato');
        }
        
        

    }

?>