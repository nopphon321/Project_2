
<?php
session_start();
require 'config/config.php';
if (isset($_POST['insert_room'])=='insert_room') {
    require 'controller_rooms.php';
    $filename = $_FILES['room_image']['name'];
    $filetmpname = $_FILES['room_image']['tmp_name'];
    $filesize = $_FILES['room_image']['size'];
    $fileerror = $_FILES['room_image']['error'];
    $filetype = $_FILES['room_image']['type'];

    $fileext = explode('.', $filename);
    $fileactualext = strtolower(end($fileext));

    $allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

    if (in_array($fileactualext, $allowed)) {
        if ($fileerror == 0) {
            if ($filesize < 1000000) {
                $filenamenew = uniqid('', true).".".$fileactualext;
                $filedestination = 'public/img/room/' .$filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                $save = new Room;
                $save->room_type_id = $_POST['room_type_id'];
                $save->room_id = $_POST['room_id'];
                $save->room_price = $_POST['room_price'];
                $save->room_detail = $_POST['room_detail'];
                $save->room_image = $filenamenew;
                $save->Insert();
            }
            echo "<script language=\"JavaScript\">";
            echo "alert('ไฟล์ภาพใหญ่เกินไป');";
            echo "location='admin_rooms.php' ";
            echo "</script>";
        }
        echo "<script language=\"JavaScript\">";
        echo "alert('ไม่สามารถอัพโหลดรูปภาพได้');";
        echo "location='admin_rooms.php' ";
        echo "</script>";
    }
}
if(isset($_POST['editrooms'])=='editrooms'){
  require 'controller_rooms.php';
  $filename = $_FILES['room_image']['name'];
  $filetmpname = $_FILES['room_image']['tmp_name'];
  $filesize = $_FILES['room_image']['size'];
  $fileerror = $_FILES['room_image']['error'];
  $filetype = $_FILES['room_image']['type'];

  $fileext = explode('.', $filename);
  $fileactualext = strtolower(end($fileext));

  $allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

  if (in_array($fileactualext, $allowed)) {
      if ($fileerror == 0) {
          if ($filesize < 1000000) {
              $filenamenew = uniqid('', true).".".$fileactualext;
              $filedestination = 'public/img/room/' .$filenamenew;
              move_uploaded_file($filetmpname, $filedestination);
  $save = new Room;
  $save->room_type_id = $_POST['room_type_id'];
  $save->room_id = $_POST['room_id'];
  $save->room_price = $_POST['room_price'];
  $save->room_detail = $_POST['room_detail'];
  $save->room_image = $filenamenew;
  $save->Edit();
}
  echo "<script language=\"JavaScript\">";
  echo "alert('ไฟล์ภาพใหญ่เกินไป');";
  echo "location='admin_rooms.php' ";
  echo "</script>";
}
echo "<script language=\"JavaScript\">";
echo "alert('ไม่สามารถอัพโหลดรูปภาพได้');";
echo "location='admin_rooms.php' ";
echo "</script>";
}
}
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
            <a href="admin_rooms.php">Rooms</a>
          </li>
          <li class="breadcrumb-item active">Edit Rooms</li>
        </ol>

<?php 
          if(isset($_POST['edit'])=='edit'){?>
               <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
           Rooms List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered text-center"   width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>เลขห้อง</th>
              <th>ประเภทห้อง</th>
              <th>รูปภาพ</th>
              <th>รายละเอียด</th>
              <th>ราคา</th>
              <th class="text-center">แก้ไข</th>
            </tr>
          </thead>
          <tbody>
            
          <?php   $room_id = $_POST['room_id'];
            $sql="SELECT * FROM rooms INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id WHERE room_id = $room_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>
          <form action="admin_rooms.php" method="POST"  enctype="multipart/form-data">
          <tr>
            <td><input name="room_id" type="text" class="form-control" value="<?php echo $row['room_id'] ; ?>" readonly></td>
            <td><select class="form-control" name="room_type_id" id="select4">
            <option value="<?php echo $row['room_type_id']; ?>"><?php echo $row['room_type']; ?></option>
                          <?php 
                      $sql2="SELECT * FROM roomtype ORDER BY room_type_id ASC";
                      $result2 = $conn->query($sql2);
                      while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
                      ?><option value="<?php echo $row2['room_type_id']; ?>"><?php echo $row2['room_type']; ?></option>
                      <?php } ?>
                          </select></td>
                          <td> <img src="public/img/room/<?php echo$row['room_image']; ?>" while="50px" height="50px" ><br>
                          <label>
  <div class="text-center">รูปภาพห้องพัก(800*1000)</div>
  <input type="file" name="room_image" class="form-control text-center" required="required" >
