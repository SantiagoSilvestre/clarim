<?php

    namespace App\Controllers;
    // Recursos do miniframewor


    use MF\Controller\Action;
    use MF\Model\Container;
    // os Models
    class AgendaController extends Action 
    {
       
        public function listarAgenda()
        {
            $agenda = Container::getModel('Agenda');
            $agendas = $agenda->getTotalJogos();
            $this->view->dados = $agendas;
            $this->render('list_agenda', 'head','menu_adm' , 'body', 'footer');
        }

        public function visAgenda()
        {
            $agenda = Container::getModel('Agenda');
            $agenda->__set('id', $_GET['id']);
            $result = $agenda->buscarPorId();
            $this->view->dados = $result;
            $this->render('vis_agenda', 'head','menu_adm' , 'body', 'footer');
        }

        public function apagarAgenda() 
        {
            session_start();
            $agenda = Container::getModel('Agenda');
            $agenda->__set('id', $_GET['id']);
            $agenda->apagar();
            $_SESSION['msg'] = "<div class='alert alert-success'> Jogo excluído da agenda!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
            header('Location: /clarim/adm/jogos');

        }

        

    }

?>