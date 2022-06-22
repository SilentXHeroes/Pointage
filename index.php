<?php
	// Définition des constantes
	define ( '_ROOT', $_SERVER['DOCUMENT_ROOT'] );

    date_default_timezone_set('Europe/Paris');

	$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	$controller = isset($_GET['controller']) && !empty($_GET['controller']) ? $_GET['controller'] : 'workTime';

	require 'ge/code.php';
	require 'models/database.php';
	require 'controller/CI.php';
	require 'controller/controller_workTime.php';
	require 'controller/controller_calendar.php';
	require 'controller/controller_user.php';
	require 'controller/controller_stats.php';

    if($isAjax){
		$CI 					= 'CI_'.$controller;
		$Controller 			= new $CI();
		$Controller->isAjax 	= $isAjax;
		$Controller->isActive 	= TRUE;
		$Controller->post		= $_POST;

		$function = isset($_GET['function']) && !empty($_GET['function']) ? $_GET['function'] : '';
		$params = isset($_GET['params']) && !empty($_GET['params']) ? explode('/', $_GET['params']) : array();

		if(!empty($function)){
			if(!empty($params))
				call_user_func_array(array($Controller, $function), $params);
			else
				$Controller->$function();
		}else{
			echo json_encode(FALSE);
		}
    }else{
		$CI = new CI();

		$Calendar = new CI_Calendar();
		$WorkTime = new CI_WorkTime();
		$User = new CI_User();
		$Stats = new CI_Stats();

		$controllers = array(
			'Calendar' 	=> $Calendar,
			'WorkTime' 	=> $WorkTime,
			'User' 		=> $User,
			'Stats'		=> $Stats
		);

		$Calendar->setControllers($controllers);
		$WorkTime->setControllers($controllers);
		$User->setControllers($controllers);
		$Stats->setControllers($controllers);

        $data['css'] = [
            'workTime.css',
            'calendar.css',
            'user.css',
            'stats.css'
        ];
        $CI->loadView('template/header.php', $data);

        switch($controller){
        	case 'workTime':
        		$WorkTime->isActive = TRUE;
        		break;

        	case 'calendar':
        		$Calendar->isActive = TRUE;
        		break;

        	case 'user':
        		$User->isActive = TRUE;
        		break;

        	case 'stats':
        		$Stats->isActive = TRUE;
        		break;
        }

        $Stats->index();
        $User->index();
        $WorkTime->index();
        $Calendar->index();

        $data['js'] = [
            'workTime.js',
            'calendar.js',
            'user.js',
            'stats.js'
        ];
        $CI->loadView('template/footer.php', $data);
    }
?>