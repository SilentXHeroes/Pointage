<?php
    Class CI_User extends CI{

        public function index(){
            $this->loadModel('user', 'User');

            $data = array();
            $this->loadView('view_user.php', $data);
        }

        public function connectUser(){
            if($this->isAjax){
                $this->loadModel('user', 'User');
                $this->loadHelper('utf8');

                $post = $this->post;
                $email = $post['email'];
                $mdp = $post['mdp'];

                $user = $this->User->getUserByEmail($email);

                $result['error'] = FALSE;
                if($user !== FALSE && password_verify($mdp, $user['password'])){
                    unset($user['password']);
                    $result['user'] = $user;
                    $_SESSION['USER'] = $user;
                }else{
                    $result['error'] = TRUE;
                    $result['message'] = 'Combinaison email / mot de passe incorrecte.';
                }

                utf8_encode_deep($result);
                echo json_encode($result);
            }
        }

    }