<?php

    namespace App;
    use MF\Init\Bootstrap;

    class Route extends Bootstrap
    {

        protected function initRoutes()
        {
            $routes['home'] = array(
                'route' =>'/',
                'controller' => 'indexController',
                'action' => 'index'
            );
            $routes['sobreNos'] = array(
                'route' =>'/sobreNos',
                'controller' => 'indexController',
                'action' => 'sobreNos'
            );
            $routes['contato'] = array(
                'route' =>'/contato',
                'controller' => 'ContatoController',
                'action' => 'contato'
            );
            $routes['campeonatos'] = array(
                'route' => '/campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'campeonato'
            );
            $routes['salvarContato'] = array(
                'route' => '/salvarContato',
                'controller' => 'ContatoController',
                'action' => 'salvarContato'
            );
            $this->setRoutes($routes);
        }
        
    }

?>