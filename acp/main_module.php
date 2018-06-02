<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dark1\memberavatarstatus\acp;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Member Avatar & Status ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $template, $user, $phpbb_admin_path, $phpEx;

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_main';
		$this->page_title = $user->lang('ACP_MAS_TITLE') . '&nbsp;-&nbsp;' . $user->lang('ACP_MAS_MODE_MAIN');
		$main_adm_path = $phpbb_admin_path . 'index.' . $phpEx;
		add_form_key('acp_mas_main');

		$template->assign_vars(array(
			'MAS_PHPBB_LK_AV'	=> append_sid($main_adm_path, 'i=acp_board&mode=avatar#allow_avatar', false),
			'MAS_PHPBB_LK_OL'	=> append_sid($main_adm_path, 'i=acp_board&mode=load#load_onlinetrack', false),
			'MAS_PHPBB_AVATAR'	=> $config['allow_avatar'],
			'MAS_PHPBB_ONLINE'	=> $config['load_onlinetrack'],
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
			// No Avatar IMG
			'MAS_NO_AVATAR_IMG'	=> $this->mas_get_no_avatar_img(),
		));
	}

	private function mas_get_no_avatar_img()
	{
		global $user, $phpbb_root_path;
		$avatar_row = array(
						'avatar'		=> $phpbb_root_path . 'ext/dark1/memberavatarstatus/image/avatar.png',
						'avatar_type'	=> AVATAR_REMOTE,
						'avatar_width'	=> 1000,
						'avatar_height'	=> 1000,
						);
		return str_replace('" />', '" title="' . $user->lang('MAS_NO_AVATAR_TEXT') . '" />', phpbb_get_user_avatar($avatar_row, $user->lang('MAS_NO_AVATAR_TEXT')));
	}
}
