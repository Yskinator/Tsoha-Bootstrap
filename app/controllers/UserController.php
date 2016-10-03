<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author ville-matti
 */
class UserController {
    public static function handleLogin(){
        $params = $_POST;
        $user = Users::authenticate($params['username'], $params['password']);
        
        if(!$user){
            Redirect::to('/', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        }else{
            $_SESSION['user'] = $user->id;

            Redirect::to('/categories', array('message' => 'Tervetuloa takaisin ' . $user->username . '!'));
        }
    }
    public static function logout(){
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
  }
}
