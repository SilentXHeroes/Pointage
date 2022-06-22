<?php
	class WorkTime extends Database
	{
	    function __construct()
	    {
	    	parent::__construct();
	    }

	    public function setPointage($id_user, $event_type = 'B', $from_event = NULL){
	    	$day = new DateTime();
	    	$id_group = $this->getLastGroupId($id_user);

	    	$request = $this->pdo->prepare('
    			INSERT INTO ptg_pointage (pointage, id_groupe_pointage, id_work, id_user, event_type, id_day, from_event)
    			VALUES (:pointage, :group, :work, :user, :evt, :day, :from)'
    		);
	    	$request->execute(array(
	    		'pointage' 	=> $day->format('Y-m-d H:i:s'),
	    		'group'		=> is_null($id_group) ? 1 : $id_group,
	    		'work'		=> 1,
	    		'user'		=> $id_user,
	    		'evt'		=> $event_type,
	    		'day'		=> intVal($day->format('N')),
	    		'from'		=> $from_event
	    	));

	    	return $this->pdo->lastInsertId();
	    }

	    public function getPointage($id_user, $type = '', $onlyLast = FALSE, $id_group = '', $order = 'DESC'){
	    	$date = new DateTime();
	    	$day = $date->format('Y-m-d');

	    	$getType = '';
    		$getDate = "AND pointage LIKE '$day%'";
	    	if(!empty($type))
	    		$getType = "AND event_type = '$type'";
	    	if(!empty($id_group)){
	    		$getDate = '';
	    		$getGroup = "AND id_groupe_pointage = $id_group";
	    	}

	    	$request = $this->pdo->query("
    			SELECT * from ptg_pointage
    			WHERE id_user = $id_user $getDate $getType $getGroup
    			ORDER BY pointage $order
    		");

	    	return $onlyLast ? $request->fetch() : $request->fetchAll();
	    }

	    public function getPointageFromEvent($id_pointage){
	    	if(empty($id_pointage)){
	    		return array();
	    	}else{
		    	return $this->pdo->query("
	    			SELECT * from ptg_pointage
	    			WHERE id_pointage = $id_pointage
	    		")->fetch();
	    	}
	    }

	    public function getGroupsPointage($id_user, $id_group = '', $type = ''){
	    	$where = '';
	    	if(!empty($type))
	    		$where .= " AND event_type = '$type'";
	    	if(!empty($id_group))
	    		$where .= " AND id_groupe_pointage = $id_group";

	    	return $this->pdo->query(
	    		"SELECT	id_groupe_pointage, id_day FROM ptg_pointage
	    		WHERE id_user = $id_user $where
	    		GROUP BY id_groupe_pointage"
	    	)->fetchAll();
	    }

	    public function getInfosGroup($id_group){
	    	return $this->pdo->query(
	    		"SELECT	DATE_FORMAT(pointage, '%Y') as year,
	    				DATE_FORMAT(pointage, '%m') as month,
	    				DATE_FORMAT(pointage, '%d') as date
	    		FROM ptg_pointage
	    		WHERE id_groupe_pointage = $id_group
	    		GROUP BY id_groupe_pointage"
	    	)->fetch();
	    }

	    public function getLastGroupId($id_user){
	    	$id_group = $this->pdo->query(
	    		"SELECT MAX(id_groupe_pointage) as max FROM ptg_pointage WHERE id_user = $id_user"
	    	)->fetch();
	    	// Premier pointage
	    	if(empty($id_group)){
	    		return 1;
	    	}else{
	    		// Si la journée n'est pas terminée, on garde l'ID
		    	$pointage = $this->getGroupsPointage($id_user, $id_group['max'], 'E');
		    	return empty($pointage) ? $id_group['max'] : $id_group['max'] + 1;
		    }
	    }
	}

?>