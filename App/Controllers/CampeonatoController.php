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
            $this->render('campeonato', 'head','menu' , 'body', 'footer');
        }

    }

?>