<?php
class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }

class Admin extends Config
{
    public $prefix;
    public $member_name;
    public $member_surname;
    public $tel;
    public $email;
    public $address;
    public $username;
    public $password;

    

    public function user_insert(){ 
        $check ="SELECT*FROM member WHERE member_username = '$this->username' ";
        $sqlcheck =mysqli_query($this->conn , $check);
        if(mysqli_num_rows($sqlcheck)>0){
                 echo "<script>";
                echo "alert('This Username adn Password are already taken.');" ;
                echo "window.location.href='register.php';";
                echo "</script>";
        
        
        }else{
              $query = "INSERT INTO member 
              (prefix_id, member_name, member_surname, member_tel, member_email, address, member_username, 	member_password) 
              VALUE (
                  '$this->prefix', 
                  '$this->member_name', 
                  '$this->member_surname', 
                  '$this->tel', 
                  '$this->email', 
                  '$this->address', 
                  '$this->username', 
                  '$this->password'
                  ) ";
              $sql =mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
              if($sql){
               
                echo "<script>";
                echo "alert('Complte Register :-{ )');" ;
                echo "window.location.href='login.php';";
                echo "</script>";
               
                }else{  
                echo "Somting went wrong so sorry !";    
                }
            }
    // public function showuser(){
    //     include "config/config.php";
    //     $sql ="SELECT * FROM member WHERE member_id = $this->member_id";
    //     $result =mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //     $row = $result->fetch_array();
}
// end puction user_insert 
        public function login(){
          //query 
            $sql="SELECT * FROM admin WHERE admin_username='".$this->username."' and admin_password='".$this->password."' ";
            $result = mysqli_query($this->conn,$sql) or die(mysqli_error($this->conn));
            
if (mysqli_num_rows($result)==1) {
    $value = mysqli_fetch_array($result);
     $_SESSION['admin_id'] = $value['admin_id'];
    echo "<script>";
    echo "alert('WELCOME ;-)');" ;
    echo "window.location.href='admin_home.php';";
    echo "</script>";
            }else{
                  echo "<script>";
                  echo "alert(\" Try Again !\");"; 
                  echo "window.history.back()";
              echo "</script>";
            }
        }
}

?>