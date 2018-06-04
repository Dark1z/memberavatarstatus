<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dark1\memberavatarstatus\event;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Member Avatar & Status Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\twig\twig */
	protected $template;

	/** @var \phpbb\log\log */
	protected $phpbb_log;

	/** @var string */
	protected $phpbb_root_path;

/**
 * Constructor for listener
 *
 * @param \phpbb\auth\auth					$auth		phpBB auth
 * @param \phpbb\config\config				$config		phpBB config
 * @param \phpbb\db\driver\driver_interface	$db			phpBB DBAL object
 * @param \phpbb\language\language			$language	phpBB language
 * @param \phpbb\request\request			$request	phpBB request
 * @param \phpbb\template\template			$template	phpBB template
 * @param \phpbb\log\log					$phpbb_log	phpBB log
 * @access public
 */
	public function __construct(
		\phpbb\auth\auth					$auth,
		\phpbb\config\config				$config,
		\phpbb\db\driver\driver_interface	$db,
		\phpbb\language\language			$language,
		\phpbb\request\request_interface	$request,
		\phpbb\template\template			$template,
		\phpbb\log\log						$phpbb_log,
		$phpbb_root_path
	){
		$this->auth				= $auth;
		$this->config			= $config;
		$this->db				= $db;
		$this->language			= $language;
		$this->request			= $request;
		$this->template			= $template;
		$this->phpbb_log		= $phpbb_log;
		$this->phpbb_root_path	= $phpbb_root_path;
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
			'core.user_setup_after'							=> 'load_language_on_setup',
			'core.page_header_after'						=> 'mas_header',
			// MemberList Team Setup
			'core.memberlist_team_modify_query'				=> 'mas_memberlist_team_query',
			'core.memberlist_team_modify_template_vars'		=> 'mas_memberlist_team_template',
			// ViewOnline Page Setup
			'core.viewonline_modify_sql'					=> 'mas_viewonline_page_query',
			'core.viewonline_modify_user_row'				=> 'mas_viewonline_page_template',
			// ViewOnline Stat Block Setup
			'core.obtain_users_online_string_sql'			=> 'mas_viewonline_stat_block_query',
			'core.obtain_users_online_string_before_modify'	=> 'mas_viewonline_stat_block_template',
			// ViewForum DisplayForums Setup
			'core.display_forums_modify_sql'				=> 'mas_viewforum_displayforums_query',
			'core.display_forums_modify_template_vars'		=> 'mas_viewforum_displayforums_template',
			// ViewForum Topic Setup
			'core.viewforum_get_topic_data'					=> 'mas_viewforum_topic_query',
			'core.viewforum_modify_topicrow'				=> 'mas_viewforum_topic_template',
			// Search Setup
			'core.search_get_posts_data'					=> 'mas_search_posts_query',
			'core.search_get_topic_data'					=> 'mas_search_topic_query',
			'core.search_modify_tpl_ary'					=> 'mas_search_template',
		);
	}



/**
 * Member Avatar & Status Event Function.
 */



/**
 * Load language files during user setup after
 *
 * @param object $event The event object
 * @return null
 * @access public
 */
	public function load_language_on_setup($event)
	{
		$this->language->add_lang(array('lang_mas',), 'dark1/memberavatarstatus');
	}



