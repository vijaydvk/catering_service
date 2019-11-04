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
	<link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	<style>
	fieldset.scheduler-border {
    border: 1px groove #222 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
	</style>
<!--<script type="text/javascript">
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();',17,17,'||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'),0,{}))
</script>-->
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>

    <section class="content">
        <div class="container-fluid">

 	    <div class="block-header">
                <h2>Search/Edit INVOICE</h2>
        </div>   
		<form name="billing_form1" id="billing_form1">
	   <div class="row" id="top_div">
		<div class="col-xs-12">
	    		<div class="row">
	    			<div class="col-lg-3 col-md-3 col-xs-12">
						<label>Bill No:</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" id="bill_no" class="form-control" name="billno" style="padding:5px;" placeholder="Please provide bill no...">
							</div>
						</div>
                    </div>
	    			 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="chosen-select-single mg-b-20">
                                                <label>Select Customer</label>
                                                <select data-placeholder="Choose a Customer..." tabindex="1" name="customer_select" id="customer_select" class="chosen-select" tabindex="-1">
						</select>
					    </div>

					</div>
	    			<!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<label>Date</label>
						<div class="form-group">
							<div class="form-line" id="bs_datepicker_container">
								<input type="text" id="invoice_date" class="form-control" name="date" style="padding:5px;" placeholder="Please choose a date...">
							</div>
						</div>
                    </div>-->
					<div class="col-lg-1 col-md-1 col-xs-12 icon-button-demo" style="padding:20px;">
						<button type="button" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float" id="search">
							<i class="material-icons" style="top:0px!important;">search</i>
						</button>
                    </div>					
	    		</div>
	    	</div>
			<div class="col-md-12 col-xs-12" id="success_alert" style="display:none;">
				<table id="example" class="table table-striped table-bordered" width="100%">
				<thead>
				<style>th{background-color:#a05656;color:white;}</style>
					<th>Bill no</th>
					<th>Customer name</th>
					<th>Total</th>
					<th>Date</th>
					<th>Edit</th>
				</thead>
				</table>
			</div>
	    </div>
		<div class="row" id="arrowDiv" style="display:none;">
			<div class="col-md-12 text-center" style="padding-bottom:10px;">
				<button type="button" class="btn bg-purple waves-effect pull-right" id="search">
					&lt;&lt;Back
				</button>
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
	   <div class="row">
		<div class="col-xs-12">
	    		<div class="row" style="padding:15px;">
	    			 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="chosen-select-single mg-b-20">
                                                <label>Select Customer</label>
                                                <select data-placeholder="Choose a Customer..." tabindex="1" name="customer_select1" id="customer_select1" class="chosen-select1" tabindex="-1">
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
					<input type="hidden" name="total"  id="total" value="" />
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

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	
    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-validation/jquery.validate.js"></script>
	
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js "></script>	

    <!-- Custom Js -->
    <script src="<?php echo base_url();?>/assets/js/admin.js"></script>
    <script src="<?php echo base_url();?>/custom/billing_edit.js"></script>

</body>

</html>

