<?php 
class database{
	private $host="localhost";
	private $username="sairauma_madina_clubroad_root";
	private $password='yKk8JndNATab';
	private $database="sairauma_sairauma_madina_clubroad";
	protected $conn;
	    
    public function __construct()
    {
        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
             mysqli_query( $this->conn , "SET SESSION sql_mode = ''");
           
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
        return $this->conn;
    }
}
?>