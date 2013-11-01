// main.js

application.main = function() {

	var configuration = this.configuration;

	// initialize SDK
	FB.init({
		appId:                configuration.facebook.appId,
		cookie:               configuration.facebook.cookie,
		logging:              configuration.facebook.logging,
		status:               configuration.facebook.status,
		xfbml:                configuration.facebook.xfbml,
		channelUrl:           configuration.facebook.channelUrl,
		frictionlessRequests: configuration.facebook.frictionlessRequests,
		authResponse:         configuration.facebook.authResponse,
		hideFlashCallback:    null
	});

	// scale canvas
	if(configuration.facebook.canvasWidth + configuration.facebook.canvasHeight > 0) {
		FB.Canvas.setSize({
			width:  configuration.facebook.canvasWidth,
			height: configuration.facebook.canvasHeight
		});
	} else {
		FB.Canvas.setAutoGrow();
	}

	// log performance
	FB.Canvas.setDoneLoading();

	// user changes status
	FB.Event.subscribe('auth.statusChange', function(response) {

		switch(response.status) {

			// user has authenticated
			case 'connected':

				break;

			// user has revoked authentication
			case 'not_authorized':

				break;

			// user has logged out
			default:
			case 'unknown':

				break;
		}
	});

	// user logs in
	FB.Event.subscribe('auth.login', function(response) {

	});

	// user logs out
	FB.Event.subscribe('auth.logout', function(response) {

	});

	// user likes something
	FB.Event.subscribe('edge.create', function(response) {

	});

	// user unlikes something
	FB.Event.subscribe('edge.remove', function(response) {

	});

	(function() {

		$(function() {
			$('.js-fb-authorize').on('click', function(event) {

				FB.login(function(response) {}, {
					scope: configuration.facebook.scope
				});

				event.preventDefault();
			});
		});

		$(function() {
			$('.js-fb-add').on('click', function(event) {

				FB.ui({
					method: 'pagetab'
				}, function(response){
					console.info('pagetab', response);
				});

				event.preventDefault();
			});
		});
	}());
};
