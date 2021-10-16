jQuery(document).ready(function($){
	
    $( ".have-code" ).click(function(){
        $(".discount-form").slideToggle();
    });
    
	var z = $(".TT_cat option:selected").text();
	var has_mos = z.search(/مسافربری/i);
	if( has_mos !== -1 ){
		$(".hide_beg_add_inroute").show(300);
		$(".hide_beg_add_inroute").prop('required', true);
		$(".hide_des_add_inroute").show(300);
		$(".hide_des_add_inroute").prop('required', true);
	}

	$(".TT_cat").change(function(){
		var z = $(".TT_cat option:selected").text();
		var has_mos = z.search(/مسافربری/i);
		if( has_mos !== -1 ){
			$(".hide_beg_add_inroute").show(500);
			$(".hide_beg_add_inroute").prop('required', true);
			$(".hide_des_add_inroute").show(500);
			$(".hide_des_add_inroute").prop('required', true);
		}else{
			$(".hide_beg_add_inroute").hide(500);
			$(".hide_beg_add_inroute").prop('required', false);
			$(".hide_des_add_inroute").hide(500);
			$(".hide_des_add_inroute").prop('required', false);
		}
	});
    

	$('input[type=radio]').on('change', function() {
		var z = $('input[name=tt_number]:checked').val();
		$('#tt_number_hidden').val(z);
	});

    
});