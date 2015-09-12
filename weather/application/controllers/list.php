<?php
/**
 * Class Days
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class days extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to show/index
     */
    public function index()
    {
        // getting all Days and amount of Days
        $days = $this->model->getAllDays();
        $amount_of_days = $this->model->getAmountOfDays();

       // load views. within the views we can echo out $Days and $amount_of_Days easily
        require APP . 'views/_templates/header.php';
        require APP . 'views/list/index.php';
        require APP . 'views/_templates/footer.php';
    }

    /**
     * ACTION: addDay
     * This method handles what happens when you move to http://yourproject/Days/addDay
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a Day" form on Days/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to Days/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addDay()
    {
        // if we have POST data to create a new Day entry
        if (isset($_POST["submit_add_day"])) {
            // do addDay() in model/model.php
            $this->model->addDay($_POST["Day"], $_POST["MxT"],  $_POST["MnT"],  $_POST["AvT"]);
        }

        // where to go after Day has been added
        header('location: ' . URL_WITH_INDEX_FILE . 'list/index');
    }

    /**
     * ACTION: deleteDay
     * This method handles what happens when you move to http://yourproject/Days/deleteDay
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a Day" button on Days/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to Days/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $Day_id Id of the to-delete Day
     */
    public function deleteDay($Day_id)
    {
        // if we have an id of a Day that should be deleted
        if (isset($Day_id)) {
            // do deleteDay() in model/model.php
            $this->model->deleteDay($Day_id);
        }

        // where to go after Day has been deleted
        header('location: ' . URL_WITH_INDEX_FILE . 'list/index');
    }

     /**
     * ACTION: editDay
     * This method handles what happens when you move to http://yourproject/Days/editDay
     * @param int $Day_id Id of the to-edit Day
     */
    public function editDay($Day_id)
    {
        // if we have an id of a Day that should be edited
        if (isset($Day_id)) {
            // do getDay() in model/model.php
            $day = $this->model->getDay($Day_id);

            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $Day easily
            require APP . 'views/_templates/header.php';
            require APP . 'views/list/edit.php';
            require APP . 'views/_templates/footer.php';
        } else {
            // redirect user to list index page (as we don't have a Day_id)
            header('location: ' . URL_WITH_INDEX_FILE . 'list/index');
        }
    }
    
    /**
     * ACTION: updateDay
     * This method handles what happens when you move to http://yourproject/Days/updateDay
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a Day" form on Days/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to Days/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateDay()
    {
        // if we have POST data to create a new Day entry
        if (isset($_POST["submit_update_day"])) {
            // do updateDay() from model/model.php
            $this->model->updateDay($_POST["MxT"],  $_POST["MnT"], $_POST["AvT"], $_POST['Day_id']);
        }

        // where to go after Day has been added
        header('location: ' . URL_WITH_INDEX_FILE . 'list/index');
    }
    
    public function getAllDaysAsJson(){
        print_r(json_encode($this->model->getAllDays()));
    }
    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $amount_of_Days = $this->model->getAmountOfDays();

        // simply echo out something. A super-simple API would be possible by echoing JSON here
        echo $amount_of_Days;
    }

}
