
<?php
session_start();
require 'config/config.php';
if(isset($_POST['save'])=='save')
{
require 'controller_rooms.php';
$filename = $_FILES['image']['name'];
$filetmpname = $_FILES['image']['tmp_name'];
$filesize = $_FILES['image']['size'];
$fileerror = $_FILES['image']['error'];
$filetype = $_FILES['image']['type'];

$fileext = explode('.', $filename);
$fileactualext = strtolower(end($fileext));

$allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

if (in_array($fileactualext, $allowed)) {
    if ($fileerror == 0) {
        if ($filesize < 1000000) {
            $filenamenew = uniqid('', true).".".$fileactualext;
            $filedestination = 'public/img/roomtype/' .$filenamenew;
            move_uploaded_file($filetmpname, $filedestination);
$save = new Roomtype;
$save->room_type = $_POST['room_type'];
$save->room_type_detail = $_POST['room_type_detail'];
$save->room_type_id = $_POST['room_type_id'];
$save->price =$_POST['price'];
$save->image = $filenamenew;
$save->Edit();
}
echo "<script language=\"JavaScript\">";
echo "alert('ไฟล์ภาพใหญ่เกินไป');";
echo "location='admin_slide.php' ";
echo "</script>";
}
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถอัพโหลดรูปภาพได้');";
echo "location='admin_slide.php' ";
echo "</script>";
}
}
if(isset($_POST['delete'])=='delete'){
  require 'controller_rooms.php';
 
  $delete = new Roomtype;
  $delete->room_type_id = $_POST['room_type_id'];
  $delete->delete();

}
if(isset($_POST['inser_type'])=='inser_type'){
  require 'controller_rooms.php';
  $filename = $_FILES['image']['name'];
  $filetmpname = $_FILES['image']['tmp_name'];
  $filesize = $_FILES['image']['size'];
  $fileerror = $_FILES['image']['error'];
  $filetype = $_FILES['image']['type'];

  $fileext = explode('.', $filename);
  $fileactualext = strtolower(end($fileext));

  $allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

  if (in_array($fileactualext, $allowed)) {
      if ($fileerror == 0) {
          if ($filesize < 1000000) {
              $filenamenew = uniqid('', true).".".$fileactualext;
              $filedestination = 'public/img/roomtype/' .$filenamenew;
              move_uploaded_file($filetmpname, $filedestination);
  $inser = new Roomtype;
  $inser->room_type = $_POST['room_type'];
  $inser->room_type_detail = $_POST['room_type_detail'];
  $inser->price = $_POST['price'];
  $inser->image =  $filenamenew;
  $inser->Insert();
}
echo "<script language=\"JavaScript\">";
echo "alert('ไฟล์ภาพใหญ่เกินไป');";
echo "location='admin_slide.php' ";
echo "</script>";
}
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถอัพโหลดรูปภาพได้');";
echo "location='admin_slide.php' ";
echo "</script>";
}
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
            <a href="admin_roomtype.php">Roomtype</a>
          </li>
          <li class="breadcrumb-item active">type</li>
        </ol>

<?php 
          if(isset($_POST['edit'])=='edit'){?>
               <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
           Edit Roomtype</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered text-center"   width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ประเภท</th>
              <th>รายละเอียด</th>
              <th>ราคา</th>
              <th>รูป</th>
              <th class="text-center">แก้ไข</th>
            </tr>
          </thead>
          <tbody>
            
          <?php   $roomtype = $_POST['room_type_id'];
            $sql="SELECT * FROM roomtype WHERE room_type_id = $roomtype";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>
          <form action="admin_roomtype.php" method="POST" enctype="multipart/form-data">
          <tr>
            <td><input name="room_type" type="text" class="form-control" value="<?php echo $row['room_type'] ; ?>"></td>
            <td><input name="room_type_detail" type="text" class="form-control" value="<?php echo $row['room_type_detail'] ; ?>"></td>
            <td><input name="price" type="text" class="form-control" value="<?php echo $row['price'] ; ?>"></td>
            <td><img src="public/img/roomtype/<?php echo$row['image']; ?>" while="50px" height="50px" ><br>
                          <label>
  <div class="text-center">รูปภาพ(800*1000)</div>
  <input type="file" name="image" class="form-control text-center" required="required" >
</label></td>

            <td class="text-center">

              <input name="room_type_id" type="hidden" value="<?php echo $row['room_type_id']; ?>">
              <button type="submit" name="save" value="save" class="btn btn-info">เรียบร้อย</button>
            </td>
          </tr>
          </form>
          </tbody>
        </table>
          </div>
         
        </div>

      </div>

       <?php }   
              }else{
              ?>
<!-- if edit -->

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
           Roomtype List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
          <thead>
            <tr>

              <th>ประเภท</th>
              <th>รายละเอียด</th>
              <th>ราคา</th>
              <th>รูป</th>
              <th class="text-center">แก้ไข</th>
              <th class="text-center">ลบ</th>
            </tr>
          </thead>
          <tbody>
          <?php

$sql="SELECT * FROM roomtype";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>



            <tr>
              <td><?php echo $row['room_type']; ?></td>
              <td><?php echo $row['room_type_detail']; ?></td>
              <td><?php echo $row['price']; ?></td>
              <td> <img src="public/img/roomtype/<?php echo $row['image']; ?>" while="80px" height="80px" ></td>
              <td class="text-center">
              <form action="admin_roomtype.php" method="POST" >
              <input name="room_type_id" type="hidden" value="<?php echo $row['room_type_id']; ?>">
              <button type="submit" name="edit" value="edit" class="btn btn-info">Edit</button>
              </form></td>
              <td class="text-center">
              <form action="admin_roomtype.php" method="POST" >
              <input name="room_type_id" type="hidden" value="<?php echo $row['room_type_id']; ?>">
              <button  onclick="return confirm('ยืนยันการลบอีกครั้ง อีกครั้ง')" type="submit" name="delete" value="delete" class="btn btn-danger">delete</button>
              </form></td>
            </tr>
    <?php 
           } ?>
          </tbody>
        </table>
          </div>
         
        </div>

      </div>
      <!-- /.container-fluid -->
        
<!-- seach date -->
<div class="card mb-3">
          <div class="card-header">
            <i class=""></i>
            เพิ่มโปรโมชั่น </div>
          <div class="card-body text-center">

          <form action="admin_roomtype.php"  method="POST" enctype="multipart/form-data">
<label>
  <div class="text-center">ชื่อห้องพัก</div>
  <input  type="text" name="room_type"   class="form-control" required="required">
</label><br>
<label>
  <div class="text-center">ราคา</div>
  <input  type="text" name="price"   class="form-control" required="required">
</label><br><label>
  <div class="text-center">รูปภาพ(800*1000)</div>
  <input  type="file" name="image"   class="form-control" required="required">
</label>
<div>รายละเอียดโปรโมชั่น</div>
  <textarea  type ="text"name="room_type_detail" class="form-control"  rows="3"></textarea>

<label>
  <div>
<button type="submit" name="inser_type" value="inser_type" class="btn  btn-info mt-3">เพิ่ม</button>
  </div>
</label>
          </form> 

          </div>
</div>
<?php } ?>

          <!-- seach date -->

<?php include 'admin_framwork/footer.php' ?>
<?php }  
} 
?>
