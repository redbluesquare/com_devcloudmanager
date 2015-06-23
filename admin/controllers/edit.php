<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

Class DevcloudmanagerControllersEdit extends DevcloudmanagerControllersDefault
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
	
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$this->data = $app->input->get('jform', array(),'array');
	
	
		if(isset($this->data['table']))
		{
			$task = $app->input->get('task', "", 'STR' );
			if($task==$this->data['table'].'.add')
			{
				$viewName = $app->input->getWord('view', $this->data['table'].'s');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
				//display view
				return parent::execute();
				 
			}
			if($task==$this->data['table'].".save")
			{
				$modelName  = $app->input->get('models', $this->data['table'].'s');
				$modelName  = 'DevcloudmanagerModels'.ucwords($modelName);
				$model = new $modelName();
				if($this->data['table'] == 'ddctaskdetail')
				{
					if( $row = $model->store() )
					{
						$return['success'] = true;
						$msg = JText::_('COM_DEVCLOUDMANAGER_SAVE_SUCCESS');
						
						$view = $app->input->get('view', 'ddctasks');
						$layout = $app->input->get('layout','_entry');
						$item = $app->input->get('item', 'tditem');
					
						$return['html'] = $row;
					
						
					}else{
						$return['msg'] = JText::_('COM_DEVCLOUDMANAGER_SAVE_FAILURE');
					}
					echo json_encode($return);
				}
				if ($this->data['table'] != 'ddctaskdetail')
				{
					if($row = $model->store() )
					{
						$return['success'] = true;
						$viewName = $app->input->getWord('view', $this->data['table'].'s');
						$app->input->set('view', $viewName);
						$app->input->set('layout','default');
						//display view
						return parent::execute();
					
					}else{
						$return['msg'] = JText::_('COM_DEVCLOUDMANAGER_SAVE_FAILURE');
						$app->input->set('layout','default');
						//display view
						return parent::execute();
					}
				}
				
				
				
			}
			if($task==$this->data['table'].".apply")
			{
				$modelName  = $app->input->get('models', $this->data['table'].'s');
				$modelName  = 'DevcloudmanagerModels'.ucwords($modelName);
				$model = new $modelName();
			
				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DEVCLOUDMANAGER_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DEVCLOUDMANAGER_SAVE_FAILURE');
				}
				$viewName = $app->input->getWord('view', $this->data['table'].'s');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
				//$app->input->set('item',$row->id);
				
				//display view
				return parent::execute();
			}
			if($task==$this->data['table'].".cancel")
			{
				$viewName = $app->input->getWord('view', $this->data['table'].'s');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
				//display view
				return parent::execute();
			}
			
		}
		else
		{
			$viewName = $app->input->getWord('view', 'dashboard');
			$app->input->set('layout','default');
			$app->input->set('view', $viewName);
			//display view
			return parent::execute();
		}
	}
	
}