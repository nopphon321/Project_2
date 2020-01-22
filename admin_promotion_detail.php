
<?php
session_start();
require 'config/config.php';
if(isset($_POST['detail'])=='detail'){
  require 'controller_promotion.php';
  $insert = new insert_pro_detail;
  $insert->promotion_id = $_POST['promotion_id'];
  $insert->promotion_code = $_POST['promotion_code'];
  $insert->discount = $_POST['discount'];
  $insert->Insert_detail();
}
if(isset($_POST['delete'])=='delete'){
  require 'controller_promotion.php';
  $delete = new Detail_delete;
  $delete->promotion_detail_id = $_POST['promotion_detail_id'];
  $delete->delete();
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
$promotion = array("ใช้แล้ว", "ยังไม่ใช้");
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
              <th>รหัสโปรโมชั่น</th>
              <th>discount</th>
              <th>สถานะโปรโมชั่น</th>
              <th class="text-center">ลบ</th>
            </tr>
          </thead>
          <tbody>
          <?php
$i=1;
$sql="SELECT * FROM promotion_detail INNER JOIN promotion ON promotion_detail.promotion_id = promotion.promotion_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>



            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['promotion_name']; ?></td>
              <td><?php echo $row['promotion_code']; ?></td>
              <td><?php echo $row['discount'] ;?></td>
              <td class="text-center"><div class="text-center btn btn-<?php if($row['promotion_status']=='1'){
                echo "success";}else{ echo "secondary" ;} ?> "><?php echo $promotion[$row['promotion_status']]; ?><div></td>
              <td class="text-center"><form action="admin_promotion_detail.php" method="POST" >
              <input name="promotion_detail_id" type="hidden" value="<?php echo $row['promotion_detail_id']; ?>">
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

          <form action="admin_promotion_detail.php"  method="POST">
<label>
  <div class="text-center">เลือกโปรโมชั่น</div>
  <select class="form-control" name="promotion_id" id="select4">
                          <?php 
                      $sql="SELECT * FROM promotion ORDER BY promotion_id ASC";
                      $result = $conn->query($sql);
                      while($row = $result->fetch_array(MYSQLI_ASSOC)){
                      ?>
                                  <option value="<?php echo $row['promotion_id']; ?>"><?php echo $row['promotion_name']; ?></option>
                      <?php } ?>
                          </select>
</label><br>
<label>
  <div class="text-center">CODE โปรโมชั่น</div>
  <input  type="text" name="promotion_code"      class="form-control" required="required">
</label><br>
<label>
  <div class="text-center">ลดราคา</div>
  <input  type="text" name="discount"   class="form-control" required="required">
</label><br>
<label>
  <div>
<button type="submit" name="detail" value="detail" class="btn  btn-info mt-3">เพิ่ม</button>
  </div>
</label>
          </form> 

          </div>
</div>


          <!-- seach date -->

<?php include 'admin_framwork/footer.php' ?>
<?php }  
} 
?>
