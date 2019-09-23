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
class search_listener implements EventSubscriberInterface
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
			'core.search_get_posts_data'					=> 'mas_search_posts_query',
			'core.search_get_topic_data'					=> 'mas_search_topic_query',
			'core.search_modify_tpl_ary'					=> 'mas_search_template',
		);
	}



	/**
	 * MAS Search Posts SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_search_posts_query($event)
	{
		// Get Event Array `sql_array`
		$sql_array = $event['sql_array'];

		// Add Query Details
		$temp_sql_array = $this->mas_func->mas_avatar_sql_query($sql_array, 'dark1_mas_sh_up', '', 'u', 'user', '');
		$sql_array['SELECT'] = $temp_sql_array['SELECT'];
		$sql_array = $this->mas_func->mas_online_sql_query($sql_array, 'dark1_mas_sh_up', 'p.poster_id', 's', '', '');

		// Assign sql_array to event -> sql_array
		$event['sql_array'] = $sql_array;
	}



	/**
	 * MAS Search Topic SQL Query Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_search_topic_query($event)
	{
		// Temp Array
		$sql_ary = array(
			'SELECT'	=> '',
			'LEFT_JOIN'	=> array(),
		);

		// Add to Event Array `sql_select` & `sql_from`
		$sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_sh_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_sh_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '');
		$sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '');

		// Add to Event Array `sql_select` & `sql_from`
		$temp_sql = $this->mas_func->mas_convert_sql($sql_ary);
		$event['sql_select'] .= $temp_sql['sql_select'];
		$event['sql_from'] .= $temp_sql['sql_from'];
	}



	/**
	 * MAS Search Topic Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_search_template($event)
	{
		// Get Event Array `row` & `tpl_ary`
		$row = $event['row'];
		$tpl_ary = $event['tpl_ary'];

		if ($event['show_results'] == 'posts')
		{
			// Get Avatar
			$avatar = $this->mas_func->mas_get_avatar('dark1_mas_sh_up', 'user', $row);

			// Get Online Status
			$online = $this->mas_func->mas_get_online('dark1_mas_sh_up', '', $row);

			// Add Avatar & Online Status to tpl_ary
			$tpl_ary = array_merge(
				$tpl_ary,
				array(
					'POST_AUTHOR_AVATAR_IMG'		=> $avatar,
					'POST_AUTHOR_S_ONLINE'			=> $online,
				)
			);
		}
		else
		{
			// Get Both Avatar
			$avatar_first_poster = $this->mas_func->mas_get_avatar('dark1_mas_sh_fp', 'topic_first_poster', $row);
			$avatar_last_poster = $this->mas_func->mas_get_avatar('dark1_mas_sh_lp', 'topic_last_poster', $row);

			// Get Both Online Status
			$online_first_poster = $this->mas_func->mas_get_online('dark1_mas_sh_fp', 'topic_first_poster', $row);
			$online_last_poster = $this->mas_func->mas_get_online('dark1_mas_sh_lp', 'topic_last_poster', $row);

			// Add Both of Avatar & Online Status to tpl_ary
			$tpl_ary = array_merge(
				$tpl_ary,
				array(
					'TOPIC_AUTHOR_AVATAR_IMG'		=> $avatar_first_poster,
					'TOPIC_AUTHOR_S_ONLINE'			=> $online_first_poster,
					'LAST_POST_AUTHOR_AVATAR_IMG'	=> $avatar_last_poster,
					'LAST_POST_AUTHOR_S_ONLINE'		=> $online_last_poster,
				)
			);
		}

		// Assign tpl_ary to event -> tpl_ary
		$event['tpl_ary'] = $tpl_ary;
	}

}