$(document).ready(function() {
	var invoice_report_JSON;
	$.when(getInvoiceDetails()).done(function(){
		dispInvoiceDetails(invoice_report_JSON);				
	});


	function getInvoiceDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceReportData',
			type:'POST',
			success:function(data){
				//console.log(data);
				invoice_report_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispInvoiceDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "pure_invoice_id" },
				{ "mDataProp": "date" },
				{ "mDataProp": "invoice_ids" },
				{ "mDataProp": function ( data, type, full, meta) {
						return "Rs : "+data.totalAmount;
					}
				},	
				{ 
					"mDataProp": function ( data, type, full, meta) {
							//return '<span id="'+ data.invoice_id +'" class="btn btn-success btnPdf">Print</span>';
							return '<a href="'+base_URL+'/foodcorridor_controller/invoiceprintView/'+data.pure_invoice_id+'" target="_blank">Print</a>';
					}
				},
{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn BtnDelete" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						
					}
				},				
			]  				
		});
	}
	
	$(document).on('click','.BtnDelete',function(){
		var r = confirm("Are you sure Want to delete!");
		if (r == true) {
		 
				var r_index = $(this).attr('id');
				pure_invoice_id = invoice_report_JSON[r_index].pure_invoice_id;
				request = $.ajax({
						type: "POST",
						url: base_URL+'index.php/foodcorridor_controller/deletePureInvoice',
						data: {"pure_invoice_id":pure_invoice_id},
				});	
				request.done(function (response){
					var js = $.parseJSON(response);
					//console.log(js);
					//$('#largeModal').modal('hide');
					refreshDetails();		
				});
		}		
	});	
	
	function refreshDetails()
	{
		$.when(getInvoiceDetails()).done(function(){	
			var table = $('#dataTable').DataTable();
			table.destroy();			
			dispInvoiceDetails(invoice_report_JSON);
			//$('[data-toggle="tooltip"]').tooltip();
		});		
	}	
	
	
});

