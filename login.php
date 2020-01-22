
<?php 
error_reporting(0);
session_start();
include("public/header.php") ; 
require_once 'controller_user.php';
?>
<?php 
if(isset($_POST['login'])){
    $login = new User;
    $login->username = $_POST['username'];
    $login->password = $_POST['password'];
    $member_id = $login->login();

}
?>
    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">

            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url(public/img/bg-img/bg-1.jpg);"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-6">
                            <!-- Slide Content -->
                            <div class="hero-slides-content justify-content-center" data-animation="fadeInUp" data-delay="100ms">
                                <div class="line" data-animation="fadeInUp" data-delay="300ms"></div>
                                <h2 data-animation="fadeInUp" data-delay="500ms"> Login </h2>
                                <form action="login.php" method="POST" class="subscribe-form">
                                    <table data-animation="fadeInUp" data-delay="700ms">
                                        <tbody>
                                            <th>
                                                
                                                <tr class="line"><input class="btn palatin-btn mt-50" type="text" name="username"  placeholder="Username"></tr>
                                            </th>
                                            <th>
                                              
                                                <tr class="line"><input type="password" class="btn palatin-btn mt-50" name="password" placeholder=" Password" ></tr>
                                            </th>
                                        
                                            
                                        </tbody>
                                    </table>
                               
                                
                                <button class="btn palatin-btn mt-50" name="login" data-animation="fadeInUp" data-delay="900ms">Config</button> 
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </section>
    <!-- ##### Hero Area End ##### -->
<?php include("public/footer.php") ; ?>