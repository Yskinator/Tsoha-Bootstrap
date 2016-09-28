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
    public $id, $category_name, $supercategory, $subcategories;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->subcategories = Category::findChildren($this->id);
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
    
    public static function findChildren($id){
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