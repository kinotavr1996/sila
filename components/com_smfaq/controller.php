<?php
/**
 * SMFAQ
 *
 * @package		Component for Joomla 2.5.6+
 * @version		1.7.3
 * @copyright	(C)2009 - 2013 by SmokerMan (http://joomla-code.ru)
 * @license		GNU/GPL v.3 see http://www.gnu.org/licenses/gpl.html
 */

// защита от прямого доступа
defined('_JEXEC') or die('@-_-@');

jimport('joomla.application.component.controller');

class SmfaqController extends JControllerLegacy
{
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	public function display($cachable = true, $urlparams = false)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$user		= JFactory::getUser();

		$vName	= $app->input->get('view', 'category');
		$app->input->set('view', $vName);

		$id	= $app->input->get('id', null, 'int'); 

		$auth = $user->authorise('core.edit', 'com_smfaq.category.'.$id);

		if ($auth ||($_SERVER['REQUEST_METHOD'] == 'POST' || $vName == 'edit')) {
			$cachable = false;
		}

		$safeurlparams = array(
			'id'				=> 'INT',
			'limit'				=> 'INT',
			'limitstart'		=> 'INT',
			'catid'				=> 'INT'
			);

		return parent::display($cachable, $safeurlparams);
	}

	/**
	 * Метод для загрузки формы
	 */
	public function showform()
	{
		$view = $this->getView('form', 'html');
		$view->display();
		exit;
	}

	/**
	 * Метод для отправки формы вопроса
	 * @return array json
	 */
	public function send()
	{
		// инициализация переменных для ответа
		$app = JFactory::getApplication();
		$post = $app->input->post;
		$catid = $post->get('catid', null, 'int');

		$res['valid'] = false;
		$res['msg'] = '';
		$res['items'] = array();

		//проверка сессии
		$token = $post->get('token', null, 'alnum');
		
		if (version_compare(JVERSION, '3.0') >= 0) {
		    $app->input->post->set($token, '1');
		} else {
		    JRequest::setVar($token, 1);
		}
		$sesion = JFactory::getSession();
		if (!$sesion->checkToken()) {
		    $res['valid'] = false;
			$res['items'][] = array('name' => 'token', 'msg' => JText::_('COM_SMFAQ_SESSION_ERROR'), 't' => $sesion->getFormToken());
			echo json_encode($res);
		    exit;
		}
		
		$user = JFactory::getUser();
		// проверка ACL
		if (!$user->authorise('core.create', 'com_smfaq.category.'. $catid)) {
			$res['valid'] = false;
			$res['items'][] = array('name' => 'question', 'msg' => JText::_("COM_SMFAQ_ALERTNOAUTHOR"));
			echo json_encode($res);
			return;
		}
		
		// загрузка параметров
		$categories = JCategories::getInstance('SmFaq');
		$category = $categories->get($catid);
		$params = $category->getParams();
		
		$res = $this->validateForm($post, $params);
	
		// если все хорошо, отправляем вопрос
		if ($res['valid'] === true) {
			$model = $this->getModel('Category');
			if ($model->send($post, $category)) {
				$res['valid'] = true;

				// сброс каптчи
				if ($params->get('show_captcha')) {
					$res['captcha'] = true;
				}

				// Устанавка куки имени и email для гостей
				if ($user->guest) {
					$config = JFactory::getConfig();
					$cookie_domain = $config->get('cookie_domain', '');
					$cookie_path = $config->get('cookie_path', '/');
					setcookie(JApplication::getHash('com_smfaq.name'), $post->get('created_by', null, 'STRING'), time() + 365 * 86400, $cookie_path, $cookie_domain);
					if (!$params->get('show_email')) {
						setcookie(JApplication::getHash('com_smfaq.email'), $post->get('created_by_email', null, 'STRING'), time() + 365 * 86400, $cookie_path, $cookie_domain);
					}
				}
				
				// Установка сообщения
				if ($post->get('answer_email', 0, 'int') === 1) {
					$res['msg'] = JText::_('COM_SMFAQ_SEND_OK_SUB');
				} else {
					$res['msg'] = JText::_('COM_SMFAQ_SEND_OK');
				}

			} else {
				$res['valid'] = false;
				$res['msg'] = 'Error';
			}
		} else {
			$res['msg'] = $this->getErrors();
		}

		die(json_encode($res));

	}

	/**
	 * Проверка формы
	 * @param array		данные формы
	 * @param $params	параметры категории
	 * @return boolean
	 */
	protected function validateForm(&$post, $params)
	{
		$user = JFactory::getUser();
		
		$res = array();
		$res['valid'] = true;
		
		//проверка имени и email неавторизованого пользователя
		if ($user->guest) {
			// убираем id пользователя
			$post->set('user_id', null);

			$created_by = $post->get('created_by', null, 'STRING');
			if (preg_match('/[\"\'\[\]\=\<\>\(\)\;]+/', $created_by ) || (mb_strlen($created_by) < 3 )) {
				$res['items'][] = array('name' => 'created_by', 'msg' => JText::_('COM_SMFAQ_WRONG_NAME'));
				$res['valid'] = false;
			} else {
				$res['valid'] = true;
			}
			if (!$params->get('show_email')) {
			    $created_by_email = $post->get('created_by_email', null, 'STRING');
				if(strlen($created_by_email) < 4 || !preg_match('#^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#i', $created_by_email)) {
					$res['items'][] = array('name' => 'created_by_email', 'msg' => JText::_('COM_SMFAQ_WRONG_EMAIL'));
					$res['valid'] = false;
				}
			}
		} else {
			if ($params->get('created_by_type')) {
			    $post->set('created_by', $user->get('name'));
			} else {
			    $post->set('created_by', $user->get('username'));
			}
			
			$post->set('created_by_email', $user->get('email'));
			$post->set('user_id', $user->get('id'));
			$res['valid'] = true;
		}

		// проверка вопроса
		$question = $post->get('question', null, 'STRING');
		if(mb_strlen($question) < $params->get('min_length_question', 10)) {
			$res['items'][] = array('name' => 'question', 'msg' => JText::sprintf('COM_SMFAQ_WRONG_QUESTION', $params->get('min_length_question')));
			$res['valid'] = false;
		}

		// проверка captcha
		if (($params->get('show_captcha') && $user->guest) || ($params->get('show_captcha') == 2)) {
			$captcha = $post->get('captcha', null, 'STRING');
			$_SESSION['captcha-code'] = isset($_SESSION['captcha-code']) ? $_SESSION['captcha-code'] : false;
			if ($_SESSION['captcha-code'] && $captcha !== $_SESSION['captcha-code']) {
				$res['items'][] = array('name' => 'captcha', 'msg' => JText::_('COM_SMFAQ_WRONG_CAPTCHA'));
				$res['valid'] = false;
			}
		}

		JPluginHelper::importPlugin('smfaq');
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger('onSmfaqBeforeSend', array(&$res, &$post, &$params));
				
		return $res;
	}

	/**
	 * Метод для записи голосования
	 */
	public function storevote()
	{

		//проверка сессии
		$app = JFactory::getApplication();
		$token = $app->input->get('token', null, 'alnum');

		if (version_compare(JVERSION, '3.0') >= 0) {
			$app->input->post->set($token, '1');
		} else {
		    JRequest::setVar($token, 1);
		}
		
		if (!JSession::checkToken('post')) {
			echo JText::_('COM_SMFAQ_SESSION_ERROR');
			exit;
		}


		$id = $app->input->get('id', null, 'int');
		$vote_value = $app->input->get('vote', 0, 'int');
        $catid = $app->input->get('catid', 0, 'int');
        if (!$catid) {
        	echo 'SmFagError: Category not found';
        	exit;
        }
		// получение параметров категории
		$categories = JCategories::getInstance('SmFaq');
		$category = $categories->get($catid);
		$params = $category->getParams();

		// проверка включения опроса в категории
		if (!$params->get('show_poll')) {
			echo JText::_('COM_SMFAQ_POLL_DISABLED');
			return;
		}

		$model = $this->getModel('Category');
		$voting = $model->storeVote($id, $vote_value);

		// форма для комментария
		if ($vote_value == 0) {
			$view = $this->getView('comments', 'html');
			$view->display();
			exit;
		} else {
			$html = '<strong>'.JText::_('COM_SMFAQ_SANKS_FOR_VOTE').'</strong>';
		}

		die($html);

	}


	/**
	 * Метод для обновления captcha
	 */
	public function captcha()
	{
		$kcaptcha = JPATH_COMPONENT.'/libraries/kcaptcha/kcaptcha.php';

		if (is_file($kcaptcha)) {
			if (!class_exists('KCAPTCHA')) {
				require_once($kcaptcha);
			}
			$captcha = new KCAPTCHA();
			$_SESSION['captcha-code'] = $captcha->getKeyString();

		}
		exit;
	}

	/**
	 * Метод для отправки комментария
	 */
	public function comment() {
	    
	    $app = JFactory::getApplication();
		
	    $res = array();
		$res['valid'] = false;
		
		//проверка сессии
		$token = $app->input->get('token', null, 'alnum');
		if (version_compare(JVERSION, '3.0') >= 0) {
		    $app->input->post->set($token, '1');
		} else {
		    JRequest::setVar($token, 1);
		}
		if (!JSession::checkToken()) {
		    $res['t'] = JSession::getFormToken();
		    $res['msg'] = JText::_('COM_SMFAQ_SESSION_ERROR');
		    echo json_encode($res);
		    exit;
		}
		

		$id = $app->input->get('id', null, 'int');
		$comment =  $app->input->get('comment', null,'STRING');

		// проверка на кол-во символов
		if(utf8_strlen($comment) < 10 ) {
			$res['msg'] = JText::_('COM_SMFAQ_COMMENT_ERR_MSG');
			echo json_encode($res);
			exit;
		}

		$db		= JFactory::getDBO();
		$query = 'INSERT INTO #__smfaq_comments (question_id, comment, created)'.
				' VALUES ('.(int) $id.',' .$db->quote($comment). ', NOW())';
		$db->setQuery($query);
		if (!$db->query()) {
			$res['valid'] = false;
			$res['msg'] = $db->getErrorMsg();
			return;
		}
		$res['valid'] = true;
		$res['msg'] = JText::_('COM_SMFAQ_THANKS_FOR_COMMENT');

		die(json_encode($res));

	}

}