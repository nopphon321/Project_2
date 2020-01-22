
<?php 

session_start();



require 'config/config.php';

if (!$_SESSION['member_id']) {
        header("Location: login.php");
} else {
    $member_id=$_SESSION['member_id'];
    $sql2="SELECT * FROM member WHERE member.member_id='$member_id'";
    $result2 = $conn->query($sql2);
    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
        include "public/header.php"
?>


  <!-- ##### About Us Area Start ##### -->
  <section class="about-us-area mt-5 pt-5">
        <div class="container">
            <div class="row align-items-center mt-5 pt-5 pb-5 mb-5">
        <h1 class="text-center"> Youy reservation List</h1>
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
        $sql="SELECT * FROM booking_room INNER JOIN member ON booking_room.member_id = member.member_id
       
         WHERE booking_room.member_id = $member_id ";

        $result=$conn->query($sql);

        while($row= $result->fetch_array(MYSQLI_ASSOC)){
          $booking_room_id = $row['booking_room_id'];
        ?>
    <tr>
<th><?php echo $list ;?></th>
    <th><?php   echo date_format(date_create($row['booking_date']), "d/m/Y"); ?></th>
    <th><?php echo number_format( $row['total_price'],2); ?></th>
    <th><?php echo $row['people']; ?></th>


    <th colspan="2">
    <?php 

    $sql2 = "SELECT booking_room_des.booking_room_id, booking_room_des.room_id
    ,roomtype.room_type ,rooms.room_price FROM booking_room_des INNER JOIN rooms ON booking_room_des.room_id = rooms.room_id INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id 
    WHERE booking_room_des.booking_room_id = $booking_room_id";
   
  $result2 = $conn->query($sql2);
   while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
    ?>
    
    Room No. --<?php echo $row2['room_id']; ?>--Roomtype-- 
     <?php echo $row2['room_type']; ?><br>
   <?php }?>
    </th>
    </tr>

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