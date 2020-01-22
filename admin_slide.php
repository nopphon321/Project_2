
<?php
session_start();
require 'config/config.php';
if (isset($_POST['insert_slide'])=='insert_slide') {
  require 'controller_slide.php';
  $filename = $_FILES['slide_image']['name'];
  $filetmpname = $_FILES['slide_image']['tmp_name'];
  $filesize = $_FILES['slide_image']['size'];
  $fileerror = $_FILES['slide_image']['error'];
  $filetype = $_FILES['slide_image']['type'];

  $fileext = explode('.', $filename);
  $fileactualext = strtolower(end($fileext));

  $allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

  if (in_array($fileactualext, $allowed)) {
      if ($fileerror == 0) {
          if ($filesize < 1000000) {
              $filenamenew = uniqid('', true).".".$fileactualext;
              $filedestination = 'public/img/slide/' .$filenamenew;
              move_uploaded_file($filetmpname, $filedestination);
                $save = new Slide;
                $save->title = $_POST['title'];
                $save->title_detail = $_POST['title_detail'];
                $save->slide_image = $filenamenew;
                $save->Insert();
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
if(isset($_POST['editslide'])=='editslide'){
  require 'controller_slide.php';
  $filename = $_FILES['slide_image']['name'];
  $filetmpname = $_FILES['slide_image']['tmp_name'];
  $filesize = $_FILES['slide_image']['size'];
  $fileerror = $_FILES['slide_image']['error'];
  $filetype = $_FILES['slide_image']['type'];

  $fileext = explode('.', $filename);
  $fileactualext = strtolower(end($fileext));

  $allowed = array('jpg', 'jpeg' , 'png' , 'pdf');

  if (in_array($fileactualext, $allowed)) {
      if ($fileerror == 0) {
          if ($filesize < 1000000) {
              $filenamenew = uniqid('', true).".".$fileactualext;
              $filedestination = 'public/img/slide/' .$filenamenew;
              move_uploaded_file($filetmpname, $filedestination);
  $save = new Slide;
  $save->slide_id= $_POST['slide_id'];
  $save->title = $_POST['title'];
  $save->title_detail = $_POST['title_detail'];
  $save->slide_image = $filenamenew;
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
if(isset($_POST['deleteslite'])=='deleteslite'){
  require 'controller_slide.php';
  $inser = new Slide;
  $inser->slide_id = $_POST['slide_id'];
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
            <a href="admin_slide.php">Slide</a>
          </li>
          <li class="breadcrumb-item active">Edit Slide</li>
        </ol>

<?php 
          if(isset($_POST['edit'])=='edit'){?>
               <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
           Slide List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered  text-center"   width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Title</th>
              <th>detail</th>
              <th>รูปภาพ</th>
              <th class="text-center">แก้ไข</th>
            </tr>
          </thead>
          <tbody>
            
          <?php   $slide_id = $_POST['slide_id'];
            $sql="SELECT * FROM slide WHERE slide_id = $slide_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>
          <form action="admin_slide.php" method="POST"  enctype="multipart/form-data">
          <tr>
            <td> <textarea  type ="text" name="title" class="form-control text-center"  cols="50" rows="3" > <?php echo $row['title']; ?></textarea></td>
            <td><textarea  type ="text" name="title_detail" class="form-control"  cols="150" rows="9" > <?php echo $row['title_detail']; ?></textarea></td>

                          <td> <img src="public/img/slide/<?php echo$row['slide_image']; ?>" while="50px" height="50px" ><br>
                          <label>
  <div class="text-center">รูปภาพห้องพัก(1920*1281)</div>
  <input type="file" name="slide_image" class="form-control text-center" required="required" >
</label>
                        </td>
            <td class="text-center">
            <input name="slide_id" type="hidden" value="<?php echo $row['slide_id']; ?>">
              <button type="submit" name="editslide" value="editslide" class="btn btn-info">เรียบร้อย</button>
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
           Slide List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Title</th>
              <th>Tiltle_detail</th>
              <th>รูป</th>
              <th class="text-center">แก้ไข</th>
              <th class="text-center">ลบ</th>
            </tr>
          </thead>
          <tbody>
          <?php

$sql="SELECT * FROM slide ORDER BY slide_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>



            <tr>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['title_detail']; ?></td>
              <td> <img src="public/img/slide/<?php echo $row['slide_image']; ?>" while="80px" height="80px" ></td>
              <td class="text-center">
              <form action="admin_slide.php" method="POST" >
              <input name="slide_id" type="hidden" value="<?php echo $row['slide_id']; ?>">
              <button type="submit" name="edit" value="edit" class="btn btn-info">Edit</button>
              </form></td>
              <td class="text-center">
              <form action="admin_slide.php" method="POST" >
              <input name="slide_id" type="hidden" value="<?php echo $row['slide_id']; ?>">
              <button type="submit" name="deleteslite" value="deleteslite" class="btn btn-danger">delete</button>
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
            เพิ่ม Slide </div>
          <div class="card-body text-center">

          <form action="admin_slide.php"  method="POST" enctype="multipart/form-data">
          <label>
          <div class="text-center">Title</div>
          <textarea  type ="text" name="title" class="form-control text-center"  cols="50" rows="3" required="required" > </textarea>
 
</label><br>
<label>
  <div class="text-center">Detail</span></div>
  <textarea  type ="text" name="title_detail" class="form-control text-center"  cols="100" rows="5" required="required" >
          </textarea>
</label><br>
<label>
  <div class="text-center">รูปภาพSlide(1920*1281)</div>
  <input type="file" name="slide_image" class="form-control text-center" required="required" >
</label>

  <div>
<button type="submit" name="insert_slide" value="insert_slide" class="btn  btn-info mt-3">เพิ่ม</button>
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
