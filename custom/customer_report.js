$(document).ready(function() {
	var customer_report_JSON;
	var invoice_JSON;
	var invoice_id_JSON;
	$.when(getcusInvoiceDetails()).done(function(){
		dispcusInvoiceDetails(customer_report_JSON);				
	});


	function getcusInvoiceDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadcustomerReportData',
			type:'POST',
			success:function(data){
				//console.log(data);
				customer_report_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispcusInvoiceDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#customerReportDetails').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "customer_name" },
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						return "RS : "+data.alltotal+" /- <span class='viewAll' id="+data.customer_id+" style='float:right;color:blue;cursor:pointer;'>View</span>";
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						return 'RS : '+data.paidamount+" /-<span class='viewPaid' id="+data.customer_id+" style='float:right;color:blue;cursor:pointer;'>View</span>";
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						return 'RS : '+data.pendingamount+" /-<span class='viewUnpaid' id="+data.customer_id+" style='float:right;color:blue;cursor:pointer;'>View</span>";
						
					}
				},				
			]  				
		});
	}
	
	$(document).on('click','.viewAll',function() {
		$('#firstView').hide(1000);
		$('#secondView').show(100);		
		$.when(getInvoiceDetails($(this).attr("id"),"all")).done(function(){
			dispInvoiceDetails(invoice_JSON);				
		});
	});
	
	$(document).on('click','.viewPaid',function() {
		$('#firstView').hide(1000);
		$('#secondView').show(100);		
		$.when(getInvoiceDetails($(this).attr("id"),"paid")).done(function(){
			dispInvoiceDetails(invoice_JSON);				
		});
	});
	
	$(document).on('click','.viewUnpaid',function() {
		$('#firstView').hide(1000);
		$('#secondView').show(100);		
		$.when(getInvoiceDetails($(this).attr("id"),"unpaid")).done(function(){
			dispInvoiceDetails(invoice_JSON);				
		});
	});
	
	$('#closeDiv').click(function(){
		$('#firstView').show(1000);
		$('#secondView').hide(1000);			
	});


	function getInvoiceDetails(customer_id,statuss)
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadCustomerInvoiceAllData',
			type:'POST',
			data:{"customer_id":customer_id,"status":statuss},
			success:function(data){
				//console.log(data);
				invoice_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispInvoiceDetails(dataJSON)
	{
		if ( $.fn.DataTable.isDataTable('#customerReportInvoiceDetails') ) {
		  $('#customerReportInvoiceDetails').DataTable().destroy();
		}
		//console.log(dataJSON);
		$('#customerReportInvoiceDetails').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "invoice_id" },
				{ "mDataProp": "date" },
				{ "mDataProp": function ( data, type, full, meta) {
						return "Rs : "+data.finaltotal;
					}
				},  	
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ data.invoice_id +'" r_index="'+meta.row+'" class="btn Btnview" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.status==0)
						{
							return "<span class='badge bg-pink'>New</span>";
						}
						else if(data.status==1)
						{
							return "<span class='badge bg-cyan'>Initiated</span>";
						}
						else if(data.status==2)
						{
							return "<span class='badge bg-green'>Completed</span><br>Comment: &nbsp;&nbsp;"+data.comment;
						}
						else if(data.status==3)
						{
							return "<span class='badge bg-red'>Not Completed</span><br>Comment: &nbsp;&nbsp;"+data.comment;
						}						
					}
				},
			]  				
		});
	}

	$(document).on('click','.Btnview',function(){
		var select_invoice_id = $(this).attr('id');
		var r_index=$(this).attr('r_index');
		var displayTotal = invoice_JSON[r_index].total;
		var displayFinalTotal = invoice_JSON[r_index].finaltotal;
		var displayPer = invoice_JSON[r_index].discountvalue;
		console.log(displayPer);
		if(invoice_JSON[r_index].discounttype=="0")
		{
			displayPer = displayPer+"%";
		}
		$.when(getInvoiceIdDetails(select_invoice_id)).done(function(){
			//dispInvoiceIdDetails(invoice_id_JSON);
			$('#largeModal').modal("show");
			$('#detailsDisp').html("");
			for(var i=0;i<invoice_id_JSON.length;i++)
			{
				$('#detailsDisp').append("<tr><td>"+invoice_id_JSON[i].food_type+"</td><td>"+invoice_id_JSON[i].tax+"</td><td>"+invoice_id_JSON[i].quantity+"</td><td>Rs: "
				+invoice_id_JSON[i].price+"</td><td>"+invoice_id_JSON[i].subtotal+"</td></tr>");
			}
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Total</td><td>Rs: "+displayTotal+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Discount:</td><td>"+displayPer+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Final Total</td><td>Rs: "+displayFinalTotal+"</td></tr>");
		});		
	});
	
	function getInvoiceIdDetails(select_invoice_id)
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceIdData',
			type:'POST',
			data:{"invoice_id":select_invoice_id},
			success:function(data){
				//console.log(data);
				invoice_id_JSON = $.parseJSON(data);
				console.log(invoice_id_JSON);
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}	

});

