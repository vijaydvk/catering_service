<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
	<!--<link href="<?php echo base_url();?>/assets/css/sweetalert.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <style>
        td{font-weight:600;}
    </style>
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Bill DASHBOARD</h2>
            </div>
		<div class="col-md-12" style="margin-top:15px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Bill Detail</th>
				<th>Customer Name</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Action</th>
			</thead>
		</table>
		</div>
		<div class="col-md-12"><div id="total_amt_disp"></div></div>
		<div class="col-md-12 text-center">
			<button type="button" data-color="green" id="proceed_button" class="btn bg-green waves-effect" style="background-color:#a05656!important;display:none;">Proceed</button>
		</div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <!--<script src="<?php echo base_url();?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>-->

    <!-- Slimscroll Plugin Js -->
    <!--<script src="<?php echo base_url();?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>-->

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url();?>/assets/plugins/morrisjs/morris.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js "></script>
	<script src="<?php echo base_url();?>/assets/js/pages/ui/tooltips-popovers.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url();?>/assets/js/admin.js"></script>
    <!--<script src="<?php echo base_url();?>/assets/js/sweetalert.js"></script>-->
	<link href="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>
    <script src="<?php echo base_url();?>/custom/billing_initiated.js"></script>

</body>

</html>
