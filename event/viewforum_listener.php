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
			'core.display_forums_modify_sql'					=> 'mas_viewforum_displayforums_query',
			'core.display_forums_modify_forum_rows'				=> 'mas_viewforum_displayforums_data',
			'core.display_forums_modify_template_vars'			=> 'mas_viewforum_displayforums_template',
			'core.viewforum_get_announcement_topic_ids_data'	=> 'mas_viewforum_announcement_topic_query',
			'core.viewforum_modify_topic_list_sql'				=> 'mas_viewforum_topic_query',
			'core.viewforum_get_shadowtopic_data'				=> 'mas_viewforum_topic_query',
			'core.viewforum_modify_topicrow'					=> 'mas_viewforum_topic_template',
			'core.mcp_forum_topic_data_modify_sql'				=> 'mas_mcp_forum_topic_query',
			'core.mcp_view_forum_modify_topicrow'				=> 'mas_mcp_forum_topic_template',
		];
	}



	/**
	 * MAS ViewForum DisplayForums SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_displayforums_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'ulp', 'forum_last_poster', ' AND forum_type <> ' . FORUM_CAT);
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'slp', 'forum_last_poster', ' AND forum_type <> ' . FORUM_CAT, 'f.forum_id');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS ViewForum DisplayForums Data Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_displayforums_data($event)
	{
		// Get Event Array `row` , `forum_rows` & `parent_id`
		$row = $event['row'];
		$forum_rows = $event['forum_rows'];
		$parent_id = $event['parent_id'];

		if ($forum_rows[$parent_id]['forum_id_last_post'] == $row['forum_id'])
		{
			if ($this->avatar->mas_get_config_avatar('dark1_mas_vf_lp_av'))
			{
				$forum_rows[$parent_id]['forum_last_poster_avatar'] = $row['forum_last_poster_avatar'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_type'] = $row['forum_last_poster_avatar_type'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_width'] = $row['forum_last_poster_avatar_width'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_height'] = $row['forum_last_poster_avatar_height'];
			}
			if ($this->status->mas_get_config_online('dark1_mas_vf_lp_ol'))
			{
				$forum_rows[$parent_id]['forum_last_poster_session_time'] = $row['forum_last_poster_session_time'];
				$forum_rows[$parent_id]['forum_last_poster_session_viewonline'] = $row['forum_last_poster_session_viewonline'];
			}
		}

		// Assign forum_rows to event -> forum_rows
		$event['forum_rows'] = $forum_rows;
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
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Get Online Status
		$online = $this->status->mas_get_online('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Add Avatar & Online Status to forum_row
		$forum_row = array_merge($forum_row, [
			'LAST_POSTER_AVATAR_IMG'	=> $avatar,
			'LAST_POSTER_S_ONLINE'		=> $online,
		]);

		// Assign forum_row to event -> forum_row
		$event['forum_row'] = $forum_row;
	}



	/**
	 * MAS ViewForum Announcement SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_announcement_topic_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_vf_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '', 't.topic_id');
		$sql_ary = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '', 't.topic_id');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS ViewForum SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_viewforum_topic_query($event)
	{
		// Get Event Array `sql_array`
		$sql_array = $event['sql_array'];

		// Add Query Details
		$sql_array = $this->avatar->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_array = $this->status->mas_online_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '', 't.topic_id');
		$sql_array = $this->avatar->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_array = $this->status->mas_online_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '', 't.topic_id');

		// Assign sql_ary to event -> sql_array
		$event['sql_array'] = $sql_array;
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
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_vf_lp', 'topic_last_poster', $row);

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



	/**
	 * MAS MCP Forum SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_mcp_forum_topic_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$sql_ary = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_vf_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '', 't.topic_id');
		$sql_ary = $this->avatar->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_ary = $this->status->mas_online_sql_query($sql_ary, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '', 't.topic_id');

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



	/**
	 * MAS MCP Forum Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_mcp_forum_topic_template($event)
	{
		// Get Event Array `row` & `topic_row`
		$row = $event['row'];
		$topic_row = $event['topic_row'];

		// Get Both Avatar
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_vf_lp', 'topic_last_poster', $row);

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
