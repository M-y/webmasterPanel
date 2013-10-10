$(function(){
    $("#submit").click(function(){
        themesearch();
   })
})
function themesearch(){
 
	$("#submit").attr("disabled", true);
	$('#submit').val('Veri alınıyor. Lütfen bekleyiniz...');
	var siteler = $('.siteler').val();
	var user_city = $('.user_city').val();

	$.ajax({
		type: "POST",
		url: "moduller/warez-tema-tespit/search.php",
		data: "siteler="+siteler+"&user_city="+user_city,
		success: function(msg){
		
			$('#sonuc').html( msg );

		}
	});
}