<?php

    namespace App\Models;
    use MF\Model\Model;
    use DateTime;


    Class Agenda extends Model {

        private $id;
        private $title;
        private $time1;
        private $time2;
        private $gol1;
        private $gol2;
        private $data;
        private $horario;
        private $start;
        private $end;
        private $user_check;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $value) {
            $this->$atributo = $value;
        }

        public function salvar(){
            try{
                $query = "INSERT INTO events(id_user_check, title, time1, time2, id_horario, data, start, end) 
                VALUES (:id_user, :title, :time1, :time2, :horario, :data, :start, :end)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':title', $this->__get('title'));
                $stmt->bindValue(':time1', $this->__get('time1'));
                $stmt->bindValue(':time2', $this->__get('time2'));
                $stmt->bindValue(':data', $this->__get('data'));
                $stmt->bindValue(':horario', $this->__get('horario'));
                $stmt->bindValue(':start', $this->__get('start'));
                $stmt->bindValue(':end', $this->__get('end'));
                $stmt->bindValue(':id_user', $this->__get('user_check'));
                $valida = $stmt->execute();
            } catch(Exception $e) {
                throw  $e;
            }
            
            return $valida;
        }

        public function update() {
            try {
                $query = "UPDATE events SET title = :title, time1 = :time1, time2 =:time2, gol_time1 = :gol1, gol_time2 = :gol2 WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':title', $this->__get('title'));
                $stmt->bindValue(':time1', $this->__get('time1'));
                $stmt->bindValue(':time2', $this->__get('time2'));
                $stmt->bindValue(':gol1', $this->__get('gol1'));
                $stmt->bindValue(':gol2', $this->__get('gol2'));
                $stmt->bindValue(':id', $this->__get('id'));
                $stmt->execute();
                return $this;
            } catch( Exception $e) {
                throw $e;
                return false;
            }
        }

        public function retornaDtString($var) {

            $string = $this->getStringDt($var);
            $format = 'Y-m-d';
            $date = DateTime::createFromFormat($format, $string);
            $return =  $date->format('Y-m-d') ;
            return $return;
        }

        public function retornaStart($data, $start) {
            $string = $this->getStringDt($data);
            $string = $string." ".$start;
            $format = 'Y-m-d H:i';
            $date = DateTime::createFromFormat($format, $string);
            $return =  $date->format('Y-m-d H:i') ;
            return $return;
        }

        public function retornaEnd($data, $start) {
            $string = $this->getStringDt($data);
            $array_end = explode(":", $start);
            if ($array_end[0] == 23) {
                $array_end[1] = 59;
            } else {
                $array_end[0] += 1;
            }
            $end = implode(":", $array_end);
            $string = $string." ".$end;
            $format = 'Y-m-d  H:i';
            $date = DateTime::createFromFormat($format, $string);
            $return =  $date->format('Y-m-d H:i') ;
            return $return;
        }

        public function getStringDt($var) {
            $var = explode(" ", $var);
            $var = $var[0];
            $var = explode("/" ,$var);
            $count = count($var);
            $string = "";
            
            while ($count > 0) {
                if(strlen($string) == 0) {
                    $string .= $var[$count - 1];
                } else {
                    $string .= "-".$var[$count - 1];
                }
                
                $count--;
            }

            return $string;

        }

        public function getHorarioById($id_horario) {
            $query = "SELECT horario from horarios where id ='".$id_horario."'  ";
            $result = $this->db->query($query)->fetchAll();
            return $result[0]['horario'];
        }

        public function getHorariosDisp($data) {
            $query = "SELECT h.id FROM `horarios` h                
            left JOIN events e on e.id_horario = h.id
            WHERE data = '".$data."' ";
            $result = $this->db->query($query)->fetchAll();
            $notHour = [];
            foreach ($result as $r) {
                $notHour[] = $r['id'];
            }
            if(count($notHour) == 0) {
                $query = " select * from horarios";
                $todosHoraios = $this->db->query($query)->fetchAll();
            }else {
                $notHora = implode(",",$notHour);
                $query = " select * from horarios where id not in ($notHora) ";
                $todosHoraios = $this->db->query($query)->fetchAll();
            }            
            return $todosHoraios;
        }

        public function getTotalJogos() {
            $query = "select count(id) as qtd from events";
            return $this->db->query($query)->fetchAll();
        }

        public function listarAgendas($inicio, $qnt_result_pg) {
            $query = "SELECT * FROM events ORDER BY data desc LIMIT $inicio, $qnt_result_pg ";
            return $this->db->query($query)->fetchAll();
        }

        public function listarAgenP($inicio, $qnt_result_pg, $id_user) {
            $query = "SELECT * FROM events where id_user_check = '".$id_user."' ORDER BY data desc LIMIT $inicio, $qnt_result_pg ";
            return $this->db->query($query)->fetchAll();
        }


        public function buscarPorId() {
            $query = "SELECT e.* FROM events e
                    WHERE e.id = '".$this->__get('id')."' ";
            return $this->db->query($query)->fetchAll();
        }

        public function validarDados($id_horario, $data, $id_user) {
            $id_horario = (int) $id_horario;
            
            
            $dt = $this->retornaDtString($data) ;
            $dt = new DateTime($dt);
            $dt->modify('-1 day');
            $dt = $dt->format('Y-m-d');
            $query = "SELECT id_horario, data, id_user_check 
                      FROM events 
                      WHERE id_horario = $id_horario and id_user_check = $id_user and data = '$dt' and id_user_check > 1 ";
            $result = $this->db->query($query)->fetchAll();
            if (count($result) > 0 ) {
                return false;
            }
            return true;
        }

        public function apagar() {
            $query = "DELETE FROM events WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }

    }

?>