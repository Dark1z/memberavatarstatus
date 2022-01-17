<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\core;

/**
 * @ignore
 */
use phpbb\auth\auth;
use phpbb\config\config;

/**
 * Member Avatar & Status Core Status Class.
 */
class status
{
	/** @var int Color Default Offline */
	const COL_DEF_OFF = '000000';

	/** @var int Color Default Online */
	const COL_DEF_ON = '00FF00';

	/** @var auth */
	protected $auth;

	/** @var config */
	protected $config;

	/**
	 * Constructor for Member Avatar & Status Core Status Class.
	 *
	 * @param auth		$auth				phpBB auth
	 * @param config	$config				phpBB config
	 * @access public
	 */
	public function __construct(auth $auth, config $config)
	{
		$this->auth		= $auth;
		$this->config	= $config;
	}



	/**
	 * MAS Get Config Online
	 *
	 * @param string|bool $config_key takes Config Key String
	 * @return bool Bool with Online Enable
	 * @access public
	 */
	public function mas_get_config_online($config_key = false)
	{
		// Check if Online is Enabled.
		return (bool) ($this->config['load_onlinetrack'] && $this->config['dark1_mas_online'] && ($config_key !== false ? $this->config[$config_key] : true));
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
		// config -> dark1_mas_col_XX , Need to get this in Hexadecimal Only else Default.
		$color = $this->mas_config_color($key, $this->config['dark1_mas_col_' . $key]);

		// Check if correction is required then set it.
		if ($color != $this->config['dark1_mas_col_' . $key])
		{
			$this->config->set('dark1_mas_col_' . $key, $color);
		}

		return $this->config['dark1_mas_col_' . $key];
	}



	/**
	 * MAS Get Online SQL Query
	 *
	 * @param array $sql_ary takes SQL Array
	 * @param string $config_key takes Config Key String
	 * @param string $sql_uid Specifies User ID to be Matched with.
	 * @param string $sql_obj Specifies SQL Object
	 * @param string $prefix Specifies the prefix to be Set in SQL Select
	 * @param string $lj_on_ex Specifies the Left Join On Extra SQL Query
	 * @param string $group_by Specifies the Group By SQL Query
	 * @return array Array of data
	 * @access public
	 */
	public function mas_online_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex, $group_by)
	{
		$config_key .= '_ol';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_online($config_key))
		{
			$sql_ary['SELECT'] .= ', MAX(' . $sql_obj . '.session_time) as ' . $prefix . 'session_time, MIN(' . $sql_obj . '.session_viewonline) as ' . $prefix . 'session_viewonline';
			$sql_ary['LEFT_JOIN'][] = [
				'FROM'	=> [SESSIONS_TABLE => $sql_obj],
				'ON'	=> $sql_uid . ' = ' . $sql_obj . '.session_user_id AND ' . $sql_obj . '.session_time >= ' . (time() - ($this->config['load_online_time'] * 60)) . ' AND ' . $sql_obj . '.session_user_id <> ' . ANONYMOUS . $lj_on_ex,
			];

			if ($group_by != '')
			{
				$sql_ary['GROUP_BY'] = (isset($sql_ary['GROUP_BY']) && !empty($sql_ary['GROUP_BY'])) ? $sql_ary['GROUP_BY'] . ', '.$group_by : $group_by;
			}
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

		if ($this->mas_get_config_online())
		{
			$online = (time() - ($this->config['load_online_time'] * 60) < $online_row['session_time'] && ((isset($online_row['session_viewonline']) && $online_row['session_viewonline']) || $this->auth->acl_get('u_viewonline'))) ? true : false;
		}

		return (bool) $online;
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
			$online_row = [
				'session_time'			=> $row[$prefix . 'session_time'],
				'session_viewonline'	=> $row[$prefix . 'session_viewonline'],
			];
			$online = $this->mas_get_online_status($online_row);
		}

		return $online;
	}

}
