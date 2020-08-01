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
            $camp = Container::getModel('Campeonato');
            $camp->__set("id", $_GET['id']);
            $campeonatos = $camp->buscarPorId();
            if ($campeonatos->__get('estilo') == 0) {
                $this->render('campeonato', 'head','menu' , 'body', 'footer');
            } else {
                $this->view->dados = $campeonatos;
                $this->render('campeonato_mata', 'head','menu' , 'body', 'footer');
            }
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
            $camp->__set('estilo', $_POST['estilo']);
            


            $camp->__set('qtdtimes', $_POST['qtdtimes']);
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
                $_SESSION['dados']['estilo'] = $camp->__get('estilo');
                $_SESSION['dados']['qtdtimes'] = $camp->__get('qtdtimes');
                header('Location: /adm/campeonatos/cadastrar');
            }

        }

        public function buscarJogoMata() {
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $dados = $camp->buscarJogo();
            echo json_encode($dados);
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
            $result = $camp->validarFinalizacao();
            if($result) {
                $camp->finalizar();
                $_SESSION['msg'] = "<div class='alert alert-success'> Campeonato finalizado com sucesso!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span>
               </button></div>";
               header('Location: /adm/campeonatos');
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'> O campeonato não teve jogos, logo não é possível finalizar
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos');
            }
            
        }

        public function jogo() 
        {   
            session_start();
            $_SESSION['dados']['id'] = $_GET['id'];
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $campeonato = $camp->buscarPorId();
            
            if ($campeonato->__get('estilo') == 1 ) {
                $this->render('jogo_mata_fase', 'head', 'menu_adm', 'body', 'footer');
            }
            
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
                    'golContra' => $_POST['gol2'],
                    'craque' => $_POST['craque1'],
                    'pcraque' => $_POST['pcraque1']
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
                    'golContra' => $_POST['gol1'],
                    'craque' => $_POST['craque2'],
                    'pcraque' => $_POST['pcraque2']
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

                        if ($_POST['craque1'] != '' || $_POST['craque2'] != '' ) {
                            if ($times['time1']['pcraque'] > $times['time2']['pcraque'] ) {
                                $times['craque'] = $_POST['craque1'];
                            } else {
                                $times['craque'] = $_POST['craque2'];
                            }
                        }
                        $times['craque1'] = $_POST['craque1'];
                        $times['craque2'] = $_POST['craque2'];
                        $times['pcraque1'] =  $_POST['pcraque1'];
                        $times['pcraque2'] =  $_POST['pcraque2'] ;

                        $camp->jogoValido($times);
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
            $camp->__set('id', $idc);
            $time = Container::getModel('Time');
            $time->__set('id', $idt);
            
            
            $teste = $time->validarTime($idc, $idt);
            $qtdTimes = $camp->validaQtdTimes($idc);
            if ($qtdTimes[0]['times_cadastrados'] == $qtdTimes[0]['qtd_times'] ) {
                $_SESSION['msg'] = "<div class='alert alert-danger'> Este campeonato já atingiu o número máximo de equipes
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button></div>";
                header('Location: /adm/campeonatos/visualizar?id='.$idc);
            } else {
                if (count($teste) > 0 ) {
                    $_SESSION['msg'] = "<div class='alert alert-danger'> Este time já pertence a esse campeonato
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
                    header('Location: /adm/campeonatos/visualizar?id='.$idc);
                } else {
                    $camp->inserirTime($idt, $idc);
                    $_SESSION['msg'] = "<div class='alert alert-success'> Time Registrado com sucesso!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
                    header('Location: /adm/campeonatos/visualizar?id='.$idc);
                }
            }

        }

        public function buscarMata() {
            $idc = $_GET['id'];
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $idc);
            $campeonato = $camp->buscarPorIdArray();
            echo json_encode($campeonato);
        }

        public function buscarTimesMataMata() {
            session_start();
            $id = null;
            if(isset($_GET['id_time'])) {
                $id = $_GET['id_time'];
                $time = Container::getModel('Time');
                $times = $time->buscarPorIdFiltro($id);
                
                echo json_encode($times);
            }
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $time = Container::getModel('Time');
                $times = $time->buscarPorIdFiltro($id);
                
                echo json_encode($times);
            }
            if(isset($_GET['id_cam'])) {
                $idc = $_GET['id_cam'];
                $time = Container::getModel('Time');
                $cam = Container::getModel('Campeonato');
                $cam->__set('id', $idc);
                $retorno = $cam->verificarQtdTimes();
                if($retorno) {
                    $times = $time->listarTodosTimes($idc);
                    echo json_encode($times);
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger'> O campeonato ainda não atigiu a quantidade de times nessa fase
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
                    echo json_encode($retorno);
                }
            }
        }

        public function salvarJmata() {
            session_start();
            $jogos = $_POST['times'];
            $valido = true;
            $erros = [];
            foreach($jogos as $key => $jogo){
                if($jogo[0] == $jogo[1] ){
                    $valido = false;
                    $erros['primeira'] = "Existe times iguais se enfrentado, verifique os confrontos";
                }
                foreach($jogos as $chave => $j) {
                    if($key == $chave) {
                        continue;
                    }
                    if($j[0] == $jogo[0] || $j[0] == $jogo[1]) {
                        $valido = false;
                        $erros['segunda'] = "Um time só pode jogar um jogo nessa fase";
                    }
                    if($j[1] == $jogo[0] || $j[1] == $jogo[1]) {
                        $valido = false;
                        $erros['segunda'] = "Um time só pode jogar um jogo nessa fase";
                    }
                    
                }
            }

            if ($valido) {
                $time = Container::getModel('Time');
                $flag = true;
                foreach($jogos as $jogo){
                    $retorno = $time->validarMata($jogo);
                    if(!$retorno) {
                        $_SESSION['dados']['id'] = $jogos[0][2];
                        $_SESSION['msg'] = "<div class='alert alert-danger'> existe time com jogo cadastrado nessa fase
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button></div>";
                            $flag = false;
                    }
                }
                if(!$flag) {
                    echo json_encode(1);
                }else {
                    foreach($jogos as $jogo){
                        $time->cadastrarJogoMata($jogo); 
                    }
                    $_SESSION['msg'] = "<div class='alert alert-success'> Jogos cadastrados com sucesso!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button></div>";
                    echo json_encode(1);
                }

                
            } else{
                $erro = null;
                foreach($erros as $e) {
                    $erro .=$e."<span> -  </span>";
                }
                $_SESSION['dados']['id'] = $jogos[0][2];
                $_SESSION['msg'] = "<div class='alert alert-danger'> ". $erro."
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
                echo json_encode(0);
            }
        }

        public function confrontoMata() {
            session_start();
            $_SESSION['dados']['id'] = $_GET['id'];
            $camp = Container::getModel('Campeonato');
            $camp->__set('id', $_GET['id']);
            $campeonato = $camp->buscarPorId();
            
            if ($campeonato->__get('estilo') == 1 ) {
                $this->render('jogo_mata', 'head', 'menu_adm', 'body', 'footer');
            }
            
        }

        public function ultimasEdicao() {
            $this->render('ultimas_edicoes', 'head', 'menu', 'body', 'footer');
            
        }

        public function registrarJogoMata() {
            session_start();
            $camp = Container::getModel('Campeonato');
            $retorno = $camp->registrarJogoMata($_POST['id'], $_POST['resul'], $_POST['id_camp']);
            $_SESSION['msg'] = "<div class='alert alert-success'> O jogo foi registrado
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            echo json_encode(1);
        }

    }

?>