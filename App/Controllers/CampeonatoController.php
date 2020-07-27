<?php

    namespace App\Controllers;
    // Recursos do miniframewor

use CompileError;
use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    class CampeonatoController extends Action 
    {
        
        public function campeonato() 
        {
            $this->render('campeonato', 'head','menu' , 'body', 'footer');
        }
        
        public function campeonatoAdm()
        {
            $campeonato = Container::getModel('Campeonato');
            $campeonatos = $campeonato->getTotalCamp();
            $this->view->dados = $campeonatos;
            $this->render('list_campeonato', 'head','menu_adm' , 'body', 'footer');
        }

        public function visualizarCampeonato() 
        {
            $campeonato = Container::getModel('Campeonato');
            $campeonato->__set('id', $_GET['id']);
            $camp = $campeonato->buscarPorId();
            $this->view->dados = $camp;
            $this->render('vis_campeonato', 'head','menu_adm' , 'body', 'footer');
        }

        public function cadastrarCampeonato() 
        {
            $this->render('cadastrar', 'head', 'menu_adm' , 'body', 'footer');
        }

        public function cadCampeonatos() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('nome', $_POST['nome']);
            $camp->__set('regulamento', $_POST['regulamento']);
            $retorno = $camp->validarDados();

            if($retorno['valido']) {
                $camp->salvar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato cadastrado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $camp->__get('nome');
                $_SESSION['dados']['regulamento'] = $camp->__get('regulamento');
                header('Location: /adm/campeonatos/cadastrar');
            }

        }

        public function editCampeonato() 
        {
            $id = null;
            if(isset($_SESSION['dados']['id'])) {
                $id = $_SESSION['dados']['id'];
            } else {
                $id = isset ($_GET['id']) ? $_GET['id'] : 1;
            }
            $campeonato = Container::getModel('Campeonato');
            $campeonato->__set('id', $id);
            $campeonato->buscarPorId();
            $this->view->dados = $campeonato;
            $this->render('editarCampeonato', 'head', 'menu_adm', 'body', 'footer');
        }

        public function procCampeonato() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_POST['id']);
            $camp->__set('nome', $_POST['nome']);
            $camp->__set('regulamento', $_POST['regulamento']);
            $retorno = $camp->validarEdicaoDados();
            if($retorno['valido']) {
                $camp->atualizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato atualizado com sucesso!
                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos');
            } else {
                unset($retorno['valido']);
                $_SESSION['erros'] = $retorno;
                $_SESSION['dados']['nome'] = $camp->__get('nome');
                $_SESSION['dados']['regulamento'] = $camp->__get('regulamento');
                header('Location: /adm/campeonatos/edit_campeonato');
            }
        }

        public function apagarCampeonato() 
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $camp->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato apagado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/campeonatos');
        }

        public function finalizarCampeonato()
        {
            session_start();
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $camp->finalizar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato finalizado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/campeonatos');
        }

        public function jogo() 
        {   
            session_start();
            $_SESSION['dados']['id'] = $_GET['id'];
            $this->render('jogo', 'head', 'menu_adm', 'body', 'footer');
        }

        public function procJogo()
        {
           session_start();
           $camp = Container::getModel('Campeonato');
           $camp->__set('id', $_POST['id']);

           $times = [];

           if ($_POST['gol1'] > $_POST['gol2'] ) {
            $times['time1'] = 
                [
                    'id' =>  $_POST['time1'],
                    'gol' => $_POST['gol1'],
                    'vermelho' =>  $_POST['vermelho1'],
                    'amarelo' => $_POST['amarelo1'],
                    'vitoria' => 1,
                    'derrota' => 0,
                    'empate' => 0,
                    'pontos' => 3,
                    'golContra' => $_POST['gol2']
                ];
            $times['time2'] = 
                [
                    'id' =>  $_POST['time2'],
                    'gol' => $_POST['gol2'],
                    'vermelho' =>  $_POST['vermelho2'],
                    'amarelo' => $_POST['amarelo2'],
                    'vitoria' => 0,
                    'derrota' => 1,
                    'empate' => 0,
                    'pontos' => 0,
                    'golContra' => $_POST['gol1']
                ];
           } else if ($_POST['gol1'] == $_POST['gol2'] ) {
            $times['time1'] = 
            [
                'id' =>  $_POST['time1'],
                'gol' => $_POST['gol1'],
                'vermelho' =>  $_POST['vermelho1'],
                'amarelo' => $_POST['amarelo1'],
                'vitoria' => 0,
                'derrota' => 0,
                'empate' => 1,
                'pontos' => 1,
                'golContra' => $_POST['gol2']

            ];
            $times['time2'] = 
            [
                'id' =>  $_POST['time2'],
                'gol' => $_POST['gol2'],
                'vermelho' =>  $_POST['vermelho2'],
                'amarelo' => $_POST['amarelo2'],
                'vitoria' => 0,
                'derrota' => 0,
                'empate' => 1,
                'pontos' => 1,
                'golContra' => $_POST['gol1']

            ];
           } else {
            $times['time1'] = 
            [
                'id' =>  $_POST['time1'],
                'gol' => $_POST['gol1'],
                'vermelho' =>  $_POST['vermelho1'],
                'amarelo' => $_POST['amarelo1'],
                'vitoria' => 0,
                'derrota' => 1,
                'empate' => 0,
                'pontos' => 0,
                'golContra' => $_POST['gol2']

            ];
            $times['time2'] = 
            [
                'id' =>  $_POST['time2'],
                'gol' => $_POST['gol2'],
                'vermelho' =>  $_POST['vermelho2'],
                'amarelo' => $_POST['amarelo2'],
                'vitoria' => 1,
                'derrota' => 0,
                'empate' => 1,
                'pontos' => 3,
                'golContra' => $_POST['gol1']

            ];
           }
           $valido = true;
           foreach($times as $time) {
                foreach($time as $key => $value) {
                    if ($key != 'vitoria' && $key != 'empate' && $key != 'pontos' && $key != 'derrota' && $value == '' ) {
                        echo $key." - <br>";
                        $valido = false;
                    }
                }
           }

           if($times['time1']['id'] == $times['time2']['id']) {
                $_SESSION['msg'] = "<div class='alert alert-danger'> Não pode selecionar o mesmo time
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campaonato/jogo?id='.$_POST['id']); 
           } else {

                if($valido) {

                        foreach($times as $time) {
                            $camp->inserirJogo($time);
                        }
                        $_SESSION['msg'] = "<div class='alert alert-success'> Jogo gravado com sucesso!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button></div>";
                        header('Location: /adm/campeonatos');
                } else {
                        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessários preencher todos os campos
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button></div>";
                        header('Location: /adm/campaonato/jogo?id='.$_POST['id']); 
                }
           }

           
        }

        public function timeCamp() {
            session_start();
            $idc = $_POST['idc'];
            $idt = $_POST['idt'];
           
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['idc']);
            $camp->inserirTime($idt, $idc);
            $_SESSION['msg'] = "<div class='alert alert-success'> Time Registrado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
           </button></div>";
           header('Location: /adm/campeonatos/visualizar?id='.$idc);

        }
    }

?>