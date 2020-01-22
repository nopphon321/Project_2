<?php 


class Config  {
    public $conn;
     public function __construct()
     {
        require 'config/config.php' ;
        $this->conn =$conn;
     }

 }
 class Promotion extends Config
 {
     public $promotion;
     public $cpromotion;
     public function checkpromotion()
     {
         $sql = "SELECT*FROM promotion_detail WHERE promotion_code= $this->promotion AND promotion_status = '1'";
         $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
         if (mysqli_num_rows($query)==0) {
            return $this->cpromotion;
         }else{
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $this->cpromotion=$row['promotion_detail_id'];
            }
            return $this->cpromotion;

         }
     }
 }
 class Pay extends Config  {
     public $book_id;
     public $bank;
     public $pay_date;
     public $member_id;
     public $money;
     public $promotion_id;
     public $imgname;
     public function insert()
     {     
    $sql = "INSERT INTO pay_ment (booking_room_id, bank_id, member_id, pay_ment_date, pay_ment_money , slipe_payment, promotion_id, 	pay_ment_status ) 
    VALUE ('$this->book_id', '$this->bank', '$this->member_id', '$this->pay_date', '$this->money', '$this->imgname'  ,'$this->promotion_id' ,'1') ";
    $query =mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn)); 
    if ($this->promotion_id!=0) {
        $this->updatepromotion();
    }
    $this->updatebooking();
    echo "<script>";
    echo "alert('complete paying!');" ;
    echo "window.location.href='payment.php';";
    echo "</script>";

     }

     private function updatepromotion(){
        $sql = "UPDATE promotion_detail SET promotion_status = '0' WHERE promotion_detail_id =$this->promotion_id";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        
     }
     private function updatebooking(){
        $sql = "UPDATE booking_room SET booking_status = '2' WHERE booking_room_id =$this->book_id";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        
     }

 }

 class Cancel_book extends Config {
    public $book_id;
    public $member_id;
    public $bc_reason;
    public $date;
    public function reason(){
        $sql = "INSERT INTO book_cancel (member_id, booking_room_id, bc_reason ,bc_date ) 
        VALUE ('$this->member_id', '$this->book_id', '$this->bc_reason', '$this->date') ";
        $query =mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn)); 
        if($query){
            $this->cancel();
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถยกเลิก');" ;
            echo "window.location.href='payment.php';";
            echo "</script>";
        }
    }
    private function cancel(){
        $sql = "UPDATE booking_room SET booking_status = '0' WHERE booking_room_id =$this->book_id";
        $query = $this->conn->query($sql) or die("Last error: {$this->conn->error}");
        if($query){
            echo "<script>";
            echo "alert('cancel  !');" ;
            echo "window.location.href='payment.php';";
            echo "</script>";
        }
    }

 }


?>