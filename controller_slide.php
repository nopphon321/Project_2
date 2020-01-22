<?php


class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }

   
 class Slide extends Config {
     public $slide_id;
     public $title;
     public $title_detail;
     public $slide_image;
     public function Edit(){
        $sql = "UPDATE slide SET title = '$this->title' , slide_image = '$this->slide_image' , title_detail = '$this->title_detail' WHERE slide_id = '$this->slide_id'";
     $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
     if($query){
        echo "<script>";
        echo "alert('แก้ไขเสร็จสิ้น');" ;
        echo "window.location.href='admin_slide.php';";
        echo "</script>";
     }else{
        echo "<script>";
        echo "alert('ไม่สมารถบันทึกได้คับ');" ;
        echo "window.location.href='admin_slide.php';";
        echo "</script>";
     }

     }
     public function Delete(){
        $sql = "DELETE FROM slide WHERE  slide_id = $this->slide_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if($query){
            echo "<script>";
            echo "alert('ลบแล้ว');" ;
            echo "window.location.href='admin_slide.php';";
            echo "</script>";
         }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้');" ;
            echo "window.location.href='admin_slide.php';";
            echo "</script>";
         }
    

     }
     public function Insert(){
        $sql = "INSERT INTO slide (title, title_detail,slide_image) 
        VALUE ('$this->title', '$this->title_detail', '$this->slide_image') ";
     $this->query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
     if($sql){
        echo "<script>";
        echo "alert('เพิ่มเสร็จ');" ;
        echo "window.location.href='admin_slide.php';";
        echo "</script>";
     }else{
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มได้');" ;
        echo "window.location.href='admin_slide.php';";
        echo "</script>";
     }

     }
 }


?>