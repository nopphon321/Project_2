
<?php

session_start();
require 'config/config.php';

if (!$_SESSION['admin_id']) {
        header("Location: admin_login.php");
} else {
    $admin_id=$_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE admin.admin_id='$admin_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>
<?php

//require 'books_config.php';
$stdate=(isset($_POST['stdate']))?$_POST['stdate']:date("Y-m-d");
        $endate=(isset($_POST['endate']))?$_POST['endate']:date("Y-m-d");
        $bookstatus = array("cancel", "Not paid",  "Checking", "approve", "Stay"); ?>
<?php include 'admin_framwork/header.php' ?>


    <div id="content-wrapper">
    <?php if (isset($_POST['print'])=='print') {
            $reservation_id = $_POST['reservation_id']; ?>
   <!-- Breadcrumbs-->
   <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="admin_home.php">Reservation</a>
          </li>
          <li class="breadcrumb-item active">print</li>
        </ol>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas "></i>


          <div class="card-body m-3 p-3">
           <h2 class="text-center">ใบเสร็จรับเงิน</h2>
           <div class="text-center">ใส่รายละเอียดที่อยู่คนเดียว</div>
           <table class="table mt-5 pt-5">
<thead class="text-center">
    <tr>
      <th>List</th>
      <th>Book Date</th>
      <th>SumPrice</th>
      <th>People</th>
      <th colspan="2">Detail</th>
    </tr>
  </thead>
  <tbody class="text-center">
  <?php
  $list = 1;
            $sql="SELECT * FROM booking_room 
       
         WHERE booking_room_id = $reservation_id ";

            $result=$conn->query($sql);

            while ($row= $result->fetch_array(MYSQLI_ASSOC)) {
                $booking_room_id = $row['booking_room_id']; ?>
    <tr>
<th><?php echo $list ; ?></th>
    <th><?php   echo date_format(date_create($row['booking_date']), "d/m/Y"); ?></th>
    <th><?php echo number_format($row['total_price'], 2); ?></th>
    <th><?php echo $row['people']; ?></th>


    <th colspan="2">
    <?php

    $sql2 = "SELECT booking_room_des.booking_room_id, booking_room_des.room_id
    ,roomtype.room_type ,rooms.room_price FROM booking_room_des INNER JOIN rooms ON booking_room_des.room_id = rooms.room_id INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id 
    WHERE booking_room_des.booking_room_id = $booking_room_id";
   
                $result2 = $conn->query($sql2);
                while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                    ?>
    
    Room No. --<?php echo $row2['room_id']; ?>--Roomtype-- 
     <?php echo $row2['room_type']; ?><br>
   <?php
                } ?>
    </th>
    </tr>

        <?php $list++;
            } ?>
    </tbody>
</table>
          </div>


        </div>
      </div>
      <!-- /.container-fluid -->
<?php
        } elseif(isset($_POST['check'])=='check') {?>
   <!-- Breadcrumbs-->
   <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="admin_home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Charts</li>
        </ol>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <div class="row">
          <div class="col-lg-8">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Bar Chart Example</div>
              <div class="card-body">
                <canvas id="myBarChart" width="100%" height="50"></canvas>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Pie Chart Example</div>
              <div class="card-body">
                <canvas id="myPieChart" width="100%" height="100"></canvas>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
          </div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More chart examples coming soon...</em>
        </p>

      </div>
      <!-- /.container-fluid -->

        <?php }else{ ?>
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">reservation</a>
          </li>
          <li class="breadcrumb-item active">Check Booking</li>
        </ol>

<!-- seach date -->
<div class="card mb-3">
          <div class="card-header">
            <i class=""></i>
            Data Reservation </div>
          <div class="card-body text-center">

          <form action="admin_home.php" method="POST">
<label>
  <div class="text-left">Check in</div>
  <input  type="date" name="stdate" value="<?php echo $nowdate; ?>"  class="form-control">
</label>
<label>
  <div class="text-left">Check out</div>
  <input  type="date" name="endate" value="<?php echo $nowdate; ?>"  class="form-control">
</label>
<label>
  <div>
<button type="submit" class="btn  btn-info">ค้นหา</button>
  </div>
</label>
          </form> 

          </div>
</div>

          <!-- seach date -->

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Reservation</div>
          <div class="card-body">
          <div class="pb-2">Datecheck<span style="color:blue"><?php   echo date_format(date_create($stdate), "d/m/Y"); ?></span> END <span style="color:blue"><?php   echo date_format(date_create($endate), "d/m/Y"); ?> </span></div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable"    width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>รายการ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>จำนวนคน</th>
                    <th>เบอร์/อีเมลล์</th>
                    <th>วันที่เช็คอิน</th>
                    <th>วันที่เช็คเอ้าท์</th>
                    <th>วันที่จอง</th>
                    <th>สถานะ</th>
                    <th>อนุมัติ</th>
                    <th>ดูหลังฐาน</th>
                    <th>พิมพ์ใบเสร็จ</th>
                  </tr>
                </thead>
                <tbody>

                <?php
  $list = 0;
        $sql="SELECT DISTINCT booking_room.booking_room_id , booking_room_des.book_in_date ,booking_room.people , booking_room_des.book_out_date , member.member_name , member.member_surname , member.member_tel  , member.member_email, booking_room.booking_date , booking_room.booking_status
        FROM booking_room INNER JOIN booking_room_des ON booking_room.booking_room_id = booking_room_des.booking_room_id INNER JOIN member ON booking_room.member_id = member.member_id
           WHERE booking_room.booking_date AND booking_room_des.book_in_date BETWEEN '$stdate' AND '$endate'   AND booking_room.booking_status >='1'  ORDER BY booking_room_des.book_in_date  ASC";

        $result = $conn->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $reservation_id = $row['booking_room_id'];
            $list ++; ?>
    <tr>
      <td><?php echo $list ?></td>
      <td><?php echo $row['member_name'] ?>/<br><?php echo $row['member_surname']; ?></td>
      <td class="text-center"><?php echo $row['people'] ?></td>
      <td><?php echo $row['member_tel'] ?>/<br><?php echo $row['member_email']; ?></td>
      <td><?php   echo date_format(date_create($row['book_in_date']), "d/m/Y"); ?></td>
      <td><?php   echo date_format(date_create($row['book_out_date']), "d/m/Y"); ?></td>
      <td><?php   echo date_format(date_create($row['booking_date']), "d/m/Y"); ?></td>
      <td ><?php echo $bookstatus[$row['booking_status']]; ?></td>
      <td>
        <form action="#" method="POST">
          <input type="hidden" name="reservation_id" value="<?php echo $reservation_id ; ?>">
          <button type="submit" class="btn btn-info" name="submit" name="submit">Print</button>
        </form>
      </td>
      <td>
        <form action="admin_home.php" method="POST">
        <input type="hidden" name="reservation_id" value="<?php echo $reservation_id ; ?>">
          <button type="submit" class="btn btn-info" name="check" name="check">Print</button>
        </form>
      </td>
      <td>
        <form action="#" method="POST">
        <input type="hidden" name="reservation_id" value="<?php echo $reservation_id ; ?>">
        <button type="submit" class="btn btn-info" name="print" name="print">Print</button>
        </form>
      </td>
    </tr>
        <?php
        } ?>
                </tbody>
              </table>
            </div>
          </div>
         
        </div>

      </div>
      <?php }
    }
}

?>

      <!-- /.container-fluid -->
<?php include 'admin_framwork/footer.php' ?>
