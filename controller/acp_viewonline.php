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
use dark1\memberavatarstatus\core\avatar;

/**
 * Member Avatar & Status [MAS] ACP controller Viewonline.
 */
class acp_viewonline extends acp_base
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
	 * Display the options a user can configure for Viewonline Mode.
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
			$this->config->set('dark1_mas_vo_pg_av', $this->request->variable('dark1_mas_vo_pg_av', 0));
			$this->config->set('dark1_mas_vo_sb_av', $this->request->variable('dark1_mas_vo_sb_av', 0));
			$this->config->set('dark1_mas_vo_pg_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_vo_pg_av_sz', avatar::AV_DEF_SZ_SML), avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML));
			$this->config->set('dark1_mas_vo_sb_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_vo_sb_av_sz', avatar::AV_DEF_SZ_SML), avatar::AV_DEF_SZ_SML, avatar::AV_MAX_SZ_SML));

			$this->success_form_on_submit();
		}

		// Set output variables for display in the template
		$this->template->assign_vars([
			'MAS_VO_PG_AVATAR'	=> $this->config['dark1_mas_vo_pg_av'],
			'MAS_VO_PG_AV_SIZE'	=> $this->config['dark1_mas_vo_pg_av_sz'],
			'MAS_VO_SB_AVATAR'	=> $this->config['dark1_mas_vo_sb_av'],
			'MAS_VO_SB_AV_SIZE'	=> $this->config['dark1_mas_vo_sb_av_sz'],
			'MAS_NO_AVATAR_IMG'	=> $this->avatar->mas_get_no_avatar_img(),
		]);
	}
}
