$(document).ready(function() {
	var testimonials_JSON;
	var testimonial_id;
	$.when(getTestimonialsDetails()).done(function(){
		dispTestimonialsDetails(testimonials_JSON);				
		//dispFoodTypeDetails(food_type_JSON,count,"new",0);
		//$('[data-toggle="tooltip"]').tooltip();
	});				

	function getTestimonialsDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadWebTestimonialsData',
			type:'POST',
			success:function(data){
				//console.log(data);
				testimonials_JSON = $.parseJSON(data);
				
			},		
			error: function() {
			console.log("market - getMarketViewsDetails - Error - line 29"); 
			alert('something bad happened'); 
			}
		}) ;
	}
	

	function dispTestimonialsDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				//{ "mDataProp": "market_id" },
				{ "mDataProp": "testimonial_name" },
				{ "mDataProp": "testimonial_phone" },
				{ "mDataProp": "testimonial_description" },	
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.active==0)
						{
							return "In active";
						}
						else if(data.active==1)
						{
							return "Active";
						}
						
					}
				},				
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn BtnEdit" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
						
					}
				},	
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.active==0)
						{
							return '<a id="'+ meta.row +'" class="btn BtnApprove" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp;&nbsp;'+
							'<a id="'+ meta.row +'" class="btn BtnDelete" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						}
						else if(data.active==1)
						{
							return '<a id="'+ meta.row +'" class="btn BtnDelete" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						}						
						
					}
				},				
			],		
		});
	}

	$(document).on('click','.BtnEdit',function(){
		mode="update";
		var r_index = $(this).attr('id');
		$('#largeModal').modal('show');
		$('#testimonials_name').val(testimonials_JSON[r_index].testimonial_name);
		$('#testimonials_phone').val(testimonials_JSON[r_index].testimonial_phone);
		$('#testimonials_description').val(testimonials_JSON[r_index].testimonial_description);		
	});
	
	$(document).on('click','.BtnApprove',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		testimonial_id = testimonials_JSON[r_index].testimonial_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/approveWebTestimonialsData',
				data: {"testimonial_id":testimonial_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			$('.alert-success').show().delay(5000).fadeOut('slow');				
			refreshDetails();		
		});		
	});
	
	$(document).on('click','.BtnDelete',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		testimonial_id = testimonials_JSON[r_index].testimonial_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteWebTestimonialsData',
				data: {"testimonial_id":testimonial_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			$('.alert-success').show().delay(5000).fadeOut('slow');				
			refreshDetails();		
		});		
	});
	

	$('#largeModal').on('hidden.bs.modal', function () {
	    $(this).find('form').trigger('reset');
	});
	
	
	function refreshDetails()
	{
		$.when(getTestimonialsDetails()).done(function(){
			var table = $('#dataTable').DataTable();
			table.destroy();			
			dispTestimonialsDetails(testimonials_JSON);				
			//dispFoodTypeDetails(food_type_JSON,count,"new",0);
			//$('[data-toggle="tooltip"]').tooltip();
		});			
	}
	
});
