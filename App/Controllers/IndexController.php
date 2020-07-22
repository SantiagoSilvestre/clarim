<?php

    namespace App\Controllers;
    // Recursos do miniframewor
    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    use App\Models\Produto;
    use App\Models\Info;
    use App\Models\Contato;

    class IndexController extends Action 
    {
        public function index()
        {
           
            $produto = Container::getModel('Produto');

            $produtos = $produto->getProdutos();
            
            $this->view->dados = $produtos;
            
            $this->render('index', 'head', 'menu', 'body', 'footer');
        }
        public function sobreNos()
        {
            $info = Container::getModel('Info');
            $informacaos = $info->getinfo();
            
            $this->view->dados = $informacaos;
            

            $this->render('sobreNos', 'head', 'menu', 'body', 'footer');
        }

        public function contato()
        {
            $contato = Container::getModel('Contato');
            $contatos = $contato->getContatos();
            
            $this->view->dados = $contatos;
            
            $this->render('contato', 'head', 'menu', 'body', 'footer');
        }

       

    }

?>