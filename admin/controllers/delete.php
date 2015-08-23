<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

Class DevcloudmanagerControllersDelete extends DevcloudmanagerControllersDefault
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
	
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$this->data = $app->input->get('jform', array(),'array');
		if($this->data['ddcinvd_id']!=null)
		{
			$model = new DevcloudmanagerModelsDdcinvoicedetails();
			if($model->deleteInvd($this->data['ddcinvd_id']))
			{
				$return['success'] = true;
				$return['msg'] = 'COM_DDC_DELETED??';
				$return['ddcinvd_id'] = $this->data['ddcinvd_id'];
			}
			echo json_encode($return);
		}
		elseif($this->data['ddctaskdetail_id']!=null)
		{
			$model = new DevcloudmanagerModelsDdctaskdetails();
			if($model->deleteTaskd($this->data['ddctaskdetail_id']))
			{
				$return['success'] = true;
				$return['msg'] = 'COM_DDC_DELETED??';
				$return['ddcinvd_id'] = $this->data['ddctaskdetail_id'];
			}
			echo json_encode($return);
		}
		else
		{
			$return['success'] = true;
			$return['myid'] = $app->input;
			echo json_encode($return);
		}
	}
	
}