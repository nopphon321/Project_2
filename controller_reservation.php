<?php 


class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }
 class cancel_booking extends Config
 {
     public $reservation_id;
     public function delete()
     {
        $sql = "DELETE FROM rooms WHERE  room_id = $this->room_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
         if ($query) {
            echo "<script>";
            echo "alert('เพิ่มโปรโมชั่นเสร็จ สิ้นไปออก CODE กันเร็ว');" ;
            echo "window.location.href='admin_promotion.php';";
            echo "</script>";
         } else {
             echo "<script>";
             echo "alert('ไม่สามารถเพิ่มโปรโมชั่น มีบางอย่างผิดพลาด');" ;
             echo "window.location.href='admin_promotion.php';";
             echo "</script>";
         }
     }
 }

?>