<h2>Listing <span class='muted'>Projects</span></h2>
<br>
<?php if ($projects): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($projects as $item): ?>		<tr>

			<td><?php echo $item->name; ?> has <?php echo count($item->tasks); echo Inflector::pluralize(' task', count($item->tasks)) ?> </td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group pull-right">
						<?php echo Html::anchor('project/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('project/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('project/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Projects.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('project/create', 'Add new Project', array('class' => 'btn btn-success')); ?>

</p>
