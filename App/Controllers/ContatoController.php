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

        public function salvarContato(){

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

    }

?>