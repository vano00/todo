<?php
	echo Form::open(array('class'=>'form-inline'));?>
	<div class="form-group">
		<?php echo Form::input(
			'task_name',
			null,
			array('placeholder'=>'Task name', 'class'=>'form-control')
		);?>
	</div>
	<?php echo Form::submit('task_submit', 'Create', array('class'=>'btn btn-default'));
	echo Form::close();
?>