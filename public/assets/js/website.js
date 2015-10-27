var uriBase = '/';

$(function() {

   	// Checkbox synchronization
   	$('#todo_list input[type=checkbox]').change(function() {
       	var $this = $(this);
       	$.post(
          	uriBase + 'project/change_task_status',
           	{
              	'task_id': $this.data('task_id'),
               	'new_status': $this.is(':checked') ? 1 : 0
           	}
		); 
   	});

	// Move task
	var $todoList = $('#todo_list');
	$todoList.sortable({
		handle: ".drag",
		// The stop event is called when the user drop an item
		// (when the sorting process has stopped).
		'stop': function() {
			// remove the cancel boxes
			//$('#message div').remove();
			// Remove the temporary deleted tasks
			$('#todo_list tr[style="display: none;"]').remove();
			// Collecting task ids from checkboxes in the
			// new order.
			var ids = [];
			$todoList.find('input[type=checkbox]').each(function() {
				ids.push($(this).data('task_id'));
			});
			// Sending the ordered task ids to the server.
			var uri = uriBase + 'project/change_tasks_order';
			var params = {
				'project_id': $todoList.data('project_id'),
				'task_ids': ids
			};

			$.post(uri, params);
		}
	});
	$todoList.disableSelection();

	// Delete and restore a task
	$('#todo_list tr a').on('click', function(event){

		var $task = $(this).closest('tr');
		var task_rank = $task.data('task_rank');
		var task_id = $task.find('input').data('task_id');

		$task.fadeOut(function() {
    		//task.delay( 6000 ).remove();
    	})

    	// Sending the deleted task ids to the server.
		var uri = uriBase + 'project/delete_task';

		$.post(uri, {task_id});

		// Displaying cancel message
		var $task_message = $('<div class="cancel_deleting">Task deleted<a href="#" class="pull-right" data-task_id="' + task_id + '">CANCEL</a></div>');
		var message_height = $('#message').outerHeight();
		$('#message').animate({height: message_height + 70 }, "slow");
		$('#message').append($task_message);
		$task_message.css("display", "none").fadeIn('slow');

		// restore a task
		$('#message a[data-task_id="' + task_id + '"]').on('click', function(event){
			var message_height = $('#message').outerHeight();
			$(this).closest('div').fadeTo('slow', 0, function(){
				$('#message').animate({height: message_height - 70 }, "slow")
				$(this).animate({height: 0, padding: 0, margin: 0, "font-size":0 }, "slow", function() {
					//$(this).remove();
				});

			})

	    	// Sending the deleted task ids to the server.
			var uri = uriBase + 'project/restore_task';
			var params = {
				'task_id': $(this).data('task_id')
			};

			$.post(uri, params);

			// Display the task again
			$('#todo_list tr[data-task_rank=\'' + task_rank + '\']').fadeIn();

		})

	})

	// Edit task
	$('div.task').click(function(event){
    	$(this).prop('contenteditable',true).addClass('editable');
    	$(this).focus();
    	$(this).keypress(function(e){ return e.which != 13; });

    	var $task = $(this).closest('tr');
    	var task_id = $task.find('input').data('task_id');

		$('html').click(function() {
			$('div.task').prop('contenteditable',false).removeClass('editable');

			var uri = uriBase + 'project/edit_task';
			var params = {
				'task_id': task_id,
				'task_content': $task.find('div.task').text()
			};

			$.post(uri, params);
		});

    	event.stopPropagation();
	})

});