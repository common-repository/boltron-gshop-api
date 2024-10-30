$(document).ready(function(){  
	$("#_boltron_google_target_country").change(function(){
	 
		var targetCountry = $("#_boltron_google_target_country").val();
		
		var nounce = $( '#google_merchant_extra_fields' ).val();
	       
		$.ajax({
		      url: ajaxurl,
		      type: "POST",
		      data: { 'action': 'get_language_from_country', 'targetCountry': targetCountry, 'security' : nounce},
		      dataType: "json",
		      success: function (response) {
			
			var language = response.language;
			var currency = response.currency;
			
			$('#_boltron_google_content_language').val(language);
			$('#_boltron_google_product_price_currency').val(currency);
			$('#_boltron_google_shipping_price_currency').val(currency);
		      }
		  });
    
	 
	}); 
  
  
});