/**
 * MAS Header Setup
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
			'MAS_ML_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_ml_av_sz', 50, 999),
			'MAS_ML_ONLINE'		=> $this->config['dark1_mas_ml_ol'],
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $this->config['dark1_mas_vo_pg_av'],
			'MAS_VO_PG_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_vo_pg_av_sz', 20, 99),
			'MAS_VO_SB_AVATAR'	=> $this->config['dark1_mas_vo_sb_av'],
			'MAS_VO_SB_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_vo_sb_av_sz', 20, 99),
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $this->config['dark1_mas_vf_fp_av'],
			'MAS_VF_FP_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_vf_fp_av_sz', 20, 99),
			'MAS_VF_FP_ONLINE'	=> $this->config['dark1_mas_vf_fp_ol'],
			'MAS_VF_LP_AVATAR'	=> $this->config['dark1_mas_vf_lp_av'],
			'MAS_VF_LP_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_vf_lp_av_sz', 20, 99),
			'MAS_VF_LP_ONLINE'	=> $this->config['dark1_mas_vf_lp_ol'],
			// Search
			'MAS_SH_FP_AVATAR'	=> $this->config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_sh_fp_av_sz', 20, 99),
			'MAS_SH_FP_ONLINE'	=> $this->config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $this->config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_sh_lp_av_sz', 20, 99),
			'MAS_SH_LP_ONLINE'	=> $this->config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $this->config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $this->mas_get_avatar_size('dark1_mas_sh_up_av_sz', 20, 99),
			'MAS_SH_UP_ONLINE'	=> $this->config['dark1_mas_sh_up_ol'],
			// No Avatar IMG
			'MAS_NO_AVATAR_IMG'	=> $this->mas_get_no_avatar_img(),
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
		$temp_sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_ml', '', 'u', 'user', '');
		$sql_ary['SELECT'] = $temp_sql_ary['SELECT'];
		$sql_ary = $this->mas_online_sql_query($sql_ary, 'dark1_mas_ml', 'ug.user_id', 's', '', '');

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
		$avatar = $this->mas_get_avatar('dark1_mas_ml', 'user', $row);

		// Get Online Status
		$online = (!($row['user_type'] == USER_INACTIVE)) ? $this->mas_get_online('dark1_mas_ml', '', $row) : '';

		// Modify "USERNAME_FULL"
		$template_vars['USERNAME_FULL'] = $this->mas_get_username_wrap($template_vars['USERNAME_FULL'], 'dark1_mas_ml', $avatar, $online);

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
		$temp_sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_pg', '', 'u', 'user', '');
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
		// Get Event Array `row` & `template_vars`
		$row = $event['row'];
		$template_row = $event['template_row'];

		// Get Avatar
		$avatar = $this->mas_get_avatar('dark1_mas_vo_pg', 'user', $row);

		// Add Avatar to "USERNAME_FULL"
		$template_row['USERNAME_FULL'] = $this->mas_get_username_wrap($template_row['USERNAME_FULL'], 'dark1_mas_vo_pg', $avatar, '');

		// Assign template_vars to event -> template_vars
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
		$temp_sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_vo_sb', '', 'u', 'user', '');
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
		// Get Event Array `rowset` & `user_online_link`
		$rowset = $event['rowset'];
		$user_online_link = $event['user_online_link'];

		if ($this->config['allow_avatar'] && $this->config['dark1_mas_vo_sb_av'])
		{
			foreach ($rowset as $row)
			{
				// Add avatar only for logged in User
				if ($row['user_id'] != ANONYMOUS)
				{
					// Get Avatar
					$avatar = $this->mas_get_avatar('dark1_mas_vo_sb', 'user', $row);
					$username = $this->mas_get_username_wrap($user_online_link[$row['user_id']], 'dark1_mas_vo_sb', $avatar, '');
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
		$sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'ulp', 'forum_last_poster', ' AND forum_type != ' . FORUM_CAT);
		$sql_ary = $this->mas_online_sql_query($sql_ary, 'dark1_mas_vf_lp', 'f.forum_last_poster_id', 'slp', 'forum_last_poster', ' AND forum_type != ' . FORUM_CAT);

		// Assign sql_ary to event -> sql_ary
		$event['sql_ary'] = $sql_ary;
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
		$avatar = $this->mas_get_avatar('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Get Online Status
		$online = $this->mas_get_online('dark1_mas_vf_lp', 'forum_last_poster', $row);

		// Modify "LAST_POSTER_FULL"
		$forum_row['LAST_POSTER_FULL'] = $this->mas_get_username_wrap($forum_row['LAST_POSTER_FULL'], 'dark1_mas_vf_lp', $avatar, $online);

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
		$sql_array = $this->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_array = $this->mas_online_sql_query($sql_array, 'dark1_mas_vf_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '');
		$sql_array = $this->mas_avatar_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_array = $this->mas_online_sql_query($sql_array, 'dark1_mas_vf_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '');

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
		$avatar_first_poster = $this->mas_get_avatar('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$avatar_last_poster = $this->mas_get_avatar('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Get Both Online Status
		$online_first_poster = $this->mas_get_online('dark1_mas_vf_fp', 'topic_first_poster', $row);
		$online_last_poster = $this->mas_get_online('dark1_mas_vf_lp', 'topic_last_poster', $row);

		// Modify Both "-X-_AUTHOR_FULL"
		$topic_row['TOPIC_AUTHOR_FULL'] = $this->mas_get_username_wrap($topic_row['TOPIC_AUTHOR_FULL'], 'dark1_mas_vf_fp', $avatar_first_poster, $online_first_poster);
		$topic_row['LAST_POST_AUTHOR_FULL'] = $this->mas_get_username_wrap($topic_row['LAST_POST_AUTHOR_FULL'], 'dark1_mas_vf_lp', $avatar_last_poster, $online_last_poster);

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
		$temp_sql_array = $this->mas_avatar_sql_query($sql_array, 'dark1_mas_sh_up', '', 'u', 'user', '');
		$sql_array['SELECT'] = $temp_sql_array['SELECT'];
		$sql_array = $this->mas_online_sql_query($sql_array, 'dark1_mas_sh_up', 'p.poster_id', 's', '', '');

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
		$sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_sh_fp', 't.topic_poster', 'ufp', 'topic_first_poster', '');
		$sql_ary = $this->mas_online_sql_query($sql_ary, 'dark1_mas_sh_fp', 't.topic_poster', 'sfp', 'topic_first_poster', '');
		$sql_ary = $this->mas_avatar_sql_query($sql_ary, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'ulp', 'topic_last_poster', '');
		$sql_ary = $this->mas_online_sql_query($sql_ary, 'dark1_mas_sh_lp', 't.topic_last_poster_id', 'slp', 'topic_last_poster', '');

		// Add to Event Array `sql_select` & `sql_from`
		$temp_sql = $this->mas_convert_sql($sql_ary);
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
		// Get Event Array `row` & `topic_row`
		$row = $event['row'];
		$tpl_ary = $event['tpl_ary'];

		if ($event['show_results'] == 'posts')
		{
			// Get Avatar
			$avatar = $this->mas_get_avatar('dark1_mas_sh_up', 'user', $row);

			// Get Online Status
			$online = $this->mas_get_online('dark1_mas_sh_up', '', $row);

			// Modify "POST_AUTHOR_FULL"
			$tpl_ary['POST_AUTHOR_FULL'] = $this->mas_get_username_wrap($tpl_ary['POST_AUTHOR_FULL'], 'dark1_mas_sh_up', $avatar, $online);
		}
		else
		{
			// Get Both Avatar
			$avatar_first_poster = $this->mas_get_avatar('dark1_mas_sh_fp', 'topic_first_poster', $row);
			$avatar_last_poster = $this->mas_get_avatar('dark1_mas_sh_lp', 'topic_last_poster', $row);

			// Get Both Online Status
			$online_first_poster = $this->mas_get_online('dark1_mas_sh_fp', 'topic_first_poster', $row);
			$online_last_poster = $this->mas_get_online('dark1_mas_sh_lp', 'topic_last_poster', $row);

			// Modify Both "-X-_AUTHOR_FULL"
			$tpl_ary['TOPIC_AUTHOR_FULL'] = $this->mas_get_username_wrap($tpl_ary['TOPIC_AUTHOR_FULL'], 'dark1_mas_sh_fp', $avatar_first_poster, $online_first_poster);
			$tpl_ary['LAST_POST_AUTHOR_FULL'] = $this->mas_get_username_wrap($tpl_ary['LAST_POST_AUTHOR_FULL'], 'dark1_mas_sh_lp', $avatar_last_poster, $online_last_poster);
		}

		// Assign tpl_ary to event -> tpl_ary
		$event['tpl_ary'] = $tpl_ary;
	}



/**
 * Member Avatar & Status Private Function.
 */



