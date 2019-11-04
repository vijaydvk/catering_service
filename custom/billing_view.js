$(document).ready(function() {
	var invoice_JSON;
	var invoice_id_JSON;
	$.when(getInvoiceDetails()).done(function(){
		dispInvoiceDetails(invoice_JSON);				
	});


	function getInvoiceDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceAllData',
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

	function dispInvoiceDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "invoice_id" },
				{ "mDataProp": "customer_name" },				
				{ "mDataProp": "date" },
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						if(data.discounttype == 100)
						{
							return 'NIL';
						}
						else if(data.discounttype == 0)
						{
							return 'Percentage';
						}
						else if(data.discounttype == 1)
						{
							return 'Cash';
						}
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						if(data.discountvalue == 0)
						{
							return 'NIL';
						}
						else 
						{
							return data.discountvalue;
						}
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) { 
							return 'Rs : '+data.finaltotal;
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
				{ 
					"mDataProp": function ( data, type, full, meta) {
							//return '<span id="'+ data.invoice_id +'" class="btn btn-success btnPdf">Print</span>';
							return '<a href="'+base_URL+'/foodcorridor_controller/printView/'+data.invoice_id+'" target="_blank">Print</a>';
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return 	'<a id="'+ meta.row +'" class="btn BtnDelete" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						
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
				$('#detailsDisp').append("<tr><td>"+invoice_id_JSON[i].food_type+"</td><td>"+invoice_id_JSON[i].tax+"</td><td>"+invoice_id_JSON[i].quantity+"</td><td>Rs:"
				+invoice_id_JSON[i].price+"</td><td>"+invoice_id_JSON[i].subtotal+"</td></tr>");
			}
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Total</td><td>Rs:"+displayTotal+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Discount:</td><td>"+displayPer+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Final Total</td><td>Rs:"+displayFinalTotal+"</td></tr>");
		});	
	});
	
	$(document).on('click','.BtnDelete',function(){
		var r = confirm("Press a button!");
		if (r == true) {
		mode="delete";
		var r_index = $(this).attr('id');
		invoice_id = invoice_JSON[r_index].invoice_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteInvoice',
				data: {"invoice_id":invoice_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			refreshDetails();		
		});		
		} else {
		 
		} 
	});
	
	function refreshDetails()
	{
		$.when(getInvoiceDetails()).done(function(){	
			var table = $('#dataTable').DataTable();
			table.destroy();			
			dispInvoiceDetails(invoice_JSON);
			//$('[data-toggle="tooltip"]').tooltip();
		});		
	}
	
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
	
	$('#proceed_button').click(function(){
		var selected = new Array();
		  $("input:checkbox:checked").each(function() {
			   selected.push($(this).val());
		  });
		 console.log(selected);
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/saveInvoiceProcessData',
			type:'POST',
			data:{"invoice_id":selected},
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
	});
	
	$(document).on('click','.btnPdf',function(){
		var inv_id = $(this).attr("id");
		$.when(getInvoiceIdDetails(inv_id)).done(function(){
			//dispInvoiceIdDetails(invoice_id_JSON);
			//$('#largeModal').modal("show");
			$('#billdetailDisp').html("");
			for(var i=0;i<invoice_id_JSON.length;i++)
			{
				$('#billdetailDisp').append("<tr><td>"+invoice_id_JSON[i].food_type+"</td><td>"+invoice_id_JSON[i].tax+"</td><td>"+invoice_id_JSON[i].quantity+"</td><td>"
				+invoice_id_JSON[i].price+"</td><td>"+invoice_id_JSON[i].subtotal+"</td></tr>");
			}
			
    var pdf = new jsPDF('p', 'pt', 'letter');
    var canvas = pdf.canvas;
	canvas.height = document.body.clientHeight;
    canvas.width = document.body.clientWidth;

    html2canvas(document.body, {
        canvas:canvas,
        onrendered: function(canvas) {
            var iframe = document.createElement('iframe');
            iframe.setAttribute('style','position:absolute;right:0; top:0; bottom:0; height:100%; width:500px');
            document.body.appendChild(iframe);
            iframe.src = pdf.output('datauristring');

           //var div = document.createElement('pre');
           //div.innerText=pdf.output();
           //document.body.appendChild(div);
        }
    });
	
			
	});
});

	
});

