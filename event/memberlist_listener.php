<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\avatar;
use dark1\memberavatarstatus\core\status;

/**
 * Member Avatar & Status Event listener.
 */
class memberlist_listener implements EventSubscriberInterface
{
	/** @var avatar*/
	protected $avatar;

	/** @var status*/
	protected $status;

	/**
	 * Constructor for listener
	 *
	 * @param avatar	$avatar		dark1 avatar
	 * @param status	$status		dark1 status
	 * @access public
	 */
	public function __construct(avatar $avatar, status $status)
	{
		$this->avatar	= $avatar;
		$this->status	= $status;
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
			'core.memberlist_team_modify_query'				=> 'mas_memberlist_team_query',
			'core.memberlist_team_modify_template_vars'		=> 'mas_memberlist_team_template',
		];
	}



	/**
	 * MAS MemberList Team SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_memberlist_team_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary['SELECT'] = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_ml', '', 'u', 'user', '')['SELECT'];
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_ml', 'u.user_id', 's', 'user', '', 'u.user_id, g.group_id');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS MemberList Team Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_memberlist_team_template($event)
	{
		// Get Event Array `row` & `template_vars`
		$row = $event['row'];
		$template_vars = $event['template_vars'];

		// Set Avatar
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_ml', 'user', $row);

		// Get Online Status
		$online = (!($row['user_type'] == USER_INACTIVE)) ? $this->status->mas_get_online('dark1_mas_ml', 'user', $row) : '';

		// Add Avatar & Online Status to template_vars
		$template_vars = array_merge($template_vars, [
			'AVATAR_IMG'	=> $avatar,
			'S_ONLINE'		=> $online,
		]);

		// Assign template_vars to event -> template_vars
		$event['template_vars'] = $template_vars;
	}

}
