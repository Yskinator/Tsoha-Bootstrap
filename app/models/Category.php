<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author ville-matti
 */
class Category extends BaseModel{
    public $id, $name, $supercategory, $subcategories, $notes, $times_and_places;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->subcategories = Category::findChildCategories($this->id);
        $this->notes = Category::findNotes($this->id);
        $this->times_and_places = Category::findTimes_And_Places($this->id);
        $this->validators = array('validateName', 'validateSupercategory');
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM CATEGORY');
        $query->execute();
        
        $rows = $query->fetchAll();
        $categories = array();
        
        foreach($rows as $row){
            $categories[] = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'supercategory' => $row['supercategory']
            ));
        }
        
        return $categories;
    }
    
    public static function findChildCategories($id){
        $statement = 'SELECT * FROM CATEGORY WHERE supercategory = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $categories = array();
        
        foreach($rows as $row){
            $categories[] = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'supercategory' => $row['supercategory']
            ));
        }
        return $categories;
    }
    
    public static function findNotes($id){
        $statement = 'SELECT * FROM NOTE WHERE supercategory = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
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
    
    public static function findTimes_And_Places($id){
        $statement = 'SELECT * FROM TIME_AND_PLACE WHERE supercategory = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $times_and_places = array();
        
        foreach($rows as $row){
            $times_and_places[] = new Time_And_Place(array(
                'id' => $row['id'],
                'dow' => $row['dow'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'location' => $row['location'],
                'supercategory' => $row['supercategory']
            ));
        }
        return $times_and_places;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM CATEGORY WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $category = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'supercategory' => $row['supercategory']
            ));
            
            return $category;
        }
        
        return null;
    }
    
    public static function findByName($name){
        $statement = 'SELECT * FROM CATEGORY WHERE name = :name LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('name' => $name));
        $row = $query->fetch();
        
        if($row){
            $category = new Category(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'supercategory' => $row['supercategory']
            ));
            
            return $category;
        }
        
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO CATEGORY (name, supercategory) VALUES (:name, :supercategory) RETURNING id');
        $query->execute(array(
            'name' => $this->name,
            'supercategory' => $this->supercategory
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE CATEGORY SET name = :name WHERE id = :id');
        $query->execute(array(
            'name' => $this->name,
            'id' => $this->id
        ));
    }
    
    public function delete(){
        $query = DB::connection()->prepare('DELETE FROM CATEGORY WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validateName(){
        //Tarkista, että nimi ei ole tyhjä tai null
        $errors = $this->validate_string_exists($this->name, 'Kategorian nimi');
        //Tarkista, että nimen pituus on vähintään 2 ja enintään 200 merkki'
        $errors = array_merge($errors, $this->validate_string_length($this->name, 2, 200, 'Kategorian nimen'));
        return $errors;
    }
    
    public function validateSupercategory(){
        $errors = array();
        if($this->name != "root"){
            $query = DB::connection()->prepare('SELECT id FROM CATEGORY WHERE id = :supercategory LIMIT 1');
            $query->execute(array('supercategory' => $this->supercategory));
            $row = $query->fetch();
            
            if(!$row){
                $errors[] = 'Yläkategoriaa ei löytynyt tietokannasta.';
            }
        }
        else
        {
            if($this->supercategory != null)
            {
                $errors[] = 'Juurikategorialla ei pitäisi olla yläkategoriaa!';
            }
        }
        return $errors;
    }
}