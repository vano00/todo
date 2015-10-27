<?php echo render('task/list', array('project' => $project)); ?>
<br>
<p><?php echo Html::anchor('project/edit/'.$project->id, 'Edit'); ?> |
<?php echo Html::anchor('project', 'Back'); ?></p>