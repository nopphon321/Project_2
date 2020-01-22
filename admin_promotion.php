
<?php
session_start();
require 'config/config.php';
if(isset($_POST['insert_promotion'])=='insert_promotion'){
  require 'controller_promotion.php';
  $inser = new insert_promotion;
  $inser->promotion_name = $_POST['promotion_name'];
  $inser->promotion_detail= $_POST['promotion_detail'];
  $inser->promotion_date = $_POST['promotion_date'];
  $save = $inser->insert();

}
if(isset($_POST['save'])=='save'){
  require 'controller_promotion.php';
  $save = new update_promotion;
  $save->promotion_name = $_POST['promotion_name'];
  $save->promotion_detail = $_POST['promotion_detail'];
  $save->promotion_id = $_POST['promotion_id'];
  $save->update();

}
if (isset($_POST['delete'])=='delete'){
  require 'controller_promotion.php';
  $delete = new Delete;
  $delete->promotion_id = $_POST['promotion_id'];
  $delete->delete_promotion();
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
            <a href="admin_promotion.php">Promotion</a>
          </li>
          <li class="breadcrumb-item active">Promotion</li>
        </ol>

        <!-- Icon Cards-->
        <!-- <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">26 New Messages!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">11 New Tasks!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">123 New Orders!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">13 New Tickets!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div> -->

        <!-- Area Chart Example-->
        <!-- <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div> -->
<!-- if edit -->
<?php 
          if(isset($_POST['edit'])=='edit'){?>
               <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
           Promotion List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered text-center"   width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ชื่อโปรโมชั่น</th>
              <th>รายละเอียดโปรโมชั่น</th>
              <th>วันที่ออกโปรโมชั่น</th>
              <th class="text-center">แก้ไข</th>
            </tr>
          </thead>
          <tbody>
            
          <?php   $promotion_id = $_POST['promotion_id'];
            $sql="SELECT * FROM promotion WHERE promotion_id = $promotion_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    ?>
          <form action="admin_promotion.php" method="POST">
          <tr>
            <td><input name="promotion_name" type="text" class="form-control" value="<?php echo $row['promotion_name'] ; ?>"></td>
            <td><input name="promotion_detail" type="text" class="form-control" value="<?php echo $row['promotion_detail'] ; ?>"></td>
            <td><?php   echo date_format(date_create($row['promotion_date']), "d/m/Y"); ?></td>
            <td class="text-center">

              <input name="promotion_id" type="hidden" value="<?php echo $row['promotion_id']; ?>">
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
           Promotion List</div>
          <div class="card-body">
          <div class="table-responsive">
              <table
              class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>รายการ</th>
              <th>ชื่อโปรโมชั่น</th>
              <th>รายละเอียดโปรโมชั่น</th>
              <th>วันที่ออกโปรโมชั่น</th>
              <th class="text-center">แก้ไข</th>
              <th class="text-center">ลบ</th>
            </tr>
          </thead>
          <tbody>
          <?php
$i=1;
$sql="SELECT * FROM promotion";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>



            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['promotion_name']; ?></td>
              <td><?php echo $row['promotion_detail']; ?></td>
              <td><?php   echo date_format(date_create($row['promotion_date']), "d/m/Y"); ?></td>
              <td class="text-center">
              <form action="admin_promotion.php" method="POST" >
              <input name="promotion_id" type="hidden" value="<?php echo $row['promotion_id']; ?>">
              <button type="submit" name="edit" value="edit" class="btn btn-info">Edit</button>
              </form></td>
              <td class="text-center"><form action="admin_promotion.php" method="POST" >
              <input name="promotion_id" type="hidden" value="<?php echo $row['promotion_id']; ?>">
              <button onclick="return confirm('ยืนยันการลบอีกครั้ง อีกครั้ง')" type="submit" name="delete" value="delete" class="btn btn-danger">delete</button>
              </form></td>
            </tr>
    <?php $i++;
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

          <form action="admin_promotion.php"  method="POST">
<label>
  <div class="text-left">ชื่อโปรโมชั่น</div>
  <input  type="text" name="promotion_name"   class="form-control" required="required">
</label>
<label>
  <div class="text-left">วันออกโปรโมชั่น</div>
  <input  type="date" name="promotion_date"   value="<?php echo $nowdate; ?>" class="form-control" required="required">
</label>
<div>รายละเอียดโปรโมชั่น</div>
  <textarea  type ="text"name="promotion_detail" class="form-control"  rows="3"></textarea>

<label>
  <div>
<button type="submit" name="insert_promotion" value="insert_promotion" class="btn  btn-info mt-3">เพิ่ม</button>
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
