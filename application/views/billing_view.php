<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
	<link href="<?php echo base_url();?>/assets/css/sweetalert.css" rel="stylesheet">
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
                <h2>Invoice DASHBOARD</h2>
            </div>
		<div class="col-md-12" style="margin-top:15px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Bill no</th>
				<th>Customer Name</th>				
				<th>Date</th>
				<th>Discount Type</th>
				<th>Discount Amount</th>
				<th>Amount</th>
				<th>View Details</th>
				<th>Proceed</th>
				<th>Print</th>
				<th>Action</th>				
			</thead>
		</table>
		</div>
		<div class="col-md-12 text-center">
			<button type="button" data-color="green" id="proceed_button" class="btn bg-green waves-effect" style="background-color:#a05656!important;display:none;">Proceed</button>
		</div>

           <!-- Large Size -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content modal-col-green card">
                        <div class="modal-header" style="padding:15px;background-color:#780e0e;">
							<button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="largeModalLabel">Invoice Details</h4>
                        </div>
                        <div class="modal-body body" style="background-color:white;">
							<table id="invoiceDetails" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
								<thead>
								<style>th{background-color:#a05656;color:white;}</style>
									<th>Category</th>
									<th>Tax</th>
									<th>quantity</th>
									<th>Amount</th>
									<th>Total</th>
								</thead>
								<tbody id="detailsDisp">
								</tbody>
							</table>				
                        </div>
                    </div>
                </div>
            </div>
		<div class="row" id="dispBill" style="display:none;text-center"><center>
			<div class="col-md-12 align-items-centerr" style="margin-top:15px;" >
			<table id="pdfbill" class="table table-striped table-bordered" style="font-size:12px;">
				<thead>
				<style>th{background-color:#a05656;color:white;}</style>
					<th>Category</th>
					<th>Tax</th>
					<th>Quantity</th>
					<th>Amount</th>
					<th>Total</th>
				</thead>
				<tbody id="billdetailDisp">
				</tbody>
			</table>
			</div></center>
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
	<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
	<script src="<?php echo base_url();?>/assets/js/jspdf.debug.js"></script>
	<script src="<?php echo base_url();?>/assets/js/html2pdf.js"></script>
    <script src="<?php echo base_url();?>/assets/js/sweetalert.js"></script>
    <script src="<?php echo base_url();?>/custom/billing_view.js"></script>

</body>

</html>
