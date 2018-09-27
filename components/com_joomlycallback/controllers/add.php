<?php
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class JoomlycallbackControllerAdd extends JoomlycallbackController
{
	
	public function save()
	{	
		$url = JFactory::getURI();
		$app    = JFactory::getApplication();
		$input  = $app->input;
		$method = $input->getMethod();
		
		$data = array();
		$data = $app->input->post->getArray($_POST);
		
		$mod = 	($data['module_id']!==null) ? $data['module_id'] : 0;
		$model= $this->getModel('add');
		$params = $model->getParams($data['module_id']);
		$url_redirect = (!empty($params->redirect_page)) ? $params->redirect_page : JFactory::getURI();
		
		if ($data['module_hash'] == JUserHelper::getCryptedPassword($url->toString()))
		{
			//Check captcha errors
			if  ($params->captcha == 1)
			{
				$ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					'secret' => $params->captcha_secretkey, 
					'remoteip' => $data['ip'], 
					'response' => $data['g-recaptcha-response']
				));
				$result_c  = json_decode(curl_exec($ch));
				curl_close($ch);

				if (!empty($params->captcha_secretkey))
				{
					if (isset($result_c->success) && ($result_c->success == 1))
					{
						$res = 11;
					} else
					{
						unset($data["email"]);
						$app->setUserState('joomly_callback.add.form.data', $data);
						setcookie('callback_captcha', null, -1,'/',null);
						setcookie('callback-sending-alert',$mod,time()+60,'/',null);
						setcookie('callback-alert-type',"captcha",time()+60,'/',null);
						$app->redirect(JRoute::_($url, false));
					}
				}
			}
			
			if ($data['cur_time'] == 0){
				$data['time'] = $data['time-today'];	
			}	else{
				$data['time'] = $data['time-any'];	
			}	
			
			$data["call_time"] = $data["time"].' '.$data["day"];

			JTable::addIncludePath(JPATH_COMPONENT.'/tables/');
			$row = JTable::getInstance('joomlycallback', 'Table');		
			
			if (!$row->bind($data)){
				echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
					
			if (!$row->store()){
				echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}


			$model= $this->getModel('add');
			$model->sendMessage($data,$params);
				
			setcookie('callback-sending-alert',$mod,time()+60,'/',null);
			setcookie('callback-alert-type',"success",time()+60,'/',null);
			$app->redirect(JRoute::_($url_redirect, false));
		} else 
		{
			setcookie('callback_captcha', null, -1,'/',null);
			setcookie('callback-sending-alert',$mod,time()+60,'/',null);
			setcookie('callback-alert-type',"captcha",time()+60,'/',null);
			$app->redirect(JRoute::_($url_redirect, false));	
		}
	}
}
