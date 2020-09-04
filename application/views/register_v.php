<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />    
	<meta name="author" content="Haiqal halim" />    
	<meta name="description" content="Myloan application">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/polo/images/myloan.ico">   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Document title -->
    <title>My Loan Application</title>
    <!-- Stylesheets & Fonts -->
    <link href="<?php echo base_url() ?>assets/polo/css/plugins.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/polo/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Section -->
         <section class="fullscreen" data-bg-parallax="<?php echo base_url() ?>assets/polo/images/custom/calc_bg.jpg?v=<?php echo time()?>">
            <div class="container container-fullscreen">
                <div class="text-middle">
                    <div class="text-center">
                        <a href="<?php echo base_url() ?>login/" class="logo">
                              <img src="<?php echo base_url() ?>assets/polo/images/custom/myloan_logo.png?v=<?php echo time()?>" alt="Myloan">
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 center p-40 background-white b-r-6">
                            <form class="form-transparent-grey" method="post" action="<?php echo base_url() ?>login/manage_registration">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Register New Account</h3>
                                        <p>Create an account by entering the information below. If you are a returning customer please back to login page.</p>
                                    </div>
									<?php get_message() ?>
                                    <div class="col-lg-12 form-group">
                                        <label class="sr-only">Full Name</label>
                                        <input type="text" name="fullname" class="form-control form-control-sm" value="<?php echo (isset($row) && is_object($row) && isset($row->fullname) && $row->fullname != "") ? $row->fullname : '' ?>" placeholder="Fullname" >
                                    </div>
                                   
                                    <div class="col-lg-12 form-group">
                                        <label class="sr-only">Username</label>
                                        <input type="text" name="username" class="form-control form-control-sm" value="<?php echo (isset($row) && is_object($row) && isset($row->username) && $row->username != "") ? $row->username : '' ?>" placeholder="Username" >
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label class="sr-only">Password</label>
										<div class="input-group mb-3">
											<input type="password" name="password" class="form-control form-control-sm" value="" placeholder="Password" >
											<div class="input-group-append">
												<?php 
													$tooltip = "Password must contain at least : <br/>1 upper case <br/>1 lower case <br/>1 digit <br/>1 special character<br/> the minimum length should be 8</ul>";
												?>
												<span class="input-group-text" id="basic-addon2" data-html="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $tooltip ?>"><i class="fas fa-info-circle text-info"></i></span>
											</div>
										</div>
                                    </div> 
									<div class="col-lg-12 form-group">
                                        <label class="sr-only">Confirm Pasword</label>
                                        <input type="password" name="confirm_password" class="form-control form-control-sm" value="" placeholder="Confirm Password" >
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <a href="<?php echo base_url() ?>login/" class="btn btn btn-sm btn-danger m-l-10">Back to login page</a>
                                        <button class="btn btn btn-sm btn-success" type="submit">Submit </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: Section -->
    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
	<script src="<?php echo base_url() ?>assets/polo/js/jquery.js"></script>
	<script src="https://kit.fontawesome.com/c1aa1e2012.js" crossorigin="anonymous"></script>
	<script src="<?php echo base_url() ?>assets/polo/plugins/popper/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/polo/js/plugins.js"></script>
    <!--Template functions-->
    <script src="<?php echo base_url() ?>assets/polo/js/functions.js"></script>
</body>

</html>