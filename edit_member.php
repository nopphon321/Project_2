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
         include("public/header.php") ;
         require_once 'controller_user.php'; ?>

<?php
        if (isset($_POST['submit'])) {
            $data= new User;
            $data->prefix         = $_POST['prefix'];
            $data->member_name    = $_POST['member_name'];
            $data->member_surname = $_POST['member_surname'];
            $data->username       = $_POST['username'];
            $data->password       = $_POST['password'];
            $data->tel            = $_POST['tel'];
            $data->email          = $_POST['email'];
            $data->address        = $_POST['address'];
            $data->member_id        = $_POST['member_id'];

            $data->user_update();
        } ?>

  <!-- ##### Contact Form Area Start ##### -->
  <section class="contact-form-area  mb-100 mt-100 ">
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading mb-100 mt-100">
                        <div class="line-"></div>
                        <br>
                        <h2>Register</h2>
                    </div>
                </div>
            </div>

            <div class="row">
<div class="col-12">
    <!-- Contact Form -->
    <form action="edit_member.php" method="POST">
    <?php
        $sql="SELECT * FROM member INNER JOIN prefix ON member.prefix_id = prefix.prefix_id WHERE member_id = $member_id";
         $result = $conn->query($sql);
         while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
             ?>
        <div class="row ">
            <div class="col-lg-1">
            <select class="form-control" name="prefix" id="select4" required="required">
            <option value="<?php echo $row['prefix_id']; ?>"><?php echo $row['prefix']; ?></option>
            <?php
        $sql2="SELECT * FROM prefix ORDER BY prefix_id ASC";
             $result2 = $conn->query($sql2);
             while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                 ?>
                    <option value="<?php echo $row2['prefix_id']; ?>"><?php echo $row2['prefix']; ?></option>
        <?php
             } ?>
            </select>
           
                         
                          
                        
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" name="member_name" placeholder="Name" value="<?php echo $row['member_name']; ?>" >
            </div>
            <div class="col-lg-5">
                <input type="text" class="form-control" name="member_surname" placeholder="Surname" value="<?php echo $row['member_surname']; ?>">
            </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $row['member_username']; ?>">
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="password" placeholder="Password" value="<?php echo $row['member_password']; ?>">
    </div>

    <div class="col-lg-6">
        <input type="text" class="form-control" name="tel" placeholder="Phon" value="<?php echo $row['member_tel']; ?>">
    </div>
    <div class="col-lg-6">
        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $row['member_email']; ?>">
    </div>

    <div class="col-12">
        <textarea name="address" class="form-control" id="address" cols="30" rows="10" placeholder="Address" ><?php echo $row['address']; ?></textarea>
    </div>

            <div class="col-12">
                <input name="member_id" type="hidden" value="<?php echo $row['member_id'];?>">
                <button type="submit"  name="submit" class="btn palatin-btn mt-50">Confirmed</button>
            </div>
                        </div>
                    </form>
        <?php
         } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Form Area End ##### -->

<?php include("public/footer.php") ; ?>
        <?php
     }
 }
  ?>