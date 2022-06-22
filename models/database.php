<?php
	class Database{
		public $pdo;

		function __construct(){
			$pdo_options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		        PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION,
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);

			try {
				$this->pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE.';charset=utf8', USER, PASS, $pdo_options);
			} catch (PDOException $e) { //Si une erreur se produit lors de la connexion
				die('Erreur : '.$e->getMessage()); //Stop le code et renvoit un message d'erreur
			}
		}
	}
?>