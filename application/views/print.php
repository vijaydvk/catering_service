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
		tr{text-align:left;font-size:12px;padding:3px!important;font-size:10px;}
    </style>
</head>

<body class="theme-green" style="background-color:white;font-family:'Roboto', Arial, Tahoma, sans-serif;font-size:10px;">
        <div class="container-fluid p-0" style="margin:0%;margin-top:1%;width:620px;">
            <div class="col-md-12 p-0" style="border-bottom: 1px solid brown;padding:0px;padding-bottom:10px;">
                <div class="col-md-6 p-0">
					<img src="<?php echo base_url();?>/assets/images/logo.png" width="75" height="75" alt="Logo" style="border-radius:100px;" />				
				</div>
				<div class="col-md-6 text-left" style="float:right;">
					<table style="float:right;font-size:10px;">
						<tr><td class="text-left">ID:</td><td class="text-left"><?php echo $invoice[0]->invoice_id;?></td></tr>
						<tr><td class="text-left">Date:</td><td class="text-left"><?php echo $invoice[0]->date;?></td></tr>
						<tr><td class="text-left">GSTIN:</td><td class="text-left">338NDPP4829H1ZX</td></tr>
						<tr><td class="text-left">Trade Name:</td><td class="text-left">Food Corridor Caterers</td></tr>
					</table>
				</div>
            </div>
			TO: <b><?php echo $invoice[0]->customer_name;?></b>,<?php echo $invoice[0]->customer_address;?>
		<div class="col-md-12" style="margin-top:15px;min-height:500px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th class="text-left">S NO</th>
				<th class="text-left">Item</th>
				<th class="text-left">Qty</th>
				<th class="text-left">Rate(Rs)</th>
				<th class="text-left">Amount(Rs)</th>
				<th class="text-left">Tax %</th>
				<th class="text-left">Tax(Rs)</th>
				<th class="text-left">Total(Rs)</th>
			</thead>
			<tbody>
			<?php
				$count=0;
				$ttotal=0;
				$tsubtotal=0;
				$ttax=0;
				foreach($invoice_details as $value)
				{
					$count++;
					echo "<tr><td>".$count."</td>";
					if($value->description=="" || $value->description==" " || $value->description=="-")
						echo "<td>".$value->food_type."</td>";
					else
						echo "<td>".$value->food_type."<br>(".$value->description.")</td>";
					echo "<td>".$value->quantity."</td>";
					echo "<td>".$value->price."</td>";
					echo "<td>".$value->price*$value->quantity."</td>";
					$tsubtotal = $tsubtotal + ($value->price*$value->quantity);
					echo "<td>".$value->tax."</td>";
					$tAmt = $value->subtotal-($value->price*$value->quantity);
					$ttax = $ttax + $tAmt;
					echo "<td>".$tAmt."</td>";
					echo "<td>".$value->subtotal."</td></tr>";
					$ttotal = $ttotal+$value->subtotal;
				}

					echo "<tr><td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					$dtax = $ttax/2;
					echo "<td colspan='3'>SGST @2.5% : ".$dtax."</td>";					
					echo "<td></td></tr>";
					
					echo "<tr><td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					$dtax = $ttax/2;
					echo "<td colspan='3'>CGST @2.5% : ".$dtax."</td>";					
					echo "<td></td></tr>";
				
					echo "<tr><td></td>";
					echo "<td>Total</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>".$tsubtotal."</td>";					
					echo "<td></td>";
					echo "<td>".$ttax."</td>";
					echo "<td>".$ttotal."</td></tr>";
					
					echo "<tr><td></td>";
					echo "<td>Final Total</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";					
					echo "<td><span id='roundoff'></span></td>";
					$cc = $ttotal-$invoice[0]->finaltotal;
					if($cc==0)
					{
						echo "<td></td>";
					}
					else
					{
						echo "<td>Discount: Rs:".$cc."</td>";						
					}
					echo "<td> Rs:".$invoice[0]->finaltotal."</td></tr>";					
			?>
			</tbody>
		</table>
		<p style="display:block;">Amount In Words : <span id="amount_words"></span></p>
	</div>

		<div class="col-md-12" style="border-top:1px solid brown;border-bottom:1px solid brown;font-size:10px;">
			<div class="col-md-6" style="padding:0;">
				Food Corridor Caterers<br>
				info@foodcorridor.in<br>
				97518 08080</br>
				<A HREF="http://www.foodcorridor.in/">www.foodcorridor.in</A><br>
				14, Airport Main Road, SITRA</br>
				Coimbatore - 641014</br>
			</div>
			<div class="col-md-6" style="padding:0">
				Declaration<br>
				We declare that this invoice shows the actual price of the goods described and that all particular true and correct<br>
			</div>
		</div>
		<p>Thank you for the Order. We do expect you again !!</p>
	</div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.js"></script>
	<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
	<script src="<?php echo base_url();?>/assets/js/jspdf.debug.js"></script>
	