</label>

                        </td>
          <td>  <textarea  type ="text"name="room_detail" class="form-control text-center"  rows="3"> <?php echo $row['room_detail']; ?></textarea> </td>
          <td><input name="room_price" type="text" class="form-control" value="<?php echo $row['room_price'] ; ?>"></td>
            <td class="text-center">
              <input name="room_type_id" type="hidden" value="<?php echo $row['room_type_id']; ?>">
              <button type="submit" name="editrooms" value="editrooms" class="btn btn-info">เรียบร้อย</button>
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
           Rooms List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>เลขห้อง</th>
              <th>ประเภทห้อง</th>
              <th>ประเภทห้อง</th>
              <th>รูป</th>
              <th>ราคา</th>
              <th class="text-center">แก้ไข</th>
              <th class="text-center">ลบ</th>
            </tr>
          </thead>
          <tbody>
          <?php

$sql="SELECT * FROM rooms INNER JOIN roomtype ON rooms.room_type_id = roomtype.room_type_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>



            <tr>
              <td><?php echo $row['room_id']; ?></td>
              <td><?php echo $row['room_type']; ?></td>
              <td><?php echo $row['room_detail']; ?> </td>
              <td> <img src="public/img/room/<?php echo$row['room_image']; ?>" while="50px" height="50px" ></td>
              <td><?php echo $row['room_price']; ?> </td>
              <td class="text-center">
              <form action="admin_rooms.php" method="POST" >
              <input name="room_id" type="hidden" value="<?php echo $row['room_id']; ?>">
              <button type="submit" name="edit" value="edit" class="btn btn-info">Edit</button>
              </form></td>
              <td class="text-center">
              <form action="admin_rooms.php" method="POST" >
              <input name="room_id" type="hidden" value="<?php echo $row['room_id']; ?>">
              <button onclick="return confirm('ยืนยันการลบอีกครั้ง อีกครั้ง')" type="submit" name="deleterooms" value="deleterooms" class="btn btn-danger">delete</button>
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

          <form action="admin_rooms.php"  method="POST" enctype="multipart/form-data">
          <label>
          <div class="text-center">เลือกประเภทห้องพัก</div>
  <select class="form-control" name="room_type_id" id="select4">
                          <?php 
                      $sql="SELECT * FROM roomtype ORDER BY room_type_id ASC";
                      $result = $conn->query($sql);
                      while($row = $result->fetch_array(MYSQLI_ASSOC)){
                      ?>
                                  <option value="<?php echo $row['room_type_id']; ?>"><?php echo $row['room_type']; ?></option>
                      <?php } ?>
                          </select>
</label><br>
<label>
  <div class="text-center">เลขห้อง <span class="text-danger">(เลขห้ามซ้ำ)</span></div>
  <input   type="text" name="room_id"   class="form-control text-center" required="required">
</label><br>
<label>
  <div class="text-center">ราคา</div>
  <input   type="text" name="room_price"   class="form-control text-center" required="required">
</label><br>
<label>
  <div class="text-center">รูปภาพห้องพัก(800*1000)</div>
  <input type="file" name="room_image" class="form-control text-center" required="required" >
</label>
<div>รายละเอียดห้องพัก</div>
  <textarea  type ="text"name="room_detail" class="form-control text-center"  rows="3"></textarea>

<label>
  <div>
<button type="submit" name="insert_room" value="insert_room" class="btn  btn-info mt-3">เพิ่ม</button>
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
