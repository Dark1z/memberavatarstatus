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
use dark1\memberavatarstatus\core\memberavatarstatus;

/**
 * Member Avatar & Status Event listener.
 */
class memberlist_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\memberavatarstatus */
	protected $mas;

	/**
	 * Constructor for listener
	 *
	 * @param \dark1\memberavatarstatus\core\memberavatarstatus		$mas	dark1 mas
	 * @access public
	 */
	public function __construct(memberavatarstatus $mas)
	{
		$this->mas		= $mas;
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
			'core.memberlist_team_modify_query'				=> 'mas_memberlist_team_query',
			'core.memberlist_team_modify_template_vars'		=> 'mas_memberlist_team_template',
		);
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
		$temp_sql_ary = $this->mas->mas_avatar_sql_query($sql_ary, 'dark1_mas_ml', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];
		$sql_ary = $this->mas->mas_online_sql_query($sql_ary, 'dark1_mas_ml', 'ug.user_id', 's', '', '');

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
		$avatar = $this->mas->mas_get_avatar('dark1_mas_ml', 'user', $row);

		// Get Online Status
		$online = (!($row['user_type'] == USER_INACTIVE)) ? $this->mas->mas_get_online('dark1_mas_ml', '', $row) : '';

		// Add Avatar & Online Status to template_vars
		$template_vars = array_merge(
			$template_vars,
			array(
				'AVATAR_IMG'	=> $avatar,
				'S_ONLINE'		=> $online,
			)
		);

		// Assign template_vars to event -> template_vars
		$event['template_vars'] = $template_vars;
	}

}
