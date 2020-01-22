
<?php 
error_reporting(0);
session_start();

require 'config/config.php';

    $book_id = $_POST['book_id'];
    $price   = $_POST['price'];

if (isset($_POST['submit'])=='promotion') {
    require 'controller_pay_pro.php';
    $check =  new Promotion;
    $check->promotion = $_POST['promotion'];
    $promotion_id = $check->checkpromotion();
    if ($promotion_id >=1) {
        $sql = "SELECT*FROM promotion_detail WHERE promotion_detail_id= $promotion_id";
        $query = $conn->query($sql) or die("Last error: {$conn->error}");
        while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
            $cpromotion=$row['discount'];
        }
    }
}
if (isset($_POST['pay_ment'])=='pay_ment') {
    $file = $_FILES['image'];

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
                $filedestination = 'imgpay/' .$filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                require 'controller_pay_pro.php';
                $payinsert = new Pay;
                $payinsert->book_id=$_POST['book_id'];
                $payinsert->bank=$_POST['bank'];
                $payinsert->pay_date=$_POST['pay_date'];
                $payinsert->member_id = $_POST['member_id'];
                $payinsert->money =$_POST['money'];
                $payinsert->promotion_id =$_POST['promotion_id'];
                $payinsert->imgname = $filenamenew;
                $payinsert->insert();
              
            }
        }
    }
}

if (!$_SESSION['member_id']) {
        header("Location: login.php");
} else {
    $member_id=$_SESSION['member_id'];
    $sql2="SELECT * FROM member WHERE member.member_id='$member_id'";
    $result2 = $conn->query($sql2);
    $bookstatus = array("cancel", "Not paid",  "Checking", "approve", "Stay");
    while ($row = $result2->fetch_array(MYSQLI_ASSOC)) {
        include "public/header.php"

       
        
?>



    <!-- ##### About Us Area Start ##### -->
    <section class="about-us-area mt-5 pt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="about-text mb-100 text-center">
                        <div class="section-heading mt-5 pt-5">
                            <div class="line-"></div>
                            <h2>Promotion Code </h2>
                            <?php if($cpromotion != 0){  ?>
                              <p> your promotion code discount <?php echo $cpromotion; ?></p>
                            <?php }else{ ?>
                              <p> No discount</p>
                            <?php } ?>
                        </div>
                        
                        <form action="form_pay.php" method="POST" >
                        <input type="hidden" name="book_id"  value="<?php echo $book_id; ?>">
                      <input type="hidden" name="price"  value="<?php echo $price; ?>">
                        <input type="text" name="promotion" required="required" ><br>
                        <button type="submit" name="submit" value="promotion" 
                        placeholder="Your E-mail"
                         class="btn palatin-btn  mt-5">Click</button>
                        </form>

                    </div>
                </div>

                <div class="col-12 col-lg-6 ">
                    <div class="about-thumbnail mb-100">
                    <h2 class="text-center mb-3">Book bank</h2>
                 
            <?php 
        $sql="SELECT * FROM bank ORDER BY bank_id ASC";
        $result = $conn->query($sql);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
        ?>
                    <h3><?php echo $row['bank_id']; ?><?php echo $row['bank_name']; ?></h3>
        <?php } ?>
        
                      </div>




                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### About Us Area End ##### -->
    
    <!-- ##### About Us Area Start ##### -->
    <section class="about-us-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-12">
                    <div class="about-text mb-100 text-center">
                        <div class="section-heading ">
                            <div class="line-"></div>
                            <h2>Pay</h2>
                        </div>
                        
                        <form action="form_pay.php" method="POST"  enctype="multipart/form-data">
                    <table class="table table-responsive-md">
                      <tbody>
                        <tr>
                          <td class="text-center">Your payment :</td>
                          <td class="text-left">
                           <?php 
                          
                           if ($cpromotion==0){?>
                            <p>Total :<?php echo $price; ?></p>
                           <?php }else{
                              $sumprice = $price - (int)$cpromotion ;
                             ?>
                            <p>Total :<?php echo $sumprice; ?> (discount <?php echo $cpromotion; ?>)</p>

                           <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Bank:</td>
                          <td>
                          <select class="form-control" name="bank" id="select4">
                          <?php 
                      $sql="SELECT * FROM bank ORDER BY bank_id ASC";
                      $result = $conn->query($sql);
                      while($row = $result->fetch_array(MYSQLI_ASSOC)){
                      ?>
                                  <option value="<?php echo $row['bank_id']; ?>"><?php echo $row['bank_name']; ?></option>
                      <?php } ?>
                          </select>
                          </td>
                        </tr>

                        <tr>
                          <td>pay date:</td>
                          <td class="text-left"><input class="form-control text-center" type="datetime-local"  name="pay_date" ></td>
                        </tr>

                        <tr>
                          <td>You pay:</td>
                          <td class="text-left"><input type="text" class="form-control text-center"  name="money" ></td>
                        </tr>
                        
                        <tr>
                          <td>sLipt:</td>
                          <td class="text-left"> <input type="file" name="image" ></td>
                        </tr>


                      </tbody>
                    </table>
                    <input type="hidden" name="promotion_id"  value="<?php echo $promotion_id; ?>">
                    <input type="hidden" name="member_id"  value="<?php echo $member_id; ?>">
                    <input type="hidden" name="book_id"  value="<?php echo $book_id; ?>">
                        <button type="submit" name="pay_ment" value="pay_ment" 
                        placeholder="Your E-mail"
                         class="btn palatin-btn  mt-5">Click</button>
                        </form>

                    </div>
                </div>



                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### About Us Area End ##### -->


<?php  include "public/footer.php"?>
    <?php
    }
} ?>