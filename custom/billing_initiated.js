$(document).ready(function() {
	var Process_JSON;
	//var invoice_id_JSON;
	$.when(getProcesseDetails()).done(function(){
		dispProcessDetails(Process_JSON);				
	});


	function getProcesseDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadProcessData',
			type:'POST',
			success:function(data){
				//console.log(data);
				Process_JSON = $.parseJSON(data);
				
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}

	function dispProcessDetails(dataJSON)
	{
		//console.log(dataJSON);
		$('#dataTable').dataTable( {
			"aaSorting":[],
			"aaData": dataJSON,
			responsive: true,
			"aoColumns": [
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						return data.invoice_ids;
						
					}
				},
				{ "mDataProp": "customer_name" },
				{ 
					"mDataProp": function ( data, type, full, meta) { 
						return 'Rs:'+data.total;
						
					}
				},
				{ 
					"mDataProp": function ( data, type, full, meta) {
						var ddate = new Date(data.createdat);
						var n = ddate.toDateString();
						return n;
						
					}
				},					
				{ 
					"mDataProp": function ( data, type, full, meta) {
						return '<a id="'+ meta.row +'" class="btn Btnupdate" style="padding:0px;" role="button" data-toggle="tooltip" data-placement="top" title="Click to edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
						
					}
				},
			]  				
		});
	}
	
	
  $(document).on("click",".Btnupdate", function(e) {
	  var r_index = $(this).attr("id"); 
	  var process_id = Process_JSON[r_index].process_id;
	  var invoice_ids = Process_JSON[r_index].invoice_ids;
	  var updateFlag = "Yes";
    var buttons = $('<div><textarea class="form-control" id="comment" name="comment" value="" rows="3" placeholder="Fill the comments"></textarea>')
    .append(createButton('Close', function() {
       swal.close();
    })).append(createButton('Confirm', function() {
       swal.close();
       //alert($('#comment').val());
	   updateFlag = "Yes";
	   updateProcess(process_id,invoice_ids,$('#comment').val(),updateFlag);
	   
    })).append(createButton('Decline', function() {
       swal.close();
	   updateFlag = "No";
	   updateProcess(process_id,invoice_ids,$('#comment').val(),updateFlag);
       //alert($('#comment').val());
    }));
    
    e.preventDefault();
    swal({
      title: "Confirm Payment",
      html: buttons,
      //type: "warning",
      showConfirmButton: false,
      showCancelButton: false
    });
  });
  
  function updateProcess(process_id,invoice_ids,comment,updateFlag)
  {
		$.ajax({
			url: base_URL+'index.php/foodcorridor_controller/updateProcessData',
			type:'POST',
			data:{"process_id":process_id,"invoice_ids":invoice_ids,"comment":comment,"updateFlag":updateFlag},
			success:function(data){
				//console.log(data);
				data = $.parseJSON(data);
				console.log(data);
				if(data.result=="success")
				{
					refreshDetails();
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

function createButton(text, cb) {
  return $('<button class="btn btn-info" style="margin:5px;">' + text + '</button>').on('click', cb);
}
	
	$('#proceed_button').click(function(){
		var selected = new Array();
		  $("input:checkbox:checked").each(function() {
			   selected.push($(this).val());
		  });
		swal({
			title: "Submit all bills?",
			text: "Are you sure you want to submit bills",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		}, function () {
				$.ajax({
						url: base_URL+'index.php/foodcorridor_controller/saveInvoiceProcessData',
						type:'POST',
						data:{"invoice_id":selected},
						success:function(data){
							//console.log(data);
							data = $.parseJSON(data);
							console.log(data);
							if(data.result=="success")
							{
								refreshDetails();
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
	});

	function refreshDetails()
	{
		$.when(getProcesseDetails()).done(function(){
			var table = $('#dataTable').DataTable();
			table.destroy();	
			dispProcessDetails(Process_JSON);				
		});
	}
});

