<?php
	class User extends Database
	{
		public $user;

		public function getInfosUser($id){
			$query = $this->pdo->prepare('
				SELECT * FROM ptg_user
				WHERE iduser = :iduser'
			);
			$query->execute(array(
				'iduser' => $id
			));
			$this->user = $query->fetch();
			return $this->user;
		}

		public function getUserByEmail($email){
			$user = $this->pdo->query(
				"SELECT * FROM ptg_user
				WHERE email = '$email'"
			)->fetch();

			return empty($user) ? FALSE : $user;
		}

		public function getProgram($id_user, $id_work = 1){
			return $this->pdo->query(
				"SELECT * FROM ptg_program
				WHERE id_user = $id_user AND id_work = $id_work"
			)->fetchAll();
		}
	}
?>