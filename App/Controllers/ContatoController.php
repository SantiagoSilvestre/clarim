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
            $contato = Container::getModel('Contato');
            $contatos = $contato->getContatos();

            $camp = Container::getModel('Campeonato');
            $camps = $camp->getCampeonatos();
            $this->view->dados['campeonatos'] = $camps;
            
            $this->view->dados['contatos'] = $contatos;
            
            $this->render('contato', 'head', 'menu' , 'body', 'footer');
        }    

    }

?>