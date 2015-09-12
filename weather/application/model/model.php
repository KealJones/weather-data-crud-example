<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        }
        catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    /**
     * Checks if the "weather" table exists
     */
    public function checkTable(){
        $sql = "SELECT name FROM sqlite_master WHERE type='table'";
        $result = $this->db->query($sql);
        $i = 0;
        $row = array();
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            
            if (!isset($res['name']))
                continue;
            
            $row[$i]     = $res['name'];
            
            $i++;
            
        }
        return (in_array("weather",$row));
    }
    
    
    /**
     * Get all Days from database
     */
    public function getAllDays()
    {
        $sql    = "SELECT Day, MxT, MnT, AvT FROM weather";
        $query  = $this->db->prepare($sql);
        $result = $query->execute();
        
        // Replaced with SQLITE3 syntax
        $row = array();
        
        $i = 0;
        
        //Itterate through all day arrays to create one array for return
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            
            if (!isset($res['Day']))
                continue;
            
            $row[$i]['Day']     = $res['Day'];
            $row[$i]['MxT'] = $res['MxT'];
            $row[$i]['MnT']  = $res['MnT'];
            $row[$i]['AvT']   = $res['AvT'];
            
            $i++;
            
        }
        
        return $row;
    }
    
    /**
     * Add a Day to database
     */
    public function addDay($Day, $MxT, $MnT, $AvT)
    {
        
        $sql   = "INSERT OR REPLACE INTO weather (Day, MxT, MnT, AvT) VALUES (:Day, :MxT, :MnT, :AvT)"; //Add Or Replace existing Data
        $query = $this->db->prepare($sql);
        $query->bindValue(':Day', $Day, SQLITE3_INTEGER);
        $query->bindValue(':MxT', $MxT, SQLITE3_INTEGER);
        $query->bindValue(':MnT', $MnT, SQLITE3_INTEGER);
        $query->bindValue(':AvT', $AvT, SQLITE3_INTEGER);
        
        $result = $query->execute();
    }
    
    /**
     * Delete a Day in the database
     */
    public function deleteDay($Day_id)
    {
        $sql   = "DELETE FROM weather WHERE Day = :Day_id";
        $query = $this->db->prepare($sql);
        $query->bindValue(':Day_id', $Day_id, SQLITE3_INTEGER);
        $query->execute();
    }
    
    /**
     * Get today from database
     */
    public function getCurrentDay(){
        return $this->getDay(date('j'));
    }
    
    /**
     * Get any day from database
     */
    public function getDay($Day_id)
    {
        
        $sql   = "SELECT Day, MxT, MnT, AvT FROM weather WHERE Day = :Day_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->bindValue(':Day_id', $Day_id, SQLITE3_INTEGER);
        $result = $query->execute();
        
        return $result->fetchArray();
    }
    
    /**
     * Update a Day in database
     */
    public function updateDay($MxT, $MnT, $AvT, $Day_id)
    {
        $sql   = "UPDATE weather SET MxT = :MxT, MnT= :MnT, AvT= :AvT WHERE Day = :Day_id";
        $query = $this->db->prepare($sql);
        $query->bindValue(':MxT', $MxT, SQLITE3_INTEGER);
        $query->bindValue(':MnT', $MnT, SQLITE3_INTEGER);
        $query->bindValue(':AvT', $AvT, SQLITE3_INTEGER);
        $query->bindValue(':Day_id', $Day_id, SQLITE3_INTEGER);
        $query->execute();
    }
    
    /**
     * Get numer of days in database
     */
    public function getAmountOfDays()
    {
        $sql        = "SELECT COUNT(Day) AS amount_of_days FROM weather";
        $query      = $this->db->prepare($sql);
        $result     = $query->execute();
        $resultline = $result->fetchArray();
        $amount     = $resultline['amount_of_days'];
        // fetch() is the PDO method that get exactly one result
        return $amount;
    }
    
    /**
     * Uploads New File, Drops Old "weather" Table, 
     * Converts the File to an Array while checking for issues,
     * Converts that array into SQLITE statements.
     */
    public function processNewDataset($file)
    {
        $fileName = $this->uploadFile($file);
        echo "<p>Uploaded $fileName</p>";
        $this->dropTable();
        $fileArray = $this->fileToArray($fileName);
        echo "<p>Uploaded $fileName</p>";
        $this->uploadedArrayToDB($fileArray);
        echo "<p>Complete!</p><br><a class='pure-button pure-button-primary' href='".URL_WITH_INDEX_FILE."list/'>View List</a>";
    }
    
    /**
     * Uploads a file to main directory
     */
    public function uploadFile($file)
    {
        define("UPLOAD_DIR", "");
        
        if (!empty($file)) {
            $myFile = $file;
            
            if ($myFile["error"] !== UPLOAD_ERR_OK) {
                echo "<p>An error occurred.</p>";
                exit;
            }
            
            // ensure a safe filename
            $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
            
            // don't overwrite an existing file
            $i     = 0;
            $parts = pathinfo($name);
            while (file_exists(UPLOAD_DIR . $name)) {
                $i++;
                $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
            }
            
            // preserve file from temporary directory
            $success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name); // Move to root directory temporarily.
            if (!$success) {
                echo "<p>Unable to save file.</p>";
                exit;
            }
            
            // set proper permissions on the new file
            chmod(UPLOAD_DIR . $name, 0644);
            return $name;
        }
    }
    
    public function dropTable()
    {
        $query = 'DROP TABLE IF EXISTS weather';
        $this->db->exec($query) or die('Drop db failed');
    }
    
    public function uploadedArrayToDB($uploadedArray)
    {
        
        /**
         * Drop Existing Table then Create New
         **/
        $query = <<<EOD
  CREATE TABLE IF NOT EXISTS weather (
  Day INTEGER PRIMARY KEY,
  MxT INTEGER,
  MnT INTEGER,
  AvT INTEGER
)
EOD;
        $this->db->exec($query) or die('Create db failed');
        
        foreach ($uploadedArray as $dayKey => $dayValue) {
            $sql   = "INSERT INTO weather (Day, MxT, MnT, AvT) VALUES (:Day, :MxT, :MnT, :AvT)";
            $query = $this->db->prepare($sql);
            $query->bindValue(':Day', $dayValue['Day'], SQLITE3_INTEGER);
            $query->bindValue(':MxT', $dayValue['MxT'], SQLITE3_INTEGER);
            $query->bindValue(':MnT', $dayValue['MnT'], SQLITE3_INTEGER);
            $query->bindValue(':AvT', $dayValue['AvT'], SQLITE3_INTEGER);
            
            $result = $query->execute();
            //print_r($result);
        }
    }
    
    public function fileToArray($file, $args = array())
    {
        //key => default
        $fields          = array(
            'header_row' => true,
            'remove_header_row' => true,
            'trim_headers' => true, //trim whitespace around header row values
            'trim_values' => true, //trim whitespace around all non-header row values
            'debug' => true, //set to true while testing if you run into troubles
            'lb' => "\n", //line break character
            'delimiter' => "    " //delimiter character
        );
        $expectedHeaders = array(
            "Day",
            "MxT",
            "MnT",
            "AvT"
        );
        
        foreach ($fields as $key => $default) {
            if (array_key_exists($key, $args)) {
                $$key = $args[$key];
            } else {
                $$key = $default;
            }
        }
        
        if (!file_exists($file)) {
            if ($debug) {
                $error = 'File does not exist: ' . htmlspecialchars($file) . '.';
            } else {
                $error = 'File does not exist.';
            }
            die($error);
        }
        
        if ($debug) {
            echo '<p>Opening ' . htmlspecialchars($file) . '&hellip;</p>';
        }
        $data = array();
        
        if (($handle = fopen($file, 'r')) !== false) {
            $contents = fread($handle, filesize($file));
            fclose($handle);
        } else {
            die('There was an error opening the file.');
        }
        
        $lines = explode($lb, $contents);
        if ($debug) {
            echo '<p>Reading ' . count($lines) . ' lines&hellip;</p>';
        }
        
        $row = 0;
        foreach ($lines as $line) {
            $row++;
            if (($header_row) && ($row == 1)) {
                $data['headers'] = array();
            } else {
                $data[$row] = array();
            }
            $values = explode($delimiter, $line);
            
            foreach ($values as $c => $value) {
                if (($header_row) && ($row == 1)) { //if this is part of the header row
                    if (in_array($value, $data['headers'])) {
                        die('There are duplicate values in the header row: ' . htmlspecialchars($value) . '.');
                    } else {
                        if ($trim_headers) {
                            $value = trim($value);
                        }
                        $data['headers'][$c] = $value . ''; //the .'' makes sure it's a string
                    }
                } elseif ($header_row) { //if this isn't part of the header row, but there is a header row
                    if (count($values) == count($data['headers'])) {
                        $key = $data['headers'][$c];
                        if ($trim_values) {
                            $value = trim($value);
                        }
                        if (!empty($value)) {
                            $data[$row][$key] = $value;
                        }
                    } else {
                        unset($data[$row]);
                        echo "<p>Line " . $row . " doesnt match header length. Line Omitted.</p>";
                    }
                } else { //if there's not a header row at all
                    $data[$row][$c] = $value;
                }
                
            }
            
        }
        
        //Verify Header Data Integrity
        if ($data['headers'] != $expectedHeaders) {
            die("Headers Dont Match!");
        } else {
            echo "Headers Good";
        }
        
        if ($remove_header_row) {
            unset($data['headers']);
        }
        
        unlink($file); //Remove the File, No need for it after collecting all data.
        
        if ($debug) {
           // echo '<pre>' . print_r($data, true) . '</pre>';
        } //Could make prettier for users.
        
        return $data;
    }
    
    
}
