<?php

    namespace App\Controllers;
    // Recursos do miniframewor
    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models

    class CampeonatoController extends Action 
    {
        
        public function campeonato() 
        {
            $campeonato = Container::getModel('Campeonato');
            $campeonatos = $campeonato->getCampeonato();

            $this->view->dados = $campeonatos;

            $this->render('campeonato', 'head','menu' , 'body', 'footer');
        } 
        
        public function camAtivo() 
        {
            $camp = Container::getModel('Campeonato');
            $camps = $camp->getCampeonato();

            $this->view->dados = $camps;

            $this->render('campeonato', 'head', 'menu' ,'body', 'footer');
        }     

    }

?>