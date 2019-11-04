$(document).ready(function() {
			
	var invoice_id_tracking;
	var search_key;
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
	var tabindex=1;
	var customer_id;
	$('#customer_body').hide();
	$('#customerDetailsdiv').hide();
	$('#bs_datepicker_container input').datepicker({
    format: 'dd/mm/yyyy', 	  
	autoclose: true,
	container: '#bs_datepicker_container'
	}).datepicker('update', new Date());
	
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
			$('.chosen-select').append('<option value="'+JSON[i].customer_id+'">'+JSON[i].customer_name+' - '+JSON[i].customer_phonenumber+'</option>');
		}
		$('.chosen-select').chosen({search_contains: true});
		$('.chosen-select').trigger("chosen:updated");
		$('.chosen-select1').append('<option value="">-- Select customer --</option>');
		for(var i=0;i<JSON.length;i++)
		{
			$('.chosen-select1').append('<option value="'+JSON[i].customer_id+'">'+JSON[i].customer_name+' - '+JSON[i].customer_phonenumber+'</option>');
		}
		$('.chosen-select1').chosen({search_contains: true,width:'100%'});
		$('.chosen-select1').trigger("chosen:updated");			
		setTimeout(function(){
			$('#customer_select_chosen').click();
		},100);
		
	}

	/*$('.chosen-select').on('change', function(evt, params) {
		count=0;
	    $('#customer_body').show();
		$('#customer_billing_body').html('');
		tabindex=1;
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
	});*/

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
											'<input type="number" data-cc="'+count+'" id="tax_'+count+'" value="5" name="tax[]" class="form-control taxClass qtyClass1 numm" placeholder="Tax" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" data-cc="'+count+'" id="qty_'+count+'" data-amt="" name="qty[]" class="form-control qtyClass qtyClass1 numm" placeholder="Quantity" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" id="amt_'+count+'"  data-cc="'+count+'"  data-tracking="'+count+'" data-checkk="true" name="amt[]" class="form-control amtClass qtyClass1 numm" placeholder="Amount" />'+
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
	
	$(document).on('keypress blur','.taxClass',function(event){
		var track_count = $(this).attr("data-cc");
   	    var keycode = (event.keyCode ? event.keyCode : event.which);
    	 if(keycode == '13'||event.type=="focusout"){
			calculateAmount(track_count);
			if(!event.type=="focusout")
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
			tabindex=tabindex-4;
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
			
		//alert(invoice_id_tracking);
		var errorFlag=0;
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
		if(errorFlag==0)
		{
		    swal({
				title: "Update Bill",
				text: "Are you sure? update bill",
				type: "info",
				showCancelButton: true,
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
			}, function () {
				var form = $('#billing_form1')[0];
				var data = new FormData(form);
				customer_id=$('#customer_select1').val();
				data.append("customer_id",customer_id);
				data.append("invoice_id",invoice_id_tracking);
				request = $.ajax({
						type: "POST",
						enctype: 'multipart/form-data',
						url: base_URL+'index.php/foodcorridor_controller/updateBill',
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
							$('#top_div').show(1000);
							count=0;
							totalAmount=0;							
							tabindex=1;
							$('#billing_form').trigger("reset");
							$('#customerTotalsdiv').hide(1000);
							$('#bill_no').val();
							$('#arrowDiv').hide(1000);							
							$('#success_alert').hide(1000);
							$('#invoice_select_id').html();
							$('#customer_body').hide(1000);
							$('#customerDetailsdiv').hide(1000);
							$(".chosen-select").val("").trigger("chosen:updated");
							$('#bs_datepicker_container input').datepicker("refresh");
							swal("Bill Has been updated sucessfully!");
						}
				});
			});
		}
		else
		{
			
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
	
	$('#search').click(function(){
		$('#customerDetailsdiv').html('');
		if($('#bill_no').val()=="" && $('#customer_select').val()=="")
		{
			swal("Select bill 0r Customer");
		}
		else if($('#bill_no').val()!="")
		{
			
			$.when(billNoAjax()).done(function(){
			});
		}
		else if($('#customer_select').val()!="")
		{
			$.when(billCustomerAjax()).done(function(){				
			});
		}
		
	});
	
	
	function billCustomerAjax()
	{
		//var data = new FormData();
		//data.append("invoice_id",$('#bill_no').val());
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceBillCustomerData',
			type:'POST',
			data:{"customer_id":$('#customer_select').val()},
			success:function(data){
				//console.log(data);
				var rdata = $.parseJSON(data);
				//customer_JSON = $.parseJSON(data);
				if(rdata.length>0)
					displayInvoiceIds(rdata);
				else
					swal("No details found"); 
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}
	

	function billNoAjax()
	{
		//var data = new FormData();
		//data.append("invoice_id",$('#bill_no').val());
		invoice_id_tracking = $('#bill_no').val();
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceBillNoData',
			type:'POST',
			data:{"invoice_id":$('#bill_no').val()},
			success:function(data){
				var rdata = $.parseJSON(data);
				search_key="billno";
				//console.log(rdata.invoice.length);
				//customer_JSON = $.parseJSON(data);
				if(rdata.invoice.length>0)
					displaDetailsByBillNo(rdata);
				else
					swal("No details found"); 
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}
	
	function displaDetailsByBillNo(ddata)
	{
		$('#arrowDiv').show(1000);
		$('#top_div').hide(1000);
		//console.log(search_key);
		if(search_key==="billno")
		{
			$('#success_alert').hide(1000);
		}
		else
		{
			$('#success_alert').show(1000);
		}
		var r_index;
		//console.log(customer_JSON[i].length);
		customer_id = ddata.invoice[0].customer_id;
		for(var i=0;i<customer_JSON.length;i++)
		{
			if(customer_JSON[i].customer_id == ddata.invoice[0].customer_id)
			{
				r_index=i;
				break;
			}
		}
		count=0;
		tabindex=0;
	    $('#customer_body').show(1000);
		$('#customerTotalsdiv').show(1000);
		$(".chosen-select1").val(customer_JSON[r_index].customer_id).trigger("chosen:updated");
		console.log(ddata.invoice[0].date);
		//$("#date").val(ddata.invoice[0].date);
		$('#invoice_date').datepicker('setDate', ddata.invoice[0].date);		
		$('#customer_billing_body').html('');
		$('#displayCustomerName').html(customer_JSON[r_index].customer_name);
		$('#displayCustomerAddress').html(customer_JSON[r_index].customer_address);
		$('#displayCustomerGst').html(customer_JSON[r_index].customer_gst);
		$('#customerDetailsdiv').show(); 
		fti=customer_JSON[r_index].food_type_id;
		o_fti=fti.split(",");
		fta=customer_JSON[r_index].amount;
		o_fta=fta.split(",");
		ftt=customer_JSON[r_index].food_type;
		o_ftt=ftt.split(",");
		console.log(ddata.invoice_details);
		for	(var i=0;i<ddata.invoice_details.length;i++)
		{
			var values=new Array();
			$("select.catClass").each(function()
			{
			if($(this).val()!="" && $(this).val()!="8")
				values.push($(this).val());
			});
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
											'<input type="text" data-cc="'+count+'" id="desc_'+count+'"  name="des[]" value="'+ddata.invoice_details[i].description+'" class="form-control" placeholder="Description" />'+
							 '</div></div></div>');								
			$('#col_'+count).append('<div class="col-sm-1"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" data-cc="'+count+'" id="tax_'+count+'" value="'+ddata.invoice_details[i].tax+'" name="tax[]" class="form-control taxClass qtyClass1 numm" placeholder="Tax" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" data-cc="'+count+'" id="qty_'+count+'" value="'+ddata.invoice_details[i].quantity+'"  data-amt="" name="qty[]" class="form-control qtyClass qtyClass1 numm" placeholder="Quantity" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"><div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" id="amt_'+count+'" data-cc="'+count+'" value="'+ddata.invoice_details[i].price+'"   data-tracking="'+count+'" data-checkk="true" name="amt[]" class="form-control amtClass qtyClass1 numm" placeholder="Amount" />'+
							 '</div></div></div>');
			$('#col_'+count).append('<div class="col-sm-2"> <div class="form-group" id="spa'+count+'"><div class="form-line">'+
											'<input type="number" id="total_'+count+'" name="subtotal[]" value="'+ddata.invoice_details[i].subtotal+'" readonly class="form-control tot_class" placeholder="Total" />'+
							 '</div></div></div>');
			$('#cat_'+count).append('<option value="">-- Please select --</option>');
			for(var ij=0;ij<o_fti.length;ij++)
			{
				var trim_val = o_fti[ij];
				trim_val=trim_val.trim();
				$('#cat_'+count).append('<option value="'+trim_val+'"  amt="'+o_fta[ij]+'" cnt="'+count+'" >'+o_ftt[ij]+'</option>');
			}
			$('#cat_'+count).val(ddata.invoice_details[i].food_type_id);
			//$('#cat_'+count).selectpicker('refresh');
			if(values.length>0)
			{	

				for(var ji=0;ji<values.length;ji++)
				{
					$('#cat_'+count+' option[value="'+values[ji]+'"]').remove();
				}
			}
		}
		
		//console.log(ddata.invoice[0].total);
		$('#tt').html(ddata.invoice[0].total);
		$('#total').val(ddata.invoice[0].total);
		if(ddata.invoice[0].discounttype!=100)
		{
			$("input[name=discounttype][value="+ddata.invoice[0].discounttype+"]").attr('checked', true);
		}
		$('#discountvalue').val(ddata.invoice[0].discountvalue);
		$('#finaltotal').val(ddata.invoice[0].finaltotal);
		/*	$('#customer_billing_body').append('<div class="col-md-12 text-left bottom"><div class="col-md-3" style="float:right;"><strong>Total&nbsp;&nbsp;&nbsp;&nbsp;</strong><span id="tt">'+ddata.invoice[0].total+'</span><input type="hidden" name="total" value="'+ddata.invoice[0].total+'" /></div></div>'+
												'<div class="col-md-12 text-center bottom"><div class="col-md-3 text-left" style="float:right;">Discount:<input type="radio" tabindex="'+tabindex+++'" id="under_0" name="discounttype" value="0"> <label for="under_0" class="light">Per %</label>'+
												'<input type="radio" tabindex="'+tabindex+++'" id="over_1" value="1"  name="discounttype" > <label for="over_1" class="light">Amount</label>'+
												'</div></div><div class="col-md-12 text-center bottom"><div class="col-md-3 text-left" style="float:right;"><input type="text" class="form-control" tabindex="'+tabindex+++'" value="'+ddata.invoice[0].discountvalue+'" name="discountvalue" id="discountvalue" /></div></div>'+
												'<div class="col-md-12 text-left bottom"><div class="col-md-3" style="float:right;"><strong>Final Total&nbsp;&nbsp;&nbsp;&nbsp;</strong><input type="text" id="finaltotal" name="finaltotal" class="form-control" readonly value="'+ddata.invoice[0].finaltotal+'" /></div></div>'+
												'<div class="col-md-12 text-center bottom"><div class="col-md-4"></div><div class="col-md-4"><button type="button" class="btn btn-success btn-block" id="save_billing" name="save_billing">Save</button></div></div>');	
		if(ddata.invoice[0].discounttype!=100)
		{
			$("input[name=discounttype][value="+ddata.invoice[0].discounttype+"]").attr('checked', true);
		}*/

	}
	
	function displayInvoiceIds(inviddata)
	{
		if ( $.fn.DataTable.isDataTable('#example') ) {
		  $('#example').DataTable().destroy();
		}
		//$('#success_alert').show(1000);
		//console.log(dataJSON);
		$('#example').dataTable( {
			"aaSorting":[],
			"aaData": inviddata,
			responsive: true,
			"aoColumns": [
				{ "mDataProp": "invoice_id" },
				{ "mDataProp": "customer_name" },
{ 
					"mDataProp": function ( data, type, full, meta) {
						return 'Rs : '+ data.finaltotal ;
					}
				},	
				{ "mDataProp": "date" },
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ data.invoice_id +'" class="btn Btnview" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
					}
				},			
			]  				
		});
	$('#success_alert').show(1000);
	$('#customer_body').hide(1000);
	$('#customerTotalsdiv').hide(1000);
		//$('#success_alert').fadeIn("slow");
	}
	
	$(document).on('click','.Btnview',function()
	{
		invoice_id_tracking = $(this).attr("id");
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadInvoiceBillNoData',
			type:'POST',
			data:{"invoice_id":invoice_id_tracking},
			success:function(data){
				var rdata = $.parseJSON(data);
				search_key="billcustomer";
				//console.log(rdata.invoice.length);
				//customer_JSON = $.parseJSON(data);
				if(rdata.invoice.length>0)
					displaDetailsByBillNo(rdata);
				else
					swal("No details found"); 
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;		
	});
	
	$('#arrowDiv').click(function(){
		$('#arrowDiv').hide(1000);
		$('#top_div').show(1000);
	});
	
	$(document).on('keypress','input[type="radio"]',function(e){
    if((e.keyCode ? e.keyCode : e.which) == 13){
        $(this).trigger('click');
    }
	});
	
	$(document).on('click','input[type="radio"]',function(e){
		if(count>1)
		{
		var val = $('#cat_'+count).val();
		if(val=="")
		{
			$('#col_'+count).remove();
			tabindex=tabindex-4;
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
	
	$(document).on('click','input',function(){
		$(this).focus();
	});

});
