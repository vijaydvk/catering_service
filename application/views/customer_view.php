<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <style>
        td{font-weight:600;}
		.address {
				max-width: 150px!important;
				text-overflow: ellipsis!important;
				white-space: nowrap!important;
				overflow: hidden!important; 
			}
    </style>
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>

    <section class="content">
        <div class="container-fluid" id="firstDiv">
            <div class="block-header">
                <h2>CUSTOMER DASHBOARD</h2>
            </div>

		<button type="button" data-color="green" id="new_button" class="btn bg-green waves-effect" style="background-color:#a05656!important;">New Customer</button>
		<div class="col-md-12" style="margin-top:15px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Name</th>
				<th>Phone no</th>
				<th>Email</th>
				<th>Address</th>
				<th>Credit Limit</th>
				<th>Food Category</th>
				<th>Login</th>
				<th>Make Invoice</th>				
				<th>Edit</th>
			</thead>
		</table>
		</div>

           <!-- Large Size -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content modal-col-green card">
                        <div class="modal-header" style="padding:15px;background-color:#780e0e;">
                            <h4 class="modal-title" id="largeModalLabel">Customer</h4>
                        </div>
                        <div class="modal-body body" style="background-color:white;">
				<form name="form" id="form">
                        	<div class="row clearfix">
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Customer Name</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_name" name="customer_name" class="form-control valid" placeholder="Please fill name...">
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Phone number</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_phonenumber" name="customer_phonenumber" class="form-control nan" placeholder="Please fill number...">
		                                </div>
		                            </div>
		                        </div>
				</div>
                        	<div class="row clearfix">
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Email</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="email" id="customer_email" name="customer_email" class="form-control" placeholder="Please fill email...">
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Password</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_pass" name="customer_pass" class="form-control" placeholder="Please fill password...">
		                                </div>
		                            </div>
		                        </div>
                            </div>
                            <div class="row clearfix">
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">address</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <textarea class="form-control" id="customer_address" name="customer_address" placeholder="Please fill address..." rows="1"></textarea>
		                                </div>
		                            </div>
		                        </div>

		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Credit limit</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_creditlimit" name="customer_creditlimit" class="form-control" placeholder="Please fill credit...">
		                                </div>
		                            </div>
		                        </div>
		                    </div>
                            <div class="row clearfix">
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">GST</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_gst"name="customer_gst" class="form-control" placeholder="Please fill name...">
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Alternative Phone</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="customer_alernative_phonenumber" name="customer_alernative_phonenumber" class="form-control" placeholder="Please fill number...">
		                                </div>
		                            </div>
		                        </div>
				             </div>
                        	<div class="row clearfix">
		                        <div class="col-xs-12 m-b-0 p-0 text-center" style="padding-right:0px;">
		                            <!--<h2 class="card-inside-title">Food Type</h2>-->
		                            <div class="form-group">
		                                <div class="form-line1">
		                                <button type="button" id="fd_add" class="btn btn-success btn-circle waves-effect waves-circle waves-float"><i class="material-icons">add</i>
                                		    </button>
						<button type="button" id="fd_remove" class="btn btn-danger btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">remove</i>
                                </button>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Category</h2>
		                            <div class="form-group" id="fd_cat">
		                               
		                            </div>
		                        </div>
		                        <div class="col-xs-6 m-b-0">
		                            <h2 class="card-inside-title">Amount</h2>
		                            <div class="form-group" id="fd_amt">
		                               
		                            </div>
		                        </div>
				</div>
                        </div>
                        <div class="modal-footer" style="background-color:#a05656">
                            <button type="button" class="btn btn-link waves-effect" id="save">SAVE CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
			</form>
                    </div>
                </div>
            </div>
 
        </div>
		
        <div class="container-fluid" id="secondDiv" style="display:none;">
            <div class="block-header">
                <h2>Bill DASHBOARD</h2>
            </div>
		<center><i class="material-icons" style="font-size: 48px;cursor:pointer;" id="closeDiv">keyboard_arrow_up</i></center>
		<div class="col-md-12" style="margin-top:15px;">
		<table id="dataTable2" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Bill no</th>
				<th>Date</th>
				<th>Amount</th>
				<th>View Details</th>
				<th>Action</th>
			</thead>
		</table>
		</div>
		<div class="col-md-12"><div id="total_amt_disp" style="font-size:18px;color:brown;"></div></div>
		<div class="col-md-12 text-center">
			<button type="button" data-color="green" id="proceed_button" class="btn bg-green waves-effect" style="background-color:#a05656!important;display:none;">Generate Invoice</button>
		</div>

           <!-- Large Size -->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
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
									<th>SubTotal</th>
								</thead>
								<tbody id="detailsDisp">
								</tbody>
							</table>
						
							</div>
                        </div>
						
                    </div>
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
	<link href="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.css" rel="stylesheet"/>
	<script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>
    <script src="<?php echo base_url();?>/custom/customer.js"></script>

</body>

</html>
