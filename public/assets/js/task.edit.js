Dropzone.autoDiscover = false;

$(document).ready(function(){
    taskEdit.init();
});

var taskEdit = {
	task_id: $('#task-id').val(),

	deleteFile: function(that){
        var file_id = that.data('file-id');

        bootbox.confirm('Are you sure you want to delete this file?', function(result) {
            if( result ){
                $.post('/task/file-delete/'+file_id, function(data) {
                    if(data.status === true) {
                        $('#files-list').html(data.html);
						Messenger().post({
							message: 'File has been removed from task',
							type: "success"
						});
                    } else {
						Messenger().post({
							message: data.message,
							type: "error"
						});
                    }
                });
            }
        });
    },

	doDropzone: function(){
        var task_id = this.task_id;

        $('#real-dropzone').dropzone({
            uploadMultiple: false,
            parallelUploads: 1,
            maxFilesize: 8,
            addRemoveLinks: false,
            dictRemoveFile: 'Remove',
            dictFileTooBig: 'Image is bigger than 8MB',
            url: '/task/file-upload/' + task_id,

            // The setting up of the dropzone
            error: function(file, response) {
                var message = '';
                if($.type(response) === "string")
                    message = response; //dropzone sends it's own error messages in string
                else
                    message = response.message;

                bootbox.alert(message);

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response, done) {
                $('#files-list').html(response.file_table);
				Messenger().post({
					message: "File has been added to task",
					type: "success"
				});
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            uploadprogress: function(file, progress, bytesSent) {
                $('#instruction').html('Uploading '+file.name); 
            }
        });

    },

	processFilesFieldChange: function( that, field ){
        var file_id = that.data('file-id');

        var field = field == 'name' ? 'name' : 'description';// just in case something else gets passed

        $.post('/task/file-change-field/'+file_id, {field: field, value: that.val()}, function(data) {
            if(data.status == 'success') {
				Messenger().post({
					message: field + ' has been updated',
					type: "success"
				});
            } else {
				Messenger().post({
					message: result.error,
					type: "error"
				});
            }
        });
    },

	init: function(){
		var that = this;

		if( that.task_id ){
			that.doDropzone();
		}

		$('#files-list').on('click', '.delete-file', function(){
            that.deleteFile($(this));
        });

		$('#files-list').on('change', '.files-name', function(){
            that.processFilesFieldChange( $(this), 'name' );
        });

        $('#files-list').on('change', '.files-description', function(){
            that.processFilesFieldChange( $(this), 'description' );
        });
	}
};
