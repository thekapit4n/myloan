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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/polo/css/plugins.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/polo/css/style.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom/sweetalert2/dist/sweetalert2.css?v=<?php echo time() ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/custom/select2_boostrap4/dist/select2-bootstrap4.min.css">
</head>
<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Header -->
        <header id="header" data-fullwidth="true" class="dark">
            <div class="header-inner">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="<?php echo base_url()?>dashboard/">
                            <span class="logo-default">MyLoan</span>
                            <span class="logo-dark">MyLoan</span>
                        </a>
                    </div>
                    <!--End: Logo-->
                    <!--Navigation-->
                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
									<?php
									if($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin')
									{
									?>
										<li><a href="<?php echo base_url() ?>crm/loan_listing">Manage Loan</a></li>
									<?php
									}
									elseif($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'user')
									{
									?>
										<li><a href="<?php echo base_url() ?>dashboard/">Home</a></li>
										<li><a href="<?php echo base_url() ?>dashboard/loan_listing">My Loan</a></li>
									<?php
									}
									?>
                                    <li><a href="<?php echo base_url() ?>login/sayonara">Log Out</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--end: Navigation-->
                </div>
            </div>
        </header>
        <!-- end: Header -->