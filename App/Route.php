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

            $routes['campeonatoAdm'] = array(
                'route' => '/adm/campeonatos',
                'controller' => 'CampeonatoController',
                'action' => 'campeonatoAdm'
            );

            $routes['visualizarCampeonato'] = array(
                'route' => '/adm/campeonatos/visualizar',
                'controller' => 'CampeonatoController',
                'action' => 'visualizarCampeonato'
            );

            $routes['cadastrarCampeonato'] = array(
                'route' => '/adm/campeonatos/cadastrar',
                'controller' => 'CampeonatoController',
                'action' => 'cadastrarCampeonato'
            );

            $routes['cadCampeonatos'] = array(
                'route' => '/adm/proc_cad_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'cadCampeonatos'
            );

            $routes['editCampeonato'] = array(
                'route' => '/adm/campeonatos/edit_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'editCampeonato'
            );

            $routes['editCampeonato'] = array(
                'route' => '/adm/campeonatos/edit_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'editCampeonato'
            );
            
            $routes['procCampeonato'] = array(
                'route' => '/adm/proc_edit_camp',
                'controller' => 'CampeonatoController',
                'action' => 'procCampeonato'
            );

            $routes['apagarCampeonato'] = array(
                'route' => '/adm/campeonato/apagar_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'apagarCampeonato'
            );

            $routes['finalizarCampeonato'] = array(
                'route' => '/adm/campeonato/finalizar_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'finalizarCampeonato'
            );

            $routes['times'] = array(
                'route' => '/adm/times',
                'controller' => 'TimesController',
                'action' => 'times'
            );

            $routes['cadTimes'] = array(
                'route' => '/adm/times/cadastrar',
                'controller' => 'TimesController',
                'action' => 'cadTimes'
            );

            $routes['procTimes'] = array(
                'route' => '/adm/proc_cad_time',
                'controller' => 'TimesController',
                'action' => 'procTimes'
            );

            $routes['visTimes'] = array(
                'route' => '/adm/times/visualizar',
                'controller' => 'TimesController',
                'action' => 'visTimes'
            );

            $routes['editTimes'] = array(
                'route' => '/adm/times/edit_time',
                'controller' => 'TimesController',
                'action' => 'editTimes'
            );

            $routes['procEdiTimes'] = array(
                'route' => '/adm/proc_edit_time',
                'controller' => 'TimesController',
                'action' => 'procEdiTimes'
            );

            $routes['procApagarTimes'] = array(
                'route' => '/adm/time/apagar_time',
                'controller' => 'TimesController',
                'action' => 'procApagarTimes'
            );

            $routes['trocarSenha'] = array(
                'route' => '/adm/trocarSenha',
                'controller' => 'UserController',
                'action' => 'trocarSenha'
            );

            $routes['trocar'] = array(
                'route' => '/adm/trocar',
                'controller' => 'UserController',
                'action' => 'trocar'
            );
        
            $this->setRoutes($routes);
        }
        
    }

?>