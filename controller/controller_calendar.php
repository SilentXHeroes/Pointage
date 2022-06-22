<?php
    Class CI_Calendar extends CI {

        private $isAtive = FALSE;

        public function index(){
            $this->loadModel('calendar', 'Calendar');

            date_default_timezone_set('Europe/Paris');
            $data['date'] = array('start' => new DateTime());
            $data['months'] = array(
                '01' => 'Janvier',
                '02' => 'Février',
                '03' => 'Mars',
                '04' => 'Avril',
                '05' => 'Mai',
                '06' => 'Juin',
                '07' => 'Juillet',
                '08' => 'Août',
                '09' => 'Septembre',
                '10' => 'Octobre',
                '11' => 'Novembre',
                '12' => 'Décembre'
            );

            $userDate = $this->Calendar->getDateStart(1);
            $data['dateStart'] = new DateTime($userDate['date']);

            $now = new DateTime();
            $data['activeMonth'] = $now->format('m');
            $data['activeYear'] = $now->format('Y');
            $data['fullMonth'] = $this->getFullMonth($data['activeMonth'], $data['activeYear'], $action);

            $this->loadView('view_calendar.php', $data);
        }

        public function setCalendar(){
            if($this->isAjax){
                $date = $_POST['date'];

                $action = isset($_POST['params']) && !empty($_POST['params']) ? $_POST['params'] : '';
                $data = $this->getFullMonth($date['month'], $date['year'], $action);

                utf8_encode_deep($data);
                echo json_encode($data);
            }
        }

        private function getFullMonth($month = '', $year = '', $action = ''){
            $dates = array();

            $compare = new DateTime('01-'.$month.'-'.$year);
            if(!empty($action)){
                if($action === 'next'){
                    $compare->modify('+1 month');
                }else{
                    $compare->modify('-1 month');
                }
                $month = $compare->format('m');
            }
            for ($i=0; $i < 31; $i++) {
                if($month === $compare->format('m'))
                    array_push($dates, $compare->format('d'));
                $compare->modify('+1 day');
            }
            $compare->modify('-1 month');
            $data['calendar'] = $dates;
            $data['get'] = array(
                'month' => $compare->format('m'),
                'year' => $compare->format('Y')
            );

            return $data;
        }
    }

?>