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

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $value) {
            $this->$atributo = $value;
        }

        public function salvar(){
            $query = "INSERT INTO events(title, time1, time2, data, id_horario, start, end) 
                VALUES (:title, :time1, :time2, :data, :horario, :start, :end)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':title', $this->__get('title'));
            $stmt->bindValue(':time1', $this->__get('time1'));
            $stmt->bindValue(':time2', $this->__get('time2'));
            $stmt->bindValue(':data', $this->__get('data'));
            $stmt->bindValue(':horario', $this->__get('horario'));
            $stmt->bindValue(':start', $this->__get('start'));
            $stmt->bindValue(':end', $this->__get('end'));
            $stmt->execute();
            return $this;
        }

        public function update() {
            try {
                $query = "UPDATE events SET title = :title, time1 = :time1, time2 =:time2, gol1 = :gol1, gol2 = :gol2 WHERE id = :id";
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

    }

?>