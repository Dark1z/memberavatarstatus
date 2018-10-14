<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dark1\memberavatarstatus\core;

/**
 * @ignore
 */
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\user;
use phpbb\log\log;

/**
 * Member Avatar & Status Event listener.
 */
class memberavatarstatus
{
	/** @var int No Avatar Size */
	const NO_AVATAR_SIZE = 1000;

	/** @var int Avatar Minimum Size */
	const AV_MIN_SZ = 9;

	/** @var int Avatar Default Size Small */
	const AV_DEF_SZ_SML = 2.0;

	/** @var int Avatar Default Size Big */
	const AV_DEF_SZ_BIG = 50;

	/** @var int Avatar Maximum Size Small */
	const AV_MAX_SZ_SML = 99;

	/** @var int Avatar Maximum Size Big */
	const AV_MAX_SZ_BIG = 999;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log\log */
	protected $phpbb_log;

	/** @var string */
	protected $phpbb_root_path;

/**
 * Constructor for listener
 *
 * @param \phpbb\auth\auth				$auth		phpBB auth
 * @param \phpbb\config\config			$config		phpBB config
 * @param \phpbb\user					$user		phpBB user
 * @param \phpbb\log\log				$phpbb_log	phpBB log
 * @param \								$root_path	phpBB root_path
 * @access public
 */
	public function __construct(
		auth				$auth,
		config				$config,
		user				$user,
		log					$phpbb_log,
		$phpbb_root_path
	)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->user				= $user;
		$this->phpbb_log		= $phpbb_log;
		$this->phpbb_root_path	= $phpbb_root_path;
	}



/**
 * MAS Get No Avatar IMG
 *
 * @param Void
 * @return String with No Avatar IMG
 * @access public
 */
	public function mas_get_no_avatar_img()
	{
		$avatar_row = array(
				'avatar'		=> $this->phpbb_root_path . 'ext/dark1/memberavatarstatus/image/avatar.png',
				'avatar_type'	=> AVATAR_REMOTE,
				'avatar_width'	=> self::NO_AVATAR_SIZE,
				'avatar_height'	=> self::NO_AVATAR_SIZE,
			);
		return str_replace(
			'" />',
			'" title="' . $this->user->lang('MAS_NO_AVATAR_TEXT') . '" />',
			phpbb_get_user_avatar($avatar_row, $this->user->lang('MAS_NO_AVATAR_TEXT'), true)
		);
	}



/**
 * MAS Get Avatar SQL Query
 *
 * @param String $config_key takes Config Key String
 * @param String $sql_uid Specifies User ID to be Matched with.
 * @param String $sql_obj Specifies SQL Object
 * @param String $prefix Specifies the prefix to be Set in SQL Select
 * @return Array of data
 * @access public
 */
	public function mas_avatar_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
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
 * @param int $av_sz takes Avatar Size
 * @param int $av_default_sz Specifies Default Size in px
 * @param int $av_max_sz Specifies Avatar MAX Size in px
 * @return int with Avatar Size in px
 * @access public
 */
	public function mas_get_avatar_size($av_sz, $av_default_sz = self::AV_DEF_SZ_SML, $av_max_sz = self::AV_MAX_SZ_SML)
	{
		// $av_sz , Need to set this between self::AV_MIN_SZ to $av_max_sz Only , Default is $av_default_sz.
		if ($av_sz < self::AV_MIN_SZ || $av_sz > $av_max_sz)
		{
			$av_sz = $av_default_sz;
		}
		return $av_sz;
	}



/**
 * MAS Get Config Avatar Size
 *
 * @param String $config_key takes Config Key String
 * @param int $av_default_sz Specifies Default Size in px
 * @param int $av_max_sz Specifies Avatar MAX Size in px
 * @return int with Avatar Size in px
 * @access public
 */
	public function mas_get_config_avatar_size($config_key, $av_default_sz = self::AV_DEF_SZ_SML, $av_max_sz = self::AV_MAX_SZ_SML)
	{
		
		// config -> dark1_mas_XX_sz , Need to set this between self::AV_MIN_SZ to $av_max_sz Only , Default is $av_default_sz.
		$av_sz = $this->mas_get_avatar_size($this->config[$config_key], $av_default_sz, $av_max_sz);

		// Check if correction is required.
		if ($av_sz != $this->config[$config_key])
		{
			$this->config->set($config_key, $av_sz);
			$this->phpbb_log->add('admin', '', '', 'MAS_LOG_CONFIG', time(), array($config_key, $this->user->lang('MAS_ERR_AV_SIZE'), $av_default_sz));
		}
		return $this->config[$config_key];
	}



/**
 * MAS Get Avatar
 *
 * @param String $config_key takes Config Key String
 * @param String $prefix Specifies the prefix to be Searched in the $row
 * @param Array $row is array of data
 * @return String with Avatar Data
 * @access public
 */
	public function mas_get_avatar($config_key, $prefix, $row)
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
 * @access public
 */
	public function mas_online_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
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
 * @access public
 */
	public function mas_get_online_status($online_row)
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
 * @access public
 */
	public function mas_get_online($config_key, $prefix, $row)
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
 * @access public
 */
	public function mas_convert_sql($sql_ary)
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
 * @access public
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	public function mas_get_avatar_img($avatar, $avatar_size = self::AV_DEF_SZ_SML)
	{
		$start_avatar = '<div class="mas-avatar" style="width: ' . $avatar_size . 'px; height: ' . $avatar_size . 'px;">';
		$end_avatar = '</div>';
		return $start_avatar . (($avatar) ? $avatar : self::$NO_AVATAR_IMG) . $end_avatar;
	}



/**
 * MAS Get Online Status DOT
 *
 * @param String $online takes User Online Status
 * @return String with Wrapped User Online Status
 * @access public
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	public function mas_get_online_status_dot($online)
	{
		$online_text = $this->user->lang('ONLINE');
		$offline_text = $this->user->lang('OFFLINE');
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
 * @access public
 *
 * Will be Deprecated in future when Style Template Events are created.
 */
	public function mas_get_username_wrap($username, $config_key, $avatar, $online)
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

}