<?php
	class Calendar extends Database
	{
		public function __construct()
	    {
	        parent::__construct();
	    }

	    public function getDateStart($iduser){
	    	$request = $this->pdo->prepare('
	    		SELECT date_start FROM ptg_work
	    		WHERE id_user = :iduser AND id_work = 1'
	    	);
	    	$request->execute(array(
	    		'iduser' => $iduser
	    	));
	    	return $request->fetch();
	    }
	}

?>