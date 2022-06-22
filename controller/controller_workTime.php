<?php
    class CI_WorkTime extends CI
    {
        private $isAtive = FALSE;

        public function index(){
            $this->loadModel('workTime', 'Time');

            $dateNow = new DateTime();
            $lastEvent = $this->Time->getPointage(1, '', TRUE);
            $beginAt = $this->Time->getPointage(1, 'B', TRUE)['pointage'];
            $breakTime = $this->getEventTime(1, 'breakTime');
            $time_worked = $this->getEventTime(1, 'workTime');
            $statsUser = $this->getStatsUser(1);
            $workTime = $statsUser['time_worked'];
            $timePause = $statsUser['time_pause'];

            if(!is_null($workTime))
                $statsUser['time_worked'] = $workTime['H'];
            if(!is_null($timePause))
                $statsUser['time_pause'] = ($timePause['M']*60) + $timePause['H'];

            if($lastEvent['event_type'] === 'W'){
                $from = new DateTime($lastEvent['pointage']);
            }else{
                $from = new DateTime($beginAt);
            }

            $over = $lastEvent['event_type'] === 'E';
            $inBreakingTime = $lastEvent['event_type'] === 'BR';
            $notStart = FALSE;
            if(!empty($beginAt)){
                // On définit le temps de travail au temps travaillé
                if($inBreakingTime || $over){
                    $hours = $time_worked['H'];
                    $minutes = $time_worked['M'];
                    $seconds = $time_worked['S'];

                    if($seconds >= 60){
                        $seconds = $seconds - 60;
                        $minutes++;
                    }
                    if($minutes >= 60){
                        $minutes = $minutes - 60;
                        $hours++;
                    }
                }
                else{
                    $diff = date_diff($dateNow, $from);

                    // On ajoute les heures de travail effectuées
                    // seulement lors de la reprise
                    if($lastEvent['event_type'] !== 'B'){
                        $diff->h += $time_worked['H'];
                        $diff->i += $time_worked['M'];
                        $diff->s += $time_worked['S'];
                    }

                    // Si les secondes sont supérieurs à 60
                    if($diff->s >= 60){
                        $diff->s = $diff->s - 60;
                        $diff->i++;
                    }
                    // Si les minutes sont supérieurs à 60
                    if($diff->i >= 60){
                        $diff->i = $diff->i - 60;
                        $diff->h++;
                    }

                    $hours = $diff->h;
                    $minutes = $diff->i;
                    $seconds = $diff->s;
                }

                $hours = ($hours < 10 ? '0' : '') . $hours;
                $minutes = ($minutes < 10 ? '0' : '') . $minutes;
                $seconds = ($seconds < 10 ? '0' : '') . $seconds;
            }else{
                $hours = '00';
                $minutes = '00';
                $seconds = '00';
                $notStart = TRUE;
            }

            $data['hours']          = $hours;
            $data['minutes']        = $minutes;
            $data['seconds']        = $seconds;
            $data['inBreakingTime'] = $inBreakingTime;
            $data['statsUser']      = $statsUser;
            $data['notStart']       = $notStart;
            $data['over']           = $over;

            $this->loadView('view_workTime.php', $data);
        }

        public function setPointage($id_user, $event_type = 'B'){
            $this->loadModel('workTime', 'Time');
            $this->loadHelper('utf8');

            $lastEvent = $this->Time->getPointage(1, '', TRUE);

            $id_pointage = $this->Time->setPointage($id_user, $event_type, $event_type !== 'B' ? $lastEvent['id_pointage'] : NULL);

            utf8_encode_deep($id_pointage);
            echo json_encode($id_pointage);
        }

        public function getEventTime($id_user, $event, $id_group = '', $all = FALSE){
            $this->loadModel('workTime', 'Time');
            $this->loadHelper('utf8');

            if($event === 'breakTime'){
                $events = array('W');
            }else if($event === 'workTime'){
                $pointages = $this->Time->getPointage($id_user, 'BR');
                if(empty($pointages) && !$all)
                    $events = array('B');
                else
                    $events = array('BR', 'E');
            }

            $time = FALSE;
            foreach($events as $event){
                $pointages = $this->Time->getPointage($id_user, $event, FALSE, $id_group);

                foreach($pointages as $pointage){
                    $thisEvent = new DateTime($pointage['pointage']);
                    $eventBefore = $this->Time->getPointageFromEvent($pointage['from_event']);
                    $H = $M = $S = 0;
                    if($event === 'B'){
                        $date = new DateTime();
                        $diff = date_diff($date, $thisEvent);

                        $H = $diff->h;
                        $M = $diff->i;
                        $S = $diff->s;
                    }else if(!empty($eventBefore)){
                        $eventBefore = new DateTime($eventBefore['pointage']);
                        $diff = date_diff($thisEvent, $eventBefore);

                        $H = $diff->h;
                        $M = $diff->i;
                        $S = $diff->s;
                    }

                    if(!$time){
                        $time = array(
                            'H' => 0,
                            'M' => 0,
                            'S' => 0
                        );
                    }
                    $time['H'] += $H;
                    $time['M'] += $M;
                    $time['S'] += $S;

                    if($time['S'] >= 60){
                        $time['M']++;
                        $time['S'] -= 60;
                    }
                    if($time['M'] >= 60){
                        $time['H']++;
                        $time['M'] -= 60;
                    }
                }
            }

            if($this->isAjax){
                echo json_encode($time);
            }else{
                return $time;
            }
        }

        public function getStatsUser($id_user){
            $this->loadModel('user', 'User');
            $this->loadModel('workTime', 'Time');

            $groups = $this->Time->getGroupsPointage($id_user);

            $H = 0;
            $M = 0;
            $S = 0;
            foreach($groups as $group){
                $times = $this->getEventTime($id_user, 'workTime', $group['id_groupe_pointage'], TRUE);

                $H += $times['H'];
                $M += $times['M'];
                $S += $times['S'];

                if($S >= 60){
                    $M++;
                    $S -= 60;
                }
                if($M >= 60){
                    $H++;
                    $M -= 60;
                }
            }

            $time = array(
                'time_worked' => array(
                    'H' => $H,
                    'M' => $M,
                    'S' => $S
                ),
                'time_pause' => NULL
            );

            return $time;
        }
    }
?>