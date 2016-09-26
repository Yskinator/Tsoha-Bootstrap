<?php

  class HelloWorldController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
        //echo 'Hello World!';
    }
        
    public static function sandbox(){
        // Testaa koodiasi täällä
        //echo 'Hello World!';
        //View::make('helloworld.html');
        
        $ti = Time_And_Place::find(1);
        $times_and_places = Time_And_Place::all();
        
        Kint::dump($times_and_places);
        Kint::dump($ti);
    }
    public static function checklistplan(){
        View::make('suunnitelmat/checklist.html');
    }
  }
