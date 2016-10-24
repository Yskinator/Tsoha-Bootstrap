<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/checklistplan', function() {
    HelloWorldController::checklistplan();
  });
  
  $routes->post('/categories', function() {
      CategoryController::store();
  });
  
  $routes->get('/categories', function() {
      CategoryController::index();
  });
  
  $routes->post('/categories/update', function() {
      CategoryController::update();
  });
  
  $routes->post('/categories/delete', function() {
      CategoryController::delete();
  });
  
  $routes->post('/notes', function() {
      NoteController::store();
  });
  
  $routes->post('/notes/delete', function() {
      NoteController::delete();
  });

  $routes->post('/notes/update', function() {
      NoteController::update();
  });  
  
  $routes->post('/times_and_places', function() {
      Time_And_PlaceController::store();
  });
  
  $routes->post('/times_and_places/delete', function() {
      Time_And_PlaceController::delete();
  });
  
  $routes->post('/times_and_places/update', function() {
      Time_And_PlaceController::update();
  });
  
  $routes->post('/login', function() {
      UserController::handleLogin();
  });
  
  $routes->post('/logout', function() {
      UserController::logout();
  });
