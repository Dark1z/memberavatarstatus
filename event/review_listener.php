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

/**
 * Member Avatar & Status Event listener.
 */
class review_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\memberavatarstatus */
	protected $mas_func;

	/**
	 * Constructor for listener
	 *
	 * @param \dark1\memberavatarstatus\core\memberavatarstatus		$mas_func	dark1 mas_func
	 * @access public
	 */
	public function __construct(memberavatarstatus $mas_func)
	{
		$this->mas_func		= $mas_func;
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
			'core.topic_review_modify_sql_ary'				=> 'mas_posting_topic_review_query',
			'core.topic_review_modify_row'					=> 'mas_posting_topic_review_template',
			'core.message_history_modify_sql_ary'			=> 'mas_pm_history_review_query',
			'core.message_history_modify_template_vars'		=> 'mas_pm_history_review_template',
			'core.mcp_topic_modify_sql_ary'					=> 'mas_mcp_topic_review_query',
			'core.mcp_topic_review_modify_row'				=> 'mas_mcp_topic_review_template',
		);
	}



	/**
	 * MAS Posting Topic Review SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_posting_topic_review_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_rv', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_rv', 'u.user_id', 's', 'user', '');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS Posting Topic Review Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_posting_topic_review_template($event)
	{
		// Get Event Array `row` & `post_row`
		$row = $event['row'];
		$post_row = $event['post_row'];

		// Set Avatar
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_rv', 'user', $row);

		// Get Online Status
		$online = $this->mas_func->mas_get_online('dark1_mas_rv', 'user', $row);

		// Add Avatar & Online Status to post_row
		$post_row = array_merge(
			$post_row,
			array(
				'AVATAR_IMG'	=> $avatar,
				'S_ONLINE'		=> $online,
			)
		);

		// Assign post_row to event -> post_row
		$event['post_row'] = $post_row;
	}



	/**
	 * MAS PM History Review SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_pm_history_review_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_rv', 'u.user_id', 's', 'user', '');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS PM History Review Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_pm_history_review_template($event)
	{
		// Get Event Array `row` & `template_vars`
		$row = $event['row'];
		$template_vars = $event['template_vars'];

		// Set Avatar
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_rv', 'user', $row);

		// Get Online Status
		$online = $this->mas_func->mas_get_online('dark1_mas_rv', 'user', $row);

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



	/**
	 * MAS MCP Topic Review SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_mcp_topic_review_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_rv', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_rv', 'u.user_id', 's', 'user', '');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS MCP Topic Review Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_mcp_topic_review_template($event)
	{
		// Get Event Array `row` & `post_row`
		$row = $event['row'];
		$post_row = $event['post_row'];

		// Set Avatar
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_rv', 'user', $row);

		// Get Online Status
		$online = $this->mas_func->mas_get_online('dark1_mas_rv', 'user', $row);

		// Add Avatar & Online Status to post_row
		$post_row = array_merge(
			$post_row,
			array(
				'AVATAR_IMG'	=> $avatar,
				'S_ONLINE'		=> $online,
			)
		);

		// Assign post_row to event -> post_row
		$event['post_row'] = $post_row;
	}

}
