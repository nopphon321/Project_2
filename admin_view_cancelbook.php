
<?php

session_start();
require 'config/config.php';

if (!$_SESSION['admin_id']) {
        header("Location: admin_login.php");
} else {
    $admin_id=$_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE admin.admin_id='$admin_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        ?>
<?php 
require 'controller_admin.php';
?>
<?php include 'admin_framwork/header.php' ?>
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">cancel</a>
          </li>
          <li class="breadcrumb-item active">Check Booking</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            cancel booking</div>
          <div class="card-body">

            <div class="table-responsive">
              <table
              class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>รายการ</th>
                    <th>วันที่ยกเลิก</th>
                    <th colspan="2">รายละเอียด</th>
                    <th colspan="2">เหตุผล</th>
                  </tr>
                </thead>
                <tbody>
                <tbody>
                <?php 
  $list = 0;
        $sql="SELECT * FROM `booking_room` WHERE booking_status='0'";

        $result = $conn->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $reservation_id = $row['booking_room_id'];
            $list ++; ?>
    <?php

        $sql2="SELECT * FROM `book_cancel` WHERE booking_room_id = $reservation_id";

            $result2 = $conn->query($sql2);
            while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                ?>
                  <tr>
                    <td><?php echo $list ?></td>
                    <td><?php   echo date_format(date_create($row2['bc_date']), "d/m/Y"); ?></td>
                    <td colspan="2">
    <?php 

    $sql3 = "SELECT booking_room_des.booking_room_id, booking_room_des.room_id
    ,roomtype.room_type ,rooms.room_price FROM booking_room_des INNER JOIN rooms ON booking_room_des.room_id = rooms.room_id INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id 
    WHERE booking_room_des.booking_room_id = $reservation_id ";
   
  $result3 = $conn->query($sql3);
   while($row3 = $result3->fetch_array(MYSQLI_ASSOC)){
    ?>
    
    Room No. --<?php echo $row3['room_id']; ?>--Roomtype-- 
     <?php echo $row3['room_type']; ?><br>
   <?php }?>
    </td>
                    <td colspan="2"><?php echo $row2['bc_reason'] ?></td>
                  </tr>
        <?php
            }
        }?>
                </tbody>
              </table>
            </div>
          </div>
         
        </div>

      </div>
      <!-- /.container-fluid -->
<?php include 'admin_framwork/footer.php' ?>
<?php }  
} 
?>
