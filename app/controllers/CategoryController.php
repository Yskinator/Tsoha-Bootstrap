<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryController
 *
 * @author ville-matti
 */
class CategoryController extends BaseController{
    public static function index(){
        $root_category = Category::findByName('');
        View::make('category/index.html', array('root_category' => $root_category));
    }
    
    public static function store(){
        $params = $_POST;
        $category = new Category(array(
            'category_name' => $params['category_name'],
            'supercategory' => $params['supercategory']
        ));
        $category->save();
        
        Redirect::to('muistilista/categories', array('message' => 'Uusi kategoria lisätty!'));
    }
}
