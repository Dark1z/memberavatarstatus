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

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/**
	 * Constructor for Member Avatar & Status Core Avatar Class.
	 *
	 * @param config		$config				phpBB config
	 * @param language		$language			phpBB language
	 * @param string		$phpbb_root_path	phpBB root path
	 * @access public
	 */
	public function __construct(config $config, language $language, $phpbb_root_path)
	{
		$this->config			= $config;
		$this->language			= $language;
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
	 * MAS Get Avatar SQL Query
	 *
	 * @param array $sql_ary takes SQL Array
	 * @param string $config_key takes Config Key String
	 * @param string $sql_uid Specifies User ID to be Matched with.
	 * @param string $sql_obj Specifies SQL Object
	 * @param string $prefix Specifies the prefix to be Set in SQL Select
	 * @param string $lj_on_ex Specifies the Left Join On Extra SQL Query
	 * @return array Array of data
	 * @access public
	 */
	public function mas_avatar_sql_query($sql_ary, $config_key, $sql_uid, $sql_obj, $prefix, $lj_on_ex)
	{
		$config_key .= '_av';
		$prefix .= ($prefix != '') ? '_' : '';

		if ($this->mas_get_config_avatar($config_key))
		{
			$sql_ary['SELECT'] .= ', ' . $sql_obj . '.user_avatar as ' . $prefix . 'avatar, ' . $sql_obj . '.user_avatar_type as ' . $prefix . 'avatar_type, ' . $sql_obj . '.user_avatar_width as ' . $prefix . 'avatar_width, ' . $sql_obj . '.user_avatar_height as ' . $prefix . 'avatar_height';
			$sql_ary['LEFT_JOIN'][] = [
				'FROM'	=> [USERS_TABLE => $sql_obj],
				'ON'	=> $sql_uid . ' = ' . $sql_obj . '.user_id' . $lj_on_ex,
			];
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
			$avatar_row = [
				'avatar'		=> $row[$prefix . 'avatar'],
				'avatar_type'	=> $row[$prefix . 'avatar_type'],
				'avatar_width'	=> $row[$prefix . 'avatar_width'],
				'avatar_height'	=> $row[$prefix . 'avatar_height'],
			];
			$avatar = phpbb_get_user_avatar($avatar_row);
		}

		return $avatar;
	}

}
