<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NoteController
 *
 * @author ville-matti
 */
class NoteController extends BaseController{
    
    public static function store(){
        $params = $_POST;
        $note = new Note(array(
            'note' => $params['note'],
            'supercategory' => $params['supercategory']
        ));
        $errors = $note->errors();
        if(count($errors) == 0)
        {
            $note->save();
            Redirect::to('/categories', array('message' => 'Merkintää lisätty!'));
        }
        else
        {
            $user = self::get_user_logged_in();
            $root_category = Category::find($user->list_root);
            View::make('category/index.html', array('root_category' => $root_category,'errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function delete(){
        self::check_logged_in();
        $params = $_POST;
        $note = Note::find($params['id']);
        $note->delete();
        Redirect::to('/categories', array('message' => 'Merkintä poistettu!'));
    }
    
    public static function update(){
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'note' => $params['note'],
            'supercategory' => $params['supercategory'],
            'id' => $params['id']
        );
        $note = new Note($attributes);
        $errors = $note->errors();
        if(count($errors) == 0)
        {
            $note->update();
            Redirect::to('/categories', array('message' => 'Merkintää muokattu!'));
        }
        else
        {
            $user = self::get_user_logged_in();
            $root_category = Category::find($user->list_root);
            View::make('category/index.html', array('root_category' => $root_category,'errors' => $errors, 'attributes' => $attributes));
        }
    }

}
