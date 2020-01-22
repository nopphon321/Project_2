  
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

        $days = (int)date_diff(date_create($bkin), date_create($bkout))->format('%R%a');
        if ($days<=0) {
            echo "<script>";
            echo "alert('Wrong Date !!!!');" ;
            echo "window.location.href='home.php';";
            echo "</script>";
        } else {
            $last_id;
            if (isset($_POST['booking_room'])) {
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
                require_once 'controller_rooms.php';
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
            if (isset($_POST['cancel'])=='cancel') {
                require_once 'controller_rooms.php';
                $cancel = new Cancel_book;
                $cancel->cancel = $_POST['book_id'];
                $cancel->rmid = $_POST['rmid'];
                $last_id = $cancel->delete();
            }
            if (isset($_POST['complete'])=='complete') {
                require_once 'controller_rooms.php';
                $complete = new Complete;
                $complete->bookid = $_POST['book_id'] ;
                $complete->sumprice = $_POST['sumprice'] ;
                $complete->complete();
            } ?>


   <!-- ##### Rooms Area Start ##### -->
   <?php
            if ($last_id == 0) {?>
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
               
            <div class="table-responsive-xl mb-5">

            
   
            <div class="row">

          <?php
                  $sum =0;
                  $sumprice = 0;
                  
                $sql="SELECT * FROM rooms LEFT JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id "
             . "WHERE room_id NOT IN (SELECT room_id FROM booking_room_des "
             . "WHERE ((book_in_date >= '$bkin' AND book_in_date <'$bkout') OR (book_in_date < '$bkin' AND book_out_date > '$bkin')))".$kw;
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $sum = (int)$days * (int)$row['room_price']; ?>
                      
                <!-- Single Rooms Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                    <form action="show_rooms.php" method="POST">
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
                        <!-- input  -->
                            <input type="hidden" name="bkin" value="<?php echo $bkin; ?>">
                            <input type="hidden" name="bkout" value="<?php echo $bkout; ?>">
                            <input type="hidden" name="roomtype" value="<?php echo $roomtype ; ?>">
                            <input type="hidden" name="people" value="<?php echo $people; ?>">
                            <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ; ?>">
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="room_price" value="<?php echo $sum ; ?>">
                        <!-- end input  -->
                        <!-- Book Room -->
                        <button type="submit" name="booking_room" value="booking" class="book-room-btn btn palatin-btn">Book Room</button>
                    </div>
                </div>
                </form>
                        <?php
                }
            ?><?php } elseif ($last_id>0) { ?> 
            
   <!-- ##### Rooms Area Start ##### -->
   
    <section class="rooms-area section-padding-0-100 ">
        <div class="container pt-100 mt-100">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading text-center mt-5 pt-5">
                        <div class="line-"></div>
                        <h2>You reservation rooms<?php echo $last_id ?></h2>
                    </div>
                </div>
            </div>
            <table class="table">
    <tr>
      <th data-field="id">List</th>
      <th data-field="name">Check In Date</th>
      <th data-field="price">Check Out Date</th>
      <th data-field="name" colspan="3">reservation List</th>
      <th data-field="name" colspan="3">cancel</th>
    </tr>
  </thead>
        <tbody>

        <?php
        $sum =0;
        $sumprice = 0;
        $i=1;
        $sql3="SELECT booking_room_des.booking_room_id, booking_room_des.room_id
        ,roomtype.room_type ,rooms.room_price FROM booking_room_des INNER JOIN rooms ON booking_room_des.room_id = rooms.room_id INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id WHERE booking_room_id = $last_id ";
        $result3 = $conn->query($sql3);
        while ($row3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $book_id=$row3['booking_room_id'];
            $rmid=$row3['room_id'];
            $price=$row3['room_prie'];
            $sum = (int)$days * (int)$row3['room_price'];
            $sumprice = (int)$sumprice + (int)$sum; ?>
        
            <tr>
                <td><?php echo $i++ ; ?></td>
                <td><?php echo date_format(date_create($bkin), "d/m/Y"); ?></td>
                <td><?php echo date_format(date_create($bkout), "d/m/Y"); ?></td>
                <td colspan="3">

                Number <?php echo $row3['room_id']; ?> / <?php echo $row3['room_type']; ?>/ <?php echo $days ; ?> Day<br>
                </td>
                <td><form action="show_rooms.php" method="POST">
                    <input type="hidden" name="book_id"  value="<?php echo $book_id; ?>">
                    <input type="hidden" name="rmid"  value="<?php echo $rmid; ?>">
                    <input type="hidden" name="bkin"  value="<?php echo $bkin; ?>">
                    <input type="hidden" name="bkout"  value="<?php echo $bkout; ?>">
                    <input type="hidden" name="roomtype"  value="<?php echo $roomtype; ?>">
                    <button type="submit" name="cancel" value="cancel" class="btn btn-danger">cancel</button>
                </form></td>
            </tr>

            <?php
        } ?>
            <tr>
                <td colspan="4" class="text-right">total:</td>
                <td><?php echo number_format($sumprice, 2)  ?></td>
            </tr>
            <tr>
                <td colspan="6" class="text-center">
                <form action="show_rooms.php" method="POST">
                    <input type="hidden" name="book_id"  value="<?php echo $book_id;?>">
                    <input type="hidden" name="sumprice"  value="<?php echo $sumprice;?>">
                    <input type="hidden" name="bkin"  value="<?php echo $bkin;?>">
                    <input type="hidden" name="bkout"  value="<?php echo $bkout;?>">
                    <button type="submit" name="complete" class=" btn-info btn" value="complete" >Complete reservation</button>
                </form>
                </td>
            </tr>
        </tbody>
        </table>
            <div class="row mt-5 pt-5">
            <?php     $sql="SELECT * FROM rooms LEFT JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id "
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
                       <div class="bg-thumbnail bg-img" style="background-image: url(public/img/room/<?php echo $row['room_image'] ; ?>);"></div>
                       <!-- Price -->
                       <p class="price-from">From $120/night </p>
                       <!-- Rooms Text -->
                       <div class="rooms-text">
                           <div class="line"></div>
                           <h4><?php echo $row['room_type'] ; ?></h4>
                           <p>Number Room <?php echo $row['room_id'] ; ?></p>
                           <p><?php echo $row['room_type_detail'] ; ?></p>
                           <p>Room Price :<?php echo $row['room_price'] ; ?></p>
                       </div>
                       <!-- input  -->
                           <input type="hidden" name="bkin" value="<?php echo $bkin; ?>">
                           <input type="hidden" name="bkout" value="<?php echo $bkout; ?>">
                           <input type="hidden" name="roomtype" value="<?php echo $roomtype ; ?>">
                           <input type="hidden" name="people" value="<?php echo $people; ?>">
                           <input type="hidden" name="last_id" value="<?php echo $last_id; ?>">
                           <input type="hidden" name="room_id" value="<?php echo $row['room_id'] ; ?>">
                           <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                           <input type="hidden" name="room_price" value="<?php echo $sum ; ?>">
                       <!-- end input  -->
                       <!-- Book Room -->
                       <button type="submit" name="booking_room_des" value="booking" class="book-room-btn btn palatin-btn">Book Room</button>
                   </div>
               </div>
               </form>
                       <?php
               }
            ?><?php } ?>
                        

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
    }
}?>
