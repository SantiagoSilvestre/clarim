<?php

    namespace App\Controllers;
    // Recursos do miniframewor
    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models

    class IndexController extends Action 
    {
        public function index()
        {
            $this->render('index', 'head', 'menu' ,'body', 'footer');
        }
        public function sobreNos()
        {
            $this->render('sobreNos', 'head', 'menu' ,'body', 'footer');
        }

        public function home()
        {
            
            $this->render('home', 'head', 'menu', 'body', 'footer');
        }      

    }

?>