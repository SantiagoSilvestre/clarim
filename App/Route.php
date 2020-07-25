<?php

    namespace App;
    use MF\Init\Bootstrap;

    class Route extends Bootstrap
    {

        protected function initRoutes()
        {
            $routes['index'] = array(
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
            $routes['home'] = array(
                'route' => '/adm/home',
                'controller' => 'UserController',
                'action' => 'home'
            );
            $routes['login'] = array(
                'route' => '/adm/login',
                'controller' => 'UserController',
                'action' => 'login'
            );
            $routes['valida'] = array(
                'route' => '/adm/valida',
                'controller' => 'UserController',
                'action' => 'valida'
            );
            $routes['sair'] = array(
                'route' => '/adm/sair',
                'controller' => 'UserController',
                'action' => 'sair'
            );

            $routes['usuarios'] = array(
                'route' => '/adm/usuarios',
                'controller' => 'UserController',
                'action' => 'usuarios'
            );

            $routes['visualizarUsuarios'] = array(
                'route' => '/adm/usuarios/visualizar',
                'controller' => 'UserController',
                'action' => 'visualizarUsuarios'
            );

            $routes['cadastrarUsuarios'] = array(
                'route' => '/adm/cadastrar/cad_usuario',
                'controller' => 'UserController',
                'action' => 'cadastrarUsuarios'
            );
            
            $routes['cadUsuarios'] = array(
                'route' => '/adm/proc_cad_user',
                'controller' => 'UserController',
                'action' => 'cadUsuarios'
            );

            $routes['editUsuarios'] = array(
                'route' => '/adm/usuarios/edit_user',
                'controller' => 'UserController',
                'action' => 'editUsuarios'
            );

            $routes['editarUsuarios'] = array(
                'route' => '/adm/proc_edit_user',
                'controller' => 'UserController',
                'action' => 'editarUsuarios'
            );
            $routes['resetarUsuario'] = array(
                'route' => '/adm/usuarios/resetar',
                'controller' => 'UserController',
                'action' => 'resetarUsuario'
            );
            
            $routes['apagarUsuario'] = array(
                'route' => '/adm/usuarios/apagar_user',
                'controller' => 'UserController',
                'action' => 'apagarUsuario'
            );

            $this->setRoutes($routes);
        }
        
    }

?>