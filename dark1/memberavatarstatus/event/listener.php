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
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\user;
use phpbb\template\template;

/**
 * Member Avatar & Status Event listener.
 */
class listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\memberavatarstatus */
	protected $mas_func;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\twig\twig */
	protected $template;

/**
 * Constructor for listener
 *
 * @param \dark1\memberavatarstatus\core\memberavatarstatus		$mas_func	dark1 mas_func
 * @param \phpbb\auth\auth										$auth		phpBB auth
 * @param \phpbb\config\config									$config		phpBB config
 * @param \phpbb\user											$user		phpBB user
 * @param \phpbb\template\template								$template	phpBB template
 * @access public
 */
	public function __construct( memberavatarstatus $mas_func, auth $auth, config $config, user $user, template $template)
	{
		$this->mas_func		= $mas_func;
		$this->auth			= $auth;
		$this->config		= $config;
		$this->user			= $user;
		$this->template		= $template;
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
			// Main Setup
			'core.user_setup'								=> 'mas_load_lang',
			'core.page_header_after'						=> 'mas_header',
			// MemberList Setup
			'core.memberlist_team_modify_query'				=> 'mas_memberlist_team_query',
			'core.memberlist_team_modify_template_vars'		=> 'mas_memberlist_team_template',
			// ViewOnline Setup
			'core.viewonline_modify_sql'					=> 'mas_viewonline_page_query',
			'core.viewonline_modify_user_row'				=> 'mas_viewonline_page_template',
			'core.obtain_users_online_string_sql'			=> 'mas_viewonline_stat_block_query',
			'core.obtain_users_online_string_before_modify'	=> 'mas_viewonline_stat_block_template',
			// ViewForum Setup
			'core.display_forums_modify_sql'				=> 'mas_viewforum_displayforums_query',
			'core.display_forums_modify_forum_rows'			=> 'mas_viewforum_displayforums_data',
			'core.display_forums_modify_template_vars'		=> 'mas_viewforum_displayforums_template',
			'core.viewforum_get_topic_data'					=> 'mas_viewforum_topic_query',
			'core.viewforum_modify_topicrow'				=> 'mas_viewforum_topic_template',
			// Search Setup
			'core.search_get_posts_data'					=> 'mas_search_posts_query',
			'core.search_get_topic_data'					=> 'mas_search_topic_query',
			'core.search_modify_tpl_ary'					=> 'mas_search_template',
			// Review Setup
			'core.topic_review_modify_sql_ary'				=> 'mas_posting_topic_review_query',
			'core.topic_review_modify_row'					=> 'mas_posting_topic_review_template',
			'core.message_history_modify_sql_ary'			=> 'mas_pm_history_review_query',
			'core.message_history_modify_template_vars'		=> 'mas_pm_history_review_template',
			'core.mcp_topic_modify_sql_ary'					=> 'mas_mcp_topic_review_query',
			'core.mcp_topic_review_modify_row'				=> 'mas_mcp_topic_review_template',
		);
	}



/**
 * Member Avatar & Status Event Function.
 */



