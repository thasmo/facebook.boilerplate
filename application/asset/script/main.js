// main.js

(function() {

	var configuration;

	var application = {

		// user object
		user: {},

		// authenticates the user
		displayLogin: function(callback) {
			FB.login(function(response) {
				callback(response);
			}, {scope: configuration.facebook.scope});
		}
	};

	var main = function() {

		// initialize SDK
		FB.init({
			appId:                configuration.facebook.appId,
			cookie:               configuration.facebook.cookie,
			logging:              configuration.facebook.logging,
			status:               configuration.facebook.status,
			xfbml:                configuration.facebook.xfbml,
			channelUrl:           configuration.facebook.channelUrl,
			authResponse:         configuration.facebook.authResponse,
			frictionlessRequests: configuration.facebook.frictionlessRequests,
			hideFlashCallback:    configuration.facebook.hideFlashCallback
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

		// update user
		FB.getLoginStatus();

		// user logs in
		FB.Event.subscribe('auth.login', function(response) {

		});

		// user logs out
		FB.Event.subscribe('auth.logout', function(response) {

		});

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

		// user likes something
		FB.Event.subscribe('edge.create', function(response) {

		});

		// user unlikes something
		FB.Event.subscribe('edge.remove', function(response) {

		});
	};

	// facebook handling
	(function() {

		$.ajaxSetup({
			cache: true
		});

		$.when(
			$.getJSON('configuration.json', function(data) {
				configuration = data;
			}),
			$.getScript('//connect.facebook.net/en_US/all.js')
		).done(main);
	}());
}());
