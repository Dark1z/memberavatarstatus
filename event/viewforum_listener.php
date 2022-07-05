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
class viewforum_listener implements EventSubscriberInterface
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
			'core.display_forums_modify_template_vars'			=> 'mas_viewforum_displayforums_template',
			'core.viewforum_modify_topicrow'					=> 'mas_viewforum_topic_template',
			'core.mcp_view_forum_modify_topicrow'				=> 'mas_viewforum_topic_template',
		];
	}



	/**
	 * MAS ViewForum DisplayForums Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_displayforums_template($event)
	{
		// Get Event Array `row` & `forum_row`
		$row = $event['row'];
		$forum_row = $event['forum_row'];

		// Get Avatar
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', $row['forum_last_poster_id']);

		// Get Online Status
		$online = $this->status->mas_get_online('dark1_mas_vf_lp', $row['forum_last_poster_id']);

		// Add Avatar & Online Status to forum_row
		$forum_row = array_merge($forum_row, [
			'LAST_POSTER_AVATAR_IMG'	=> $avatar,
			'LAST_POSTER_S_ONLINE'		=> $online,
		]);

		// Assign forum_row to event -> forum_row
		$event['forum_row'] = $forum_row;
	}



	/**
	 * MAS ViewForum Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_topic_template($event)
	{
		// Get Event Array `row` & `topic_row`
		$row = $event['row'];
		$topic_row = $event['topic_row'];

		// Get Both Avatar
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_fp', $row['topic_poster']);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', $row['topic_last_poster_id']);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_vf_fp', $row['topic_poster']);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_vf_lp', $row['topic_last_poster_id']);

		// Add Both of Avatar & Online Status to topic_row
		$topic_row = array_merge($topic_row, [
			'TOPIC_AUTHOR_AVATAR_IMG'		=> $avatar_first_poster,
			'TOPIC_AUTHOR_S_ONLINE'			=> $online_first_poster,
			'LAST_POST_AUTHOR_AVATAR_IMG'	=> $avatar_last_poster,
			'LAST_POST_AUTHOR_S_ONLINE'		=> $online_last_poster,
		]);

		// Assign topic_row to event -> topic_row
		$event['topic_row'] = $topic_row;
	}

}
