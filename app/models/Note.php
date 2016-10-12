<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Note
 *
 * @author ville-matti
 */
class Note extends BaseModel{
    public $id, $note, $supercategory;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array();
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM NOTE');
        $query->execute();
        
        $rows = $query->fetchAll();
        $notes = array();
        
        foreach($rows as $row){
            $notes[] = new Note(array(
                'id' => $row['id'],
                'note' => $row['note'],
                'supercategory' => $row['supercategory']
            ));
        }
        
        return $notes;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM NOTE WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $note = new Note(array(
                'id' => $row['id'],
                'note' => $row['note'],
                'supercategory' => $row['supercategory']
            ));
            
            return $note;
        }
        
        return null;
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE NOTE SET note = :note WHERE id = :id');
        $query->execute(array(
            'note' => $this->note,
            'id' => $this->id
        ));
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO NOTE (note, supercategory) VALUES (:note, :supercategory) RETURNING id');
        $query->execute(array(
            'note' => $this->note,
            'supercategory' => $this->supercategory
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete(){
        $query = DB::connection()->prepare('DELETE FROM NOTE WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }
}