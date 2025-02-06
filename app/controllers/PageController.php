<?php

namespace dwes\app\controllers;

use dwes\core\App;
use dwes\core\Response;

class PageController{

    public function index(){
        Response::renderView('index')(
            'index',
            'layout'
        );
    }
    public function galeria_edit(){
        Response::renderView('galeria_edit')(
            'galeria_edit',
            'layout'
        );
    }
    public function galeria(){
        Response::renderView('galeria')(
            'galeria',
            'layout'
        );
    }
    
}