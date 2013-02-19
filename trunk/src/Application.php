<?php

/**
 * 
 * Proyect Name: mini-linker-core
 * Linkerweb Corporation.
 * 
 * description: framework sencillo para la creacion de sitios pequeños pero bien
 *               estructurados y con buenas practicas
 *  
 * Apache License.
 * 
 * @author Uriel isai Rodriguez rivas <isairivas@gmail.com>
 * 
*/

class Application {
    
    protected $displayError = '-1';
    protected $request = array();
    protected $defaultController = 'Index';
    protected $defaultAction = 'index';
    protected $env = 'controllers';
    

    public function __construct() {
        $this->env = 'test';
        error_reporting($this->displayError);
        $this->request = array(
            'controller' => 'Index',
            'action'     => 'index'
        );
        
        $this->initConstantes();
        $this->initIncludes();
    }
    
    public function run(){
        $this->readRequest();
        $this->rooter();
    }
    
    private function rooter(){
        
        $controller = $this->defaultController;
        $action = $this->defaultAction;
        if(file_exists(PATH_SRC.$this->env.'/'.$this->request['controller'].'.php')){
            $controller = $this->request['controller'];
        }
        require_once PATH_SRC . $this->env. '/'.$controller.'.php';
        $object = new $controller();
        $object->$action();
    }
    
    private function initIncludes(){
        include_once 'autoload.php';
    }
    public function readRequest(){
        
        if(isset($_GET['section'])){
            $this->request['controller'] = ucfirst($_GET['section']);
        }
        if(isset($_GET['action'])){
            $this->request['action'] = $_GET['action'];
        }
    }
    
    private function initConstantes(){
        $sourcePath = dirname(__FILE__);
        $appPath = $sourcePath.'/..';
        define('PATH_APP',$appPath.'/');
        define('PATH_SRC',$sourcePath.'/');
        define('PATH_CONFIG',$appPath.'/configs/');
    }
}

