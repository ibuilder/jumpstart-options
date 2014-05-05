jQuery(document).ready(function($){
	// Inspired by http://www.zajtra.sk/programovanie/490/videocast-turbotip-4-jquery-fullpage-load-a-zobrazenie-stranky-az-po-jej-kompletnom-nacitani

	// document is ready, LET'S ROCK
	jQuery(function()
	{
		cartDiv = document.createElement('div');
		cartDiv.id					= "altbg";
		cartDiv.style.width 		= "100%";
		cartDiv.style.height 		= '100%';
		cartDiv.style.background	= '#333333';
		cartDiv.style.position		= 'absolute';
		cartDiv.style.top			= 0;
		cartDiv.style.left			= 0;
		document.body.appendChild(cartDiv);

		var spinner = new Spinner().spin(cartDiv);
	});

	// website is fully loaded, LET'S STOP ROCKIN'
	jQuery(window).load(function()
	{
		jQuery('.spinner').fadeOut('slow', function()
		{
			jQuery('#altbg').fadeOut();
		});
	});

});