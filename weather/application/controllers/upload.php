<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class upload extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/upload/index.php';
        require APP . 'views/_templates/footer.php';
    }

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function uploadFile()
    {
        require APP . 'views/_templates/header.php';
        // Uploads the file
        $this->model->processNewDataset($_FILES['weatherFile']);
        require APP . 'views/_templates/footer.php';
        
    }
    
    public function dropTable(){
        $this->model->dropTable();
    }
    
    public function checkTable(){
        echo "Checking...";
        $this->model->checkTable();
    }
    
    public function analyseUpload(){
        print_r($this->model->dsvToArray('weather.dat',"\t"));
    }

}
