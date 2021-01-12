<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
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
 * Member Avatar & Status [MAS] ACP controller Memberlist.
 */
class acp_memberlist extends acp_base
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \dark1\memberavatarstatus\core\avatar*/
	protected $avatar;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\language\language					$language	Language object
	 * @param \phpbb\log\log							$log		Log object
	 * @param \phpbb\request\request					$request	Request object
	 * @param \phpbb\template\template					$template	Template object
	 * @param \phpbb\user								$user		User object
	 * @param \phpbb\config\config						$config		Config object
	 * @param \dark1\memberavatarstatus\core\avatar		$avatar		dark1 avatar
	 */
	public function __construct(language $language, log $log, request $request, template $template, user $user, config $config, avatar $avatar)
	{
		parent::__construct($language, $log, $request, $template, $user);

		$this->config	= $config;
		$this->avatar	= $avatar;
	}

	/**
	 * Display the options a user can configure for Memberlist Mode.
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
			$this->config->set('dark1_mas_ml_av', $this->request->variable('dark1_mas_ml_av', 0));
			$this->config->set('dark1_mas_ml_ol', $this->request->variable('dark1_mas_ml_ol', 0));
			$this->config->set('dark1_mas_ml_av_sz', $this->avatar->mas_get_avatar_size($this->request->variable('dark1_mas_ml_av_sz', avatar::AV_DEF_SZ_BIG), avatar::AV_DEF_SZ_BIG, avatar::AV_MAX_SZ_BIG));

			$this->success_form_on_submit();
		}

		// Set output variables for display in the template
		$this->template->assign_vars([
			'MAS_COLOR_OFFLINE'	=> $this->config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $this->config['dark1_mas_col_on'],
			'MAS_ML_AVATAR'		=> $this->config['dark1_mas_ml_av'],
			'MAS_ML_AV_SIZE'	=> $this->config['dark1_mas_ml_av_sz'],
			'MAS_ML_ONLINE'		=> $this->config['dark1_mas_ml_ol'],
			'MAS_NO_AVATAR_IMG'	=> $this->avatar->mas_get_no_avatar_img(),
		]);
	}
}
