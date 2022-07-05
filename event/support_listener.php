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
			'paybas.recenttopics.modify_tpl_ary'		=> 'mas_recenttopics_topic_template',
			'vse.similartopics.modify_topicrow'			=> 'mas_similartopics_topic_template',
		];
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
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_fp', $row['topic_poster']);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_vf_lp', $row['topic_last_poster_id']);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_vf_fp', $row['topic_poster']);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_vf_lp', $row['topic_last_poster_id']);

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
		$avatar_first_poster = $this->avatar->mas_get_avatar('dark1_mas_sh_fp', $row['topic_poster']);
		$avatar_last_poster = $this->avatar->mas_get_avatar('dark1_mas_sh_lp', $row['topic_last_poster_id']);

		// Get Both Online Status
		$online_first_poster = $this->status->mas_get_online('dark1_mas_sh_fp', $row['topic_poster']);
		$online_last_poster = $this->status->mas_get_online('dark1_mas_sh_lp', $row['topic_last_poster_id']);

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
