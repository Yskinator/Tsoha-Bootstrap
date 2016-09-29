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
class NoteController {
    
    public static function store(){
        $params = $_POST;
        $note = new Note(array(
            'note' => $params['note'],
            'supercategory' => $params['supercategory']
        ));
        $note->save();
        Redirect::to('/categories', array('message' => 'Uusi merkintä lisätty!'));
    }

}
