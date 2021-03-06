<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class report extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        if(!$this->model->checkTable()){
            header('location: ' . URL_WITH_INDEX_FILE . 'upload/');
        } else {
            $days = $this->model->getAllDays();
            require APP . 'views/_templates/header.php';
            require APP . 'views/report/index.php';
            require APP . 'views/_templates/footer.php';
        }
    
    }

    
}
