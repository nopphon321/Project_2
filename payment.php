<style>
      .status1 {
        color: #f1f1f1;
        background: rgb(255, 6, 6);
      }
        .status2 {
        color: #f1f1f1;
        background: rgb(248, 150, 4);
      }
      .status3 {
        color: #f1f1f1;
        background: rgb(11, 182, 68);
      }
      .status4 {
        color: #f1f1f1;
        background: rgb(11, 182, 68);
      }
      .status0 {
        color: #f1f1f1;
        background: #000000;
      }
      </style>
<?php 
error_reporting(0);
session_start();

if(isset($_POST['cancel_book'])=='cancel_book'){
  require 'controller_pay_pro.php';
  $nowdate=date("Y-m-d"); 
  $cancel = new Cancel_book;
  $cancel->book_id =$_POST['booking_room_id'];
  $cancel->member_id =$_POST['member_id'];
  $cancel->bc_reason =$_POST['reason'];
  $cancel->date =$nowdate;
  $book_status = $cancel->reason(); 
}


require 'config/config.php';

if (!$_SESSION['member_id']) {
        header("Location: login.php");
} else {
    $member_id=$_SESSION['member_id'];
    $sql2="SELECT * FROM member WHERE member.member_id='$member_id'";
    $result2 = $conn->query($sql2);
    $bookstatus = array("cancel", "Not paid",  "Checking", "approve", "Stay");
    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
        include "public/header.php"
        
?>


  <!-- ##### About Us Area Start ##### -->
  <section class="about-us-area mt-5 pt-5">
        <div class="container">
            <div class="row align-items-center mt-5 pt-5 pb-5 mb-5">
        <h1 class="text-center">Pay</h1>
            <table class="table table-responsive-md pt-5">
<thead class="text-center">
    <tr>
      <th>List</th>
      <th>Book Date</th>
      <th>SumPrice</th>
      <th>Status</th>
      <?php if($status!=0){?>
      <th>CancelBook</th>
      <th>Pay/print</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody class="text-center">
  <?php 
  $list = 1;
        $sql="SELECT * FROM booking_room INNER JOIN member ON booking_room.member_id = member.member_id
       
         WHERE booking_room.member_id = $member_id ORDER BY booking_room_id ASC ";

        $result=$conn->query($sql);

        while($row= $result->fetch_array(MYSQLI_ASSOC)){
          $booking_room_id = $row['booking_room_id'];
          $status =$row['booking_status'];
        ?>
    <tr>
<td><?php echo $list ;?></td>
    <td><?php   echo date_format(date_create($row['booking_date']), "d/m/Y"); ?></td>
    <td><?php echo number_format( $row['total_price'],2); ?></td>
    <td><p class=" btn status<?php echo $row['booking_status']; ?>"><?php echo $bookstatus[$row['booking_status']]; ?></p></td>
    <?php if($status!=0){?>



      
    <td>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">cancel</button>
                        <!-- popup -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel"> reason </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="payment.php" method="POST">
          <div class="form-group">
            <label for="message-text" class="col-form-label">reason</label>
            <textarea name="reason" class="form-control" id="message-text"></textarea>
            <input type="hidden" name="booking_room_id" value="<?php echo $booking_room_id; ?>">
            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" onclick="return confirm('ยืนยันการยกเลิกอีกครั้ง อีกครั้ง')" name="cancel_book" value="cancel_book" class="btn btn-primary">Send</button>
      </div>
      </form>

    </div>
  </div>
</div>
    <!-- popup -->

    </td>

    <?php 
    if($status < 2){?>

    <td><form action="form_pay.php" method="POST">
                    <input type="hidden" name="book_id"  value="<?php echo $booking_room_id; ?>">
                    <input type="hidden" name="price"  value="<?php echo $row['total_price']; ?>">
                    <button type="submit" name="pay" value="pay" class="btn btn-info">Pay</button>
                </form></td>
    </tr>
    <?php }else{ ?>
      <td><form action="print.php" method="POST">
                    <input type="hidden" name="book_id"  value="<?php echo $booking_room_id; ?>">
                    <input type="hidden" name="price"  value="<?php echo $row['total_price']; ?>">
                    <button type="submit" name="pay" value="pay" class="btn btn-warning">Print</button>
                </form></td>
    <?php } ?>
    <?php } ?>
        <?php $list++; } ?>
    </tbody>
</table>

                </div>
            </div>
        </div>
    </section>
    <!-- ##### About Us Area End ##### -->

<?php  include "public/footer.php"?>
    <?php
    }
} ?>