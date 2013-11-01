// bootstrap.js

var application = {};

(function() {

	$.ajaxSetup({
		cache: true
	});

	$.when(
		$.getJSON('/configuration.json', function(data) {
			application.configuration = data;
		}),
		$.getScript('//connect.facebook.net/en_US/all.js')
	).done(function() {
		application.main();
	});
}());
