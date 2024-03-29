<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Reset controller class for Users.
 *
 * @since  1.6
 */
class UsersControllerReset extends UsersController
{
	/**
	 * Method to request a password reset.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function request()
	{
		// Check the request token.
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Submit the password reset request.
		$return	= $model->processResetRequest($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_REQUEST_ERROR');
			}

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset' . $itemid;

			// Go back to the request form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// The request failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset' . $itemid;

			// Go back to the request form.
			$message = JText::sprintf('COM_USERS_RESET_REQUEST_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');

			return false;
		}
		else
		{
			// The request succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=confirm' . $itemid;

			// Proceed to step two.
			$this->setRedirect(JRoute::_($route, false));

			return true;
		}
	}

	/**
	 * Method to confirm the password request.
	 *
	 * @return  boolean
	 *
	 * @access	public
	 * @since   1.6
	 */
	public function confirm()
	{
		// Check the request token.
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->get('jform', array(), 'array');

		// Confirm the password reset request.
		$return	= $model->processResetConfirm($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_CONFIRM_ERROR');
			}

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=confirm' . $itemid;

			// Go back to the confirm form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// Confirm failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=confirm' . $itemid;

			// Go back to the confirm form.
			$message = JText::sprintf('COM_USERS_RESET_CONFIRM_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');

			return false;
		}
		else
		{
			// Confirm succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=complete' . $itemid;

			// Proceed to step three.
			$this->setRedirect(JRoute::_($route, false));

			return true;
		}
	}

	/**
	 * Method to complete the password reset process.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function complete()
	{
		// Check for request forgeries
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Complete the password reset request.
		$return	= $model->processResetComplete($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			if ($app->get('error_reporting'))
			{
				$message = $return->getMessage();
			}
			else
			{
				$message = JText::_('COM_USERS_RESET_COMPLETE_ERROR');
			}

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=complete' . $itemid;

			// Go back to the complete form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');

			return false;
		}
		elseif ($return === false)
		{
			// Complete failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=reset&layout=complete' . $itemid;

			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_RESET_COMPLETE_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');

			return false;
		}
		else
		{
			// Complete succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getLoginRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route  = 'index.php?option=com_users&view=login' . $itemid;

			// Proceed to the login form.
			$message = JText::_('COM_USERS_RESET_COMPLETE_SUCCESS');
			$this->setRedirect(JRoute::_($route, false), $message);

			return true;
		}
	}
	//Password change function starts 25-02-2016
	public function resetcheck()
	{
		// Check for request forgeries
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));

		$app   = JFactory::getApplication();
		$model = $this->getModel('Reset', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Complete the password reset request.
		$return	= $model->processResetCheck($data);

		if($return == true){

			// Complete succeeded.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getLoginRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route  = 'index.php?option=com_users&view=login' . $itemid;

			//auto logout after password change submit
			$app = JFactory::getApplication();
			$user = JFactory::getUser();
			$user_id = $user->get('id');
			$app->logout($user_id, array());

			//auto logout after password change submit
			$app = JFactory::getApplication();
			$user = JFactory::getUser();
			$user_id = $user->get('id');
			$app->logout($user_id, array());

			// Proceed to the login form.
			$message = JText::_('COM_USERS_RESET_COMPLETE_SUCCESS');
			$this->setRedirect(JRoute::_($route, false), $message);

			return true;
		}
		elseif ($return === false)
		{
			// Complete failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getResetRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route	= 'index.php?option=com_users&view=profile' . $itemid;

			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_RESET_COMPLETE_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');
			return false;
		}

	}

	public function passwordmatch(){
		$curpass = JRequest::getVar('curpass');
		$user =JFactory::getUser();
		$userId = $user->get( 'id' );
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
		->select('password')
		->from($db->quoteName('#__users'))
		->where($db->quoteName('id') . ' = ' . $db->quote($userId));


		$match = JUserHelper::verifyPassword($curpass, $user->password, $user->id);
        if($match==1)
        {
        	echo "1";
        }
        else
        {
        	echo "0";
        }
        exit;
		/*if($match == true){

		}*/

	}

}
