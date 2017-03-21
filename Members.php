<?php
class Member {
	private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "ovcaa";
    private $userTbl    = 'members';
	
	function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
	
	function checkMember($user_check = array()){
        if(!empty($user_check)){
            //Check whether Member data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE uid = '".$user_check['uid']."' AND uname = '".$user_check['uname']."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0){
                //Update Member data if already exists
                $query = "UPDATE ".$this->userTbl." SET uname = '".$user_check['uname']."', last_name = '".$user_check['last_name']."', email = '".$user_check['email']."', gender = '".$user_check['gender']."', locale = '".$user_check['locale']."', picture = '".$user_check['picture']."', link = '".$user_check['link']."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$user_check['oauth_provider']."' AND oauth_uid = '".$user_check['oauth_uid']."'";
                $update = $this->db->query($query);
            }else{
                //Insert Member data
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$user_check['oauth_provider']."', oauth_uid = '".$user_check['oauth_uid']."', uname = '".$user_check['uname']."', last_name = '".$user_check['last_name']."', email = '".$user_check['email']."', gender = '".$user_check['gender']."', locale = '".$user_check['locale']."', picture = '".$user_check['picture']."', link = '".$user_check['link']."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'";
                $insert = $this->db->query($query);
            }
            
            //Get Member data from the database
            $result = $this->db->query($prevQuery);
            $user_check = $result->fetch_assoc();

        }
        
        //Return Member data
        return $user_check;
    }
}
?>