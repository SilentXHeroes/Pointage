<?php
    class CI
    {
        public $version = '1.7.2';
        public $controllers;

        function __construct(){
            session_start();
        }

        public function loadModel($model, $name = ''){
            require_once _ROOT.'/models/'.$model.'.php';

            if(empty($name))
                $name = $model;

            $this->{$name} = new $model();
        }

        public function loadView($view, $data = array()){
            $activeController = $this->activeController;

            foreach($data as $var => $value){
                ${$var} = $value;
            }

            require _ROOT.'/views/'.$view;
        }

        public function loadHelper($name){
            require_once _ROOT.'/helpers/'.$name.'.php';
        }

        public function setControllers($controllers){
            $this->controllers = $controllers;
        }

        public function getControllers(){
            return $this->controllers;
        }

        public function getController($name){
            return $this->controllers[$name];
        }
    }
?>