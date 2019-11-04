<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
	<link href="<?php echo base_url();?>/assets/css/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />		
    <style>
        td{font-weight:600;padding:0px 10px;font-size:12px;padding:3px!important;font-size:10px;}
		tr{text-align:right;font-size:12px;padding:3px!important;font-size:10px;}
    </style>
</head>

<body class="theme-green" style="background-color:white;font-family:'Roboto', Arial, Tahoma, sans-serif;font-size:10px;">
    <div class="container-fluid p-0" style="margin:0%;margin-top:1%;" id="typing">
             <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
						Date:<input type="date" id="date"><br><br>
                            <textarea id="ckeditor">
                                <p style="float:right;" id="date">dfdsfsdf</p>
                            </textarea>
                        </div>
                    </div>
                </div>	
					<center><button class="btn btn-success" id="make_letter">Make letter</button></center>
			</div>
	</div>
	
    <div class="container-fluid p-0" style="margin:0%;margin-top:1%;max-width:620px;min-width:620px;display:none;" id="display">
            <div class="col-md-12 p-0" style="border-bottom: 1px solid brown;padding:0px;">
                <div class="col-md-6 p-0">
					<img src="<?php echo base_url();?>/assets/images/logo.png" width="75" height="75" alt="Logo" style="border-radius:100px;" />				
				</div>
				<div class="col-md-4" style="padding:0;float:right">
					Food Corridor Caterers<br>
					info@foodcorridor.in<br>
					97518 08080</br>
					<A HREF="http://www.foodcorridor.in/">www.foodcorridor.in</A><br>
					14, Airport Main Road, SITRO, Coimbatore,</br>
					Tamil Nadu - 641014</br>
				</div>				
            </div>
			<div class="col-md-12 p-0" id="content" style="padding:0px;padding-bottom:10px;">
			</div>
	</div>
	

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>/assets/plugins/ckeditor/ckeditor.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>/assets/html2canvas.js"></script>
	<script src="<?php echo base_url();?>/assets/js/jspdf.debug.js"></script>
	
<script>
$(document).ready(function(){ 
//$("#date").val(new Date().toISOString().substring(0, 10));
	    CKEDITOR.replace('ckeditor');
		CKEDITOR.config.height = 300;
		//alert($('#ckeditor').val());
		$('#make_letter').click(function(){
				var today = new Date($('#date').val());
				var dd = today.getDate();
				var mm = today.getMonth() + 1; //January is 0!

				var yyyy = today.getFullYear();
				if (dd < 10) {
				  dd = '0' + dd;
				} 
				if (mm < 10) {
				  mm = '0' + mm;
				} 
				var today = dd + '/' + mm + '/' + yyyy;
			//console.log(CKEDITOR.instances.ckeditor.getData());
			var datee = "<div style='float:right;'>DATE:"+today+"</div><br>";
			$('#content').html(datee+CKEDITOR.instances.ckeditor.getData());
			$('#display').show();
			$('#typing').hide();
			 var pdf = new jsPDF('p', 'pt', 'letter');
			var width = 600;
			document.body.style.width=width + "px";
			pdf.html(document.getElementById("display"), {callback: function(pdf) {
				var iframe = document.createElement('iframe');
				iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:100%');
				document.body.appendChild(iframe);
				pdf.setPage(pdf.internal.getNumberOfPages())
				// The 10,200 value is only for A4 landscape. You need to define your own for other page sizes
				pdf.text("Thank you visit again",10,780)
				iframe.src = pdf.output('datauristring');
				$('#display').hide();
				//console.log(pdf.internal.getNumberOfPages());
			}
			}); 
			
		});
});
</script>
</body>

</html>
