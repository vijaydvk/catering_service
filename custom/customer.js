$(document).ready(function() {
	var count=1;
	var food_type_JSON;
	var customer_JSON;
	var customer_id;
	var inv_customer_id;
    var type;
	var amt;
	var mode;
	$.when(getCustomerDetails()).done(function(){
	$.when(getFoodTypeDetails()).done(function(){
		dispCustomerDetails(customer_JSON);				
		//dispFoodTypeDetails(food_type_JSON,count,"new",0);
		//$('[data-toggle="tooltip"]').tooltip();
	});				
		
	});


	function getCustomerDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadCustomerData',
			type:'POST',
			success:function(data){
				//console.log(data);
				customer_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispCustomerDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			//responsive: true,
			"aoColumns": [
				{ "mDataProp": "customer_name" },
				{ "mDataProp": "customer_phonenumber" },
				{ "mDataProp": "customer_email" },
				{ "mDataProp": "customer_address","sClass": "address" },
				{ "mDataProp": "customer_creditlimit" },  	
				/*{ "mDataProp": "foot_type_id" },*/
				{ 
					"mDataProp": function ( data, type, full, meta) {
						console.log(data.food_type);
						if(data.food_type===null)
						{
							return 'No Category Found';

						}
						else
						{
							var fti=data.food_type_id;
							var o_fti=fti.split(",");
							var fta=data.amount;
							var o_fta=fta.split(",");
							var ftt=data.food_type;
							var o_ftt=ftt.split(",");
							var content="<div>";
							var f_type='';
							for (var i=0;i<o_fti.length;i++)
							{
								content+="Category:"+o_ftt[i]+"<br>Amount:"+o_fta[i]+"<br>";
							}
							content+="</div>";
							//console.log(content);
							return '<a data-html="true" role="button" data-toggle="popover" title="Food Category"  data-placement="left" data-content="'+content+'" "><b>view</b></a>';
						}
											
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn BtnLogin" style="cursor:pointer;">Login</a>&nbsp;&nbsp;';
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn BtnInvoice" style="cursor:pointer;">Make Invoice</a>&nbsp;&nbsp;';
						
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
		$('#fd_cat').html('');
		$('#fd_amt').html('');
		count=1;
		dispFoodTypeDetails(food_type_JSON,count,"new",0);
	});

	$(document).on('click','.BtnEdit',function(){
		mode="update";
		var r_index = $(this).attr('id');
		customer_id = customer_JSON[r_index].customer_id;
		$('#largeModal').modal('show');
		$('#customer_name').val(customer_JSON[r_index].customer_name);
		$('#customer_phonenumber').val(customer_JSON[r_index].customer_phonenumber);
		$('#customer_email').val(customer_JSON[r_index].customer_email);
		$('#customer_pass').val(customer_JSON[r_index].customer_pass);
		$('#customer_address').val(customer_JSON[r_index].customer_address);
		$('#customer_creditlimit').val(customer_JSON[r_index].customer_creditlimit);
		$('#customer_gst').val(customer_JSON[r_index].customer_gst);
		$('#customer_alernative_phonenumber').val(customer_JSON[r_index].customer_alernative_phonenumber);
		$('#fd_cat').html('');
		$('#fd_amt').html('');
		var fti=customer_JSON[r_index].food_type_id;
		var o_fti=fti.split(",");
		var fta=customer_JSON[r_index].amount;
		var o_fta=fta.split(",");
		count=0;
		for (var i=0;i<o_fti.length;i++)
		{
			type=o_fti[i];
			amt=o_fta[i];
			count++;
			dispFoodTypeDetails(food_type_JSON,count,"edit",0);
			
		}
		
	});
	
	$(document).on('click','.BtnDelete',function(){
		mode="delete";
		var r_index = $(this).attr('id');
		customer_id = customer_JSON[r_index].customer_id;
		request = $.ajax({
				type: "POST",
				url: base_URL+'index.php/foodcorridor_controller/deleteCustomer',
				data: {"customer_id":customer_id},
		});	
		request.done(function (response){
			var js = $.parseJSON(response);
			//console.log(js);
			//$('#largeModal').modal('hide');
			refreshDetails();		
		});		
	});
	
	$(document).on('click','.BtnLogin',function(){
		var r_index = $(this).attr('id');
		var name = customer_JSON[r_index].customer_name;
		var pass = customer_JSON[r_index].customer_pass;
		window.open("https://foodcorridor.in/food_customer/foodcorridor_controller/index/"+name+"/"+pass,"_blank");
			
	});
	
	function getFoodTypeDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadFoodTypeData',
			type:'POST',
			success:function(data){
				//console.log(data);
				food_type_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispFoodTypeDetails(data,count,flag,cc)
	{
		$('#fd_cat').append(' <span id="spc'+count+'"style="margin-top:5px;"><div class="form-line"><select class="form-control a" id="cat_'+count+'" name="cat[]">'+
		                        
		                     '</select></div></span>');
		$('#fd_amt').append(' <span id="spa'+count+'"><div class="form-line">'+
		                                    '<input type="text" id="amt_'+count+'"  name="amt[]" class="form-control" placeholder="Please fill name...">'+
		                     '</div></span>');

		$('#cat_'+count).append('<option value="">-- Please select --</option>');
		for(var i=0;i<data.length;i++)
		{
			$('#cat_'+count).append('<option value="'+data[i].food_type_id+'">'+data[i].food_type+'</option>');
		}
		//$('#cat_'+count).selectpicker('refresh');
		if(flag!="new")
		{
		var values=new Array();
		$("select.a").each(function()
		{
		if($(this).val()!="")
		    values.push($(this).val());
		});
		if(values.length>0)
		{	

			for(var i=0;i<values.length;i++)
			{
				$('#cat_'+count+' option[value="'+values[i]+'"]').remove();
			}
		}
		if(flag=="edit")
		{
			amt=amt.trim();
			type=type.trim();
			$('#amt_'+count).val(amt);
			$('#cat_'+count).val(type);
		}
		}
		
	}

	$('#fd_add').click(function(){
		var values=new Array();
		$("select.a").each(function()
		{
		console.log($(this).val());
		if($(this).val()!="")
		    values.push($(this).val());
		});
		if(values.length>0)
		{
                	count++;
			dispFoodTypeDetails(food_type_JSON,count,"add",0);			
		}
		else
		{
			alert("Fill above details");
		}

	});
	$('#fd_remove').click(function(){
		if(count<=1)
		{
			alert("Cannot remove element");
		}
		else
		{
			$('#spc'+count).remove();
			$('#spa'+count).remove();
			count--;
		}
	});

	$('#save').click(function(){
		if(mode=="save")
		{
			saveCusData();
		}
		else
		{
			updateCusData();
		}
	});

	$('#largeModal').on('hidden.bs.modal', function () {
	    $(this).find('form').trigger('reset');
	});

	function saveCusData()
	{
		var valid = 0;

		$('.nan').each(function() {
			if(isNaN($(this).val())){
				$(this).css("border-bottom","1px solid red");
				valid = 1;
				return false;
			 }
			else
			{
				$(this).css("border-bottom","1px solid #ddd");
			}
		});
		if(valid==0)
		{
			$('.valid').each(function() {
				if($(this).val()=="")
				{
					$(this).css("border-bottom","1px solid red");
					valid=1;
					return false;
				}
				else
				{
					$(this).css("border-bottom","1px solid #ddd");
				}
			});	
		}
		if(valid==0)
		{
			var form = $('#form')[0];
			var data = new FormData(form);
			console.log(data);
			request = $.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url: base_URL+'index.php/foodcorridor_controller/insertCustomer',
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
	}
	
	function updateCusData()
	{
		var form = $('#form')[0];
		var data = new FormData(form);
		data.append("customer_id",customer_id);;
		request = $.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: base_URL+'index.php/foodcorridor_controller/updateCustomer',
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
		$.when(getCustomerDetails()).done(function(){	
			var table = $('#dataTable').DataTable();
			table.destroy();			
			dispCustomerDetails(customer_JSON);
			//$('[data-toggle="tooltip"]').tooltip();
		});		
	}
	
	$(document).on('click', function (e) {
		$('[data-toggle="popover"],[data-original-title]').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {                
				(($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
			}

		});
	});
	
	$(document).on('click','.BtnInvoice',function(){
		mode="update";
		var r_index = $(this).attr('id');
		inv_customer_id = customer_JSON[r_index].customer_id;
		$.when(getInvoiceDetails(inv_customer_id)).done(function(){
			dispInvoiceDetails(invoice_JSON);
			$('#firstDiv').hide(1000);
			$('#secondDiv').show(1000);
		});		
		
	});
	
	var invoice_JSON;
	var invoice_id_JSON;
	var tamount=0;


	function getInvoiceDetails(inv_customer_id)
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceData',
			type:'POST',
			data:{"customer_id":inv_customer_id},
			success:function(data){
				//console.log(data);
				invoice_JSON = $.parseJSON(data);
					if ( $.fn.DataTable.isDataTable('#dataTable2') ) {
					  $('#dataTable2').DataTable().destroy();
					}
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
		$('#dataTable2').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "invoice_id" },
				{ "mDataProp": "date" },
				{ "mDataProp": "finaltotal" },  	
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ data.invoice_id +'" r_index="'+meta.row+'" class="btn Btnview" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						//return '<input type="checkbox" class="form-control" name="procedd[]" value="'+data.invoice_id+'"><input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br>';
						return '<input type="checkbox" id="md_checkbox_'+meta.row+'" data-check-element="'+meta.row+'" data-amount="'+data.finaltotal+'" value="'+data.invoice_id+'" class="filled-in chk-col-brown"><label for="md_checkbox_'+meta.row+'"></label>';
						
					}
				},
			]  				
		});
	}
	
	$(document).on('change','input[type=checkbox]',function() {
		/* $('#proceed_button').show();
		var checkbox_value = $(this).attr("data-check-element");
		if(checkbox_value>0)
		{
			checkbox_value=checkbox_value-1;
			nxtcheck = checkbox_value+1;
			//console.log($('#md_checkbox_').prop('checked'));
			if (!$('input[data-check-element='+checkbox_value+']').prop('checked')||($(this).prop('checked')==false&&$('input[data-check-element='+nxtcheck+']').prop('checked')==true)) {
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
		} */
		var msgflag="false";
		$('#proceed_button').show();
		/*var checkbox_value = $(this).attr("data-check-element");
		if($(this).prop("checked") == true){
			var sList = "";
			var loopcount=0;
			var loopflag=0;
			$('input[type=checkbox]').each(function () {
				if(checkbox_value==loopcount)
				{
					loopflag=0;
				}
				else
				{
					if($(this).prop('checked')==false)
					{
						loopflag=1;
						return false;
					}
					else
					{
						loopcount++;
					}
				}
			});
		}
		else
		{
			var loopcount=0;
			var loopflag=0;
			$('input[type=checkbox]').each(function () {
				loopcount++;
				if(loopcount>checkbox_value)
					if($(this).prop('checked')==true)
					{
						loopflag=1;
						return false;
					}
			});
		}

		if(loopflag!==0)
		{
			$(this).prop('checked',false);
			swal({
				title: "Are you sure?",
				text: "You will not be able to proceed bill without select previous bill!",
				type: "error",
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Ok'
			  });
			  msgflag="true";
			 //$(this).prop('checked',false);
			 $('#proceed_button').hide();
		}*/
		
		if(msgflag=="false")
		{
			tamount = 0;
			$('input[type=checkbox]').each(function () {
				if($(this).prop('checked')==true)
					{
						tamount=tamount+parseFloat($(this).attr("data-amount"))	;
					}
			});
			$('#total_amt_disp').html("Total amount:"+tamount);
		}
		else
		{
			$('#total_amt_disp').html('');
		}
		if(tamount==0)
		{
			$('#proceed_button').hide();
			$('#total_amt_disp').html("");
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
			$('#viewModal').modal("show");
			$('#detailsDisp').html("");
			for(var i=0;i<invoice_id_JSON.length;i++)
			{
				$('#detailsDisp').append("<tr><td>"+invoice_id_JSON[i].food_type+"</td><td>"+invoice_id_JSON[i].tax+"</td><td>"+invoice_id_JSON[i].quantity+"</td><td>"
				+invoice_id_JSON[i].price+"</td><td>"+invoice_id_JSON[i].subtotal+"</td></tr>");
			}
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Total</td><td>"+displayTotal+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Discount:</td><td>"+displayPer+"</td></tr>");
			$('#detailsDisp').append("<tr><td colspan='4' class='text-right'>Final Total</td><td>"+displayFinalTotal+"</td></tr>");
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
	
  $(document).on("click","#proceed_button", function(e) {
		var selected = new Array();
		  $("input:checkbox:checked").each(function() {
			   selected.push($(this).val());
		  });
    var buttons = $('<div><textarea class="form-control" id="comment" name="comment" value="" rows="3" placeholder="Fill the comments"></textarea>')
    .append(createButton('Close', function() {
       swal.close();
    })).append(createButton('Confirm', function() {
       swal.close();
       //alert($('#comment').val());
	   updateProcess(selected,$('#comment').val());	   
    }));
    e.preventDefault();
    swal({
      title: "Confirm Invoice",
	  text: "Are you sure you want to submit bills, Total amount - Rs:"+tamount,
      html: buttons,
      //type: "warning",
      showConfirmButton: false,
      showCancelButton: false
    });
  });
  
	
	function createButton(text, cb) {
	  return $('<button class="btn btn-info" style="margin:5px;">' + text + '</button>').on('click', cb);
	}

  
  function updateProcess(selected,comment)
  {
	$.ajax({
		url: base_URL+'index.php/foodcorridor_controller/saveInvoiceProcessData',
		type:'POST',
		data:{"invoice_id":selected,"customer_id":inv_customer_id,"notes":comment},
		success:function(data){
			//console.log(data);
			data = $.parseJSON(data);
			console.log(data);
			if(data.result=="success")
			{
				$('#proceed_button').hide();
				refreshDetails1();
				swal("Updated Successfully");
			}
			else
			{
				swal("Not updated");
			}
		},		
		error: function() {
			console.log("Error"); 
			//alert('something bad happened'); 
		}
	});
  }

	
/*	$('#proceed_button').click(function(){
		var selected = new Array();
		  $("input:checkbox:checked").each(function() {
			   selected.push($(this).val());
		  });
		swal({
			title: "Submit all bills?",
			text: "Are you sure you want to submit bills, Total amount - Rs:"+tamount,
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		}, function () {
				$.ajax({
						url: base_URL+'index.php/foodcorridor_controller/saveInvoiceProcessData',
						type:'POST',
						data:{"invoice_id":selected,"customer_id":inv_customer_id},
						success:function(data){
							//console.log(data);
							data = $.parseJSON(data);
							console.log(data);
							if(data.result=="success")
							{
								$('#proceed_button').hide();
								refreshDetails1();
								swal("Updated Successfully");
							}
							else
							{
								swal("Not updated");
							}
						},		
						error: function() {
							console.log("Error"); 
							//alert('something bad happened'); 
						}
					});
		});		 
	});*/

	function refreshDetails1()
	{
		$.when(getInvoiceDetails(inv_customer_id)).done(function(){
			var table = $('#dataTable2').DataTable();
			table.destroy();	
			$('#total_amt_disp').html('');
			dispInvoiceDetails(invoice_JSON);				
		});
	}
	
	$('#closeDiv').click(function(){
		$('#firstDiv').show(1000);
		$('#secondDiv').hide(1000);
		$('#total_amt_disp').html('');
		$('#proceed_button').hide();
	});

});
