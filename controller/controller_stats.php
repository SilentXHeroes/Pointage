<?php
    Class CI_Stats extends CI{

        public function index(){
            $this->loadModel('user', 'User');

            $data = array();

            $data['stats'] = $this->getPointagesForStats(1);
            $data['program'] = $this->User->getProgram(1);
            $this->loadView('view_stats.php', $data);
        }

        public function getPointagesForStats($id_user){
            $this->loadModel('workTime', 'Time');
            $this->loadHelper('time');

            $groups = $this->Time->getGroupsPointage(1);
            $workTime = parent::getController('WorkTime');
            $data = array();
            foreach($groups as $group){
                $ptgs  = $this->Time->getPointage(1, '', FALSE, $group['id_groupe_pointage'], 'ASC');
                $listePtg = array();
                foreach($ptgs as $ptg){
                    $date = new DateTime($ptg['pointage']);
                    array_push($listePtg, $date->format('H:i'));
                }
                $times = $workTime->getEventTime(1, 'workTime', $group['id_groupe_pointage'], TRUE);
                $infos = $this->Time->getInfosGroup($group['id_groupe_pointage']);
                $date  = array(
                    'id_day'   => $group['id_day'],
                    'time'     => $times,
                    'ptg'      => $listePtg
                );
                $year   = intval($infos['year']);
                $month  = intval($infos['month']);
                $day   = intval($infos['date']);
                if(!isset($data[$year])){
                    $data[$year] = array();
                }
                if(!isset($data[$year][$month])){
                    $data[$year][$month] = array();
                }
                if(!isset($data[$year][$month][$day])){
                    $data[$year][$month][$day] = array();
                }

                $data[$year][$month][$day] = $date;
            }
            return $data;
        }

    }