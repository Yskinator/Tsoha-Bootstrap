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
        //Replace empty strings with nulls so that the database handles empty dates correctly
        foreach ($params as $key => $value)
        {
            if($value == ""){
                $params[$key] = null;
            }
        }
        $attributes = array(
            'dow' => $params['dow'],
            'tp_date' => $params['tp_date'],
            'start_time' => $params['start_time'],
            'end_time' => $params['end_time'],
            'location' => $params['location'],
            'supercategory' => $params['supercategory']
        );
        $time_and_place = new Time_And_Place($attributes);       
        $errors = $time_and_place->errors();
        if(count($errors) == 0)
        {
            $time_and_place->save();
            Redirect::to('/categories', array('message' => 'Aika ja paikka lisätty!'));
        }
        else
        {
            $user = self::get_user_logged_in();
            Redirect::to('/categories', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function update(){
        $params = $_POST;
        //Replace empty strings with nulls so that the database handles empty dates correctly
        foreach ($params as $key => $value)
        {
            if($value == ""){
                $params[$key] = null;
            }
        }
        $attributes = array(
            'dow' => $params['dow'],
            'tp_date' => $params['tp_date'],
            'start_time' => $params['start_time'],
            'end_time' => $params['end_time'],
            'location' => $params['location'],
            'supercategory' => $params['supercategory'],
            'id' => $params['id']
        );
        $time_and_place = new Time_And_Place($attributes);       
        $errors = $time_and_place->errors();
        if(count($errors) == 0)
        {
            $time_and_place->update();
            Redirect::to('/categories', array('message' => 'Aika ja paikka lisätty!'));
        }
        else
        {
            $user = self::get_user_logged_in();
            Redirect::to('/categories', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    
    public static function delete(){
        self::check_logged_in();
        $params = $_POST;
        $time_and_place = Time_And_Place::find($params['id']);
        $time_and_place->delete();
        Redirect::to('/categories', array('message' => 'Merkintä poistettu!'));
    }
    
    
}
