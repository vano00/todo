<?php

class Model_Task extends \Orm\Model_Soft
{
	protected static $_properties = array(
		'id',
		'name',
		'status',
		'rank',
		'project_id',
		'created_at',
		'updated_at',
		'deleted_at'
	);

	protected static $_soft_delete = array(
        'deleted_field' => 'deleted_at',
        'mysql_timestamp' => true,
    );

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'tasks';

	protected static $_belongs_to = array('project');

}
