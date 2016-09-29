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
    public $id, $category_name, $supercategory, $subcategories, $notes, $times_and_places;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->subcategories = Category::findChildCategories($this->id);
        $this->notes = Category::findNotes($this->id);
        $this->times_and_places = Category::findTimes_And_Places($this->id);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM CATEGORY');
        $query->execute();
        
        $rows = $query->fetchAll();
        $categories = array();
        
        foreach($rows as $row){
            $categories[] = new Category(array(
                'id' => $row['id'],
                'category_name' => $row['category_name'],
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
                'category_name' => $row['category_name'],
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
                'category_name' => $row['category_name'],
                'supercategory' => $row['supercategory']
            ));
            
            return $category;
        }
        
        return null;
    }
    
    public static function findByName($category_name){
        $statement = 'SELECT * FROM CATEGORY WHERE category_name = :category_name LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('category_name' => $category_name));
        $row = $query->fetch();
        
        if($row){
            $category = new Category(array(
                'id' => $row['id'],
                'category_name' => $row['category_name'],
                'supercategory' => $row['supercategory']
            ));
            
            return $category;
        }
        
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO CATEGORY (category_name, supercategory) VALUES (:category_name, :supercategory) RETURNING id');
        $query->execute(array(
            'category_name' => $this->category_name,
            'supercategory' => $this->supercategory
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}