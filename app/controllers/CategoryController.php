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
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $root_category = Category::find($user->list_root);
        View::make('category/index.html', array('root_category' => $root_category));
    }
    
    public static function update(){
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
            'supercategory' => $params['supercategory'],
            'id' => $params['id']
        );
        $category = new Category($attributes);
        $errors = $category->errors();
        if(count($errors) == 0)
        {
            $category->update();
            Redirect::to('/categories', array('message' => 'Kategoriaa muokattu!'));
        }
        else
        {
            Redirect::to('/categories', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function delete(){
        self::check_logged_in();
        $params = $_POST;
        $category = Category::find($params['id']);
        $category->delete();
        Redirect::to('/categories', array('message' => 'Kategoria poistettu!'));
    }
    
    public static function store(){
        self::check_logged_in();
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
            Redirect::to('/categories', array('errors' => $errors, 'attributes' => $attributes));
        }

    }
}
