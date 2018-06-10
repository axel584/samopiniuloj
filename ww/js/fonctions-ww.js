//$(document).ready(function () {
//});

$(document).bind('pageinit',function () {
//$(document).ready(function () {
	$(".search").live('keyup',function () { 
		if ($(this).val().length>2) {
			$.ajax({
				type: "GET",
				url: "search.php",
				data : "q="+$(this).val(),
				dataType : "html",
				success: function(data){
					var content = $('.result-search').html();
						if (content!=data) {
							$('.result-search').html(''); 
							$('.result-search').html(data).trigger("create"); 
						}
						//$(this).trigger('create');
				}
			});
		}
		
	});

});

