
<?php 
error_reporting(0);
include("public/header.php") ;
 require_once 'controller_user.php';
?>

<?php 
        if(isset($_POST['submit'])){
            $data= new User;
            $data->prefix         = $_POST['prefix'];
            $data->member_name    = $_POST['member_name'];
            $data->member_surname = $_POST['member_surname'];
            $data->username       = $_POST['username'];
            $data->password       = $_POST['password'];
            $data->tel            = $_POST['tel'];
            $data->email          = $_POST['email'];
            $data->address        = $_POST['address'];

            $data->user_insert();
        }
    
?>

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
    <form action="register.php" method="POST">
        <div class="row ">
            <div class="col-lg-1">
            <select class="form-control" name="prefix" id="select4" required="required">
            <?php 
        $sql="SELECT * FROM prefix ORDER BY prefix_id ASC";
        $result = $conn->query($sql);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
        ?>
                    <option value="<?php echo $row['prefix_id']; ?>"><?php echo $row['prefix']; ?></option>
        <?php } ?>
            </select>
           
                         
                          
                        
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" name="member_name" placeholder="Name" required="required">
            </div>
            <div class="col-lg-5">
                <input type="text" class="form-control" name="member_surname" placeholder="Surname"required="required">
            </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="username" placeholder="Username" required="required">
    </div>
    <div class="col-lg-6">
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>

    <div class="col-lg-6">
        <input type="text" class="form-control" name="tel" placeholder="Phon" required="required">
    </div>
    <div class="col-lg-6">
        <input type="email" class="form-control" name="email" placeholder="Email" required="required">
    </div>

    <div class="col-12">
        <textarea name="address" class="form-control" id="address" cols="30" rows="10" placeholder="Address" required="required"></textarea>
    </div>

            <div class="col-12">
                <button type="submit"  name="submit" class="btn palatin-btn mt-50">Confirmed</button>
            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Form Area End ##### -->

<?php include("public/footer.php") ; ?>