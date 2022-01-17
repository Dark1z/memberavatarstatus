<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
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

/**
 * Member Avatar & Status [MAS] ACP controller Main.
 */
class acp_main extends acp_base
{
	/** @var config */
	protected $config;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string phpBB adm relative path */
	protected $phpbb_adm_relative_path;

	/** @var string phpBB php ext */
	protected $php_ext;

	/**
	 * Constructor.
	 *
	 * @param language		$language					Language object
	 * @param log			$log						Log object
	 * @param request		$request					Request object
	 * @param template		$template					Template object
	 * @param user			$user						User object
	 * @param config		$config						Config object
	 * @param string		$phpbb_root_path			phpBB root path
	 * @param string		$phpbb_adm_relative_path	phpBB adm relative path
	 * @param string		$php_ext					phpBB php ext
	 */
	public function __construct(language $language, log $log, request $request, template $template, user $user, config $config, $phpbb_root_path, $phpbb_adm_relative_path, $php_ext)
	{
		parent::__construct($language, $log, $request, $template, $user);

		$this->config					= $config;
		$this->phpbb_root_path			= $phpbb_root_path;
		$this->phpbb_adm_relative_path	= $phpbb_adm_relative_path;
		$this->php_ext					= $php_ext;
	}

	/**
	 * Display the options a user can configure for Main Mode.
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

			$this->success_form_on_submit();
		}

		$acp_board = append_sid($this->phpbb_root_path . $this->phpbb_adm_relative_path . 'index.' . $this->php_ext, 'i=acp_board');

		// Set output variables for display in the template
		$this->template->assign_vars([
			'MAS_PHPBB_LK_AV'	=> $acp_board.'&amp;mode=avatar#allow_avatar',
			'MAS_PHPBB_LK_OL'	=> $acp_board.'&amp;mode=load#load_onlinetrack',
			'MAS_PHPBB_AVATAR'	=> $this->config['allow_avatar'],
			'MAS_PHPBB_ONLINE'	=> $this->config['load_onlinetrack'],
			// General
			'MAS_AVATAR'		=> $this->config['dark1_mas_avatar'],
			'MAS_ONLINE'		=> $this->config['dark1_mas_online'],
			'MAS_COLOR_OFFLINE'	=> $this->config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $this->config['dark1_mas_col_on'],
			// MemberList
			'MAS_ML_AVATAR'		=> $this->config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $this->config['dark1_mas_ml_av_sz'],
			'MAS_ML_ONLINE'		=> $this->config['dark1_mas_ml_ol'],
			// ViewOnline
			'MAS_VO_PG_AVATAR'	=> $this->config['dark1_mas_vo_pg_av'],
			'MAS_VO_PG_AV_SIZE'	=> $this->config['dark1_mas_vo_pg_av_sz'],
			'MAS_VO_SB_AVATAR'	=> $this->config['dark1_mas_vo_sb_av'],
			'MAS_VO_SB_AV_SIZE'	=> $this->config['dark1_mas_vo_sb_av_sz'],
			// ViewForum
			'MAS_VF_FP_AVATAR'	=> $this->config['dark1_mas_vf_fp_av'],
			'MAS_VF_FP_AV_SIZE'	=> $this->config['dark1_mas_vf_fp_av_sz'],
			'MAS_VF_FP_ONLINE'	=> $this->config['dark1_mas_vf_fp_ol'],
			'MAS_VF_LP_AVATAR'	=> $this->config['dark1_mas_vf_lp_av'],
			'MAS_VF_LP_AV_SIZE'	=> $this->config['dark1_mas_vf_lp_av_sz'],
			'MAS_VF_LP_ONLINE'	=> $this->config['dark1_mas_vf_lp_ol'],
			// Search
			'MAS_SH_FP_AVATAR'	=> $this->config['dark1_mas_sh_fp_av'],
			'MAS_SH_FP_AV_SIZE'	=> $this->config['dark1_mas_sh_fp_av_sz'],
			'MAS_SH_FP_ONLINE'	=> $this->config['dark1_mas_sh_fp_ol'],
			'MAS_SH_LP_AVATAR'	=> $this->config['dark1_mas_sh_lp_av'],
			'MAS_SH_LP_AV_SIZE'	=> $this->config['dark1_mas_sh_lp_av_sz'],
			'MAS_SH_LP_ONLINE'	=> $this->config['dark1_mas_sh_lp_ol'],
			'MAS_SH_UP_AVATAR'	=> $this->config['dark1_mas_sh_up_av'],
			'MAS_SH_UP_AV_SIZE'	=> $this->config['dark1_mas_sh_up_av_sz'],
			'MAS_SH_UP_ONLINE'	=> $this->config['dark1_mas_sh_up_ol'],
			// Review
			'MAS_RV_AVATAR'		=> $this->config['dark1_mas_rv_av'],
			'MAS_RV_AV_SIZE'	=> $this->config['dark1_mas_rv_av_sz'],
			'MAS_RV_ONLINE'		=> $this->config['dark1_mas_rv_ol'],
			// Friendlist
			'MAS_FL_AVATAR'		=> $this->config['dark1_mas_fl_av'],
			'MAS_FL_AV_SIZE'	=> $this->config['dark1_mas_fl_av_sz'],
			'MAS_FL_ONLINE'		=> $this->config['dark1_mas_fl_ol'],
		]);
	}
}