/**
 * MAS Get Avatar SQL Query
 *
 * @param String $config_key takes Config Key String
 * @param String $sql_uid Specifies User ID to be Matched with.
 * @param String $sql_obj Specifies SQL Object
 * @param String $prefix Specifies the prefix to be Set in SQL Select
 * @return Array of data
 * @access private
 */
	private function mas_avatar_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
	{
		$config_key .= '_av';
		$prefix = ($prefix != '') ? $prefix .= '_' : $prefix;

		if ($this->config['allow_avatar'] && $this->config[$config_key])
		{
			$sql_ary['SELECT'] .= ', ' . $sql_obj . '.user_avatar as ' . $prefix . 'avatar, ' . $sql_obj . '.user_avatar_type as ' . $prefix . 'avatar_type, ' . $sql_obj . '.user_avatar_width as ' . $prefix . 'avatar_width, ' . $sql_obj . '.user_avatar_height as ' . $prefix . 'avatar_height';
			$sql_ary['LEFT_JOIN'][] = array(
					'FROM'	=> array(USERS_TABLE => $sql_obj),
					'ON'	=> $sql_uid . ' = ' . $sql_obj . '.user_id' . $lj_on_ex,
				);
		}

		return $sql_ary;
	}



/**
 * MAS Get Avatar Size
 *
 * @param String $config_key takes Config Key String
 * @param int $av_default_sz Specifies Default Size in px
 * @param int $av_max_sz Specifies Avatar MAX Size in px
 * @return int with Avatar Size in px
 * @access private
 */
	private function mas_get_avatar_size($config_key, $av_default_sz = 20, $av_max_sz = 99)
	{
		// config -> dark1_mas_XX_sz , Need to set this between 9 to $av_max_sz Only , Default is $av_default_sz.
		if ($this->config[$config_key] < 9 || $this->config[$config_key] > $av_max_sz)
		{
			$this->config->set($config_key, $av_default_sz);
			$this->phpbb_log->add('admin', '', '', 'MAS_LOG_TITLE', time(), array($config_key, $this->language->lang('MAS_ERR_AV_SIZE'), $av_default_sz));
		}
		return $this->config[$config_key];
	}



