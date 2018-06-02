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
class memberlist_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_log, $phpbb_root_path;

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

			$acp_error_text = '<br />&raquo;&nbsp;' . $user->lang('ACP_MAS_MODE_MEMBERLIST') . '&nbsp;' . $user->lang('ACP_MAS_SET_SAV');
			$trigger_error_text = $user->lang('ACP_MAS_TITLE') . '<br />' . $user->lang('ACP_MAS_MODE_MEMBERLIST') . '&nbsp;' . $user->lang('ACP_MAS_SET_SAV');
			$trigger_error_value = E_USER_NOTICE;

			// Get Setting from ACP
			$config->set('dark1_mas_ml_av', $request->variable('dark1_mas_ml_av', 0));
			$config->set('dark1_mas_ml_ol', $request->variable('dark1_mas_ml_ol', 0));

			// Check Avatar Size Before Assigning
			$AvatarSize = $request->variable('dark1_mas_ml_av_sz', 50);
			if ($AvatarSize < 9 || $AvatarSize > 999)
			{
				$AvatarSize = 50; // Need to set this between 9 to 999 Only , Default is 50.
				$acp_error_text .= '<br />&raquo;&nbsp;' . $user->lang('ACP_MAS_ERR_AV_SZ_BIG');
				$trigger_error_text .= '<br />' . $user->lang('ACP_MAS_ERR_AV_SZ_BIG');
				$trigger_error_value = E_USER_WARNING;
			}
			$config->set('dark1_mas_ml_av_sz', $AvatarSize);

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MAS_LOG_TITLE', time(), array($acp_error_text));
			trigger_error($trigger_error_text . adm_back_link($this->u_action), $trigger_error_value);
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'MAS_ML_AVATAR'		=> $config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $config['dark1_mas_ml_av_sz'],
			'MAS_ML_ONLINE'		=> $config['dark1_mas_ml_ol'],
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
