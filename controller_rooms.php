<?php


class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }

    class Post
    {
        public $bkin;
        public $bkout;
        public $q;
        public $row;
        public $conn;
        public $kw;
        public $result;
        public $room_id;
        public $member_id;
        public $room_price;
        public $bookin;
        public $bookout;
        public $people;
        public $query;
    }
    class Rooms extends Post{
        public function booking_room()
        {
            require 'config/config.php' ;
            $nowdate=date("Y-m-d");
            $sql = "INSERT INTO booking_room (member_id, booking_date , total_price, people, booking_status) 
            VALUE ('$this->member_id', '$nowdate' , '$this->room_price', '$this->people' , '1') ";
            $this->query = $conn->query($sql) or die("Last error: {$conn->error}");
            $last_id = mysqli_insert_id($conn);
            $this->booking_room_last_id($last_id);
            return $last_id;

        }

        private function booking_room_last_id($last_id)
        {
            require 'config/config.php' ;
                $sql = "INSERT INTO booking_room_des (booking_room_id, room_id, book_in_date , book_out_date, total_room_price , booking_des_status) 
                VALUE ('$last_id', '$this->room_id', '$this->bookin' , '$this->bookout' ,'$this->room_price' , '1') ";
                $this->query = $conn->query($sql) or die("Last error: {$conn->error}");
           
        }
        
    }

    class Book_des extends Post
 {

     public function booking_room_des()
     {
       
         require 'config/config.php' ;
         $sql = "INSERT INTO booking_room_des (booking_room_id, room_id, book_in_date , book_out_date, total_room_price , booking_des_status) 
            VALUE ('$this->last_id', '$this->room_id', '$this->bookin' , '$this->bookout' ,'$this->room_price' , '1') ";
         $this->query = $conn->query($sql) or die("Last error: {$conn->error}");
         return $this->last_id;
     }
 }
 class Cancel_book extends Post
 {
     public $cancel;
     public $rmid;
     public $sqlcheck;

        public function delete()
        {
            require 'config/config.php' ;
            $sql = "DELETE FROM booking_room_des WHERE  booking_room_id = $this->cancel AND room_id = $this->rmid ";
            $this->query = $conn->query($sql) or die("Last error: {$conn->error}");

            $check ="SELECT*FROM booking_room_des WHERE booking_room_id = $this->cancel ";
            $this->sqlcheck =$conn->query($check) or die("Last error: {$conn->error}");

            if (mysqli_num_rows($this->sqlcheck)==0) {
                $sql = "DELETE FROM booking_room WHERE  booking_room_id = $this->cancel";
               $this->query = $conn->query($sql) or die("Last error: {$conn->error}");
               if ($this->query) {
                   echo "<script>";
                   echo "alert('So Sorry plese booking againn !');" ;
                   echo "window.location.href='home.php';";
                   echo "</script>";
               }
            }
            return $this->cancel;
        }
 }
 class Complete extends Post
 {
    public $bookid;
    public $sumprice;
    public function complete()
    {
        require 'config/config.php' ;
        $sql = "UPDATE booking_room SET total_price = '$this->sumprice' WHERE booking_room_id = '$this->bookid'";
        ;
        $this->query = $conn->query($sql) or die("Last error: {$conn->error}");
        if($this->query){
            echo "<script language=\"JavaScript\">";
            echo "alert('reservation complete please pay Your booking after you booking 5 day');";
            echo "location='home.php' ";
            echo "</script>"; 
        }
    }
 }
   
 class Roomtype extends Config {
     public $room_type;
     public $room_type_detail;
     public $room_type_id;
     public $price;
     public $image;
     public function Edit(){
        $sql = "UPDATE roomtype SET room_type = '$this->room_type' , room_type_detail = '$this->room_type_detail' , price = '$this->price' , image = '$this->image' WHERE room_type_id = '$this->room_type_id'";
     $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
     if($query){
        echo "<script>";
        echo "alert('แก้ไขเสร็จสิ้น');" ;
        echo "window.location.href='admin_roomtype.php';";
        echo "</script>";
     }else{
        echo "<script>";
        echo "alert('ไม่สมารถบันทึกได้คับ');" ;
        echo "window.location.href='admin_roomtype.php';";
        echo "</script>";
     }

     }
     public function delete(){
        $sql = "DELETE FROM roomtype WHERE  room_type_id = $this->room_type_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if($query){
            echo "<script>";
            echo "alert('ลบแล้ว');" ;
            echo "window.location.href='admin_roomtype.php';";
            echo "</script>";
         }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้');" ;
            echo "window.location.href='admin_roomtype.php';";
            echo "</script>";
         }
    

     }
     public function Insert(){
        $sql = "INSERT INTO roomtype (room_type, price, image, room_type_detail) 
        VALUE ('$this->room_type', '$this->price', '$this->image', '$this->room_type_detail') ";
     $this->query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
     if($sql){
        echo "<script>";
        echo "alert('เพิ่มเสร็จ');" ;
        echo "window.location.href='admin_roomtype.php';";
        echo "</script>";
     }else{
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มได้');" ;
        echo "window.location.href='admin_roomtype.php';";
        echo "</script>";
     }

     }
 }
 class Room extends Config{
     public $room_type_id;
     public $room_id;
     public $room_price;
     public $room_detail;
     public $room_image;
     public function Insert(){
        $sql = "INSERT INTO rooms (room_id, room_type_id, room_detail, room_image, room_price ) 
        VALUE ('$this->room_id', '$this->room_type_id', '$this->room_detail', '$this->room_image', '$this->room_price') ";
     $this->query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
     if($sql){
        echo "<script>";
        echo "alert('เพิ่มเสร็จ');" ;
        echo "window.location.href='admin_rooms.php';";
        echo "</script>";
     }else{
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มได้');" ;
        echo "window.location.href='admin_rooms.php';";
        echo "</script>";
     }
     }

     public function Edit(){
        $sql = "UPDATE rooms SET room_type_id = '$this->room_type_id',room_image = '$this->room_image' , room_detail ='$this->room_detail' , room_price ='$this->room_price' WHERE room_id = '$this->room_id'";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if($sql){
            echo "<script>";
            echo "alert('แก้ไขเสร็จสิ้น');" ;
            echo "window.location.href='admin_rooms.php';";
            echo "</script>";
         }else{
            echo "<script>";
            echo "alert('ไม่สามารถแก้ไขได้');" ;
            echo "window.location.href='admin_rooms.php';";
            echo "</script>";
         }

     }
     public function Delete(){
        $sql = "DELETE FROM rooms WHERE  room_id = $this->room_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if($sql){
            echo "<script>";
            echo "alert('ลบแล้ว');" ;
            echo "window.location.href='admin_rooms.php';";
            echo "</script>";
         }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้ได้');" ;
            echo "window.location.href='admin_rooms.php';";
            echo "</script>";
         }
     }
 }


?>