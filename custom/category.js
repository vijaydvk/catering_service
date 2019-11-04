$(document).ready(function() {
	var category_JSON;
	var food_type_id;
	var mode;
	$.when(getCategoryDetails()).done(function(){
		dispCategoryDetails(category_JSON);				
		//dispFoodTypeDetails(food_type_JSON,count,"new",0);
		//$('[data-toggle="tooltip"]').tooltip();
	});				

	function getCategoryDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadCategoryData',
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
				{ "mDataProp": "food_type" },
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
		food_type_id = category_JSON[r_index].food_type_id;
		$('#largeModal').modal('show');
		$('#food_type').val(category_JSON[r_index].food_type);
	});
	
	$(document).on('click','.BtnDelete',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		food_type_id = category_JSON[r_index].food_type_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteCategory',
				data: {"food_type_id":food_type_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			refreshDetails();		
		});		
	});
	
	$(document).on('click','#save',function(){
		if(mode=="save")
		{
			InsertCategoryData();
		}
		else
		{
			updateCategoryData();
		}
	});	
	

	function updateCategoryData()
	{
		var form = $('#form')[0];
		var data = new FormData(form);
		data.append("food_type_id",food_type_id);;
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/updateCategory',
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
			refreshDetails();		
		});		
	}
	
	function InsertCategoryData()
	{
		var form = $('#form')[0];
		var data = new FormData(form);
		//data.append("food_type_id",food_type_id);;
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/insertCategory',
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
			refreshDetails();		
		});		
	}

	function refreshDetails()
	{
		$.when(getCategoryDetails()).done(function(){	
			var table = $('#dataTable').DataTable();
			table.destroy();			
			dispCategoryDetails(category_JSON);
			//$('[data-toggle="tooltip"]').tooltip();
		});		
	}
	
});
