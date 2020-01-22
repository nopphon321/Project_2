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
         ?>
<?php
error_reporting(0);
         include("public/header.php") ; ?>
 <!-- ##### Hero Area Start ##### -->
 <section class="hero-area">
        <div class="hero-slides owl-carousel">
        <?php   $room_id = $_POST['room_id'];
            $sql="SELECT * FROM slide";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url(public/img/slide/<?php echo $row['slide_image'];?>);"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-9">
                            <!-- Slide Content -->
                            <div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
                                <div class="line" data-animation="fadeInUp" data-delay="300ms"></div>
                                <h2 data-animation="fadeInUp" data-delay="500ms"><?php echo $row['title'];?></h2>
                                <p data-animation="fadeInUp" data-delay="700ms"><?php echo $row['title_detail'];?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?>

    </section>
    <!-- ##### Hero Area End ##### -->
    <!-- ##### Book Now Area Start ##### -->
    <div class="book-now-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 ">
                    <div class="book-now-form">
            <!-- ##### Check user if user Login action to index but not login to go home ##### -->   
                            <form action="show_rooms.php" method="POST">
                             <!-- Form Group -->
                             <div class="form-group">
                                <label for="select1">Check In</label>
                                <input  type="date"  min=<?php echo $nowdate ;?>  name="bkin" value="<?php echo $nowdate; ?>"  >
                            </div>

                            <!-- Form Group -->
                            <div class="form-group">
                                <label for="select2">Check Out</label>
                                <input  type="date"  min=<?php echo $nowdate ;?> name="bkout" value="<?php echo $nowdate; ?>"  >
                            </div>

                            <!-- Form Group -->
                            <div class="form-group">
                                <label for="select3">Adults</label>
                                <select name="people" class="form-control" id="select3">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                  <option>More 6</option>
                                </select>
                            </div>

                            <!-- Form Group -->
                            <div class="form-group">
                                <label  for="select4">Childrens</label>
                                <select name="roomtype" class="form-control" id="select4">
                                <option value="0">All</option>
                                <?php 
                        $sql="SELECT * FROM roomtype ORDER BY room_type ASC";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        ?>
                          <option value="<?php echo $row['room_type_id']; ?>"><?php echo $row['room_type']; ?></option>
                          
                          <?php } ?>
                                </select>
                            </div>

                            <!-- Button -->
                            <button name="submit" value="submit" type="submit">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Book Now Area End ##### -->

    <!-- ##### About Us Area Start ##### -->
    <section class="about-us-area">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-12 col-lg-6">
                    <div class="about-text text-center mb-100">
                        <div class="section-heading text-center">
                            <div class="line-"></div>
                            <h2>A place to remember</h2>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus.</p>
                        <div class="about-key-text">
                            <h6><span class="fa fa-check"></span> Donec malesuada lorem maximus mauris sceleri</h6>
                            <h6><span class="fa fa-check"></span> Malesuada lorem maximus mauris sceleri</h6>
                        </div>
                        <a href="#" class="btn palatin-btn mt-50">Read More</a>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="about-thumbnail homepage mb-100">
                        <!-- First Img -->
                        <div class="first-img wow fadeInUp" data-wow-delay="100ms">
                            <img src="public/img/bg-img/5.jpg" alt="">
                        </div>
                        <!-- Second Img -->
                        <div class="second-img wow fadeInUp" data-wow-delay="300ms">
                            <img src="public/img/bg-img/6.jpg" alt="">
                        </div>
                        <!-- Third Img-->
                        <div class="third-img wow fadeInUp" data-wow-delay="500ms">
                            <img src="public/img/bg-img/7.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### About Us Area End ##### -->

    <!-- ##### Pool Area Start ##### -->
    <section class="pool-area section-padding-100 bg-img bg-fixed" style="background-image: url(public/img/bg-img/4.png);">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12 col-lg-7">
                    <div class="pool-content text-center wow fadeInUp" data-wow-delay="300ms">
                        <div class="section-heading text-center white">
                            <div class="line-"></div>
                            <h2>Infinity Pool</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum.</p>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="pool-feature">
                                    <i class="icon-cocktail-1"></i>
                                    <p>Pool Beachbar</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="pool-feature">
                                    <i class="icon-swimming-pool"></i>
                                    <p>Infinity Pool</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="pool-feature">
                                    <i class="icon-beach"></i>
                                    <p>Sunbeds</p>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <a href="#" class="btn palatin-btn mt-50">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Pool Area End ##### -->

    <!-- ##### Rooms Area Start ##### -->
    <section class="rooms-area section-padding-100-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading text-center">
                        <div class="line-"></div>
                        <h2>Choose a room</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
            <?php 
                        $sql="SELECT * FROM roomtype ORDER BY room_type ASC";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        ?>
                <!-- Single Rooms Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                        <!-- Thumbnail -->
                        <div class="bg-thumbnail bg-img" style="background-image: url(public/img/roomtype/<?php echo $row['image']; ?>);"></div>
                        <!-- Price -->
                        <p class="price-from">From <?php echo $row['price']; ?>/night</p>
                        <!-- Rooms Text -->
                        <div class="rooms-text">
                            <div class="line"></div>
                            <h4><?php echo $row['room_type']; ?></h4>
                            <p><?php echo $row['room_type_detail']; ?></p>
                        </div>
                        <!-- Book Room -->
                        <a href="#" class="book-room-btn btn palatin-btn">Book Room</a>
                    </div>
                </div>
                        <?php } ?>

            </div>
        </div>
    </section>
    <!-- ##### Rooms Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area d-flex flex-wrap align-items-center">
        <div class="home-map-area">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22236.40558254599!2d-118.25292394686001!3d34.057682914027104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2z4Kay4Ka4IOCmj-CmnuCnjeCmnOCnh-CmsuCnh-CmuCwg4KaV4KeN4Kav4Ka-4Kay4Ka_4Kar4KeL4Kaw4KeN4Kao4Ka_4Kav4Ka84Ka-LCDgpq7gpr7gprDgp43gppXgpr_gpqgg4Kav4KeB4KaV4KeN4Kak4Kaw4Ka-4Ka34KeN4Kaf4KeN4Kaw!5e0!3m2!1sbn!2sbd!4v1532328708137" allowfullscreen></iframe>
        </div>
        <!-- Contact Info -->
        <div class="contact-info">
            <div class="section-heading wow fadeInUp" data-wow-delay="100ms">
                <div class="line-"></div>
                <h2>Contact Info</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus. Lorem ipsum dolor sit amet, consectetur adipiscing.</p>
            </div>
            <h4 class="wow fadeInUp" data-wow-delay="300ms">Los Angeles 1481 Creekside Lane Avila Beach, CA 931</h4>
            <h5 class="wow fadeInUp" data-wow-delay="400ms">+53 345 7953 32453</h5>
            <h5 class="wow fadeInUp" data-wow-delay="500ms">yourmail@gmail.com</h5>
            <!-- Social Info -->
            <div class="social-info mt-50 wow fadeInUp" data-wow-delay="600ms">
                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->
<?php include("public/footer.php") ;
     }
}
?>
