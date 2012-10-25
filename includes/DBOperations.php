<?php
class DBOperations{    
    protected $connection;    
    public function open_database(){
        if(!$this->connection =mysql_connect(DB_SERVER, DB_USER, DB_PASS)){
            die("Database connection failed..." . mysql_error() . '<br/><a href="PhotoGallery.php">GO BACK</a>');
        }
        if(!$db = mysql_select_db(DB_NAME,$this->connection)){
            die("Database could not be opened..." . mysql_error() . '<br/><a href="PhotoGallery.php">GO BACK</a>');
        }
    }
    
    public function close_database(){
        if(!mysql_close($this->connection)){
            die("Connection failed to close..." . mysql_error() . '<br/><a href="PhotoGallery.php">GO BACK</a>');
        }
    }
}
?>
