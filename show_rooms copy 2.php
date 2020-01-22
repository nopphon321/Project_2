  
   <?php 
error_reporting(0);
session_start();



require 'config/config.php';

if (!$_SESSION['member_id']) {
        header("Location: login.php");
} else {
    $member_id=$_SESSION['member_id'];
    $sql2="SELECT * FROM member WHERE member.member_id='$member_id'";
    $result2 = $conn->query($sql2);
    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
        include "public/header.php";
        $bkin=$_POST['bkin'];
        $bkout=$_POST['bkout'];
        $people = $_POST['people'];
        $roomtype = $_POST['roomtype'];
        
        if ($roomtype>0) {
            $kw=" AND roomtype.room_type_id='$roomtype'";
        } else {
            $kw="";
        }

    
     $last_id;
        if(isset($_POST['booking_room'])){
            require_once 'controller_rooms.php';
            $book = new Rooms;
            $book->people = $people;
            $book->bookin = $bkin;
            $book->bookout = $bkout;
            $book->room_id = $_POST['room_id'];
            $book->member_id = $_POST['member_id'];
            $book->room_price = $_POST['room_price'];
            $last_id = $book->booking_room(); 
             }  
             if (isset($_POST['booking_room_des'])=='booking') {
                 require_once 'controller_book_des.php';
                 $book = new Book_des;
                 $book->people = $people;
                 $book->bookin = $bkin;
                 $book->bookout = $bkout;
                 $book->last_id = $_POST['last_id'];
                 $book->room_id = $_POST['room_id'];
                 $book->member_id = $_POST['member_id'];
                 $book->room_price = $_POST['room_price'];
                 
                $last_id = $book->booking_room_des();
             }
             ?>


   <!-- ##### Rooms Area Start ##### -->
    <section class="rooms-area section-padding-0-100 ">
        <div class="container pt-100 mt-100">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading text-center mt-5 pt-5">
                        <div class="line-"></div>
                        <h2>Choose a room<?php echo $last_id ?></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.</p>
                    </div>
                </div>
            </div>
   
            <div class="row">

            <?php
            if ($last_id == 0) {
                $sql="SELECT * FROM rooms LEFT JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id "
             . "WHERE room_id NOT IN (SELECT room_id FROM booking_room_des "
             . "WHERE ((book_in_date >= '$bkin' AND book_in_date <'$bkout') OR (book_in_date < '$bkin' AND book_out_date > '$bkin')))".$kw;
                $result = $conn->query($sql);
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
                            <input type="hidden" name="bkin" value="<?php echo $bkin; ?>">
                            <input type="hidden" name="bkout" value="<?php echo $bkout; ?>">
                            <input type="hidden" name="roomtype" value="<?php echo $roomtype ; ?>">
                            <input type="hidden" name="people" value="<?php echo $people; ?>">
                            <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ; ?>">
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="room_price" value="<?php echo $row['room_price'] ; ?>">
                        <!-- end input  -->
                        <!-- Book Room -->
                        <button type="submit" name="booking_room" value="booking" class="book-room-btn btn palatin-btn">Book Room</button>
                    </div>
                </div>
                
                        <?php
                }
            ?></form><?php }elseif($last_id>0){ ?> <?php     $sql="SELECT * FROM rooms LEFT JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id "
            . "WHERE room_id NOT IN (SELECT room_id FROM booking_room_des "
            . "WHERE ((book_in_date >= '$bkin' AND book_in_date <'$bkout') OR (book_in_date < '$bkin' AND book_out_date > '$bkin')))".$kw;
               $result = $conn->query($sql);
               while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                   ?>
                     
               <!-- Single Rooms Area -->
               <div class="col-12 col-md-6 col-lg-4">
                   <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                   <form action="show_rooms.php" method="POST">
                       <!-- Thumbnail -->
                       <div class="bg-thumbnail bg-img" style="background-image: url(public/img/bg-img/1.jpg);"></div>
                       <!-- Price -->
                       <p class="price-from">From $120/night </p>
                       <!-- Rooms Text -->
                       <div class="rooms-text">
                           <div class="line"></div>
                           <h4><?php echo $row['room_type'] ; ?></h4>
                           <p>Number Room <?php echo $row['room_id'] ; ?></p>
                           <p><?php echo $row['room_type_detail'] ; ?></p>
                       </div>
                       <!-- input  -->
                           <input type="hidden" name="bkin" value="<?php echo $bkin; ?>">
                           <input type="hidden" name="bkout" value="<?php echo $bkout; ?>">
                           <input type="hidden" name="roomtype" value="<?php echo $roomtype ; ?>">
                           <input type="hidden" name="people" value="<?php echo $people; ?>">
                           <input type="hidden" name="last_id" value="<?php echo $last_id; ?>">
                           <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ; ?>">
                           <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                           <input type="hidden" name="room_price" value="<?php echo $row['room_price'] ; ?>">
                       <!-- end input  -->
                       <!-- Book Room -->
                       <button type="submit" name="booking_room_des" value="booking" class="book-room-btn btn palatin-btn">Book Room</button>
                   </div>
               </div>
               
                       <?php
               }
            ?></form><?php } ?>
                        

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
