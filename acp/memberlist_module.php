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
 * Member Avatar & Status ACP module.
 */
class memberlist_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $config, $request, $template, $user, $phpbb_log, $phpbb_root_path;
		$mas_func = $phpbb_container->get('dark1.memberavatarstatus');
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_memberlist';
		$this->page_title = $user->lang('ACP_MAS_TITLE') . '&nbsp;-&nbsp;' . $user->lang('ACP_MAS_MODE_MEMBERLIST');
		add_form_key('acp_mas_memberlist');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_mas_memberlist'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			// Get Setting from ACP
			$config->set('dark1_mas_ml_av', $request->variable('dark1_mas_ml_av', 0));
			$config->set('dark1_mas_ml_ol', $request->variable('dark1_mas_ml_ol', 0));
			$config->set('dark1_mas_ml_av_sz', $mas_func->mas_get_avatar_size($request->variable('dark1_mas_ml_av_sz', $mas_func::AV_DEF_SZ_BIG), $mas_func::AV_DEF_SZ_BIG, $mas_func::AV_MAX_SZ_BIG));

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MAS_LOG_SET_SAV', time(), array($user->lang('ACP_MAS_MODE_MEMBERLIST')));
			trigger_error(sprintf($user->lang('ACP_MAS_LOG_SET_SAV'), $user->lang('ACP_MAS_MODE_MEMBERLIST')) . adm_back_link($this->u_action), E_USER_NOTICE);
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			'MAS_ML_AVATAR'		=> $config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $config['dark1_mas_ml_av_sz'],
			'MAS_ML_ONLINE'		=> $config['dark1_mas_ml_ol'],
			'MAS_NO_AVATAR_IMG'	=> $mas_func->mas_get_no_avatar_img(),
		));
	}

}
