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
class general_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main()
	{
		global $phpbb_container, $config, $request, $template, $user, $language, $phpbb_log;
		$mas = $phpbb_container->get('dark1.memberavatarstatus');
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		$user->add_lang_ext('dark1/memberavatarstatus', 'lang_acp_mas');
		$this->tpl_name = 'acp_mas_general';
		$this->page_title = $language->lang('ACP_MAS_TITLE') . ' - ' . $language->lang('ACP_MAS_MODE_GENERAL');
		add_form_key('acp_mas_general');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_mas_general'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			// Get Setting from ACP
			$config->set('dark1_mas_avatar', $request->variable('dark1_mas_avatar', 0));
			$config->set('dark1_mas_online', $request->variable('dark1_mas_online', 0));
			$config->set('dark1_mas_col_off', $mas->mas_config_color('off', $request->variable('dark1_mas_col_off', memberavatarstatus::COL_DEF_OFF)));
			$config->set('dark1_mas_col_on', $mas->mas_config_color('on', $request->variable('dark1_mas_col_on', memberavatarstatus::COL_DEF_ON)));

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'ACP_MAS_LOG_SET_SAV', time(), array($language->lang('ACP_MAS_MODE_GENERAL')));
			trigger_error($language->lang('ACP_MAS_LOG_SET_SAV', $language->lang('ACP_MAS_MODE_GENERAL')) . adm_back_link($this->u_action), E_USER_NOTICE);
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'MAS_EXT_NAME'		=> $ext_name_mas,
			'MAS_EXT_DEV'		=> $ext_by_dark1,
			'MAS_AVATAR'		=> $config['dark1_mas_avatar'],
			'MAS_ONLINE'		=> $config['dark1_mas_online'],
			'MAS_COLOR_OFFLINE'	=> $config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $config['dark1_mas_col_on'],
		));
	}

}
