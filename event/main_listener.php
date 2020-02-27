<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\mas_avatar;
use dark1\memberavatarstatus\core\mas_status;
use phpbb\template\template;

/**
 * Member Avatar & Status Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \dark1\memberavatarstatus\core\mas_avatar*/
	protected $mas_avatar;

	/** @var \dark1\memberavatarstatus\core\mas_status*/
	protected $mas_status;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor for listener
	 *
	 * @param \dark1\memberavatarstatus\core\mas_avatar		$mas_avatar		dark1 mas_avatar
	 * @param \dark1\memberavatarstatus\core\mas_status		$mas_status		dark1 mas_status
	 * @param \phpbb\template\template						$template	phpBB template
	 * @access public
	 */
	public function __construct(mas_avatar $mas_avatar, mas_status $mas_status, template $template)
	{
		$this->mas_avatar	= $mas_avatar;
		$this->mas_status	= $mas_status;
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
			'core.user_setup'								=> 'mas_load_lang',
			'core.page_header_after'						=> 'mas_header',
		);
	}



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
			// General
			'MAS_AVATAR'		=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_avatar'),
			'MAS_ONLINE'		=> $this->mas_status->mas_get_config_online('dark1_mas_online'),
			'MAS_COLOR_OFFLINE'	=> $this->mas_status->mas_get_config_color('off'),
			'MAS_COLOR_ONLINE'	=> $this->mas_status->mas_get_config_color('on'),
			// MemberList
			'MAS_ML_AVATAR'		=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_ml_av'),
			'MAS_ML_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_ml_av_sz', mas_avatar::AV_DEF_SZ_BIG, mas_avatar::AV_MAX_SZ_BIG),
			'MAS_ML_ONLINE'		=> $this->mas_status->mas_get_config_online('dark1_mas_ml_ol'),
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_vo_pg_av'),
			'MAS_VO_PG_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_vo_pg_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_VO_SB_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_vo_sb_av'),
			'MAS_VO_SB_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_vo_sb_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_vf_fp_av'),
			'MAS_VF_FP_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_vf_fp_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_VF_FP_ONLINE'	=> $this->mas_status->mas_get_config_online('dark1_mas_vf_fp_ol'),
			'MAS_VF_LP_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_vf_lp_av'),
			'MAS_VF_LP_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_vf_lp_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_VF_LP_ONLINE'	=> $this->mas_status->mas_get_config_online('dark1_mas_vf_lp_ol'),
			// Search
			'MAS_SH_FP_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_sh_fp_av'),
			'MAS_SH_FP_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_sh_fp_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_SH_FP_ONLINE'	=> $this->mas_status->mas_get_config_online('dark1_mas_sh_fp_ol'),
			'MAS_SH_LP_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_sh_lp_av'),
			'MAS_SH_LP_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_sh_lp_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_SH_LP_ONLINE'	=> $this->mas_status->mas_get_config_online('dark1_mas_sh_lp_ol'),
			'MAS_SH_UP_AVATAR'	=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_sh_up_av'),
			'MAS_SH_UP_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_sh_up_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_SH_UP_ONLINE'	=> $this->mas_status->mas_get_config_online('dark1_mas_sh_up_ol'),
			// Review
			'MAS_RV_AVATAR'		=> $this->mas_avatar->mas_get_config_avatar('dark1_mas_rv_av'),
			'MAS_RV_AV_SIZE'	=> $this->mas_avatar->mas_get_config_avatar_size('dark1_mas_rv_av_sz', mas_avatar::AV_DEF_SZ_SML, mas_avatar::AV_MAX_SZ_SML),
			'MAS_RV_ONLINE'		=> $this->mas_status->mas_get_config_online('dark1_mas_rv_ol'),
			// No Avatar IMG
			'MAS_NO_AVATAR_IMG'	=> $this->mas_avatar->mas_get_no_avatar_img(),
		));
	}

}
