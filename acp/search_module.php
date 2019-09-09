<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\acp;

use dark1\memberavatarstatus\core\memberavatarstatus;

/**
 * Member Avatar & Status ACP module.
 */
class search_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main()
	{
		global $phpbb_container, $config, $request, $template, $user, $phpbb_log;
		$mas_func = $phpbb_container->get('dark1.memberavatarstatus');
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_search';
		$this->page_title = $user->lang('ACP_MAS_TITLE') . ' - ' . $user->lang('ACP_MAS_MODE_SEARCH');
		add_form_key('acp_mas_search');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_mas_search'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			// Get Setting from ACP
			$config->set('dark1_mas_sh_fp_av', $request->variable('dark1_mas_sh_fp_av', 0));
			$config->set('dark1_mas_sh_fp_ol', $request->variable('dark1_mas_sh_fp_ol', 0));
			$config->set('dark1_mas_sh_lp_av', $request->variable('dark1_mas_sh_lp_av', 0));
			$config->set('dark1_mas_sh_lp_ol', $request->variable('dark1_mas_sh_lp_ol', 0));
			$config->set('dark1_mas_sh_up_av', $request->variable('dark1_mas_sh_up_av', 0));
			$config->set('dark1_mas_sh_up_ol', $request->variable('dark1_mas_sh_up_ol', 0));

			// Check Avatar Size Before Assigning
			$config->set('dark1_mas_sh_fp_av_sz', $mas_func->mas_get_avatar_size($request->variable('dark1_mas_sh_fp_av_sz', memberavatarstatus::AV_DEF_SZ_SML), memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML));
			$config->set('dark1_mas_sh_lp_av_sz', $mas_func->mas_get_avatar_size($request->variable('dark1_mas_sh_lp_av_sz', memberavatarstatus::AV_DEF_SZ_SML), memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML));
			$config->set('dark1_mas_sh_up_av_sz', $mas_func->mas_get_avatar_size($request->variable('dark1_mas_sh_up_av_sz', memberavatarstatus::AV_DEF_SZ_SML), memberavatarstatus::AV_DEF_SZ_SML, memberavatarstatus::AV_MAX_SZ_SML));

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MAS_LOG_SET_SAV', time(), array($user->lang('ACP_MAS_MODE_SEARCH')));
			trigger_error(sprintf($user->lang('ACP_MAS_LOG_SET_SAV'), $user->lang('ACP_MAS_MODE_SEARCH')) . adm_back_link($this->u_action), E_USER_NOTICE);
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			'MAS_SH_FP_AVATAR'	=> $config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $config['dark1_mas_sh_fp_av_sz'],
			'MAS_SH_FP_ONLINE'	=> $config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $config['dark1_mas_sh_lp_av_sz'],
			'MAS_SH_LP_ONLINE'	=> $config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $config['dark1_mas_sh_up_av_sz'],
			'MAS_SH_UP_ONLINE'	=> $config['dark1_mas_sh_up_ol'],
			'MAS_NO_AVATAR_IMG'	=> $mas_func->mas_get_no_avatar_img(),
		));
	}

}
