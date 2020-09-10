<?php

    namespace App;
    use MF\Init\Bootstrap;

    class Route extends Bootstrap
    {
        
        protected function initRoutes()
        {
            $routes['index'] = array(
                'route' =>'/clarim/',
                'controller' => 'indexController',
                'action' => 'index'
            );
            $routes['sobreNos'] = array(
                'route' =>'/clarim/sobreNos',
                'controller' => 'indexController',
                'action' => 'sobreNos'
            );
            $routes['contato'] = array(
                'route' =>'/clarim/contato',
                'controller' => 'ContatoController',
                'action' => 'contato'
            );
            $routes['campeonatos'] = array(
                'route' => '/clarim/campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'campeonato'
            );
            $routes['salvarContato'] = array(
                'route' => '/clarim/salvarContato',
                'controller' => 'ContatoController',
                'action' => 'salvarContato'
            );
            $routes['home'] = array(
                'route' => '/clarim/adm/home',
                'controller' => 'UserController',
                'action' => 'home'
            );
            $routes['login'] = array(
                'route' => '/clarim/adm/login',
                'controller' => 'UserController',
                'action' => 'login'
            );
            $routes['valida'] = array(
                'route' => '/clarim/adm/valida',
                'controller' => 'UserController',
                'action' => 'valida'
            );
            $routes['sair'] = array(
                'route' => '/clarim/adm/sair',
                'controller' => 'UserController',
                'action' => 'sair'
            );

            $routes['usuarios'] = array(
                'route' => '/clarim/adm/usuarios',
                'controller' => 'UserController',
                'action' => 'usuarios'
            );

            $routes['visualizarUsuarios'] = array(
                'route' => '/clarim/adm/usuarios/visualizar',
                'controller' => 'UserController',
                'action' => 'visualizarUsuarios'
            );

            $routes['cadastrarUsuarios'] = array(
                'route' => '/clarim/adm/cadastrar/cad_usuario',
                'controller' => 'UserController',
                'action' => 'cadastrarUsuarios'
            );
            
            $routes['cadUsuarios'] = array(
                'route' => '/clarim/adm/proc_cad_user',
                'controller' => 'UserController',
                'action' => 'cadUsuarios'
            );

            $routes['editUsuarios'] = array(
                'route' => '/clarim/adm/usuarios/edit_user',
                'controller' => 'UserController',
                'action' => 'editUsuarios'
            );

            $routes['editarUsuarios'] = array(
                'route' => '/clarim/adm/proc_edit_user',
                'controller' => 'UserController',
                'action' => 'editarUsuarios'
            );
            $routes['resetarUsuario'] = array(
                'route' => '/clarim/adm/usuarios/resetar',
                'controller' => 'UserController',
                'action' => 'resetarUsuario'
            );
            
            $routes['apagarUsuario'] = array(
                'route' => '/clarim/adm/usuarios/apagar_user',
                'controller' => 'UserController',
                'action' => 'apagarUsuario'
            );

            $routes['campeonatoAdm'] = array(
                'route' => '/clarim/adm/campeonatos',
                'controller' => 'CampeonatoController',
                'action' => 'campeonatoAdm'
            );

            $routes['visualizarCampeonato'] = array(
                'route' => '/clarim/adm/campeonatos/visualizar',
                'controller' => 'CampeonatoController',
                'action' => 'visualizarCampeonato'
            );

            $routes['cadastrarCampeonato'] = array(
                'route' => '/clarim/adm/campeonatos/cadastrar',
                'controller' => 'CampeonatoController',
                'action' => 'cadastrarCampeonato'
            );

            $routes['cadCampeonatos'] = array(
                'route' => '/clarim/adm/proc_cad_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'cadCampeonatos'
            );

            $routes['editCampeonato'] = array(
                'route' => '/clarim/adm/campeonatos/edit_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'editCampeonato'
            );

            $routes['editCampeonato'] = array(
                'route' => '/clarim/adm/campeonatos/edit_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'editCampeonato'
            );
            
            $routes['procCampeonato'] = array(
                'route' => '/clarim/adm/proc_edit_camp',
                'controller' => 'CampeonatoController',
                'action' => 'procCampeonato'
            );

            $routes['apagarCampeonato'] = array(
                'route' => '/clarim/adm/campeonato/apagar_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'apagarCampeonato'
            );

            $routes['finalizarCampeonato'] = array(
                'route' => '/clarim/adm/campeonato/finalizar_campeonato',
                'controller' => 'CampeonatoController',
                'action' => 'finalizarCampeonato'
            );

            $routes['times'] = array(
                'route' => '/clarim/adm/times',
                'controller' => 'TimesController',
                'action' => 'times'
            );

            $routes['cadTimes'] = array(
                'route' => '/clarim/adm/times/cadastrar',
                'controller' => 'TimesController',
                'action' => 'cadTimes'
            );

            $routes['procTimes'] = array(
                'route' => '/clarim/adm/proc_cad_time',
                'controller' => 'TimesController',
                'action' => 'procTimes'
            );

            $routes['visTimes'] = array(
                'route' => '/clarim/adm/times/visualizar',
                'controller' => 'TimesController',
                'action' => 'visTimes'
            );

            $routes['editTimes'] = array(
                'route' => '/clarim/adm/times/edit_time',
                'controller' => 'TimesController',
                'action' => 'editTimes'
            );

            $routes['procEdiTimes'] = array(
                'route' => '/clarim/adm/proc_edit_time',
                'controller' => 'TimesController',
                'action' => 'procEdiTimes'
            );

            $routes['procApagarTimes'] = array(
                'route' => '/clarim/adm/time/apagar_time',
                'controller' => 'TimesController',
                'action' => 'procApagarTimes'
            );

            $routes['trocarSenha'] = array(
                'route' => '/clarim/adm/trocarSenha',
                'controller' => 'UserController',
                'action' => 'trocarSenha'
            );

            $routes['trocar'] = array(
                'route' => '/clarim/adm/trocar',
                'controller' => 'UserController',
                'action' => 'trocar'
            );

            $routes['videos'] = array(
                'route' => '/clarim/adm/videos',
                'controller' => 'VideoController',
                'action' => 'videos'
            );

            $routes['cadVideos'] = array(
                'route' => '/clarim/adm/video/cadastrar',
                'controller' => 'VideoController',
                'action' => 'cadVideos'
            );

            $routes['proCadVideos'] = array(
                'route' => '/clarim/adm/proc_cad_video',
                'controller' => 'VideoController',
                'action' => 'proCadVideos'
            );

            $routes['apagarVideos'] = array(
                'route' => '/clarim/adm/video/apagar_video',
                'controller' => 'VideoController',
                'action' => 'apagarVideos'
            );

            $routes['editVideos'] = array(
                'route' => '/clarim/adm/video/edit_video',
                'controller' => 'VideoController',
                'action' => 'editVideos'
            );

            $routes['procEditVideos'] = array(
                'route' => '/clarim/adm/proc_edit_video',
                'controller' => 'VideoController',
                'action' => 'procEditVideos'
            );

            $routes['visVideos'] = array(
                'route' => '/clarim/adm/video/visualizar',
                'controller' => 'VideoController',
                'action' => 'visVideos'
            );

            $routes['listContato'] = array(
                'route' => '/clarim/adm/contato',
                'controller' => 'ContatoController',
                'action' => 'listContato'
            );

            $routes['apagarContato'] = array(
                'route' => '/clarim/adm/contato/apagar_contato',
                'controller' => 'ContatoController',
                'action' => 'apagarContato'
            );

            $routes['visContato'] = array(
                'route' => '/clarim/adm/contato/vis_contato',
                'controller' => 'ContatoController',
                'action' => 'visContato'
            );

            $routes['visualizarContato'] = array(
                'route' => '/clarim/adm/contato/visualizarMensagem',
                'controller' => 'ContatoController',
                'action' => 'visualizarContato'
            );

            
            $routes['responderContato'] = array(
                'route' => '/clarim/adm/contato/responderMensagem',
                'controller' => 'ContatoController',
                'action' => 'responderContato'
            );

            $routes['jogo'] = array(
                'route' => '/clarim/adm/campaonato/jogo',
                'controller' => 'CampeonatoController',
                'action' => 'jogo'
            );

            $routes['procJogo'] = array(
                'route' => '/clarim/adm/proc_cad_jogo',
                'controller' => 'CampeonatoController',
                'action' => 'procJogo'
            );

            $routes['timeCamp'] = array(
                'route' => '/clarim/adm/campaonato/time',
                'controller' => 'CampeonatoController',
                'action' => 'timeCamp'
            );

            $routes['buscarMata'] = array(
                'route' => '/clarim/campeonato/ajax',
                'controller' => 'CampeonatoController',
                'action' => 'buscarMata'
            );

            $routes['buscarTimesMataMata'] = array(
                'route' => '/clarim/campeonato/ajaxTime',
                'controller' => 'CampeonatoController',
                'action' => 'buscarTimesMataMata'
            );

            $routes['salvarJmata'] = array(
                'route' => '/clarim/adm/proc_cad_mata',
                'controller' => 'CampeonatoController',
                'action' => 'salvarJmata'
            );

            $routes['confrontoMata'] = array(
                'route' => '/clarim/adm/confrontos',
                'controller' => 'CampeonatoController',
                'action' => 'confrontoMata'
            );

            $routes['ultimasEdicao'] = array(
                'route' => '/clarim/campeonato/ultimos',
                'controller' => 'CampeonatoController',
                'action' => 'ultimasEdicao'
            );

            $routes['buscarJogoMata'] = array(
                'route' => '/clarim/campeonato/jogo/buscar',
                'controller' => 'CampeonatoController',
                'action' => 'buscarJogoMata'
            );

            $routes['registrarJogoMata'] = array(
                'route' => '/clarim/adm/jogo/cad_mata',
                'controller' => 'CampeonatoController',
                'action' => 'registrarJogoMata'
            );

            $routes['buscarJogosFase'] = array(
                'route' => '/clarim/campeonato/ajax/buscaFase',
                'controller' => 'CampeonatoController',
                'action' => 'buscarJogosFase'
            );

            $routes['listarUltimas'] = array(
                'route' => '/clarim/campeonato/listarUltimas',
                'controller' => 'CampeonatoController',
                'action' => 'listarUltimas'
            );

            $routes['esqueceuSenha'] = array(
                'route' => '/clarim/adm/esqueceuSenha',
                'controller' => 'UserController',
                'action' => 'esqueceuSenha'
            );

            $routes['solicitarSenha'] = array(
                'route' => '/clarim/UserController/ajax/solicitarSenha',
                'controller' => 'UserController',
                'action' => 'solicitarSenha'
            );

            $routes['listarSolicitacaoSenha'] = array(
                'route' => '/clarim/adm/listarSolicitacaoSenha',
                'controller' => 'UserController',
                'action' => 'listarSolicitacaoSenha'
            );

            $routes['perfil'] = array(
                'route' => '/clarim/perfil',
                'controller' => 'UserController',
                'action' => 'perfil'
            );

            $routes['agenda'] = array(
                'route' => '/clarim/adm/agenda',
                'controller' => 'UserController',
                'action' => 'agenda'
            );

            $routes['eventos'] = array(
                'route' => '/clarim/eventos',
                'controller' => 'UserController',
                'action' => 'eventos'
            );

            $routes['cadEvent'] = array(
                'route' => '/clarim/cadEventos',
                'controller' => 'UserController',
                'action' => 'cadEvent'
            );

            $routes['buscarHorarios'] = array(
                'route' => '/clarim/buscarHorarios',
                'controller' => 'UserController',
                'action' => 'buscarHorarios'
            );

            $routes['salvarEventos'] = array(
                'route' => '/clarim/salvaEventos',
                'controller' => 'UserController',
                'action' => 'salvarEventos'
            );

            $routes['listarAgenda'] = array(
                'route' => '/clarim/adm/jogos',
                'controller' => 'AgendaController',
                'action' => 'listarAgenda'
            );

            $routes['visAgenda'] = array(
                'route' => '/clarim/adm/visAgenda',
                'controller' => 'AgendaController',
                'action' => 'visAgenda'
            );

            $routes['apagarAgenda'] = array(
                'route' => '/clarim/adm/apagar_agenda',
                'controller' => 'AgendaController',
                'action' => 'apagarAgenda'
            );

            $routes['listCampFin'] = array(
                'route' => '/clarim/adm/campeonatos_fin',
                'controller' => 'CampeonatoController',
                'action' => 'listCampFin'
            );

            $routes['visualizarFin'] = array(
                'route' => '/clarim/adm/campeonatos/visualizar_fin',
                'controller' => 'CampeonatoController',
                'action' => 'visualizarFin'
            );

            
            $this->setRoutes($routes);
        }
        
    }

?>