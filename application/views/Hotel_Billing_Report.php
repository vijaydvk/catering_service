<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
	<link href="<?php echo base_url();?>/assets/css/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">	
	
	
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
                <h2>Hotel Billing Report</h2>
            </div>
			<div class="col-md-12">
			<div class="col-xs-6">
				<label>From Date</label>
				<div class="form-group">
					<div class="form-line" id="bs_datepicker_container">
						<input type="text" id="from_date" class="form-control valid" name="from_date" style="padding:5px;" placeholder="Please choose a date..." aria-invalid="false">
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<label>To Date</label>
				<div class="form-group">
					<div class="form-line" id="bs_datepicker_container1">
						<input type="text" id="to_date" class="form-control valid" name="to_date" style="padding:5px;" placeholder="Please choose a date..." aria-invalid="false">
					</div>
				</div>
			</div>	
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<div class="btn btn-success btn-block" id="Generate_Report">Generate</div>
			</div>
			</div>
		<div class="col-md-12" style="margin-top:15px;">
		
			
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;display:none;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Bill no</th>
				<th>Date</th>
				<th>Bill Total</th>				
				<th>Tax (5%)</th>
				<th>Total</th>
			</thead>
			<tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>				
            </tr>
        </tfoot>
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
								<style>th{background-color:#a05656;color:white;}td{color:black!important;}</style>
									<th>Product Name</th>
									<th>Quantity</th>
									<th>Amount</th>
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
    <script src="<?php echo base_url();?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

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
    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>	
	
    <!-- Custom Js -->
    <script src="<?php echo base_url();?>/assets/js/admin.js"></script>
	<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
	<script src="<?php echo base_url();?>/assets/js/jspdf.debug.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>	
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
 	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js "></script>	
 
	
	<script src="<?php echo base_url();?>/assets/js/html2pdf.js"></script>
    <script src="<?php echo base_url();?>/assets/js/sweetalert.js"></script>
    <script src="<?php echo base_url();?>/custom/Hotel_Billing_Report.js"></script>

</body>

</html>
