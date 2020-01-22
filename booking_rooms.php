  
   <?php 
error_reporting(0);
session_start();


   
if (isset($_POST['booking'])) {
    echo "<script>";
    echo "alert('Login please !!! ');" ;
    echo "window.location.href='login.php';";
    echo "</script>";
}
require 'config/config.php';
        include "public/header.php";
        require 'controller_rooms.php';

        $bkin   = $_POST['bkin'];
        $bkout  = $_POST['bkout'];
        $roomtype     = $_POST['roomtype'];
        $people = $_POST['people'];
        
        if ($roomtype>0) {
            $kw=" AND roomtype.room_type_id='$roomtype'";
        } else {
            $kw="";
        }
        $days = (int)date_diff(date_create($bkin), date_create($bkout))->format('%R%a');
        if ($days<=0) {
            echo "<script>";
            echo "alert('Wrong Date !!!!');" ;
            echo "window.location.href='index.php';";
            echo "</script>";
        } else {
//    if(isset($_POST['booking'])){
//     $booking = new Booking;
//     $booking->room_id    = $_POST['room_id'];
//     $booking->member_id  = $_POST['member_id'];
//     $booking->room_price = $_POST['room_price'];
//     $book = $booking->booking_room();
            //  }?>
   <!-- ##### Rooms Area Start ##### -->

    <section class="rooms-area section-padding-0-100 ">
        <div class="container pt-100 mt-100">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading text-center mt-5 pt-5">
                        <div class="line-"></div>
                        <h2>Choose a room</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.</p>
                    </div>
                </div>
            </div>
   
            <div class="row">

            <?php
            $sql="SELECT * FROM rooms LEFT JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id "
            . "WHERE room_id NOT IN (SELECT room_id FROM booking_room_des "
            . "WHERE ((book_in_date >= '$bkin' AND book_in_date <'$bkout') OR (book_in_date < '$bkin' AND book_out_date > '$bkin')))".$kw;
            $result = $conn->query($sql);
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                ?>
                      
                <!-- Single Rooms Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                    <form action="booking_rooms.php" method="POST">
                        <!-- Thumbnail -->
                        <div class="bg-thumbnail bg-img" style="background-image: url(public/img/room/<?php echo $row['room_image'] ; ?>);"></div>
                        <!-- Price -->
                        <p class="price-from">From $150/night </p>
                        <!-- Rooms Text -->
                        <div class="rooms-text">
                            <div class="line"></div>
                            <h4><?php echo $row['room_type'] ; ?></h4>
                            <p>Number Room <?php echo $row['room_id'] ; ?></p>
                            <p><?php echo $row['room_type_detail'] ; ?></p>
                        </div>
                        <!-- Book Room -->
                        <button type="submit" name="booking" value="booking" class="book-room-btn btn palatin-btn">Book Room</button>
                    </div>
                </div>
                
                        <?php
            } ?></form>
                        

                <div class="col-12">
                    <!-- Pagination -->
                    <div class="pagination-area wow fadeInUp" data-wow-delay="400ms">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item active"><a class="page-link" href="#">01.</a></li>
                                <li class="page-item"><a class="page-link" href="#">02.</a></li>
                                <li class="page-item"><a class="page-link" href="#">03.</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ##### Rooms Area End ##### -->
<?php   include("public/footer.php");
        }?>