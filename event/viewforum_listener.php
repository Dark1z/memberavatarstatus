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

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\memberavatarstatus;
use phpbb\config\config;

/**
 * Member Avatar & Status Event listener.
 */
class viewforum_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\memberavatarstatus */
	protected $mas_func;

	/** @var \phpbb\config\config */
	protected $config;

/**
 * Constructor for listener
 *
 * @param \dark1\memberavatarstatus\core\memberavatarstatus		$mas_func	dark1 mas_func
 * @param \phpbb\config\config									$config		phpBB config
 * @access public
 */
	public function __construct(memberavatarstatus $mas_func, config $config)
	{
		$this->mas_func		= $mas_func;
		$this->config		= $config;
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
			'core.display_forums_modify_sql'				=> 'mas_viewforum_displayforums_query',
			'core.display_forums_modify_forum_rows'			=> 'mas_viewforum_displayforums_data',
			'core.display_forums_modify_template_vars'		=> 'mas_viewforum_displayforums_template',
			'core.viewforum_get_topic_data'					=> 'mas_viewforum_topic_query',
			'core.viewforum_modify_topicrow'				=> 'mas_viewforum_topic_template',
		);
	}



/**
 * Member Avatar & Status Event Function.
 */



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
		$sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'ulp', 'forum_last_poster', ' AND forum_type <> ' . FORUM_CAT);
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'slp', 'forum_last_poster', ' AND forum_type <> ' . FORUM_CAT);

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
			if ($this->config['allow_avatar'] && $this->config['dark1_mas_vf_lp_av'])
			{
				$forum_rows[$parent_id]['forum_last_poster_avatar'] = $row['forum_last_poster_avatar'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_type'] = $row['forum_last_poster_avatar_type'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_width'] = $row['forum_last_poster_avatar_width'];
				$forum_rows[$parent_id]['forum_last_poster_avatar_height'] = $row['forum_last_poster_avatar_height'];
			}
			if ($this->config['load_onlinetrack'] && $this->config['dark1_mas_vf_lp_ol'])
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
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Get Online Status
		$online = $this->mas_func->mas_get_online('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Add Avatar & Online Status to forum_row
		$forum_row = array_merge(
			$forum_row,
			array(
				'LAST_POSTER_AVATAR_IMG'	=> $avatar,
				'LAST_POSTER_S_ONLINE'		=> $online,
			)
		);

		// Assign forum_row to event -> forum_row
		$event['forum_row'] = $forum_row;
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
		$sql_array = $this->mas_func->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_array = $this->mas_func->mas_online_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '');
		$sql_array = $this->mas_func->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_array = $this->mas_func->mas_online_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '');

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
		$avatar_first_poster = $this->mas_func->mas_get_avatar('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->mas_func->mas_get_avatar('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->mas_func->mas_get_online('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->mas_func->mas_get_online('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Add Both of Avatar & Online Status to topic_row
		$topic_row = array_merge(
			$topic_row,
			array(
				'TOPIC_AUTHOR_AVATAR_IMG'		=> $avatar_first_poster,
				'TOPIC_AUTHOR_S_ONLINE'			=> $online_first_poster,
				'LAST_POST_AUTHOR_AVATAR_IMG'	=> $avatar_last_poster,
				'LAST_POST_AUTHOR_S_ONLINE'		=> $online_last_poster,
			)
		);

		// Assign topic_row to event -> topic_row
		$event['topic_row'] = $topic_row;
	}

}
