<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\core;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\language\language;
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
	const AV_DEF_SZ_SML = 20;

	/** @var int Avatar Default Size Big */
	const AV_DEF_SZ_BIG = 50;

	/** @var int Avatar Maximum Size Small */
	const AV_MAX_SZ_SML = 99;

	/** @var int Avatar Maximum Size Big */
	const AV_MAX_SZ_BIG = 999;

	/** @var int Color Default Offline */
	const COL_DEF_OFF = '000000';

	/** @var int Color Default Online */
	const COL_DEF_ON = '00FF00';

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $phpbb_log;

	/** @var string */
	protected $phpbb_root_path;

	/**
	 * Constructor for listener
	 *
	 * @param \phpbb\auth\auth				$auth				phpBB auth
	 * @param \phpbb\config\config			$config				phpBB config
	 * @param \phpbb\language\language		$language			phpBB language
	 * @param \phpbb\log\log				$phpbb_log			phpBB log
	 * @param string						$phpbb_root_path	phpBB root_path
	 * @access public
	 */
	public function __construct(auth $auth, config $config, language $language, log $phpbb_log, $phpbb_root_path)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->language			= $language;
		$this->phpbb_log		= $phpbb_log;
		$this->phpbb_root_path	= $phpbb_root_path;
	}



	/**
	 * MAS Get No Avatar IMG
	 *
	 * @param void
	 * @return string String with No Avatar IMG
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
			'" title="' . $this->language->lang('MAS_NO_AVATAR_TEXT') . '" />',
			phpbb_get_user_avatar($avatar_row, $this->language->lang('MAS_NO_AVATAR_TEXT'), true)
		);
	}



	/**
	 * MAS Get Config Avatar
	 *
	 * @param string $config_key takes Config Key String
	 * @return bool Bool with Avatar Enable
	 * @access public
	 */
	public function mas_get_config_avatar($config_key)
	{
		// Check if Avatar is Enabled.
		return (bool) ($this->config['allow_avatar'] && $this->config['dark1_mas_avatar'] && $this->config[$config_key]);
	}



	/**
	 * MAS Get Config Online
	 *
	 * @param string $config_key takes Config Key String
	 * @return bool Bool with Online Enable
	 * @access public
	 */
	public function mas_get_config_online($config_key)
	{
		// Check if Online is Enabled.
		return (bool) ($this->config['load_onlinetrack'] && $this->config['dark1_mas_online'] && $this->config[$config_key]);
	}



	/**
	 * MAS Get Config Online/Offline Color
	 *
	 * @param string $key takes `on/off` String
	 * @param string $color takes Hex Color String
	 * @return string String with Hex Color
	 * @access public
	 */
	public function mas_config_color($key, $color)
	{
		// Check if Color is in Hexadecimal else Default.
		if (!preg_match('/^([0-9a-fA-F]{6}|[0-9a-fA-F]{3})$/', $color))
		{
			$color = (strtoupper($key) === 'ON') ? self::COL_DEF_ON : self::COL_DEF_OFF ;
		}

		return $color;
	}



	/**
	 * MAS Get Config Online/Offline Color
	 *
	 * @param string $key takes `on/off` String
	 * @return string String with Hex Color
	 * @access public
	 */
	public function mas_get_config_color($key)
	{
		return $this->mas_config_color($key, $this->config['dark1_mas_col_' . $key]);
	}



	/**
	 * MAS Get Avatar SQL Query
	 *
	 * @param string $sql_ary takes SQL Array
	 * @param string $config_key takes Config Key String
	 * @param string $sql_uid Specifies User ID to be Matched with.
	 * @param string $sql_obj Specifies SQL Object
	 * @param string $prefix Specifies the prefix to be Set in SQL Select
	 * @param string $lj_on_ex Specifies the Left Join On Extension SQL Query
	 * @return array Array of data
	 * @access public
	 */
	public function mas_avatar_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
	{
		$config_key .= '_av';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_avatar($config_key))
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
	 * @return int Integer with Avatar Size in px
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
	 * @param string $config_key takes Config Key String
	 * @param int $av_default_sz Specifies Default Size in px
	 * @param int $av_max_sz Specifies Avatar MAX Size in px
	 * @return int Integer with Avatar Size in px
	 * @access public
	 */
	public function mas_get_config_avatar_size($config_key, $av_default_sz = self::AV_DEF_SZ_SML, $av_max_sz = self::AV_MAX_SZ_SML)
	{

		// config -> dark1_mas_XX_sz , Need to set this between self::AV_MIN_SZ to $av_max_sz Only , Default is $av_default_sz.
		$av_sz = $this->mas_get_avatar_size((int) $this->config[$config_key], $av_default_sz, $av_max_sz);

		// Check if correction is done then set it.
		if ($av_sz != $this->config[$config_key])
		{
			$this->config->set($config_key, $av_sz);
			$this->phpbb_log->add('admin', '', '', 'MAS_LOG_CONFIG', time(), array($config_key, $this->language->lang('MAS_ERR_AV_SIZE'), $av_default_sz));
		}
		return $this->config[$config_key];
	}



	/**
	 * MAS Get Avatar
	 *
	 * @param string $config_key takes Config Key String
	 * @param string $prefix Specifies the prefix to be Searched in the $row
	 * @param array $row is array of data
	 * @return string String with Avatar Data
	 * @access public
	 */
	public function mas_get_avatar($config_key, $prefix, $row)
	{
		$avatar = '';
		$config_key .= '_av';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_avatar($config_key))
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
	 * @param string $sql_ary takes SQL Array
	 * @param string $config_key takes Config Key String
	 * @param string $sql_uid Specifies User ID to be Matched with.
	 * @param string $sql_obj Specifies SQL Object
	 * @param string $prefix Specifies the prefix to be Set in SQL Select
	 * @param string $lj_on_ex Specifies the Left Join On Extension SQL Query
	 * @return array Array of data
	 * @access public
	 */
	public function mas_online_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex = '')
	{
		$config_key .= '_ol';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_online($config_key))
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
	 * @param array $online_row takes user details to find Online Status
	 * @return bool Bool Online Status
	 * @access public
	 */
	public function mas_get_online_status($online_row)
	{
		$online = false;

		if ($this->mas_get_config_online('dark1_mas_online'))
		{
			$online = (time() - ($this->config['load_online_time'] * 60) < $online_row['session_time'] && ((isset($online_row['session_viewonline']) && $online_row['session_viewonline']) || $this->auth->acl_get('u_viewonline'))) ? true : false;
		}

		return $online;
	}



	/**
	 * MAS Get Online
	 *
	 * @param string $config_key takes Config Key String
	 * @param string $prefix Specifies the prefix to be Searched in the $row
	 * @param array $row is array of data
	 * @return string String with Online Data
	 * @access public
	 */
	public function mas_get_online($config_key, $prefix, $row)
	{
		$online = '';
		$config_key .= '_ol';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_online($config_key))
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
	 * @param array $sql_ary takes SQL Array
	 * @return array Array of data
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
	 * @param string $avatar takes User Avatar IMG
	 * @param int $avatar_size Specifies Avatar Size in px
	 * @return string String with Wrapped User Avatar IMG
	 * @access public
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	public function mas_get_avatar_img($avatar, $avatar_size = self::AV_DEF_SZ_SML)
	{
		$start_avatar = '<div class="mas-avatar" style="width: ' . $avatar_size . 'px; height: ' . $avatar_size . 'px;">';
		$end_avatar = '</div>';
		return $start_avatar . (($avatar) ? $avatar : $this->mas_get_no_avatar_img()) . $end_avatar;
	}



	/**
	 * MAS Get Online Status DOT
	 *
	 * @param string $online takes User Online Status
	 * @return string String with Wrapped User Online Status
	 * @access public
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	public function mas_get_online_status_dot($online)
	{
		$online_text = $this->language->lang('ONLINE');
		$offline_text = $this->language->lang('OFFLINE');
		$start_online = ' ' . '<div class="mas-wrap-status' . ($online ? ' mas-status-online' : '') . '">';
		$end_online = '</div>';
		$online_dot = '<span class="mas-status-dot mas-color" title="' . ($online ? $online_text : $offline_text) . '"/>';
		return $start_online . $online_dot . $end_online;
	}



	/**
	 * MAS Get UserName Wrap
	 *
	 * @param string $username takes UserName
	 * @param string $config_key takes Config Key String
	 * @param string $avatar takes User Avatar IMG
	 * @param string $online takes User Online Status
	 * @return string String with Wrapped Main & UserName
	 * @access public
	 *
	 * Will be Deprecated in future when Style Template Events are created.
	 */
	public function mas_get_username_wrap($username, $config_key, $avatar, $online)
	{
		$start_wrap = '<div class="mas-wrap">';
		$start_username = '<div class="mas-username">';
		$end_tag = '</div>';
		$avatar_test = $this->mas_get_config_avatar($config_key . '_av');
		$online_test = $this->mas_get_config_online($config_key . '_ol');
		$avatar_wrap = ($avatar_test) ? $this->mas_get_avatar_img($avatar, (int) $this->config[$config_key . '_av_sz']) : '';
		$online_wrap = ($online_test) ? $this->mas_get_online_status_dot($online) : '';
		return ($avatar_test || $online_test) ? ($start_wrap . $avatar_wrap . $start_username . $username . $end_tag . $online_wrap . $end_tag) : $username;
	}

}
