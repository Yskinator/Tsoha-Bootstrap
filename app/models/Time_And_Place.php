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
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO TIME_AND_PLACE (dow, tp_date, start_time, end_time, location, supercategory) VALUES (:dow, tp_date, start_time, end_time, location, supercategory)');
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
}