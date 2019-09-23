<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\memberavatarstatus;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\user;

/**
 * Member Avatar & Status Event listener.
 */
class viewonline_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\memberavatarstatus */
	protected $mas_func;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor for listener
	 *
	 * @param \dark1\memberavatarstatus\core\memberavatarstatus		$mas_func	dark1 mas_func
	 * @param \phpbb\auth\auth										$auth		phpBB auth
	 * @param \phpbb\config\config									$config		phpBB config
	 * @param \phpbb\user											$user		phpBB user
	 * @access public
	 */
	public function __construct(memberavatarstatus $mas_func, auth $auth, config $config, user $user)
	{
		$this->mas_func		= $mas_func;
		$this->auth			= $auth;
		$this->config		= $config;
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
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_pg', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];

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
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_vo_pg', 'user', $row);

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
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_sb', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];

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

		if ($this->config['allow_avatar'] && $this->config['dark1_mas_vo_sb_av'])
		{
			foreach ($rowset as $row)
			{
				// Add avatar only for logged in User and not for Hidden User
				if ($row['user_id'] != ANONYMOUS && (!isset($online_users['hidden_users'][$row['user_id']]) || $this->auth->acl_get('u_viewonline') || $row['user_id'] === $this->user->data['user_id']))
				{
					// Get Avatar
					$avatar = $this->mas_func->mas_get_avatar('dark1_mas_vo_sb', 'user', $row);
					$username = $this->mas_func->mas_get_username_wrap($user_online_link[$row['user_id']], 'dark1_mas_vo_sb', $avatar, '');
					$user_online_link[$row['user_id']] = str_replace('div', 'span', $username);
				}
			}
		}

		// Assign user_online_link to event -> user_online_link
		$event['user_online_link'] = $user_online_link;
	}

}
