<table class="table table-striped">
  <tbody id="todo_list" data-project_id="<?php echo $project->id; ?>">
<?php foreach ($project->tasks as $task): $input_id = 'todo_item_'.$task->id;?>    
    <tr data-task_rank="<?php echo $task->rank; ?>">
      <td>
        <span class="drag glyphicon glyphicon-th" aria-hidden="true"></span>
        <input
        type="checkbox"
        autocomplete="off"
        id="<?php echo $input_id; ?>"
        data-task_id="<?php echo $task->id; ?>"
        <?php echo $task->status ? 'checked' : ''; ?>
        >
        <div class="task">
          <?php echo $task->name; ?>
        </div>
      </td>
      <td>
        <div class="btn-toolbar">
          <div class="btn-group pull-right">
            <?php echo html::anchor('#', '<span class="glyphicon glyphicon-remove-sign"></span>'); ?>
           </div>
        </div>
      </td>
    </tr>
<?php endforeach; ?>  
  <tr>
      <td colspan="2">
        <?php echo render('task/create', array('project' => $project)); ?>
      </td>
    </tr>
  </tbody>
</table>