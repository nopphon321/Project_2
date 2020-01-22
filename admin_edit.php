
<?php
session_start();
require 'config/config.php';
if(isset($_POST['deleterooms'])=='deleterooms'){
  require 'controller_rooms.php';
  $inser = new Room;
  $inser->room_id = $_POST['room_id'];
  $inser->Delete();
}
if (!$_SESSION['admin_id']) {
        header("Location: admin_login.php");
} else {
    $admin_id=$_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE admin.admin_id='$admin_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        ?>
<?php 

//require 'books_config.php';
$stdate=(isset($_POST['stdate']))?$_POST['stdate']:date("Y-m-d");
$endate=(isset($_POST['endate']))?$_POST['endate']:date("Y-m-d");
$bookstatus = array("cancel", "Not paid",  "Checking", "approve", "Stay");
?>
<?php include 'admin_framwork/header.php' ?>
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="admin_edit.php">Amin</a>
          </li>
          <li class="breadcrumb-item active">Edit </li>
        </ol>


  
        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="icon ion-ios-create "></i>
           Edit </div>
          <div class="card-body">
          <form>
          <?php
        $sql="SELECT * FROM admin WHERE admin_id=$admin_id";
             $result = $conn->query($sql);
             while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                 ?>
          <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">ชื่อ</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_name']; ?>" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">นามสกุล</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_lastname']; ?>" >
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Username</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_username']; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">Password</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_password']; ?>" >
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">email</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_email']; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">phone</label>
      <input type="text" class="form-control" value="<?php echo $row['admin_phone']; ?>" >
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="inputCity">ที่อยู่</label>
      <textarea  type ="text" name="address" class="form-control text-center"  cols="50" rows="3" >
        <?php echo $row['admin_address']; ?>
      </textarea>
    </div>
  </div>
  <div class="text-center"><button type="button" class="btn btn-danger ">ยืนยัน</button></div>
</form>
             <?php } ?>
          </div>
          <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
        </div>


          <!-- seach date -->

<?php include 'admin_framwork/footer.php' ?>
<?php }  
} 
?>
