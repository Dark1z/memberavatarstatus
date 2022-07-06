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
use phpbb\db\driver\driver_interface as db_driver;

/**
 * Member Avatar & Status Core Status Class.
 */
class status
{
	/** @var int Color Default Offline */
	const COL_DEF_OFF = '000000';

	/** @var int Color Default Online */
	const COL_DEF_ON = '00FF00';

	/** @var bool[] User Online List */
	private static $user_online = [];

	/** @var auth */
	protected $auth;

	/** @var config */
	protected $config;

	/** @var db_driver */
	protected $db;

	/**
	 * Constructor for Member Avatar & Status Core Status Class.
	 *
	 * @param auth			$auth		phpBB auth
	 * @param config		$config		phpBB config
	 * @param db_driver		$db			Database object
	 * @access public
	 */
	public function __construct(auth $auth, config $config, db_driver $db)
	{
		$this->auth		= $auth;
		$this->config	= $config;
		$this->db		= $db;
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
	 * MAS Get User Online
	 *
	 * @param array $online_row takes user details to find Online Status
	 * @return bool Online Status
	 * @access private
	 */
	private function mas_get_user_online($online_row)
	{
		return (bool) (
			(time() - ($this->config['load_online_time'] * 60) < $online_row['session_time']) &&
			((isset($online_row['session_viewonline']) && $online_row['session_viewonline']) || $this->auth->acl_get('u_viewonline'))
		);
	}



	/**
	 * MAS Get Online
	 *
	 * @param string $config_key takes Config Key String
	 * @param int $user_id User ID
	 * @return string Online Data
	 * @access public
	 */
	public function mas_get_online($config_key, $user_id)
	{
		$online = '';
		$config_key .= '_ol';

		// Check for Config Online
		if ($this->mas_get_config_online($config_key))
		{
			// Get stored user online status
			$online = $this->mas_user_online_store($user_id);
		}

		return $online;
	}



	/**
	 * MAS User Online Store to retrieve old or create new online status
	 *
	 * @param int $user_id User ID
	 * @return bool User Online Status
	 * @access private
	 */
	private function mas_user_online_store(int $user_id)
	{
		// Check if user online status not stored
		if (!isset(self::$user_online[$user_id]))
		{
			$sql = 'SELECT MAX(session_time) as session_time, MIN(session_viewonline) as session_viewonline' .
					' FROM ' . SESSIONS_TABLE .
					' WHERE session_time >= ' . (time() - ($this->config['load_online_time'] * 60)) . ' AND session_user_id <> ' . ANONYMOUS . ' AND session_user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$online_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			self::$user_online[$user_id] = $this->mas_get_user_online($online_row);
		}

		return self::$user_online[$user_id];
	}

}
