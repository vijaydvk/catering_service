$(document).ready(function() {
	var invoice_JSON;
	var invoice_details_JSON;
	var id_JSON;
	$.when(getHotelDetails()).done(function(){
		dispHotelDetails(invoice_JSON);				
	});


	function getHotelDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/selecthotelBillCustomer',
			type:'POST',
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

	function dispHotelDetails(dataJSON)
	{
	
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "id" },
				{ "mDataProp": "billNo" },				
				{ "mDataProp": "billDate" },
				{ "mDataProp": "billTime" },
				{ "mDataProp": "disPer" },				
				{ "mDataProp": "disAmt" },
				{ "mDataProp": "totalAmount" },
				{ "mDataProp": "thirdParty" },	

				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ data.id +'" r_index="'+meta.row+'" class="btn Btnview" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
						
					}
				},
						
			]  				
		});
	}

	$(document).on('change','input[type=checkbox]',function() {
		$('#proceed_button').show();
		var checkbox_value = $(this).attr("data-check-element");
		if(checkbox_value>0)
		{
			checkbox_value=checkbox_value-1;
			nxtcheck = checkbox_value+1;
			//console.log($('#md_checkbox_').prop('checked'));
			if (!$('input[data-check-element='+checkbox_value+']').prop('checked') || $('input[data-check-element='+nxtcheck+']').prop('checked')) {
				 swal({
					title: "Are you sure?",
					text: "You will not be able to proceed bill without select previous bill!",
					type: "error",
					confirmButtonClass: 'btn-danger',
					confirmButtonText: 'Ok'
				  });
				 $(this).prop('checked',false);
				 $('#proceed_button').hide();
			}
		}
	});
	
	$(document).on('click','.Btnview',function(){
		var select_invoice_id = $(this).attr('id');
		$.when(getInvoiceIdDetails(select_invoice_id)).done(function(){
			//dispInvoiceIdDetails(invoice_id_JSON);
			$('#largeModal').modal("show");
			$('#detailsDisp').html("");
			for(var i=0;i<invoice_details_JSON.length;i++)
			{
				$('#detailsDisp').append("<tr><td>"+invoice_details_JSON[i].productName+"</td><td>"+invoice_details_JSON[i].productQty+"</td><td>"+invoice_details_JSON[i].amount+"</td></tr>");
			}
		});	
	});
	

	

	
	function getInvoiceIdDetails(select_invoice_id)
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadIdData',
			type:'POST',
			data:{"id":select_invoice_id},
			success:function(data){
				//console.log(data);
				invoice_details_JSON = $.parseJSON(data);
				//console.log(invoice_details_JSON);
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}
	
});