<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Time_And_Place
 *
 * @author ville-matti
 */
class Time_And_Place extends BaseModel{
    public $id, $dow, $tp_date, $start_time, $end_time, $location, $supercategory;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validateDow');
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM TIME_AND_PLACE');
        $query->execute();
        
        $rows = $query->fetchAll();
        $times_and_places = array();
        
        foreach($rows as $row){
            $times_and_places[] = new Time_And_Place(array(
                'id' => $row['id'],
                'dow' => $row['dow'],
                'tp_date' => $row['tp_date'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'location' => $row['location'],
                'supercategory' => $row['supercategory']
            ));
        }
        
        return $times_and_places;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM TIME_AND_PLACE WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $time_and_place = new Time_And_Place(array(
                'id' => $row['id'],
                'dow' => $row['dow'],
                'tp_date' => $row['tp_date'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'location' => $row['location'],
                'supercategory' => $row['supercategory']
            ));
            
            return $time_and_place;
        }
        
        return null;
    }
    
    public function delete(){
        $query = DB::connection()->prepare('DELETE FROM TIME_AND_PLACE WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE TIME_AND_PLACE SET dow = :dow, tp_date = :tp_date, start_time = :start_time, end_time = :end_time, location = :location WHERE id = :id');
        $query->execute(array(
            'dow' => $this->dow,
            'tp_date' => $this->tp_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
            'id' => $this->id
        ));
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO TIME_AND_PLACE (dow, tp_date, start_time, end_time, location, supercategory) VALUES (:dow, :tp_date, :start_time, :end_time, :location, :supercategory) RETURNING id');
        $query->execute(array(
            'dow' => $this->dow,
            'tp_date' => $this->tp_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
            'supercategory' => $this->supercategory
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function validateDow(){
        $errors = array();
        //If day of the week is specified, it should be between two - ma, ti, etc - to eleven - keskiviikko - characters long.
        if($this->dow != '' && $this->dow != null){
            $errors = $this->validate_string_length($this->dow, 2, 11, 'Viikonpäivän');
        }
        return $errors;
    }
    
}