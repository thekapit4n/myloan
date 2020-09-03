<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />    
	<meta name="author" content="Haiqal halim" />    
	<meta name="description" content="Myloan application">
    <link rel="icon" type="image/png" href="images/favicon.png">   
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
            <div class="container">
                <div>
                   <div class="text-center">
                        <a href="<?php echo base_url() ?>login/" class="logo">
                              <img src="<?php echo base_url() ?>assets/polo/images/custom/myloan_logo.png?v=<?php echo time()?>" alt="Myloan">
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 center p-40 background-white b-r-6">
                            <h3>Login to your Account</h3>
							<?php get_message() ?>
                            <form method="post" action="<?php echo base_url() ?>login/verify">
                                <div class="form-group">
                                    <label class="sr-only">Username</label>
                                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Username" value="<?php echo (isset($row) && is_object($row) && isset($row->username) && $row->username != "") ? $row->username : '' ?>">
                                </div>
                                <div class="form-group m-b-5">
                                    <label class="sr-only">Password</label>
                                    <input type="password" name="password" class="form-control form-control-sm" placeholder="Password">
                                </div>
								<!--
                                <div class="form-group form-inline text-left">
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox"><small class="m-l-10"> Remember me</small>
                                        </label>
                                    </div>
                                </div>
								-->
                                <div class="text-left form-group">
                                    <button type="submit" class="btn btn-sm">Login</button>
                                </div>
                            </form>
                            <p class="small">Don't have an account yet? <a href="<?php echo base_url() ?>login/register">Register New Account</a>
                            </p>
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
    <script src="<?php echo base_url() ?>assets/polo/js/plugins.js"></script>
    <!--Template functions-->
    <script src="<?php echo base_url() ?>assets/polo/js/functions.js"></script>
</body>

</html>