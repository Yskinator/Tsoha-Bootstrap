<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Time_And_PlaceController
 *
 * @author ville-matti
 */
class Time_And_PlaceController extends BaseController{
    public static function store(){
        $params = $_POST;
        $time_and_place = new Time_And_Place(array(
            'dow' => $params['dow'],
            'tp_date' => $params['tp_date'],
            'start_time' => $params['start_time'],
            'end_time' => $params['end_time'],
            'location' => $params['location'],
            'supercategory' => $params['supercategory']
        ));
        $errors = $time_and_place->errors();
        if(count($errors) == 0)
        {
            $time_and_place->save();
            Redirect::to('/categories', array('message' => 'Aika ja paikka lisätty!'));
        }
        else
        {
            $user = self::get_user_logged_in();
            $root_category = Category::find($user->list_root);
            View::make('category/index.html', array('root_category' => $root_category,'errors' => $errors, 'attributes' => $attributes));
        }
    }
    
}