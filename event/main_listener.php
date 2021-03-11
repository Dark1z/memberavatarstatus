<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\avatar;
use dark1\memberavatarstatus\core\status;
use phpbb\template\template;
use phpbb\language\language;

/**
 * Member Avatar & Status Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/** @var avatar*/
	protected $avatar;

	/** @var status*/
	protected $status;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/**
	 * Constructor for listener
	 *
	 * @param avatar		$avatar		dark1 avatar
	 * @param status		$status		dark1 status
	 * @param template		$template	phpBB template
	 * @param language		$language	phpBB language
	 * @access public
	 */
	public function __construct(avatar $avatar, status $status, template $template, language $language)
	{
		$this->avatar		= $avatar;
		$this->status		= $status;
		$this->template		= $template;
		$this->language		= $language;
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
		return [
			'core.user_setup_after'		=> 'mas_load_lang',
			'core.page_header_after'	=> 'mas_header',
		];
	}



	/**
	 * MAS Load language files during user setup after
	 *
	 * @return null
	 * @access public
	 */
	public function mas_load_lang()
	{
		$this->language->add_lang('lang_mas', 'dark1/memberavatarstatus');
	}



	/**
	 * MAS Header setup during page header after
	 *
	 * @return null
	 * @access public
	 */
	public function mas_header()
	{
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		// Assign template var's
		$this->template->assign_vars([
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			// General
			'MAS_AVATAR'		=> $this->avatar->mas_get_config_avatar(),
			'MAS_ONLINE'		=> $this->status->mas_get_config_online(),
			'MAS_COLOR_OFFLINE'	=> $this->status->mas_get_config_color('off'),
			'MAS_COLOR_ONLINE'	=> $this->status->mas_get_config_color('on'),
			// MemberList
			'MAS_ML_AVATAR'		=> $this->avatar->mas_get_config_avatar('dark1_mas_ml_av'),
			'MAS_ML_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_ml_av_sz', avatar::AV_DEF_SZ_BIG, avatar::AV_MAX_SZ_BIG),
			'MAS_ML_ONLINE'		=> $this->status->mas_get_config_online('dark1_mas_ml_ol'),
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_vo_pg_av'),
			'MAS_VO_PG_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_vo_pg_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_VO_SB_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_vo_sb_av'),
			'MAS_VO_SB_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_vo_sb_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_vf_fp_av'),
			'MAS_VF_FP_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_vf_fp_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_VF_FP_ONLINE'	=> $this->status->mas_get_config_online('dark1_mas_vf_fp_ol'),
			'MAS_VF_LP_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_vf_lp_av'),
			'MAS_VF_LP_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_vf_lp_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_VF_LP_ONLINE'	=> $this->status->mas_get_config_online('dark1_mas_vf_lp_ol'),
			// Search
			'MAS_SH_FP_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_sh_fp_av'),
			'MAS_SH_FP_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_sh_fp_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_SH_FP_ONLINE'	=> $this->status->mas_get_config_online('dark1_mas_sh_fp_ol'),
			'MAS_SH_LP_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_sh_lp_av'),
			'MAS_SH_LP_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_sh_lp_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_SH_LP_ONLINE'	=> $this->status->mas_get_config_online('dark1_mas_sh_lp_ol'),
			'MAS_SH_UP_AVATAR'	=> $this->avatar->mas_get_config_avatar('dark1_mas_sh_up_av'),
			'MAS_SH_UP_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_sh_up_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_SH_UP_ONLINE'	=> $this->status->mas_get_config_online('dark1_mas_sh_up_ol'),
			// Review
			'MAS_RV_AVATAR'		=> $this->avatar->mas_get_config_avatar('dark1_mas_rv_av'),
			'MAS_RV_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_rv_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_RV_ONLINE'		=> $this->status->mas_get_config_online('dark1_mas_rv_ol'),
			// Friendlist
			'MAS_FL_AVATAR'		=> $this->avatar->mas_get_config_avatar('dark1_mas_fl_av'),
			'MAS_FL_AV_SIZE'	=> $this->avatar->mas_get_config_avatar_size('dark1_mas_fl_av_sz', avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML),
			'MAS_FL_ONLINE'		=> $this->status->mas_get_config_online('dark1_mas_fl_ol'),
			// No Avatar IMG
			'MAS_NO_AVATAR_IMG'	=> $this->avatar->mas_get_no_avatar_img(),
		]);
	}

}
