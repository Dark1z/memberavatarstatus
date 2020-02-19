<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\acp;

/**
 * Member Avatar & Status ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main()
	{
		global $config, $template, $user, $language, $phpbb_root_path, $phpbb_adm_relative_path, $phpEx;
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_main';
		$this->page_title = $language->lang('ACP_MAS_TITLE') . ' - ' . $language->lang('ACP_MAS_MODE_MAIN');
		$main_adm_path = $phpbb_root_path . $phpbb_adm_relative_path . 'index.' . $phpEx;

		$template->assign_vars(array(
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			'MAS_PHPBB_LK_AV'	=> append_sid($main_adm_path, 'i=acp_board&amp;mode=avatar#allow_avatar'),
			'MAS_PHPBB_LK_OL'	=> append_sid($main_adm_path, 'i=acp_board&amp;mode=load#load_onlinetrack'),
			'MAS_PHPBB_AVATAR'	=> $config['allow_avatar'],
			'MAS_PHPBB_ONLINE'	=> $config['load_onlinetrack'],
			// General
			'MAS_AVATAR'		=> $config['dark1_mas_avatar'],
			'MAS_ONLINE'		=> $config['dark1_mas_online'],
			'MAS_COLOR_OFFLINE'	=> $config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $config['dark1_mas_col_on'],
			// MemberList
			'MAS_ML_AVATAR'		=> $config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $config['dark1_mas_ml_av_sz'],
			'MAS_ML_ONLINE'		=> $config['dark1_mas_ml_ol'],
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $config['dark1_mas_vo_pg_av'],
			'MAS_VO_PG_AV_SIZE'	=> $config['dark1_mas_vo_pg_av_sz'],
			'MAS_VO_SB_AVATAR'	=> $config['dark1_mas_vo_sb_av'],
			'MAS_VO_SB_AV_SIZE'	=> $config['dark1_mas_vo_sb_av_sz'],
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $config['dark1_mas_vf_fp_av'],
			'MAS_VF_FP_AV_SIZE'	=> $config['dark1_mas_vf_fp_av_sz'],
			'MAS_VF_FP_ONLINE'	=> $config['dark1_mas_vf_fp_ol'],
			'MAS_VF_LP_AVATAR'	=> $config['dark1_mas_vf_lp_av'],
			'MAS_VF_LP_AV_SIZE'	=> $config['dark1_mas_vf_lp_av_sz'],
			'MAS_VF_LP_ONLINE'	=> $config['dark1_mas_vf_lp_ol'],
			// Search
			'MAS_SH_FP_AVATAR'	=> $config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $config['dark1_mas_sh_fp_av_sz'],
			'MAS_SH_FP_ONLINE'	=> $config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $config['dark1_mas_sh_lp_av_sz'],
			'MAS_SH_LP_ONLINE'	=> $config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $config['dark1_mas_sh_up_av_sz'],
			'MAS_SH_UP_ONLINE'	=> $config['dark1_mas_sh_up_ol'],
			// Review
			'MAS_RV_AVATAR'		=> $config['dark1_mas_rv_av'],
			'MAS_RV_AV_SIZE'	=> $config['dark1_mas_rv_av_sz'],
			'MAS_RV_ONLINE'		=> $config['dark1_mas_rv_ol'],
		));
	}

}
