var HubApp = (function(){
    'use strict';

	function _createEventListeners(){

	}

	function _pusherNewGitPush(){
		var notificationsChannel = pusher.subscribe('git');

        notificationsChannel.bind('new_push', function(notification){
            var message = notification.message;
			bootbox.alert(message + '<br />' + task_name + '<br />' + comment);
        });
	}

	function init(){
        _createEventListeners();
		_pusherNewGitPush();
    }

    return {
        init: init
    };
})();
jQuery( HubApp.init() );
