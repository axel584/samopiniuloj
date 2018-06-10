
$(document).bind('pageinit',function () {
	// on initialise avec la date
	var today = new Date();
	$("#lib-date").text(today.toDateString());
	
	

$("#next").live('click',function () { 
	//alert();
	var date = new Date($("#lib-date").text());
	date.setDate(date.getDate()+1);
	$("#lib-date").text(date.toDateString());
});


$("#prev").live('click',function () { 
	var date = new Date($("#lib-date").text());
	date.setDate(date.getDate()-1);
	$("#lib-date").text(date.toDateString());
});


$("#today").live('click',function () { 
	var date = new Date();
	$("#lib-date").text(date.toDateString());
});

$("#recherche").submit(function() {
	alert("submit");
	return false;
});

$("#recherche").blur(function() {
	alert("blur");
	return false;
});

$("#recherche").change(function() {
	// c'est lˆ qu'on propose d'ajouter le truc
	alert("change");
	return false;
});
	
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

