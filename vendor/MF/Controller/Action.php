<?php

    namespace MF\Controller;

    abstract class Action
    {
        protected $view;

        public function __construct()
        {
            $this->view = new \stdClass();
        }

        protected function render($view, $head, $menu ,$body, $footer)
        {
            $this->view->page = $view;    
            if(file_exists("../App/Views/".$head.".phtml"))
            {
                include_once "../App/Views/".$head.".phtml";
                include_once "../App/Views/".$menu.".phtml";
                include_once "../App/Views/".$body.".phtml";
                include_once "../App/Views/".$footer.".phtml";
               
            } else {
                $this->content();
            } 
            
        }
        protected function content()
        {
            
            $classAtual = get_class($this);

            $classAtual = str_replace('App\\Controllers\\', '', $classAtual);
            $classAtual = strtolower(str_replace('Controller', '', $classAtual));
            require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";
        }

    }

?>