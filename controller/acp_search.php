<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\controller;

/**
 * @ignore
 */
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use dark1\memberavatarstatus\core\avatar;

/**
 * Member Avatar & Status [MAS] ACP controller Search.
 */
class acp_search extends acp_base
{
	/** @var config */
	protected $config;

	/** @var avatar*/
	protected $avatar;

	/**
	 * Constructor.
	 *
	 * @param language		$language	Language object
	 * @param log			$log		Log object
	 * @param request		$request	Request object
	 * @param template		$template	Template object
	 * @param user			$user		User object
	 * @param config		$config		Config object
	 * @param avatar		$avatar		dark1 avatar
	 */
	public function __construct(language $language, log $log, request $request, template $template, user $user, config $config, avatar $avatar)
	{
		parent::__construct($language, $log, $request, $template, $user);

		$this->config	= $config;
		$this->avatar	= $avatar;
	}

	/**
	 * Display the options a user can configure for Search Mode.
	 *
	 * @return void
	 * @access public
	 */
	public function handle()
	{
		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			$this->check_form_on_submit();

			// Set the options the user configured
			$this->config->set('dark1_mas_sh_fp_av', $this->request->variable('dark1_mas_sh_fp_av', 0));
			$this->config->set('dark1_mas_sh_fp_ol', $this->request->variable('dark1_mas_sh_fp_ol', 0));
			$this->config->set('dark1_mas_sh_lp_av', $this->request->variable('dark1_mas_sh_lp_av', 0));
			$this->config->set('dark1_mas_sh_lp_ol', $this->request->variable('dark1_mas_sh_lp_ol', 0));
			$this->config->set('dark1_mas_sh_up_av', $this->request->variable('dark1_mas_sh_up_av', 0));
			$this->config->set('dark1_mas_sh_up_ol', $this->request->variable('dark1_mas_sh_up_ol', 0));
			$this->config->set('dark1_mas_sh_fp_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_sh_fp_av_sz', avatar::AV_DEF_SZ_SML), avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML));
			$this->config->set('dark1_mas_sh_lp_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_sh_lp_av_sz', avatar::AV_DEF_SZ_SML), avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML));
			$this->config->set('dark1_mas_sh_up_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_sh_up_av_sz', avatar::AV_DEF_SZ_SML), avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML));

			$this->success_form_on_submit();
		}

		// Set output variables for display in the template
		$this->template->assign_vars([
			'MAS_COLOR_OFFLINE'	=> $this->config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $this->config['dark1_mas_col_on'],
			'MAS_SH_FP_AVATAR'	=> $this->config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $this->config['dark1_mas_sh_fp_av_sz'],
			'MAS_SH_FP_ONLINE'	=> $this->config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $this->config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $this->config['dark1_mas_sh_lp_av_sz'],
			'MAS_SH_LP_ONLINE'	=> $this->config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $this->config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $this->config['dark1_mas_sh_up_av_sz'],
			'MAS_SH_UP_ONLINE'	=> $this->config['dark1_mas_sh_up_ol'],
			'MAS_NO_AVATAR_IMG'	=> $this->avatar->mas_get_no_avatar_img(),
		]);
	}
}
