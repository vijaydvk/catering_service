$(document).ready(function() {
	getnotificationDetails();
	function getnotificationDetails()
	{
		return $.ajax({
			url: base_URL+'index.php/foodcorridor_controller/loadnotificationData',
			type:'POST',
			success:function(data){
				
				var js = $.parseJSON(data);
				console.log(data);
				//console.log(js[0].count);
				$('.label-count').html(js.count[0].count);
				$('#balance_display').html(js.total[0].total);
			},		
			error: function() {
				console.log("Error"); 
				//alert('something bad happened'); 
			}
		}) ;
	}


});