/**
 * MAS Load language files during user setup after
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_load_lang($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dark1/memberavatarstatus',
			'lang_set' => 'lang_mas',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}



/**
 * MAS Header setup during page header after
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_header($event)
	{
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		// Assign template var's
		$this->template->assign_vars(array(
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			// MemberList
			'MAS_ML_AVATAR'		=> $this->config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_ml_av_sz', memberavatarstatus::AV_DEF_SZ_BIG, memberavatarstatus::AV_MAX_SZ_BIG),
			'MAS_ML_ONLINE'		=> $this->config['dark1_mas_ml_ol'],
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $this->config['dark1_mas_vo_pg_av'],
			'MAS_VO_PG_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_vo_pg_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_VO_SB_AVATAR'	=> $this->config['dark1_mas_vo_sb_av'],
			'MAS_VO_SB_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_vo_sb_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $this->config['dark1_mas_vf_fp_av'],
			'MAS_VF_FP_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_vf_fp_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_VF_FP_ONLINE'	=> $this->config['dark1_mas_vf_fp_ol'],
			'MAS_VF_LP_AVATAR'	=> $this->config['dark1_mas_vf_lp_av'],
			'MAS_VF_LP_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_vf_lp_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_VF_LP_ONLINE'	=> $this->config['dark1_mas_vf_lp_ol'],
			// Search
			'MAS_SH_FP_AVATAR'	=> $this->config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_sh_fp_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_SH_FP_ONLINE'	=> $this->config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $this->config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_sh_lp_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_SH_LP_ONLINE'	=> $this->config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $this->config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_sh_up_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_SH_UP_ONLINE'	=> $this->config['dark1_mas_sh_up_ol'],
			// Review
			'MAS_RV_AVATAR'		=> $this->config['dark1_mas_rv_av'],
			'MAS_RV_AV_SIZE'	=> $this->mas_func->mas_get_config_avatar_size('dark1_mas_rv_av_sz', memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML),
			'MAS_RV_ONLINE'		=> $this->config['dark1_mas_rv_ol'],
			// No Avatar IMG
			'MAS_NO_AVATAR_IMG'	=> $this->mas_func->mas_get_no_avatar_img(),
		));
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
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_ml', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];
		$sql_ary = $this->mas_func->mas_online_sql_query($sql_ary, 'dark1_mas_ml', 'ug.user_id', 's', '', '');

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
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_ml', 'user', $row);

		// Get Online Status
		$online = (!($row['user_type'] == USER_INACTIVE)) ? $this->mas_func->mas_get_online('dark1_mas_ml', '', $row) : '';

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
 * MAS ViewOnline Avatar SQL Query Setup
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_viewonline_page_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_pg', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



/**
 * MAS ViewOnline Avatar Template Setup
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_viewonline_page_template($event)
	{
		// Get Event Array `row` & `template_row`
		$row = $event['row'];
		$template_row = $event['template_row'];

		// Get Avatar
		$avatar = $this->mas_func->mas_get_avatar('dark1_mas_vo_pg', 'user', $row);

		// Add Avatar to template_row
		$template_row = array_merge(
			$template_row,
			array(
				'AVATAR_IMG'	=> $avatar,
			)
		);

		// Assign template_row to event -> template_row
		$event['template_row'] = $template_row;
	}



/**
 * MAS ViewOnline Stat Block Avatar SQL Query Setup
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_viewonline_stat_block_query($event)
	{
		// Get Event Array `sql_ary`
		$sql_ary = $event['sql_ary'];

		// Add Query Details
		$temp_sql_ary = $this->mas_func->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_sb', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
	}



/**
 * MAS ViewOnline Stat Block Avatar Template Setup
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function mas_viewonline_stat_block_template($event)
	{
		// Get Event Array `rowset` , `online_users` & `user_online_link`
		$rowset = $event['rowset'];
		$online_users = $event['online_users'];
		$user_online_link = $event['user_online_link'];

		if ($this->config['allow_avatar'] && $this->config['dark1_mas_vo_sb_av'])
		{
			foreach ($rowset as $row)
			{
				// Add avatar only for logged in User and not for Hidden User
				if ($row['user_id'] != ANONYMOUS && (!isset($online_users['hidden_users'][$row['user_id']]) || $this->auth->acl_get('u_viewonline') || $row['user_id'] === $this->user->data['user_id']))
				{
					// Get Avatar
					$avatar = $this->mas_func->mas_get_avatar('dark1_mas_vo_sb', 'user', $row);
					$username = $this->mas_func->mas_get_username_wrap($user_online_link[$row['user_id']], 'dark1_mas_vo_sb', $avatar, '');
					$user_online_link[$row['user_id']] = str_replace('div', 'span', $username);
				}
			}
		}

		// Assign user_online_link to event -> user_online_link
		$event['user_online_link'] = $user_online_link;
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
