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
class review_listener implements EventSubscriberInterface
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
			'core.topic_review_modify_row'					=> 'mas_posting_topic_review_template',
			'core.message_history_modify_template_vars'		=> 'mas_pm_history_review_template',
			'core.mcp_topic_review_modify_row'				=> 'mas_mcp_topic_review_template',
		];
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
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_rv', $row['user_id']);

		// Get Online Status
		$online = $this->status->mas_get_online('dark1_mas_rv', $row['user_id']);

		// Add Avatar & Online Status to post_row
		$post_row = array_merge($post_row, [
			'AVATAR_IMG'	=> $avatar,
			'S_ONLINE'		=> $online,
		]);

		// Assign post_row to event -> post_row
		$event['post_row'] = $post_row;
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
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_rv', $row['user_id']);

		// Get Online Status
		$online = $this->status->mas_get_online('dark1_mas_rv', $row['user_id']);

		// Add Avatar & Online Status to template_vars
		$template_vars = array_merge($template_vars, [
			'AVATAR_IMG'	=> $avatar,
			'S_ONLINE'		=> $online,
		]);

		// Assign template_vars to event -> template_vars
		$event['template_vars'] = $template_vars;
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
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_rv', $row['poster_id']);

		// Get Online Status
		$online = $this->status->mas_get_online('dark1_mas_rv', $row['poster_id']);

		// Add Avatar & Online Status to post_row
		$post_row = array_merge($post_row, [
			'AVATAR_IMG'	=> $avatar,
			'S_ONLINE'		=> $online,
		]);

		// Assign post_row to event -> post_row
		$event['post_row'] = $post_row;
	}

}
