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
				if($row = $model->store() )
				{
					$return['success'] = true;
					if($this->data['table'] == 'ddcinvoice'):
						$invdmodel = new DevcloudmanagerModelsDdcinvoicedetails();
						$invdmodel->storeDetails($row->ddc_invoice_header_id);
						if($this->data['sendmail']==1):
							$sent = $this->_sendEmail($row->ddc_invoice_header_id);
						endif;
					endif;
					if($this->data['table'] == 'ddctaskdetail')
					{
						$viewName = $app->input->getWord('view', 'ddctasks');
					}else 
					{
						$viewName = $app->input->getWord('view', $this->data['table'].'s');
					}
					
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
				if($this->data['table']=='ddctaskdetail')
				{
					$viewName = 'ddctasks';
				}
				else{
					$viewName = $app->input->getWord('view', $this->data['table'].'s');
				}
				
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
	
	private function _sendEmail($id)
	{
		//save the new booking and send to customer
		$model = new DevcloudmanagerModelsDdcinvoices();
		$inv = $model->emailinvoice($id);
		$params = JComponentHelper::getParams('com_devcloudmanager');
	
		$app = JFactory::getApplication();
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');
		$sitename	= $app->getCfg('sitename');

		$body		= (string)$inv[0];
		$name		= $inv[1];
		$email		= $inv[2];
		$subject	= (string)$inv[3];
	
		$mail = JFactory::getMailer();
		$mail->addRecipient(array($email));
		$mail->addCC(array($mailfrom, $fromname));
		$mail->addReplyTo(array($mailfrom, $fromname));
		$mail->setSender(array($mailfrom, $fromname));
		$mail->setSubject($sitename.': '.$subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';
		$mail->setBody($body);
		$sent = $mail->Send();
		return $sent;
	}
	
}