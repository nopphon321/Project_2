<?php 


class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }
 class insert_promotion extends Config
 {
     public $promotion_name;
     public $promotion_detail;
     public $promotion_date;
     public function insert()
     {
         $sql = "INSERT INTO promotion (promotion_name, promotion_detail, promotion_date) 
           VALUE ('$this->promotion_name', '$this->promotion_detail', '$this->promotion_date') ";
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
 class Delete extends Config
 {
     public $promotion_id;
     public function delete_promotion(){
        $sql = "DELETE FROM promotion WHERE  promotion_id = $this->promotion_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
         if ($query) {
            echo "<script>";
            echo "alert('ลบเสร็จสิ้น');" ;
            echo "window.location.href='admin_promotion.php';";
            echo "</script>";
         } else {
             echo "<script>";
             echo "alert('ไม่สามารถลบโปรโมชั่น มีบางอย่างผิดพลาด');" ;
             echo "window.location.href='admin_promotion.php';";
             echo "</script>";
         }
     }
 }
 class update_promotion extends Config {
     public $promotion_id;
     public $promotion_name;
     public $promotion_detail;
     public function update()
     {
        $sql="UPDATE `promotion` SET promotion_name = '$this->promotion_name' , promotion_detail = '$this->promotion_detail' WHERE promotion_id = '$this->promotion_id'";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if ($query) {
            echo "<script>";
            echo "alert('แก้ไขเสร็จสิ้น');" ;
            echo "window.location.href='admin_promotion.php';";
            echo "</script>";
         } else {
             echo "<script>";
             echo "alert('ไม่่สามารถแก้ไขได้ มีบางอย่างผิดพลาด');" ;
             echo "window.location.href='admin_promotion.php';";
             echo "</script>";
         }
     }

 }
 class insert_pro_detail extends Config{
     public $promotion_id;
     public $promotion_code;
     public $discount;
     public function Insert_detail(){
        $sql = "INSERT INTO promotion_detail (promotion_id, promotion_code, discount, promotion_status) 
        VALUE ('$this->promotion_id', '$this->promotion_code', '$this->discount' , '1') ";
      $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
      if ($query) {
         echo "<script>";
         echo "alert('เสร็จสิ้น');" ;
         echo "window.location.href='admin_promotion_detail.php';";
         echo "</script>";
      } else {
          echo "<script>";
          echo "alert('ไม่สามารถเพิ่มได้');" ;
          echo "window.location.href='admin_promotion_detail.php';";
          echo "</script>";
      }

     }
 }
 class Detail_delete extends Config{
     public $prmotion_detail_id;
     public function delete(){
        $sql = "DELETE FROM promotion_detail WHERE  promotion_detail_id = $this->promotion_detail_id  ";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
         if ($query) {
            echo "<script>";
            echo "alert('ลบเสร็จสิ้น');" ;
            echo "window.location.href='admin_promotion_detail.php';";
            echo "</script>";
         } else {
             echo "<script>";
             echo "alert('ไม่สามารถลบโปรโมชั่น มีบางอย่างผิดพลาด');" ;
             echo "window.location.href='admin_promotion_detail.php';";
             echo "</script>";
         }

     }

 }
//  class Pay extends Config  {
//      public $book_id;
//      public $bank;
//      public $pay_date;
//      public $member_id;
//      public $money;
//      public $promotion_id;
//      public $imgname;
//      public function insert()
//      {     
//     $sql = "INSERT INTO pay_ment (booking_room_id, bank_id, member_id, pay_ment_date, pay_ment_money , slipe_payment, promotion_id, 	pay_ment_status ) 
//     VALUE ('$this->book_id', '$this->bank', '$this->member_id', '$this->pay_date', '$this->money', '$this->imgname'  ,'$this->promotion_id' ,'1') ";
//     $query =mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn)); 
//     if ($this->promotion_id!=0) {
//         $this->updatepromotion();
//     }
//     $this->updatebooking();
    // echo "<script>";
    // echo "alert('complete paying!');" ;
    // echo "window.location.href='payment.php';";
    // echo "</script>";

//      }

//      private function updatepromotion(){
//         $sql = "UPDATE promotion_detail SET promotion_status = '0' WHERE promotion_detail_id =$this->promotion_id";
//         $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        
//      }
//      private function updatebooking(){
//         $sql = "UPDATE booking_room SET booking_status = '2' WHERE booking_room_id =$this->book_id";
//         $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        
//      }

//  }

//  class Cancel_book extends Config {
//     public $book_id;
//     public $member_id;
//     public $bc_reason;
//     public $date;
//     public function reason(){
//         $sql = "INSERT INTO book_cancel (member_id, booking_room_id, bc_reason ,bc_date ) 
//         VALUE ('$this->member_id', '$this->book_id', '$this->bc_reason', '$this->date') ";
//         $query =mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn)); 
//         if($query){
//             $this->cancel();
//         }else{
//             echo "<script>";
//             echo "alert('ไม่สามารถยกเลิก');" ;
//             echo "window.location.href='payment.php';";
//             echo "</script>";
//         }
//     }
//     private function cancel(){
//         $sql = "UPDATE booking_room SET booking_status = '0' WHERE booking_room_id =$this->book_id";
//         $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
//         if($query){
//             echo "<script>";
//             echo "alert('cancel  !');" ;
//             echo "window.location.href='payment.php';";
//             echo "</script>";
//         }
//     }

//  }


?>