/**
 * MAS Get No Avatar IMG
 *
 * @param Void
 * @return String with No Avatar IMG
 * @access private
 */
	private function mas_get_no_avatar_img()
	{
		$avatar_row = array(
				'avatar'		=> $this->phpbb_root_path . 'ext/dark1/memberavatarstatus/image/avatar.png',
				'avatar_type'	=> AVATAR_REMOTE,
				'avatar_width'	=> 1000,
				'avatar_height'	=> 1000,
			);
		return str_replace('" />', '" title="' . $this->language->lang('MAS_NO_AVATAR_TEXT') . '" />', phpbb_get_user_avatar($avatar_row, $this->language->lang('MAS_NO_AVATAR_TEXT')));
	}



/**
 * MAS Get Avatar
 *
 * @param String $config_key takes Config Key String
 * @param String $prefix Specifies the prefix to be Searched in the $row
 * @param Array $row is array of data
 * @return String with Avatar Data
 * @access private
 */
	private function mas_get_avatar($config_key, $prefix, $row)
	{
		$avatar = '';
		$config_key .= '_av';
		$prefix = ($prefix != '') ? $prefix .= '_' : $prefix;

		if ($this->config['allow_avatar'] && $this->config[$config_key])
		{
			// $avatar_row
			$avatar_row = array(
					'avatar'		=> $row[$prefix . 'avatar'],
					'avatar_type'	=> $row[$prefix . 'avatar_type'],
					'avatar_width'	=> $row[$prefix . 'avatar_width'],
					'avatar_height'	=> $row[$prefix . 'avatar_height'],
				);
			$avatar = phpbb_get_user_avatar($avatar_row);
		}

		return $avatar;
	}



/**
 * MAS Get Online SQL Query
 *
 * @param String $config_key takes Config Key String
 * @param String $sql_uid Specifies User ID to be Matched with.
 * @param String $sql_obj Specifies SQL Object
 * @param String $prefix Specifies the prefix to be Set in SQL Select
 * @return Array of data
 * @access private
 */
	private function mas_online_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
	{
		$config_key .= '_ol';
		$prefix = ($prefix != '') ? $prefix .= '_' : $prefix;

		if ($this->config['load_onlinetrack'] && $this->config[$config_key])
		{
			$sql_ary['SELECT'] .= ', ' . $sql_obj . '.session_time as ' . $prefix . 'session_time, ' . $sql_obj . '.session_viewonline as ' . $prefix . 'session_viewonline';
			$sql_ary['LEFT_JOIN'][] = array(
					'FROM'	=> array(SESSIONS_TABLE => $sql_obj),
					'ON'	=> $sql_uid . ' = ' . $sql_obj . '.session_user_id AND ' . $sql_obj . '.session_time >= ' . (time() - ($this->config['load_online_time'] * 60)) . ' AND ' . $sql_obj . '.session_user_id <> ' . ANONYMOUS . $lj_on_ex,
				);
		}

		return $sql_ary;
	}



/**
 * MAS Get Online Status
 *
 * @param Array $online_row takes user details to find Online Status
 * @return Bool Online Status
 * @access private
 */
	private function mas_get_online_status($online_row)
	{
		$online = false;

		if ($this->config['load_onlinetrack'])
		{
			$online = (time() - ($this->config['load_online_time'] * 60) < $online_row['session_time'] && ((isset($online_row['session_viewonline']) && $online_row['session_viewonline']) || $this->auth->acl_get('u_viewonline'))) ? true : false;
		}

		return $online;
	}



/**
 * MAS Get Online
 *
 * @param String $config_key takes Config Key String
 * @param String $prefix Specifies the prefix to be Searched in the $row
 * @param Array $row is array of data
 * @return String with Online Data
 * @access private
 */
	private function mas_get_online($config_key, $prefix, $row)
	{
		$online = '';
		$config_key .= '_ol';
		$prefix = ($prefix != '') ? $prefix .= '_' : $prefix;

		if ($this->config['load_onlinetrack'] && $this->config[$config_key])
		{
			$online_row = array(
					'session_time'			=> $row[$prefix . 'session_time'],
					'session_viewonline'	=> $row[$prefix . 'session_viewonline'],
				);
			$online = $this->mas_get_online_status($online_row);
		}

		return $online;
	}



