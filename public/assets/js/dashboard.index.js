var DashboardIndex = (function(){
    'use strict';

	function _createEventListeners(){

	}

	function _pusherNotifications(){
		var notificationsChannel = pusher.subscribe('notifications');

        notificationsChannel.bind('new_notification', function(notification){
            var message = notification.message;
            $('div.notification').text(message);
        });
	}

	function init(){
        _createEventListeners();
		_pusherNotifications();
    }

    return {
        init: init
    };
})();
jQuery( DashboardIndex.init() );
