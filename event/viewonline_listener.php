<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\mas_avatar;
use dark1\memberavatarstatus\core\mas_status;
use phpbb\auth\auth;
use phpbb\user;

/**
 * Member Avatar & Status Event listener.
 */
class viewonline_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\mas_avatar*/
	protected $mas_avatar;

	/** @var \dark1\memberavatarstatus\core\mas_status*/
	protected $mas_status;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor for listener
	 *
	 * @param \dark1\memberavatarstatus\core\mas_avatar		$mas_avatar		dark1 mas_avatar
	 * @param \dark1\memberavatarstatus\core\mas_status		$mas_status		dark1 mas_status
	 * @param \phpbb\auth\auth								$auth			phpBB auth
	 * @param \phpbb\user									$user			phpBB user
	 * @access public
	 */
	public function __construct(mas_avatar $mas_avatar, mas_status $mas_status, auth $auth, user $user)
	{
		$this->mas_avatar	= $mas_avatar;
		$this->mas_status	= $mas_status;
		$this->auth			= $auth;
		$this->user			= $user;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewonline_modify_sql'					=> 'mas_viewonline_page_query',
			'core.viewonline_modify_user_row'				=> 'mas_viewonline_page_template',
			'core.obtain_users_online_string_sql'			=> 'mas_viewonline_stat_block_query',
			'core.obtain_users_online_string_before_modify'	=> 'mas_viewonline_stat_block_template',
		);
	}



	/**
	 * MAS ViewOnline Avatar SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewonline_page_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary['SELECT'] = $this->mas_avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_pg', '', 'u', 'user', '')['SELECT'];

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS ViewOnline Avatar Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewonline_page_template($event)
	{
		// Get Event Array `row` & `template_row`
		$row = $event['row'];
		$template_row = $event['template_row'];

		// Get Avatar
		$avatar = $this->mas_avatar->mas_get_avatar('dark1_mas_vo_pg', 'user', $row);

		// Add Avatar to template_row
		$template_row = array_merge(
			$template_row,
			array(
				'AVATAR_IMG'	=> $avatar,
			)
		);

		// Assign template_row to event -> template_row
		$event['template_row'] = $template_row;
	}



	/**
	 * MAS ViewOnline Stat Block Avatar SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewonline_stat_block_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary['SELECT'] = $this->mas_avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_sb', '', 'u', 'user', '')['SELECT'];

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS ViewOnline Stat Block Avatar Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewonline_stat_block_template($event)
	{
		// Get Event Array `rowset` , `online_users` & `user_online_link`
		$rowset = $event['rowset'];
		$online_users = $event['online_users'];
		$user_online_link = $event['user_online_link'];

		if ($this->mas_avatar->mas_get_config_avatar('dark1_mas_vo_sb_av'))
		{
			foreach ($rowset as $row)
			{
				// Add avatar only for logged in User and not for Hidden User
				if ($row['user_id'] != ANONYMOUS && (!isset($online_users['hidden_users'][$row['user_id']]) || $this->auth->acl_get('u_viewonline') || $row['user_id'] === $this->user->data['user_id']))
				{
					// Get Avatar
					$avatar = $this->mas_avatar->mas_get_avatar('dark1_mas_vo_sb', 'user', $row);
					$username = $this->mas_get_username_wrap($user_online_link[$row['user_id']], 'dark1_mas_vo_sb', $avatar, '');
					$user_online_link[$row['user_id']] = str_replace('div', 'span', $username);
				}
			}
		}

		// Assign user_online_link to event -> user_online_link
		$event['user_online_link'] = $user_online_link;
	}



	/** Private Functions **/



	/**
	 * MAS Get Avatar IMG
	 *
	 * @param string $avatar takes User Avatar IMG
	 * @param int $avatar_size Specifies Avatar Size in px
	 * @return string String with Wrapped User Avatar IMG
	 * @access private
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	private function mas_get_avatar_img($avatar, $avatar_size = mas_avatar::AV_DEF_SZ_SML)
	{
		$start_avatar = '<div class="mas-avatar" style="width: ' . $avatar_size . 'px; height: ' . $avatar_size . 'px;">';
		$end_avatar = '</div>';
		return $start_avatar . (($avatar) ? $avatar : $this->mas_avatar->mas_get_no_avatar_img()) . $end_avatar;
	}



	/**
	 * MAS Get Online Status DOT
	 *
	 * @param string $online takes User Online Status
	 * @return string String with Wrapped User Online Status
	 * @access private
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	private function mas_get_online_status_dot($online)
	{
		$online_text = $this->language->lang('ONLINE');
		$offline_text = $this->language->lang('OFFLINE');
		$start_online = ' ' . '<div class="mas-wrap-status' . ($online ? ' mas-status-online' : '') . '">';
		$end_online = '</div>';
		$online_dot = '<span class="mas-status-dot mas-color" title="' . ($online ? $online_text : $offline_text) . '"/>';
		return $start_online . $online_dot . $end_online;
	}



	/**
	 * MAS Get UserName Wrap
	 *
	 * @param string $username takes UserName
	 * @param string $config_key takes Config Key String
	 * @param string $avatar takes User Avatar IMG
	 * @param string $online takes User Online Status
	 * @return string String with Wrapped Main & UserName
	 * @access private
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	private function mas_get_username_wrap($username, $config_key, $avatar, $online)
	{
		$start_wrap = '<div class="mas-wrap">';
		$start_username = '<div class="mas-username">';
		$end_tag = '</div>';
		$avatar_test = $this->mas_avatar->mas_get_config_avatar($config_key . '_av');
		$online_test = $this->mas_status->mas_get_config_online($config_key . '_ol');
		$avatar_wrap = ($avatar_test) ? $this->mas_get_avatar_img($avatar, (int) $this->config[$config_key . '_av_sz']) : '';
		$online_wrap = ($online_test) ? $this->mas_get_online_status_dot($online) : '';
		return ($avatar_test || $online_test) ? ($start_wrap . $avatar_wrap . $start_username . $username . $end_tag . $online_wrap . $end_tag) : $username;
	}

}