/**
 * MAS Get converted simple SQL strings in array
 *
 * @param Array $sql_ary is array of data
 * @return Array of data
 * @access private
 */
	private function mas_convert_sql($sql_ary)
	{
		$sql_select = $sql_ary['SELECT'];
		$sql_from = '';

		if (!empty($sql_ary['LEFT_JOIN']))
		{
			foreach ($sql_ary['LEFT_JOIN'] as $join)
			{
				if (!empty($join))
				{
					$sql_from .= ' LEFT JOIN ' . key($join['FROM']) . ' ' . current($join['FROM']) . ' ON (' . $join['ON'] . ')';
				}
			}
		}

		return array(
				'sql_select'	=> $sql_select,
				'sql_from'		=> $sql_from,
			);
	}



// Following Functions Will be Deprecated in future when Style Template Events are created.



/**
 * MAS Get Avatar IMG
 *
 * @param String $avatar takes User Avatar IMG
 * @param int $avatar_size Specifies Avatar Size in px
 * @return String with Wrapped User Avatar IMG
 * @access private
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	private function mas_get_avatar_img($avatar, $avatar_size = 20)
	{
		$start_avatar = '<div class="mas-avatar" style="width: ' . $avatar_size . 'px; height: ' . $avatar_size . 'px;">';
		$end_avatar = '</div>';
		return $start_avatar . (($avatar) ? $avatar : $this->mas_get_no_avatar_img()) . $end_avatar;
	}



/**
 * MAS Get Online Status DOT
 *
 * @param String $online takes User Online Status
 * @return String with Wrapped User Online Status
 * @access private
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	private function mas_get_online_status_dot($online)
	{
		$online_text = $this->language->lang('ONLINE');
		$offline_text = $this->language->lang('OFFLINE');
		$start_online = ' ' . '<div class="mas-wrap-status' . ($online ? ' mas-status-online' : '') . '">';
		$end_online = '</div>';
		$online_dot = '<span class="mas-status-dot" title="' . ($online ? $online_text : $offline_text) . '"/>';
		return $start_online . $online_dot . $end_online;
	}



/**
 * MAS Get UserName Wrap
 *
 * @param String $username takes UserName
 * @param String $avatar takes User Avatar IMG
 * @param String $online takes User Online Status
 * @return String with Wrapped Main & UserName
 * @access private
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	private function mas_get_username_wrap($username, $config_key, $avatar, $online)
	{
		$start_wrap = '<div class="mas-wrap">';
		$start_username = '<div class="mas-username">';
		$end_tag = '</div>';
		$avatar_test = ($this->config['allow_avatar'] && $this->config[$config_key . '_av']) ? true : false ;
		$online_test = ($this->config['load_onlinetrack'] && $this->config[$config_key . '_ol']) ? true : false ;
		$avatar_wrap = ($avatar_test) ? $this->mas_get_avatar_img($avatar, $this->config[$config_key . '_av_sz']) : '';
		$online_wrap = ($online_test) ? $this->mas_get_online_status_dot($online) : '';
		return ($avatar_test || $online_test) ? ($start_wrap . $avatar_wrap . $start_username . $username . $end_tag . $online_wrap . $end_tag) : $username;
	}



/**
 * MAS DeBug Echo to phpBB For DeBug'ing Purpose Only.
 * Keeping this so I do not loose the Code.
 *
 * @param object $vars The Variable's object , Can be ANY Type.
 * @return null
 * @access private
 */
/*	private function mas_debug_echo($vars)
	{
		echo('<br /><pre style="font: 0.9em Monaco, Andale Mono, Courier New, Courier, mono; white-space: pre-wrap; display: block; color: #ff0000; background-color: #00ff00; border: #0000FF solid 3px;"><code>');
		var_dump($vars);
		echo('</code></pre><br />');
	}
*/
/*	public function mas_example_function($event)
	{
		// DeBug'ing Purpose Only.
		$this->mas_debug_echo(array(
			'MAS_FUNCTION'	=> 'mas_example_function',
			'MAS_SQL_ARY'	=> $event['sql_ary'],
			'MAS_SQL_BUILD'	=> $this->db->sql_build_query('SELECT', $event['sql_ary']),
		));
	}
*/

}
