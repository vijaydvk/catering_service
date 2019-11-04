<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <style>
        td{font-weight:600;}
    </style>
</head>

<body class="theme-green">
    <?php require('components/toppanel.php');?>
    <?php require('components/leftpanel.php');?>

    <section class="content">
        <div class="container-fluid" id="firstDiv">
            <div class="block-header">
                <h2>FOOD CATEGORY</h2>
            </div>

		<button type="button" data-color="green" id="new_button" class="btn bg-green waves-effect" style="background-color:#a05656!important;">New Category</button>
		<div class="col-md-12" style="margin-top:15px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th>Category</th>
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
		                        <div class="col-xs-12 m-b-0">
		                            <h2 class="card-inside-title">Category</h2>
		                            <div class="form-group">
		                                <div class="form-line">
		                                    <input type="text" id="food_type" name="food_type" class="form-control valid" placeholder="Please fill category name...">
		                                </div>
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
    <script src="<?php echo base_url();?>/custom/category.js"></script>

</body>

</html>
