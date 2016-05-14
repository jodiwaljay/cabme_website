<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<?php
$user = JFactory::getUser();
$userId = $user->get( 'id' );
//echo $userId.'<br>';

$user =JFactory::getUser();
    /*foreach ($user->groups as $registered_user => $value){
        //echo $registered_user.'<br>';
    }
    echo $registered_user;
if($registered_user==2):*/ ?>

<fieldset id="users-profile-core" class="register_user">
	<legend>
		<?php echo JText::_('COM_USERS_PROFILE_CORE_LEGEND'); ?>
	</legend>
	<dl class="dl-horizontal">
		<dt><?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?></dt>
		<span>:</span>
		<dd><?php echo $this->data->name; ?></dd>

		<dt><?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?></dt>
		<span>:</span>
		<dd><?php echo htmlspecialchars($this->data->username); ?></dd>

		<dt><?php echo JText::_('Profile Pic'); ?></dt>
		<span>:</span>
		<?php $picval=$this->data->profile_pic; if(!empty($picval)){
		?>
		<dd><div class="user_pic"><img src="<?php echo JURI::root().'components/com_users/profilepic/'.$picval; ?>" /></div></dd>
		<?php }else{  ?>
			<dd><img src="<?php echo JURI::root().'images/no-profile-img.png' ?>" /></dd>
			<?php } ?>
		<dt><?php echo JText::_('COM_USERS_PROFILE_EMAIL_LABEL'); ?></dt>
		<span>:</span>
		<dd><?php echo htmlspecialchars($this->data->email1); ?></dd>

		<dt><?php echo JText::_('COM_USERS_PROFILE_MOBILE_LABEL'); ?></dt>
		<span>:</span>
		<dd><?php echo htmlspecialchars($this->data->mobile); ?></dd>

		<dt><?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></dt>
		<span>:</span>
		<dd><?php echo JHtml::_('date', $this->data->registerDate); ?></dd>

		<dt><?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></dt>
		<span>:</span>
		<?php if ($this->data->lastvisitDate != '0000-00-00 00:00:00'){?>
			<dd><?php echo JHtml::_('date', $this->data->lastvisitDate); ?></dd>
		<?php }
		else
		{?>
			<dd><?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?></dd>
		<?php } ?>

	</dl>
</fieldset>

