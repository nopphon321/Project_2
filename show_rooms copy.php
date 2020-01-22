  
   <?php 

session_start();
require 'config/config.php';

if (!$_SESSION['member_id']) {
        header("Location: login.php");
} else {
    $member_id=$_SESSION['member_id'];
    $sql="SELECT * FROM member WHERE member.member_id='$member_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        require 'config/config.php' ;
        include "public/header.php";
        require 'controller_rooms.php';

        $check = new Rooms;
        $check->conn   = $conn;
        $check->bkin   = $_POST['bkin'];
        $check->bkout  = $_POST['bkout'];
        $check->q      = $_POST['roomtype'];
        $check->people = $_POST['people'];
        if ($check->q>0) {
            $check->kw=" AND roomtype.room_type_id='$check->q'";
        } else {
            $check->kw="";
        }
        $result = $check->checkroom();
  
     
        if(isset($_POST['booking_room'])){
            $book = new Booking;
            $book->room_id = $_POST['room_id'];
            $book->mrmber_id = $_POST['member_id'];
            $book->room_price = $_POST['room_price'];
            $room = $book->booking_room();

        }

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
                        <h2>Choose a room //<?php echo $room ?></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.</p>
                    </div>
                </div>
            </div>
   
            <div class="row">

            <?php
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            ?>
                      
                <!-- Single Rooms Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                    <form action="show_rooms.php" method="POST">
                        <!-- Thumbnail -->
                        <div class="bg-thumbnail bg-img" style="background-image: url(public/img/bg-img/1.jpg);"></div>
                        <!-- Price -->
                        <p class="price-from">From $150/night </p>
                        <!-- Rooms Text -->
                        <div class="rooms-text">
                            <div class="line"></div>
                            <h4><?php echo $row['room_type'] ; ?></h4>
                            <p>Number Room <?php echo $row['room_id'] ; ?></p>
                            <p><?php echo $row['room_type_detail'] ; ?></p>
                        </div>
                        <!-- input  -->
                            <input type="hidden" name="" value="<?php echo $row['room_id'] ; ?>">
                            <input type="hidden" name="" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="" value="<?php echo $row['room_price'] ; ?>">
                        <!-- end input  -->
                        <!-- Book Room -->
                        <button type="submit" name="booking_room" value="booking_room" class="book-room-btn btn palatin-btn">Book Room</button>
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
    }
}?>