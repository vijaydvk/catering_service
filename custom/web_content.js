$(document).ready(function() {
	var category_JSON;
	var category_id;
	var menu_details_id;
	var content_JSON;
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
		for(var i=0;i<category_JSON.length;i++)
		{
			$('#category_id').append("<option value="+category_JSON[i].category_id+">"+category_JSON[i].category_name+"</option>");
		}
	}
	
	$.when(getViewsDetails()).done(function(){				
		disptViewsDetails(content_JSON);
		//$('[data-toggle="tooltip"]').tooltip();
	});
	
	function getViewsDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadWebContentData',
			type:'POST',
			success:function(data){
				//console.log(data);
				content_JSON = $.parseJSON(data);
				
			},		
			error: function() {
			console.log("market - getMarketViewsDetails - Error - line 29"); 
			alert('something bad happened'); 
			}
		}) ;
	}
	

	function disptViewsDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				//{ "mDataProp": "market_id" },
				{ "mDataProp": "category_name" },
				{ "mDataProp": "menu_details_title" },
				{ 
					"mDataProp": function ( data, type, full, meta) {
						if(data.menu_details_description!==null)
						{
							var string = data.menu_details_description;
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
						if(data.menu_details_image_url!==null)
							return "<a href="+data.menu_details_image_url+" target='_blank'>Click to view Image</a>";
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
			"initComplete": function () {
					var api = this.api();
						  $clearButton = $('<input type = "button" data-toggle="tooltip" data-placement="top" title="Click to clear search and refresh the table" value="Clear" />')
				       .click(function() {
								 api.search('').draw();
				       }) ;
							$newButton = $('<i class="fa fa-plus" style="margin:5px 15px;"></i>');
							$('#example2_filter').append($newButton);
			},				
		});
	}

	$(document).on('click','#new_button',function(){
		mode="save";
		$('#largeModal').modal('show');
	});

	$(document).on('click','.BtnEdit',function(){
		mode="update";
		var r_index = $(this).attr('id');
		menu_details_id = content_JSON[r_index].menu_details_id;
		$('#largeModal').modal('show');
		$('#menu_details_id').val(content_JSON[r_index].menu_details_id);
		$('#menu_details_title').val(content_JSON[r_index].menu_details_title);
		$('#menu_details_description').val(content_JSON[r_index].menu_details_description);		
	});
	
	$(document).on('click','.BtnDelete',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		menu_details_id = content_JSON[r_index].menu_details_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteWebContentData',
				data: {"menu_details_id":menu_details_id},
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
		data.append("menu_details_id",menu_details_id);
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/updateWebContentData',
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
		data.append("menu_details_id","null");
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/insertWebContentData',
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
		$.when(getViewsDetails()).done(function(){
			var table = $('#dataTable').DataTable();
			table.destroy();	
			disptViewsDetails(content_JSON);				
		});
	}
	
});
