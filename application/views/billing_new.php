<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <!-- chosen CSS
		============================================ -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/chosen/bootstrap-chosen.css">
    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo base_url();?>/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>

    <section class="content">
        <div class="container-fluid">
		<div class="alert alert-success" id="success-alert" style="display:none;">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<strong>Success! </strong>
			Invoice has been added successfully
		</div>
 	    <div class="block-header">
                <h2>INVOICE</h2>


            </div>   
		<form name="billing_form" id="billing_form">
	   <div class="row">
		<div class="col-xs-12">
	    		<div class="row">
	    			 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="chosen-select-single mg-b-20">
                                                <label>Select Customer</label>
                                                <select data-placeholder="Choose a Customer..." tabindex="1" name="customer_select" id="customer_select" class="chosen-select" tabindex="-1">
						</select>
					    </div>

				 </div>
	    			 <div class="col-xs-6">
                                    <label>Date</label>
                                    <div class="form-group">
                                        <div class="form-line" id="bs_datepicker_container">
                                            <input type="text" id="invoice_date" class="form-control" name="date" style="padding:5px;" placeholder="Please choose a date...">
                                        </div>
                                    </div>
                                </div>
	    		</div>	    		
	    	</div>
	    </div>
		
		<div class="row clearfix" id="customerDetailsdiv">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card" style="border-radius:0px;">
                        <div class="header" style="padding:10px;">
                            <h5>
                                Customer Name                               
                            </h5>                            
                        </div>
                        <div class="body" style="padding:10px;">
                            <ol class="breadcrumb">
                                <li class="active" style="font-size:14px;" id="displayCustomerName"></li>
                            </ol>                           
                        </div>
                    </div>
            </div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card" style="border-radius:0px;">
                        <div class="header" style="padding:10px;">
                            <h5>
                                Customer Address                              
                            </h5>                            
                        </div>
                        <div class="body" style="padding:10px;">
                            <ol class="breadcrumb">
                                <li class="active" style="font-size:14px;" id="displayCustomerAddress"></li>
                            </ol>                           
                        </div>
                    </div>
            </div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card" style="border-radius:0px;">
                        <div class="header" style="padding:10px;">
                            <h5>
                                GST No                           
                            </h5>                            
                        </div>
                        <div class="body" style="padding:10px;">
                            <ol class="breadcrumb">
                                <li class="active" style="font-size:14px;" id="displayCustomerGst"></li>
                            </ol>                           
                        </div>
                    </div>
            </div>
		</div>
    
	    <div class="row" id="customer_body">
	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-heading">
	    				<h3 class="panel-title"><strong>Order summary</strong></h3> 
	    			</div>
	    			<div class="panel-body">
	    				<div class="row">
						<div class="col-md-12">
							<div class="col-md-3"><h5>Category</h5></div>
							<div class="col-md-2"><h5>Description</h5></div>
							<div class="col-md-1"><h5>Tax</h5></div>
							<div class="col-md-2"><h5>Quantity</h5></div>						
							<div class="col-md-2"><h5>Price</h5></div>
							<div class="col-md-2"><h5>Sub Total</h5></div>
						</div>
					</div>
					<div class="row" id="customer_billing_body">
										
					</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
		
		<div class="row" id="customerTotalsdiv" style="display:none;background-color:white;margin:0px;padding:15px;">
			<div class="col-md-12 text-left">
				<div class="col-md-3" style="float:right;">
					<strong>Total&nbsp;&nbsp;&nbsp;&nbsp;</strong><span id="tt">0</span>
					<input type="hidden" id="total" name="total" value="" />
				</div>
			</div>
			<div class="col-md-12 text-center">
				<div class="col-md-3 text-left" style="float:right;">
					Discount:<input type="radio" tabindex="99" id="under_0" checked="" name="discounttype" value="0"> <label for="under_0" class="light">Per %</label>
							<input type="radio" tabindex="100" id="over_1"  name="discounttype" value="1"> <label for="over_1" class="light">Amount</label>
				</div>
			</div>
			<div class="col-md-12 text-center">
				<div class="col-md-3 text-left" style="float:right;"><input type="text" class="form-control numm" tabindex="101" name="discountvalue" value="0" id="discountvalue" />
				</div>
			</div>
			<div class="col-md-12 text-left">
				<div class="col-md-3" style="float:right;"><strong>Final Total&nbsp;&nbsp;&nbsp;&nbsp;</strong><input type="text" id="finaltotal" name="finaltotal" class="form-control" readonly value="0" />
				</div>
			</div>
			<div class="col-md-12 text-center">
				<div class="col-md-4"></div>
				<div class="col-md-4"><button type="button" class="btn btn-success btn-block" id="save_billing" name="save_billing">Save</button></div>
			</div>
		</div>
		
		</form>
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

    <!-- Popover Js -->
    <script src="<?php echo base_url();?>/assets/js/pages/ui/tooltips-popovers.js"></script>
	
	<!-- SweetAlert Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- chosen JS
		============================================ -->
    <script src="<?php echo base_url();?>/assets/js/chosen/chosen.jquery.js"></script>
    <!--<script src="<?php echo base_url();?>/assets/js/chosen/chosen-active.js"></script>-->
	

    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url();?>/assets/js/admin.js"></script>
    <script src="<?php echo base_url();?>/custom/billing_new.js"></script>
	

</body>

</html>

