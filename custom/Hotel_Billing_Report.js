$(document).ready(function() {
	var hotel_report_JSON;
	$('#bs_datepicker_container input').datepicker({
	 format: 'dd/mm/yyyy', 
	autoclose: true,
	container: '#bs_datepicker_container'
	}).datepicker('update', new Date());
	
	$('#bs_datepicker_container1 input').datepicker({
	 format: 'dd/mm/yyyy', 
	autoclose: true,
	container: '#bs_datepicker_container1'
	}).datepicker('update', new Date());	
	
	$(document).on('click','#Generate_Report',function(){
		console.log($('#from_date').val());
		console.log($('#to_date').val());
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/getHotelReportDetails',
			type:'POST',
			data:{"from_date":$('#from_date').val(),"to_date":$('#to_date').val()},
			success:function(data){
				console.log(data);
				hotel_report_JSON = $.parseJSON(data);
				dispHotelDetails(hotel_report_JSON);	
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;		
	});
	
	var invoice_JSON;
	var invoice_details_JSON;
	var id_JSON;
	/*$.when(getHotelDetails()).done(function(){
		dispHotelDetails(invoice_JSON);				
	});*/


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
		$('#dataTable').show();		
		if ( $.fn.DataTable.isDataTable('#dataTable') ) {
		  $('#dataTable').DataTable().destroy();
		}

		$('#dataTable tbody').empty();		
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			paging: false,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "billNo" },
				{ "mDataProp": "log" },
				{ "mDataProp": "total_amount" },				
				{ "mDataProp": "percentage" },
{ 
					"mDataProp": function ( data, type, full, meta) { 
						return parseFloat(data.total_amount)+parseFloat(data.percentage);
						
					}
				},						
			],
        dom: 'Bfrtip',
        buttons: [
				{ extend: 'pdfHtml5', footer: true }
        ],			
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
            total1 = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );	

            total2 = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );					
				
				//alert(total);
 
            // Update footer
            $( api.column( 2 ).footer() ).html('Tax Amount:'+total);
			$( api.column( 1 ).footer() ).html('Bill Amount:'+total1);
			$( api.column( 3 ).footer() ).html('Total Amount:'+total2);			
        }			
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