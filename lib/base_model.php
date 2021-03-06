<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      $this->validators = array();
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }
    
    public function validate_string_exists($str, $strName){
        $errors = array();
        if($str == '' || $str == null){
            $errors[] = $strName.' ei saa olla tyhjä.';
        }
        return $errors;
    }
    
    public function validate_string_length($str, $strMin, $strMax, $strName){
        $errors = array();
        if(strlen($str) < $strMin){
            $errors[] = $strName.' pituuden täytyy olla vähintään '.$strMin.' merkkiä.';
        }
        if(strlen($str) > $strMax){
            $errors[] = $strName.' pituus saa olla enintään '.$strMax.' merkkiä.';
        }
        return $errors;
    }
    
    public function validateSupercategoryExists($id){
        $errors = array();
        $query = DB::connection()->prepare('SELECT id FROM CATEGORY WHERE id = :supercategory LIMIT 1');
            $query->execute(array('supercategory' => $id));
            $row = $query->fetch();
            
            if(!$row){
                $errors[] = 'Yläkategoriaa ei löytynyt tietokannasta.';
            }
        
        return $errors;
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        $errors = array_merge($errors, $this->{$validator}());
      }

      return $errors;
    }

  }
