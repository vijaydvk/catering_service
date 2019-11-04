$(document).ready(function() {
	var customer_JSON;
	var fti;
	var o_fti;
	var fta;
	var o_fta;
	var ftt;
	var o_ftt;
        var count=0;
	var totalAmount=0;
	var flag=1;
	var customer_id;
	$('#customer_body').hide();
	$('#customerDetailsdiv').hide();
	$('#bs_datepicker_container input').datepicker({
	 format: 'dd/mm/yyyy', 
	autoclose: true,
	container: '#bs_datepicker_container'
	}).datepicker('update', new Date());
	
 	$("#billing_form").validate({
		 errorPlacement: function(error, element) {
			//	console.log(element);
             // element[0].parentNode.parentNode.append("Please enter proper details");
				error.appendTo(element[0].parentNode.parentNode);
         }
		
	}); 
	
	//$("#billing_form").validate();

	$.when(getCustomerDetails()).done(function(){
			dispCustomerDetails(customer_JSON);				
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

	function dispCustomerDetails(JSON)
	{
		$('.chosen-select').append('<option value="">-- Select customer --</option>');
		for(var i=0;i<JSON.length;i++)
		{
			$('.chosen-select').append('<option value="'+i+'">'+JSON[i].customer_name+' - '+JSON[i].customer_phonenumber+'</option>');
		}
		$('.chosen-select').chosen({search_contains: true});
		$('.chosen-select').trigger("chosen:updated");
		setTimeout(function(){
			$('#customer_select_chosen').click();
		},100);
		
	}

	$('.chosen-select').on('change', function(evt, params) {
		count=0;
		$('#customerTotalsdiv').show();
	    $('#customer_body').show();
		$('#customer_billing_body').html('');
		var r_index = $(".chosen-select").val();
		customer_id = customer_JSON[r_index].customer_id;
		fti=customer_JSON[r_index].food_type_id;
		o_fti=fti.split(",");
		fta=customer_JSON[r_index].amount;
		o_fta=fta.split(",");
		ftt=customer_JSON[r_index].food_type;
		o_ftt=ftt.split(",");
		dispFoodTypeDetails();
		var selector = "cat_"+1;
		setTimeout(function(){
		$("#"+selector).focus();
		},100);
		$('#displayCustomerName').html(customer_JSON[r_index].customer_name);
		$('#displayCustomerAddress').html(customer_JSON[r_index].customer_address);
		$('#displayCustomerGst').html(customer_JSON[r_index].customer_gst);
		$('#customerDetailsdiv').show();
		//console.log(selector);
	});

	function dispFoodTypeDetails()
	{
		var values=new Array();
		$("select.catClass").each(function()
		{
		if($(this).val()!="" && $(this).val()!="8")
		    values.push($(this).val());
		});
		//console.log(values);
		if($('#cat_'+count).val()=="")
		{
			$('#cat_'+count).focus();
			swal({
			  title: "Problem",   
			  text: "Select Category !",   
			  type: "error" 
			});			
		}
		else
		{
			count++;
			$('#customer_billing_body').append('<div class="col-md-12" id="col_'+count+'"></div>');
			$('#col_'+count).append('<div class="col-sm-3">'+
									'<div class="form-group">'+
										'<div class="form-line">'+
											'<select class="form-control catClass" id="cat_'+count+'" name="cat[]" data-cc="'+count+'"></select>'+											
										'</div>'+
									'</div>'+
								'</div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="desc'+count+'"><div class="form-line">'+
											'<input type="text" data-cc="'+count+'" id="desc_'+count+'"  name="des[]" value=" " class="form-control" placeholder="Description" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-1"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" data-cc="'+count+'" id="tax_'+count+'"  value="5" name="tax[]" class="form-control taxClass qtyClass1 numm" placeholder="Tax" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" data-cc="'+count+'" id="qty_'+count+'"  data-amt="" name="qty[]" class="form-control qtyClass qtyClass1 numm" placeholder="Quantity" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" id="amt_'+count+'"   data-cc="'+count+'"  data-tracking="'+count+'" data-checkk="true" name="amt[]" class="form-control amtClass qtyClass1 numm" placeholder="Amount" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"> <div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" id="total_'+count+'" name="subtotal[]" readonly class="form-control tot_class" placeholder="Total" />'+
							 '</div></div></div>');
			$('#cat_'+count).append('<option value="">-- Please select --</option>');
			for(var i=0;i<o_fti.length;i++)
			{
				var trim_val = o_fti[i];
				trim_val=trim_val.trim();
				$('#cat_'+count).append('<option value="'+trim_val+'"  amt="'+o_fta[i]+'" cnt="'+count+'" >'+o_ftt[i]+'</option>');
			}
			//$('#cat_'+count).selectpicker('refresh');
			if(values.length>0)
			{	

				for(var i=0;i<values.length;i++)
				{
					$('#cat_'+count+' option[value="'+values[i]+'"]').remove();
				}
			}
			$('#cat_'+count).click();
			totalAmount=0;
			$("input[class *= 'tot_class']").each(function(){
					if($(this).val()==="")
					{
						totalAmount += 0;
					}
					else
					{
						totalAmount += parseFloat($(this).val());
					}
			});
			displayTotal(totalAmount);
		}
	
	}
	
	$(document).on('keypress blur','.special_cat',function(event) {
	// If the keypress event code is 13 (Enter)
   	     var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13' || event.type=="focusout"){
			var this_cnt = $(this).attr("data-cnt");
			$(this).attr("type","hidden");
			$('#tax_'+this_cnt).focus();
		}
	});

	$(document).on('change','select.catClass',function(event){
		 var keycode = (event.keyCode ? event.keyCode : event.which);
		//console.log(event.type+" "+event.keyCode+" "+event.which);
		var track_count = $(this).attr("data-cc");
		//if(keycode == '13' && event.type=="keypress")
		//{
		if($(this).val()!=="")
			{
				
				$('#des_'+track_count).attr("type","hidden");
				$('#des_'+track_count).val("-");
				var d_amt=$('option:selected',this).attr("amt").trim();
				var ccnt = $('option:selected',this).attr("cnt").trim();
				$('#amt_'+ccnt).val(d_amt);
				console.log(ccnt+" "+d_amt);
				$('#qty_'+count).attr("data-amt",d_amt);
				//alert(d_amt);
				calculateAmount(track_count);
				$('#tax_'+track_count).focus();
			}
			else
			{
				$('#tax_'+track_count).focus();
			}
		//} 
	});
	
/* 	$(document).on('click','select.catClass',function(){
		var track_count = $(this).attr("data-cc");
		if($(this).val()==8)
		{
			$('#des_'+track_count).attr("type","text");
			$('#des_'+track_count).focus();
			$('#amt_'+track_count).val("");
		}
		/*else
		{
			$('#des_'+track_count).attr("type","hidden");
			$('#des_'+track_count).val("-");
			var d_amt=$('option:selected',this).attr("amt");
			var ccnt = $('option:selected',this).attr("cnt");
			$('#amt_'+ccnt).val(d_amt);
			$('#qty_'+count).attr("data-amt",d_amt);
			//alert(d_amt);
		*/
	/*}); */
	
	$(document).on('keypress blur','.taxClass',function(event){
		var track_count = $(this).attr("data-cc");
   	    var keycode = (event.keyCode ? event.keyCode : event.which);
    	 if(keycode == '13'||event.type=="focusout"){
			calculateAmount(track_count);
			if(!event.type=="focusout")
			$('#qty_'+track_count).focus();
		}
		if(keycode == '13')
		{
			$('#qty_'+track_count).focus();
		}	 	
		
	});
	
	$(document).on('keypress blur','.qtyClass',function(event){
		var track_count = $(this).attr("data-cc");
   	    var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13'||event.type=="focusout")
		{
			calculateAmount(track_count);
			if(!event.type=="focusout")
			$('#amt_'+track_count).focus();
		}
		if(keycode == '13')
		{
			$('#amt_'+track_count).focus();
		}
		
	});
	
	$(document).on('keypress blur','.amtClass',function(event){
		var track_count = $(this).attr("data-cc");
		var nxt = track_count+1;
   	    var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13'||event.type=="focusout"){
			calculateAmount(track_count);
			if((track_count-count)==0||count==1)
				{
					dispFoodTypeDetails();
					if(!event.type=="focusout")
					$('#cat_'+nxt).focus();
				}
			else
			{
				if(!event.type=="focusout")
				$('#cat_'+nxt).focus();
			}
		}
		if(keycode == '13')
		{
			$('#cat_'+nxt).focus();
		}
		
	});
	
	
	function calculateAmount(track_count)
	{
		var d_amt=$('#amt_'+track_count).val();
		var d_qty=$('#qty_'+track_count).val();
		//console.log(d_amt);
		//console.log(d_qty);
		var tt_amt = (d_amt*d_qty)*$('#tax_'+track_count).val()/100;
		var final_amt = (d_amt*d_qty)+tt_amt;
		final_amt = final_amt.toFixed(2);
		$('#total_'+track_count).val(final_amt);
	 	totalAmount=0;
		$("input[class *= 'tot_class']").each(function(){
					if($(this).val()==="")
					{
						totalAmount += 0;
					}
					else
					{
						totalAmount += parseFloat($(this).val());
					}
		});
		displayTotal(totalAmount);
	}
	
	
	function popupCall(track_count)
	{
		
	}

	$(document).on('focus','.qtyClass1',function()
	{
		if(count>1)
		{
		var val = $('#cat_'+count).val();
		if(val=="")
		{
			$('#col_'+count).remove();
			count--;
			flag="0";
			totalAmount=0;
			    $("input[class *= 'tot_class']").each(function(){
					if($(this).val()==="")
					{
						totalAmount += 0;
					}
					else
					{
						totalAmount += parseFloat($(this).val());
					}
			    });			
				displayTotal(totalAmount);
			
		}
		}
		
	});
	
	
	
	function displayTotal(totalAmount)
	{
		console.log(totalAmount);
		$('#tt').html(totalAmount);
		$('#total').val(totalAmount);
		var f_total=$('#tt').html();
		var check_val = $('input[name=discounttype]:checked').val();
		//console.log(check_val);
		if (check_val>=0) {	
			if(check_val==0)
			{
				if($('#discountvalue').val()>100)
				{
					$('#discountvalue').focus();
								swal({
								  title: "Problem",   
								  text: "Percentage Must be Lesser than 100 !",   
								  type: "error" 
								});	
								
				}
				else
				{
					$('#finaltotal').val(f_total-(f_total*$('#discountvalue').val())/100);
					$('#save_billing').focus();
				}
			}
			if(check_val==1)
			{
				if($('#discountvalue').val()>f_total)
				{
					$('#finaltotal').focus();
						swal({
							  title: "Problem",   
							  text: "Value Must be lesser than total !",   
							  type: "error" 
							});		
							
				}
				else
				{
					$('#finaltotal').val((f_total)-$('#discountvalue').val());
					$('#save_billing').focus();
				}
			}
			
		}
		else
		{
			$('#finaltotal').val(f_total);
		}

		
				
	}

	/*$(document).on('blur','.qty_class',function(){
        var tracking=$(this).attr("data-tracking");
		var d_amt=$('#amt_'+tracking).val();
		var d_qty=$('#qty_'+tracking).val();
		//console.log(d_amt);
		//console.log(d_qty);
		var tt_amt = (d_amt*d_qty)*$('#tax_'+tracking).val()/100;
		var final_amt = (d_amt*d_qty)+tt_amt;
		final_amt = final_amt.toFixed(2);
		$('#total_'+tracking).val(final_amt);
		//console.log(totalAmount);
		dispFoodTypeDetails();
	});*/

	$(document).on('click','#save_billing',function(){
	    $('#save_billing').attr('disabled', 'disabled');
		var errorFlag=0;
		var val = $('#cat_'+count).val();
		if(val=="")
		{
			$('#col_'+count).remove();
			count--;
			flag="0";
			totalAmount=0;
				$("input[class *= 'tot_class']").each(function(){
					if($(this).val()==="")
					{
						totalAmount += 0;
					}
					else
					{
						totalAmount += parseFloat($(this).val());
					}
				});			
				displayTotal(totalAmount);
			
		}
		$('.numm').each(function() {
			if($(this).val()=="")
			{
				$(this).css("border-bottom","1px solid red");
				errorFlag=1;
				return false;
			}
			 if(isNaN(!$(this).val())){
				$(this).css("border-bottom","1px solid red");
				errorFlag=1;
				return false;
			 }
		});
		
		$('.catClass').each(function() {
			if($(this).val()=="")
			{
				$(this).css("border-bottom","1px solid red");
				errorFlag=1;
				return false;
			}
		});		
		if($('#finaltotal').val()!="NaN"&&$('#finaltotal').val()>0&&errorFlag==0)
		{
				if($("#billing_form").valid())
				{
					swal({
						title: "Are you sure?",
						text: "Are you sure want to save!",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Yes,",
						cancelButtonText: "No",
						closeOnConfirm: true,
						closeOnCancel: true,
						focusConfirm: true,
					},
					function(isConfirm) {
						if (isConfirm) {
							var form = $('#billing_form')[0];
							var data = new FormData(form);
							data.append("customer_id",customer_id);
							request = $.ajax({
									type: "POST",
									enctype: 'multipart/form-data',
									url: base_URL+'index.php/foodcorridor_controller/insertBill',
									data: data,
									processData: false,
									contentType: false,
									cache: false,
									timeout: 600000,
							});	
							request.done(function (response){
								var js = $.parseJSON(response);
								console.log(js);	
									if(js.status=="success")
									{
										$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
											$("#success-alert").slideUp(500);
										});
										$('#customer_billing_body').html('');
										count=0;
										totalAmount=0;
										$('#customerTotalsdiv').hide();
										$('#customer_body').hide();
										$('#customerDetailsdiv').hide();
										$(".chosen-select").val("").trigger("chosen:updated");
										$('#billing_form').trigger("reset");
									}
									$('#save_billing').removeAttr("disabled");
							});
						} else {
							$('#discountvalue').focus();
							$('#save_billing').removeAttr("disabled");
							swal("Cancelled", "You cancelled save", "error");
						}
					});
				}
				else
				{
				    $('#save_billing').removeAttr("disabled");
				}

		}
		else
		{
			swal("Please Fill the All Details");
			$('#save_billing').removeAttr("disabled");
			
		}
	});
	
	/*$(document).on('focus','#discountvalue',function(e){
			var check_val = $('input[name=discounttype]:checked').val();
			console.log(check_val);
			if (check_val>=0) {				
			}
			else
			{
				alert("Must select discount");
				$('#finaltotal').focus();
			}
	});*/
	
	$(document).on('keypress blur','#discountvalue',function(e){
       if(e.keyCode=='13'||e.type=="focusout")
	   {
		   //alert("hi");
		   var f_total=parseInt($('#tt').html());
		   var check_val = $('input[name=discounttype]:checked').val();
			console.log(check_val);
			if (check_val>=0) {	
				if(check_val==0)
				{
					if($('#discountvalue').val()>100)
					{
						$('#discountvalue').focus();
									swal({
									  title: "Problem",   
									  text: "Percentage Must be Lesser than 100 !",   
									  type: "error" 
									});	
									
					}
					else
					{
						$('#finaltotal').val(f_total-(f_total*$('#discountvalue').val())/100);
						$('#save_billing').focus();
					}
				}
				if(check_val==1)
				{
					if($('#discountvalue').val()>f_total)
					{
						$('#finaltotal').focus();
							swal({
								  title: "Problem",   
								  text: "Value Must be lesser than total !",   
								  type: "error" 
								});		
								
					}
					else
					{
						$('#finaltotal').val((f_total)-$('#discountvalue').val());
						$('#save_billing').focus();
					}
				}
				
			}
			else
			{
				$('#finaltotal').val(f_total);
			}
			/*else
			{
				var r = confirm("Are you sure generate invoice without discount!");
					if (r == true) {
						$('#finaltotal').focus();
					}
					else
					{
						$('#under_0').focus();
					}
			}*/
	   }
	});
	
	$(document).on('keypress','input[type="radio"]',function(e){
		if((e.keyCode ? e.keyCode : e.which) == 13){
			$(this).trigger('click');
		}
	});
	
	$(document).on('change','input[type="radio"]',function(e){
		if((e.keyCode ? e.keyCode : e.which) == 13){
			$(this).trigger('click');
		}
		totalAmount=0;
		$("input[class *= 'tot_class']").each(function(){
					if($(this).val()==="")
					{
						totalAmount += 0;
					}
					else
					{
						totalAmount += parseFloat($(this).val());
					}
		});
		displayTotal(totalAmount);
	});

});
