var HubApp = (function(){
    'use strict';

	function _createEventListeners(){

	}

	function _pusherNewGitPush(){
		var notificationsChannel = pusher.subscribe('task');

        notificationsChannel.bind('new_comment', function(notification){
            var message = notification.message;
            var task_name = notification.task_name;
            var comment = notification.comment;
			$.notify(message + '<br />' + task_name + '<br />' + comment);
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
