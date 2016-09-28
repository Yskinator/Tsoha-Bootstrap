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
  

