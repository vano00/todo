<?php
class Controller_Project extends Controller_Template
{

	public function action_index()
	{
		//$data['projects'] = Model_Project::find('all');
		$data['projects'] = Model_Project::find('all', array(
       		'related' => array(
           		'tasks' 
			),
   		));

		$this->template->title = "Projects";
		$this->template->content = View::forge('project/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('project');

		$data['project'] = Model_Project::find($id, array(
       		'related' => array(
           		'tasks' => array(
            	'order_by' => 'rank',
				), 
			),
   		));

   		if ( ! $data['project'])
		{
			Session::set_flash('error', 'Could not find project #'.$id);
			Response::redirect('project');
		}

		// Checking first if we received a POST request
	   	if (Input::method() == 'POST')
	   	{
	       	// Getting the task name. If empty, we display an
	       	// error, otherwise we attempt to create the new
	       	// task
	       	$task_name = Input::post('task_name', '');

	       	if ($task_name == '') {
	           	// Setting the flash session variable named
	           	// error. Reminder: this variable is displayed
	           	// in the template using Session::get_flash
	           	Session::set_flash(
					'error',
	               	'The task name is empty!'
	           	);
	       	} else {
	           	$task = Model_Task::forge();
	           	$task->name = $task_name;
	           	$task->status = 0;
	           	// Appending the task at the end of the to-do list
   				$task->rank = count($data['project']->tasks);
	           	$data['project']->tasks[] = $task;
	           	$data['project']->save();
	           	// When the task has been saved, we redirect
	           	// the browser to the same webpage. This
	           	// prevents the form from being submitted
	           	// again if the user refreshes the webpage
	           Response::redirect('project/view/'.$id);
			} 	
		}

		$this->template->title = $data['project']->name;
		$this->template->content = View::forge('project/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Project::validate('create');

			if ($val->run())
			{
				$project = Model_Project::forge(array(
					'name' => Input::post('name'),
				));

				if ($project and $project->save())
				{
					Session::set_flash('success', 'Added project #'.$project->id.'.');

					Response::redirect('project');
				}

				else
				{
					Session::set_flash('error', 'Could not save project.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Projects";
		$this->template->content = View::forge('project/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('project');

		if ( ! $project = Model_Project::find($id))
		{
			Session::set_flash('error', 'Could not find project #'.$id);
			Response::redirect('project');
		}

		$val = Model_Project::validate('edit');

		if ($val->run())
		{
			$project->name = Input::post('name');

			if ($project->save())
			{
				Session::set_flash('success', 'Updated project #' . $id);

				Response::redirect('project');
			}

			else
			{
				Session::set_flash('error', 'Could not update project #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$project->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('project', $project, false);
		}

		$this->template->title = "Projects";
		$this->template->content = View::forge('project/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('project');

		if ($project = Model_Project::find($id))
		{
			$project->delete();

			Session::set_flash('success', 'Deleted project #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete project #'.$id);
		}

		Response::redirect('project');

	}

	public function action_change_task_status()
   	{
        if (Input::is_ajax()) {
            $task = Model_Task::find(intval(Input::post('task_id')));
            $task->status = intval(Input::post('new_status'));
            $task->save();
		}
        return false; // we return no content at all
   	}

   	public function action_change_tasks_order() {
       	if (Input::is_ajax()) {
           	$project = Model_Project::find(
               	intval(Input::post('project_id'))
           	);
           	// Changing the rank property according to the
           	// list of ids received by the controller
           	$task_ids = Input::post('task_ids');
           	for ($i = 0; $i < count($task_ids); $i++) {
               	$task_id = intval($task_ids[$i]);
               	$project->tasks[$task_id]->rank = $i;
           	}
           	$project->save();
       }
       return false; // we return no content at all
   	}

   	public function action_delete_task()
   	{
        if (Input::is_ajax()) {

            $task = Model_Task::find(intval(Input::post('task_id')));
            $task->delete();
		}
        return false; // we return no content at all
   	}

   	public function action_restore_task()
   	{
        if (Input::is_ajax()) {

            $task = Model_Task::deleted(intval(Input::post('task_id')));
            $task->restore();
		}
        return false; // we return no content at all
   	}

   	public function action_edit_task()
   	{
        if (Input::is_ajax()) {

            $task = Model_Task::find(intval(Input::post('task_id')));
            $task->name = trim(Security::clean(Input::post('task_content')));
            $task->save();
		}
        return false; // we return no content at all
   	}

}