<script>
$(document).ready(function(){
$(document).ready(function(){
	
	var amount = <?php echo $invoice[0]->finaltotal; ?>;
	convertNumberToWords(amount);
	console.log(amount-Math.round(amount));
	if(amount-Math.round(amount)!==0)
	{
		//alert("hi");
		$('#roundoff').html('roundoff:'+(amount-Math.round(amount)).toFixed(2));
	}
	$('#finalTot').html(Math.round(amount));
		var pdf = new jsPDF('p', 'pt', 'letter');
		var width = 600;
		document.body.style.width=width + "px";

		pdf.html(document.body, {callback: function(pdf) {
			var iframe = document.createElement('iframe');
			iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:50%');
			document.body.appendChild(iframe);
			iframe.src = pdf.output('datauristring');
		}
		});
		
		

		function convertNumberToWords(amount) {
			var words = new Array();
			words[0] = '';
			words[1] = 'One';
			words[2] = 'Two';
			words[3] = 'Three';
			words[4] = 'Four';
			words[5] = 'Five';
			words[6] = 'Six';
			words[7] = 'Seven';
			words[8] = 'Eight';
			words[9] = 'Nine';
			words[10] = 'Ten';
			words[11] = 'Eleven';
			words[12] = 'Twelve';
			words[13] = 'Thirteen';
			words[14] = 'Fourteen';
			words[15] = 'Fifteen';
			words[16] = 'Sixteen';
			words[17] = 'Seventeen';
			words[18] = 'Eighteen';
			words[19] = 'Nineteen';
			words[20] = 'Twenty';
			words[30] = 'Thirty';
			words[40] = 'Forty';
			words[50] = 'Fifty';
			words[60] = 'Sixty';
			words[70] = 'Seventy';
			words[80] = 'Eighty';
			words[90] = 'Ninety';
			amount = amount.toString();
			var atemp = amount.split(".");
			var number = atemp[0].split(",").join("");
			var n_length = number.length;
			var words_string = "";
			if (n_length <= 9) {
				var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
				var received_n_array = new Array();
				for (var i = 0; i < n_length; i++) {
					received_n_array[i] = number.substr(i, 1);
				}
				for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
					n_array[i] = received_n_array[j];
				}
				for (var i = 0, j = 1; i < 9; i++, j++) {
					if (i == 0 || i == 2 || i == 4 || i == 7) {
						if (n_array[i] == 1) {
							n_array[j] = 10 + parseInt(n_array[j]);
							n_array[i] = 0;
						}
					}
				}
				value = "";
				for (var i = 0; i < 9; i++) {
					if (i == 0 || i == 2 || i == 4 || i == 7) {
						value = n_array[i] * 10;
					} else {
						value = n_array[i];
					}
					if (value != 0) {
						words_string += words[value] + " ";
					}
					if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
						words_string += "Crores ";
					}
					if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
						words_string += "Lakhs ";
					}
					if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
						words_string += "Thousand ";
					}
					if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
						words_string += "Hundred and ";
					} else if (i == 6 && value != 0) {
						words_string += "Hundred ";
					}
				}
				words_string = words_string.split("  ").join(" ");
			}
			$('#amount_words').html(words_string);
		}


		});
});
</script>
</body>

</html>
