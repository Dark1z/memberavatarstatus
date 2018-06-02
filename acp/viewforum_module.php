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
class viewforum_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	private $acp_error_text;
	private $trigger_error_text;
	private $trigger_error_value;
	private $triggered_error = 0;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_log, $phpbb_root_path;

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_viewforum';
		$this->page_title = $user->lang('ACP_MAS_TITLE') . '&nbsp;-&nbsp;' . $user->lang('ACP_MAS_MODE_VIEWFORUM');
		add_form_key('acp_mas_viewforum');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_mas_viewforum'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			$this->acp_error_text = '<br />&raquo;&nbsp;' . $user->lang('ACP_MAS_MODE_VIEWFORUM') . '&nbsp;' . $user->lang('ACP_MAS_SET_SAV');
			$this->trigger_error_text = $user->lang('ACP_MAS_TITLE') . '<br />' . $user->lang('ACP_MAS_MODE_VIEWFORUM') . '&nbsp;' . $user->lang('ACP_MAS_SET_SAV');
			$this->trigger_error_value = E_USER_NOTICE;

			// Get Setting from ACP
			$config->set('dark1_mas_vf_fp_av', $request->variable('dark1_mas_vf_fp_av', 0));
			$config->set('dark1_mas_vf_fp_ol', $request->variable('dark1_mas_vf_fp_ol', 0));
			$config->set('dark1_mas_vf_lp_av', $request->variable('dark1_mas_vf_lp_av', 0));
			$config->set('dark1_mas_vf_lp_ol', $request->variable('dark1_mas_vf_lp_ol', 0));

			// Check Avatar Size Before Assigning
			$config->set('dark1_mas_vf_fp_av_sz', $this->mas_get_avatar_size($request->variable('dark1_mas_vf_fp_av_sz', 20)));
			$config->set('dark1_mas_vf_lp_av_sz', $this->mas_get_avatar_size($request->variable('dark1_mas_vf_lp_av_sz', 20)));

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MAS_LOG_TITLE', time(), array($this->acp_error_text));
			trigger_error($this->trigger_error_text . adm_back_link($this->u_action), $this->trigger_error_value);
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'MAS_VF_FP_AVATAR'	=> $config['dark1_mas_vf_fp_av'],
			'MAS_VF_FP_AV_SIZE'	=> $config['dark1_mas_vf_fp_av_sz'],
			'MAS_VF_FP_ONLINE'	=> $config['dark1_mas_vf_fp_ol'],
			'MAS_VF_LP_AVATAR'	=> $config['dark1_mas_vf_lp_av'],
			'MAS_VF_LP_AV_SIZE'	=> $config['dark1_mas_vf_lp_av_sz'],
			'MAS_VF_LP_ONLINE'	=> $config['dark1_mas_vf_lp_ol'],
			'MAS_NO_AVATAR_IMG'	=> $this->mas_get_no_avatar_img(),
		));
	}

	private function mas_get_avatar_size($AvatarSize)
	{
		global $user;
		if ($AvatarSize < 9 || $AvatarSize > 99)
		{
			$AvatarSize = 20; // Need to set this between 9 to 99 Only , Default is 20.
			if ($this->triggered_error == 0)
			{
				$this->acp_error_text .= '<br />&raquo;&nbsp;' . $user->lang('ACP_MAS_ERR_AV_SZ_SML');
				$this->trigger_error_text .= '<br />' . $user->lang('ACP_MAS_ERR_AV_SZ_SML');
				$this->trigger_error_value = E_USER_WARNING;
				$this->triggered_error = 1;
			}
		}
		return $AvatarSize;
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
