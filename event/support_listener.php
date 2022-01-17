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
 * Member Avatar & Status Support Other Extension Event listener.
 */
class support_listener implements EventSubscriberInterface
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
			'paybas.recenttopics.sql_pull_topics_data'	=> 'mas_recenttopics_topic_query',
			'paybas.recenttopics.modify_tpl_ary'		=> 'mas_recenttopics_topic_template',
			'vse.similartopics.get_topic_data'			=> 'mas_similartopics_topic_query',
			'vse.similartopics.modify_topicrow'			=> 'mas_similartopics_topic_template',
		];
	}



	/**
	 * MAS RecentTopics SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_recenttopics_topic_query($event)
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
	 * MAS RecentTopics Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_recenttopics_topic_template($event)
	{
		// Get Event Array `row` & `tpl_ary`
		$row = $event['row'];
		$tpl_ary = $event['tpl_ary'];

		// Get Both Avatar
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Add Both of Avatar & Online Status to tpl_ary
		$tpl_ary = array_merge($tpl_ary, [
			'TOPIC_AUTHOR_AVATAR_IMG'		=> $avatar_first_poster,
			'TOPIC_AUTHOR_S_ONLINE'			=> $online_first_poster,
			'LAST_POST_AUTHOR_AVATAR_IMG'	=> $avatar_last_poster,
			'LAST_POST_AUTHOR_S_ONLINE'		=> $online_last_poster,
		]);

		// Assign tpl_ary to event -> tpl_ary
		$event['tpl_ary'] = $tpl_ary;
	}



	/**
	 * MAS SimilarTopics SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_similartopics_topic_query($event)
	{
		// Get Event Array `sql_array`
		$sql_array = $event['sql_array'];

		// Add Query Details
		$sql_array = $this->avatar->mas_avatar_sql_query($sql_array, 'dark1_mas_sh_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_array = $this->status->mas_online_sql_query($sql_array, 'dark1_mas_sh_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '', 't.topic_id');
		$sql_array = $this->avatar->mas_avatar_sql_query($sql_array, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_array = $this->status->mas_online_sql_query($sql_array, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '', 't.topic_id');

		// Assign sql_ary to event -> sql_array
		$event['sql_array'] = $sql_array;
	}



	/**
	 * MAS SimilarTopics Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_similartopics_topic_template($event)
	{
		// Get Event Array `row` & `topic_row`
		$row = $event['row'];
		$topic_row = $event['topic_row'];

		// Get Both Avatar
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_sh_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_sh_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_sh_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_sh_lp', 'topic_last_poster', $row);

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
