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
        $root_category = Category::findByName('root');
        View::make('category/index.html', array('root_category' => $root_category));
    }
    
    public static function store(){
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
            'supercategory' => $params['supercategory']
        );
        $category = new Category($attributes);
        $errors = $category->errors();
        if(count($errors) == 0)
        {
            $category->save();
            Redirect::to('/categories', array('message' => 'Uusi kategoria lisätty!'));
        }
        else
        {
            $root_category = Category::findByName('root');
            View::make('category/index.html', array('root_category' => $root_category,'errors' => $errors, 'attributes' => $attributes));
        }

    }
}
