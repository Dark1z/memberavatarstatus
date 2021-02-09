<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\avatar;
use phpbb\auth\auth;
use phpbb\user;
use phpbb\config\config;
use phpbb\language\language;

/**
 * Member Avatar & Status Event listener.
 */
class viewonline_listener implements EventSubscriberInterface
{
	/** @var avatar*/
	protected $avatar;

	/** @var auth */
	protected $auth;

	/** @var user */
	protected $user;

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/**
	 * Constructor for listener
	 *
	 * @param avatar		$avatar		dark1 avatar
	 * @param auth			$auth		phpBB auth
	 * @param user			$user		phpBB user
	 * @param config		$config		phpBB config
	 * @param language		$language	phpBB language
	 * @access public
	 */
	public function __construct(avatar $avatar, auth $auth, user $user, config $config, language $language)
	{
		$this->avatar		= $avatar;
		$this->auth			= $auth;
		$this->user			= $user;
		$this->config		= $config;
		$this->language		= $language;
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
		return [
			'core.viewonline_modify_sql'					=> 'mas_viewonline_page_query',
			'core.viewonline_modify_user_row'				=> 'mas_viewonline_page_template',
			'core.obtain_users_online_string_sql'			=> 'mas_viewonline_stat_block_query',
			'core.obtain_users_online_string_before_modify'	=> 'mas_viewonline_stat_block_template',
		];
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
		$sql_ary['SELECT'] = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_pg', '', 'u', 'user', '')['SELECT'];

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
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_vo_pg', 'user', $row);

		// Add Avatar to template_row
		$template_row = array_merge($template_row, [
			'AVATAR_IMG'	=> $avatar,
		]);

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
		$sql_ary['SELECT'] = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_sb', '', 'u', 'user', '')['SELECT'];

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
		$hidden_users = $event['online_users']['hidden_users'];
		$user_online_link = $event['user_online_link'];

		if ($this->avatar->mas_get_config_avatar('dark1_mas_vo_sb_av'))
		{
			foreach ($rowset as $row)
			{
				// Add avatar only for logged in User and not Hidden User
				if ($this->mas_viewonline_user_login($row['user_id'], $hidden_users))
				{
					// Get Avatar
					$avatar = $this->avatar->mas_get_avatar('dark1_mas_vo_sb', 'user', $row);
					$user_online_link[$row['user_id']] = $this->mas_viewonline_username_wrap($user_online_link[$row['user_id']], 'dark1_mas_vo_sb', $avatar);
				}
			}
		}

		// Assign user_online_link to event -> user_online_link
		$event['user_online_link'] = $user_online_link;
	}



	/** Private Functions **/



	/**
	 * MAS ViewOnline Check if User Login & not Hidden
	 *
	 * @param int $user_id takes User ID
	 * @param array $hidden_users is Hidden Users
	 * @return bool is User Login & not Hidden
	 * @access private
	 */
	private function mas_viewonline_user_login($user_id, $hidden_users)
	{
		return (bool) $user_id != ANONYMOUS && (!isset($hidden_users[$user_id]) || $this->auth->acl_get('u_viewonline') || $user_id === $this->user->data['user_id']);
	}



	/**
	 * MAS ViewOnline UserName Wrap
	 *
	 * @param string $username takes UserName
	 * @param string $config_key takes Config Key String
	 * @param string $avatar takes User Avatar IMG
	 * @return string String with Wrapped Main & UserName
	 * @access private
	 */
	private function mas_viewonline_username_wrap($username, $config_key, $avatar)
	{
		if ($this->avatar->mas_get_config_avatar($config_key . '_av'))
		{
			$avatar_size = (int) $this->config[$config_key . '_av_sz'];
			$avatar = !empty($avatar) ? $avatar : $this->avatar->mas_get_no_avatar_img();
			$username = '<span class="mas-wrap">' .
							'<span class="mas-avatar" style="width: ' . $avatar_size . 'px; height: ' . $avatar_size . 'px;">' . $avatar . '</span>' .
							'<span class="mas-username">' . $username . '</span>' .
						'</span>';
		}
		return $username;
	}

}
