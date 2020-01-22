<style type="text/css">
@media print{
#no_print{display:none;}
}
</style><div id="no_print">
<?php
error_reporting(0);
session_start();

$book_id = $_POST['book_id'];


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


</div>
    <!-- ##### Testimonial Area Start ##### -->
    <section class="testimonial-area section-padding-100 bg-img" style="background-image: url(public/img/core-img/pattern.png);">
        <div class="container mt-5 pt-5">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="testimonial-content">
                        <div class="section-heading text-center">
                            <div class="line-"></div>
                            <h2>ใบเสร็จการจอง</h2>
                            <h5 class="text-left">วันที่จอง :<?php   echo date_format(date_create($row['booking_date']), "d/m/Y"); ?></h5>
                        </div>
                        <table class="table ">
                                                    <thead class="text-center">
                                <tr>
                                <th>List</th>
                                <th>SumPrice</th>
                                <th>People</th>
                                <th colspan="2">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php 
                            $list = 1;
                                    $sql="SELECT booking_room.booking_room_id,booking_room.people,  pay_ment.pay_ment_money FROM `pay_ment` INNER JOIN booking_room ON pay_ment.booking_room_id = booking_room.booking_room_id
                                    WHERE booking_room.booking_room_id= $book_id ";

                                    $result=$conn->query($sql);

                                    while($row= $result->fetch_array(MYSQLI_ASSOC)){
                                    $booking_room_id = $row['booking_room_id'];
                                    ?>
                                <tr>
                            <th><?php echo $list ;?></th>
                                <th><?php echo number_format( $row['pay_ment_money'],2); ?></th>
                                <th><?php echo $row['people']; ?></th>


                                <th colspan="2">
                                <?php 

                                $sql2 = "SELECT booking_room_des.book_in_date, booking_room_des.book_out_date, booking_room_des.booking_room_id, booking_room_des.room_id
                                ,roomtype.room_type ,rooms.room_price  FROM booking_room_des INNER JOIN rooms ON booking_room_des.room_id = rooms.room_id INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id 
                                WHERE booking_room_des.booking_room_id = $book_id";
                            
                            $result2 = $conn->query($sql2);
                            while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
                                $bkin = $row2['book_in_date'];
                                $bkout = $row2['book_out_date'];
                                $days = (int)date_diff(date_create($bkin), date_create($bkout))->format('%R%a'); 
                                ?>
                                
                                Room No. --<?php echo $row2['room_id']; ?>--Roomtype-- 
                                <?php echo $row2['room_type']; ?><br>
                            <?php }?>
                                </th>
                                </tr>

                                    <?php $list++; } ?>
                                </tbody>
                            </table>
                            <p>Check In <?php   echo date_format(date_create($bkin), "d/m/Y"); ?> /Check Out <?php   echo date_format(date_create($bkout), "d/m/Y"); ?> / <?php echo  $days ;?> Day </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="no_print">
<?php include("public/footer.php") ; ?>
</div>
    <?php
    }
}
 ?>