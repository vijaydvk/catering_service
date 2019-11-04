<!DOCTYPE html>
<html>

<head>
 <?php require('components/header.php');?>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"> 
	<link href="<?php echo base_url();?>/assets/css/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />		
    <style>
    
    /*table > thead > th:nth-child(2) {
    width: 20%;
    text-align: left;
}*/
        td{font-weight:600;padding:0px 10px;font-size:12px;padding:3px!important;font-size:10px;}
		tr{text-align:left;font-size:12px;padding:3px!important;font-size:10px;}
		.page{padding:15px!important;}
    </style>
</head>

<body class="theme-green" style="background-color:white;font-family:'Roboto', Arial, Tahoma, sans-serif;font-size:10px;">
 	<div style="padding-left:50px;"><button class="btn btn-info" onclick="javascript:demoFromHTML();">Datewise Report</button></div>
        <div class="container-fluid p-0" id="container-fluid" style="margin:0%;margin-top:1%;width:50%;overflow: auto;">
            <div class="col-md-12 p-0" style="border-bottom: 1px solid brown;padding:0px;padding-bottom:10px;">
                <div class="col-md-6 p-0">
                    <br>
					<img src="<?php echo base_url();?>/assets/images/logo.png" width="75" height="75" alt="Logo" style="border-radius:100px;" />				
				</div>
				<div class="col-md-6 text-right" style="float:right;">
				    <br>
					<table style="float:right;font-size:10px;">
						<tr><td class="text-left">Invoice No</td><td class="text-left">: <?php echo $pure_invoice[0]->pure_invoice_id."-OC";?></td></tr>
						<tr><td class="text-left">Invoice Date</td><td class="text-left">: <?php echo date("F jS, Y", strtotime($pure_invoice[0]->date));?></td></tr>
						<tr><td class="text-left">Trade Name</td><td class="text-left">: Food Corridor Caterers</td></tr>
						<tr><td class="text-left">Bill Date(s)</td><td class="text-left">: <?php echo $invoice_details[0]->mindate." - ".$invoice_details[0]->maxdate;?></td></tr>
						<tr><td class="text-left">GSTIN</td><td class="text-left">: 33BNDPP4829H1ZX</td></tr>
					</table>
				</div>
            </div>
			<p style="letter-spacing:1px;word-spacing:1.5px" id="textt">TO:<span id="cname"><?php echo $invoice_details[0]->customer_name;?></span></p>
			<script></script>
			<p><?php echo $invoice_details[0]->customer_address;?></p>
			GSTIN:<?php echo $invoice_details[0]->customer_gst;?>
		<div class="col-md-12" style="margin-top:15px;min-height:250px;">
		<table id="dataTable" class="table table-striped table-bordered table-responsive nowrap" style="width:100%;font-size:12px;">
			<thead>
			<style>th{background-color:#a05656;color:white;}</style>
				<th class="text-left">S NO</th>
				<th style="width:40px;" class="text-left">Item1</th>
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
				foreach($invoice_items as $value)
				{
					$count++;
					echo "<tr><td>".$count."</td>";
					echo "<td>".$value->food_type."</td>";
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
					echo "<td> Rs:".$tsubtotal."</td>";					
					echo "<td></td>";
					echo "<td>".$ttax."</td>";
					echo "<td> Rs:".$ttotal."</td></tr>";
					
					echo "<tr><td></td>";
					echo "<td>Final Total</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";					
					echo "<td><span id='roundoff'></span></td>";
					$cc = $ttotal-$invoice_details[0]->finaltotal;
					if($cc==0)
					{
						echo "<td></td>";
					}
					else
					{
						echo "<td>Discount: Rs:".$cc."</td>";						
					}
					echo "<td> Rs:<span id='finalTot'>".$invoice_details[0]->finaltotal."</span></td></tr>";					
			?>
			</tbody>
		</table>
		<p style="display:block;">Amount In Words : <span id="amount_words"></span></p>
		<?php if($pure_invoice[0]->notes!=""){?><b>Notes:<br><?php echo $pure_invoice[0]->notes;?></b><?php }?>
	</div>
		<div class="col-md-12" style="border-top:1px solid brown;border-bottom:1px solid brown;font-size:10px;">
		    
			<div class="col-md-4" style="padding:0;">
				<h6>Food&nbspCorridor&nbspCaterers</h6>
				info@foodcorridor.in<br>
				97518 08080,9842221048</br>
				<A HREF="http://www.foodcorridor.in/">www.foodcorridor.in</A><br>
				Office:</br>
				41, Airport Main Road, SITRA</br>
				Coimbatore - 641014</br>
			</div>
			<div class="col-md-2" style="padding:0;">
				<h6>Bank&nbspDetails </h6>
				<b>Name</b><br>
				<b>Acc No</b><br>
				<b>IFSC</b><br>
				<b>Acc Type</b><br>
				<b>Bank</b><br>
				<b>Branch</b><br>
				<br>
				
			</div>
			<div class="col-md-3" style="padding:0;">
				<h6>&nbsp</h6>
				 Food Corridor Caterers<br>
				 3603303330<br>
				 CBIN0282057<br>
				 Current<br>
				 Central Bank<br>
				 Kalapatti,Coimbatore-14<br>
				<br>
			</div>
			<div class="col-md-3" style="padding:0">
				<h6>Declaration</h6>
				We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct<br>
			</div>
			
		</div>
		<center><p>Thank you for the Order. We do expect you again !!</p></center>
		<center><p>Computer generated invoice signature not required .</p></center>
	</div>

	<div >
	<table id="tablePrint" style="width:95%;border:1px solid black;margin-top:60px;display:none;"> <tbody><tr><td>Date</td>
	<?php 
	
	//print_r($invoiceAllData);
	
	for($i=0;$i<sizeof($Food_type);$i++)
	{
	    echo "<td>".$Food_type[$i]->food_type."</td>";
	}
    echo "</tr>";
    ?>
    
<tr><td>Date</td>
	<?php 
	
	//print_r($invoiceAllData);
	
	for($i=0;$i<sizeof($Food_type);$i++)
	{
	    echo "<td>".$Food_type[$i]->food_type."</td>";
	}
    echo "</tr>";    

	for($i=0;$i<sizeof($date);$i++)
	{
	    echo "<tr><td style='border:1px solid black;'>";
	    echo $date[$i]->date."</td>";
	    for($j=0;$j<sizeof($Food_type);$j++)
	    {
    	   $visit=0;	        
	        for($k=0;$k<sizeof($invoiceAllData);$k++)
    	    {

    	        if($invoiceAllData[$k]->food_type_id==$Food_type[$j]->food_type_id&&$date[$i]->date==$invoiceAllData[$k]->date )
    	        {
    	            echo "<td style='border:1px solid black;'>".$invoiceAllData[$k]->quantity."</td>";
    	            $visit=1;
    	        }
    	    }
    	    if($visit==0)
    	    {
    	        echo "<td style='border:1px solid black;'></td>";
    	    }
	    }
	    echo "</tr>";
	}
	
	?>
	</tbody>
	</table>	
	</div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>/assets/html2canvas.js"></script>
	<script src="<?php echo base_url();?>/assets/js/jspdf.debug.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.1.0/jspdf.plugin.autotable.js"></script>	
	
<script>
function demoFromHTML() {
var pdfsize = 'a4';
  var pdf = new jsPDF('l', 'pt', pdfsize);

  var res = pdf.autoTableHtmlToJson(document.getElementById("tablePrint"));

  var header = function(data) {
    pdf.setFontSize(18);
    pdf.setTextColor(40);
    pdf.setFontStyle('normal');
    //doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 20, 50, 50);
   // pdf.text("Testing Report", data.settings.margin.left, 50);
  }

  pdf.autoTable(res.columns, res.data, {
      
    theme: 'grid',
    styles: {
        cellPadding: 0,
        rowHeight: 10,
        fillStyle: 'S',
        halign: 'center',
        valign: 'middle',
        fontStyle: 'bold',
        lineWidth: 0.01,
        fontSize: 10,
        textColor: 0,
    },      

   // beforePageContent: header,
    startY: 60,
    drawHeaderRow: function(row, data) {
      row.height = 46;
    },
    drawHeaderCell: function(cell, data) {
      pdf.rect(cell.x, cell.y, cell.width, cell.height, cell.styles.fillStyle);
      pdf.setFillColor(230);
      pdf.rect(cell.x, cell.y + (cell.height / 2), cell.width, cell.height / 2, cell.styles.fillStyle);
      pdf.autoTableText(cell.text, cell.textPos.x, cell.textPos.y, {
        halign: cell.styles.halign,
        valign: cell.styles.valign
      });
      pdf.setTextColor(100);
      var text = data.table.rows[0].cells[data.column.dataKey].text;
      pdf.autoTableText(text, cell.textPos.x, cell.textPos.y + (cell.height / 2), {
        halign: cell.styles.halign,
        valign: cell.styles.valign
      });
      return false;
    },
    drawRow: function(row, data) {
      if (row.index === 0) return false;
    },
    margin: {
      top: 60
    },
    styles: {
      overflow: 'linebreak',
      fontSize: 10,
      tableWidth: 'auto',
      columnWidth: 'auto',
    },
    columnStyles: {
      1: {
        columnWidth: 'auto'
      }
    },


  });

    

  pdf.save($('#cname').html() + ".pdf");
}
$(document).ready(function(){
	var amount = <?php echo $invoice_details[0]->finaltotal; ?>;
	convertNumberToWords(amount);
	console.log(amount-Math.round(amount));
	if(amount-Math.round(amount)!==0)
	{
		//alert("hi");
		$('#roundoff').html('roundoff:'+(amount-Math.round(amount)).toFixed(2));
	}
	$('#finalTot').html(Math.round(amount));
		var pdf = new jsPDF('p', 'pt', 'letter');
	//	var width = 600;
		//document.body.style.width=width + "px";
		//alert($(window).width());
		var per = $(window).width()/100;
		var screen = per*37.5;
		var width = 500+'px';
		$('#container-fluid').width(width);
        margins = {top: 40, bottom: 60, left: 40, width: 522};
		pdf.html(document.getElementsByClassName('container-fluid')[0],{callback: function(pdf) {
			var iframe = document.createElement('iframe');
			iframe.setAttribute('style', 'position:absolute;top:0;left:50%;height:100%; width:50%');
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
</script>
</body>

</html>
