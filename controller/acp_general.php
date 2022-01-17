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
use dark1\memberavatarstatus\core\status;

/**
 * Member Avatar & Status [MAS] ACP controller General.
 */
class acp_general extends acp_base
{
	/** @var config */
	protected $config;

	/** @var status*/
	protected $status;

	/**
	 * Constructor.
	 *
	 * @param language		$language	Language object
	 * @param log			$log		Log object
	 * @param request		$request	Request object
	 * @param template		$template	Template object
	 * @param user			$user		User object
	 * @param config		$config		Config object
	 * @param status		$status		dark1 status
	 */
	public function __construct(language $language, log $log, request $request, template $template, user $user, config $config, status $status)
	{
		parent::__construct($language, $log, $request, $template, $user);

		$this->config	= $config;
		$this->status	= $status;
	}

	/**
	 * Display the options a user can configure for General Mode.
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
			$this->config->set('dark1_mas_avatar', $this->request->variable('dark1_mas_avatar', 0));
			$this->config->set('dark1_mas_online', $this->request->variable('dark1_mas_online', 0));
			$this->config->set('dark1_mas_col_off', $this->status->mas_config_color('off', $this->request->variable('dark1_mas_col_off', status::COL_DEF_OFF)));
			$this->config->set('dark1_mas_col_on', $this->status->mas_config_color('on', $this->request->variable('dark1_mas_col_on', status::COL_DEF_ON)));

			$this->success_form_on_submit();
		}

		// Set output variables for display in the template
		$this->template->assign_vars([
			'MAS_AVATAR'		=> $this->config['dark1_mas_avatar'],
			'MAS_ONLINE'		=> $this->config['dark1_mas_online'],
			'MAS_COLOR_OFFLINE'	=> $this->config['dark1_mas_col_off'],
			'MAS_COLOR_ONLINE'	=> $this->config['dark1_mas_col_on'],
		]);
	}
}
