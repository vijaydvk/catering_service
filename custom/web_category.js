$(document).ready(function() {
	var category_JSON;
	var category_id;
	$.when(getCategoryDetails()).done(function(){
		dispCategoryDetails(category_JSON);				
		//dispFoodTypeDetails(food_type_JSON,count,"new",0);
		//$('[data-toggle="tooltip"]').tooltip();
	});				

	function getCategoryDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadWebCategoryData',
			type:'POST',
			success:function(data){
				//console.log(data);
				category_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}
	

	function dispCategoryDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			//responsive: true,
			"aoColumns": [
				{ "mDataProp": "category_name" },
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.category_description!==null)
						{
							var string = data.category_description;
							var length = 15;
							var trimmedString = string.substring(0, length);
							return trimmedString+"...";
						}
						else
						{
							return '';
						}
					}
				},			
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.category_image_url!==null)
							return "<a href="+data.category_image_url+" target='_blank'>Click to view Image</a>";
						else
							return '';
					}
				},				
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn BtnEdit" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'+
						'<a id="'+ meta.row +'" class="btn BtnDelete" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
						
					}
				},
			],
			  drawCallback: function() {
			    $('[data-toggle="popover"]').popover({container:'body'});
			  }  				
		});
	}

	$(document).on('click','#new_button',function(){
		mode="save";
		$('#largeModal').modal('show');
	});

	$(document).on('click','.BtnEdit',function(){
		mode="update";
		var r_index = $(this).attr('id');
		category_id = category_JSON[r_index].category_id;
		$('#largeModal').modal('show');
		$('#category_name').val(category_JSON[r_index].category_name);
		var string_replace = category_JSON[r_index].category_description;
		var res=string_replace.replace("<br>","\n");
		$('#category_description').val(res);
	});
	
	$(document).on('click','.BtnDelete',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		category_id = category_JSON[r_index].category_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteWebCategoryData',
				data: {"category_id":category_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			$('.alert-success').show().delay(5000).fadeOut('slow');				
			refreshDetails();		
		});		
	});
	
	$('#save').click(function(){
		if($('#category_name').val()!="")
		{
			if(mode=="save")
			{
				saveCusData();
			}
			else
			{
				updateCusData();
			}
		}
		else
		{
			alert("Fill the value");
		}
	});

	$('#largeModal').on('hidden.bs.modal', function () {
	    $(this).find('form').trigger('reset');
	});
	
	function updateCusData()
	{
		var form = $('#form')[0];
		var data = new FormData(form);
		data.append("category_id",category_id);
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/updateWebCategoryData',
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			console.log(js);
			$('#largeModal').modal('hide');
			$('.alert-success').show().delay(5000).fadeOut('slow');	
			refreshDetails();		
		});		
	}
	
	function saveCusData()
	{
		var form = $('#form')[0];
		var data = new FormData(form);
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/insertWebCategoryData',
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			console.log(js);
			$('#largeModal').modal('hide');
			$('.alert-success').show().delay(5000).fadeOut('slow');				
			refreshDetails();		
		});		
	}
	
	function refreshDetails()
	{
		$.when(getCategoryDetails()).done(function(){
			var table = $('#dataTable').DataTable();
			table.destroy();	
			dispCategoryDetails(category_JSON);				
		});
	}
	
});
