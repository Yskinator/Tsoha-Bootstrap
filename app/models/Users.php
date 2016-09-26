<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author ville-matti
 */
class Users extends BaseModel{
    public $id, $username, $password, $list_root;

    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM USERS');
        $query->execute();
        
        $rows = $query->fetchAll();
        $users = array();
        
        foreach($rows as $row){
            $users[] = new Users(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'list_root' => $row['list_root']
            ));
        }
        
        return $users;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM USERS id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $user = new Users(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'list_root' => $row['list_root']
            ));
            
            return $user;
        }
        
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO USERS (username, password, list_root) VALUES (:username, password, list_root)');
        $query->execute(array(
            'username' => $this->username,
            'password' => $this->password,
            'list_root' => $this->list_root
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}