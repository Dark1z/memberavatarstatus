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
use phpbb\config\config;
use phpbb\language\language;
use phpbb\db\driver\driver_interface as db_driver;

/**
 * Member Avatar & Status Core Avatar Class.
 */
class avatar
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

	/** @var string[] User Avatar List */
	private static $user_avatar = [];

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var db_driver */
	protected $db;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string phpBB php ext */
	protected $php_ext;

	/**
	 * Constructor for Member Avatar & Status Core Avatar Class.
	 *
	 * @param config		$config				phpBB config
	 * @param language		$language			phpBB language
	 * @param db_driver		$db					Database object
	 * @param string		$phpbb_root_path	phpBB root path
	 * @param string		$php_ext			phpBB php ext
	 * @access public
	 */
	public function __construct(config $config, language $language, db_driver $db, $phpbb_root_path, $php_ext)
	{
		$this->config			= $config;
		$this->language			= $language;
		$this->db				= $db;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->php_ext			= $php_ext;

		$this->mas_include();
	}

	/**
	* MAS Include
	*
	* @return void
	* @access private
	*/
	private function mas_include()
	{
		include_once($this->phpbb_root_path . 'includes/functions.' . $this->php_ext);
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
		$avatar_row = [
			'avatar'		=> $this->phpbb_root_path . 'ext/dark1/memberavatarstatus/image/avatar.png',
			'avatar_type'	=> AVATAR_REMOTE,
			'avatar_width'	=> self::NO_AVATAR_SIZE,
			'avatar_height'	=> self::NO_AVATAR_SIZE,
		];
		return str_replace(
			'" />',
			'" title="' . $this->language->lang('MAS_NO_AVATAR_TEXT') . '" />',
			phpbb_get_user_avatar($avatar_row, $this->language->lang('MAS_NO_AVATAR_TEXT'), true)
		);
	}



	/**
	 * MAS Get Config Avatar
	 *
	 * @param string|bool $config_key takes Config Key String
	 * @return bool Bool with Avatar Enable
	 * @access public
	 */
	public function mas_get_config_avatar($config_key = false)
	{
		// Check if Avatar is Enabled.
		return (bool) ($this->config['allow_avatar'] && $this->config['dark1_mas_avatar'] && ($config_key !== false ? $this->config[$config_key] : true));
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
		return (int) $av_sz;
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
		// config -> dark1_mas_XX_sz , Need to get this between self::AV_MIN_SZ to $av_max_sz Only , Default is $av_default_sz.
		$av_sz = $this->mas_get_avatar_size((int) $this->config[$config_key], $av_default_sz, $av_max_sz);

		// Check if correction is required then set it.
		if ($av_sz != $this->config[$config_key])
		{
			$this->config->set($config_key, $av_sz);
		}

		return (int) $this->config[$config_key];
	}



	/**
	 * MAS Get Avatar
	 *
	 * @param string $config_key takes Config Key String
	 * @param int $user_id User ID
	 * @return string String with Avatar Data
	 * @access public
	 */
	public function mas_get_avatar($config_key, $user_id)
	{
		$avatar = '';
		$config_key .= '_av';

		// Check for Config Avatar
		if ($this->mas_get_config_avatar($config_key))
		{
			// Get stored user avatar
			$avatar = $this->mas_user_avatar_store($user_id);
		}

		return $avatar;
	}



	/**
	 * MAS User Avatar Store to retrieve old or create new avatar
	 *
	 * @param int $user_id User ID
	 * @return string User Avatar HTML
	 * @access private
	 */
	private function mas_user_avatar_store(int $user_id)
	{
		// Check if user avatar not stored
		if (!isset(self::$user_avatar[$user_id]))
		{
			$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height' .
					' FROM ' . USERS_TABLE .
					' WHERE user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$avatar_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			self::$user_avatar[$user_id] = phpbb_get_user_avatar($avatar_row);
		}

		return self::$user_avatar[$user_id];
	}

}
