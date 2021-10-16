jQuery(document).ready(function($){

	var z = $("#TT_type option:selected").text();
	var has_mos = z.search(/مسافربری/i);
	if( has_mos !== -1 ){
		$(".hide_beg_add_inroute").show(300);
		$(".hide_beg_add_inroute").prop('required', true);
		$(".hide_des_add_inroute").show(300);
		$(".hide_des_add_inroute").prop('required', true);
	}

	$("#TT_type").change(function(){
		var z = $("#TT_type option:selected").text();
	var has_mos = z.search(/مسافربری/i);
		if( has_mos !== -1 ){
			$(".hide_beg_add_inroute").show(500);
			$(".hide_beg_add_inroute").prop('required', true);
			$(".hide_des_add_inroute").show(500);
			$(".hide_des_add_inroute").prop('required', true);
		}else{
			$(".hide_beg_add_inroute").hide(500);
			$(".hide_des_add_inroute").hide(500);
		}
	});

	function GetURLParameter(sParam)
	{
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) 
		{
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) 
			{
				return sParameterName[1];
			}
		}
	}
	var tech = GetURLParameter('id');

	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	var base_url = window.location.origin;

	$("#out_ex").attr('href', base_url+'/wp-json/api/output/?date='+year+month+day+'&inroute='+tech );

	$("#day, #month, #year").change(function(){

		var day = $('#day').val();
		var month = $('#month').val();
		var year = $('#year').val();
		var base_url = window.location.origin;

		$("#out_ex").attr('href', base_url+'/wp-json/api/output/?date='+year+month+day+'&inroute='+tech );
		
	});

});