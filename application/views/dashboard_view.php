<!DOCTYPE html>
<html>

<head>
<?php require('components/header.php');?>
<style>
.m-50
{
	display:table-cell;
    vertical-align:middle;
    text-align:center;
}
.p-50
{
	padding-left:20%!important;
}
a {text-decoration: none;}
</style>
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>
 
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url();?>/foodcorridor_controller/billing_new"><div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content p-50">
                            <h5>NEW BILL</h5>
							Click Here!
                        </div>
                    </div></a>
                </div>
                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url();?>/foodcorridor_controller/customer_view"><div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="content p-50">
                            <h5>CUSTOMERS</h5>
							Click Here!
                        </div>
                    </div></a>
                </div>
                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url();?>/foodcorridor_controller/invoice_report"><div class="info-box bg-brown hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="content p-50">
                            <h5>INVOICE</h5>
							Click Here!
                        </div>
                    </div></a>
                </div>	
                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url();?>/foodcorridor_controller/billing_initiated"><div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">notifications</i>
                        </div>
                        <div class="content p-50">
							<span class="label-count" style="font-size:14px;padding:10px;">7</span>
                            <h5>Notification</h5>
							Click Here!
                        </div>
                    </div></a>
                </div>	
                 <?php if($this->session->userdata('username')=="admin"){ ?>
                 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col-lg-offset-4">
                    <a href="<?php echo base_url();?>/foodcorridor_controller/billing_view"><div class="info-box bg-teal hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">money</i>
                        </div>
                        <div class="content p-50">
							<h5>Balance Amount</h5>
                            <h5>Rs: <span id="balance_display">Amount</span>/-</h5>
                        </div>
                    </div></a>
                </div>
                <?php }?>
            </div>
            <!-- #END# Widgets -->
 
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <!--<script src="<?php echo base_url();?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>-->

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url();?>/assets/plugins/morrisjs/morris.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url();?>/assets/js/admin.js"></script>

    <script src="<?php echo base_url();?>/custom/notification.js"></script>	
</body>

</html>
