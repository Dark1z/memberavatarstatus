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

/**
 * Member Avatar & Status [MAS] ACP controller Base.
 */
class acp_base
{
	/** @var language */
	protected $language;

	/** @var log */
	protected $log;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var string The module ID */
	protected $id;

	/** @var string The module mode */
	protected $mode;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param language		$language		Language object
	 * @param log			$log			Log object
	 * @param request		$request		Request object
	 * @param template		$template		Template object
	 * @param user			$user			User object
	 */
	public function __construct(language $language, log $log, request $request, template $template, user $user)
	{
		$this->language		= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
	}

	/**
	 * Set Data form.
	 *
	 * @param int		$id			The module ID
	 * @param string	$mode		The module mode
	 * @param string	$u_action	Custom form action
	 *
	 * @return void
	 * @access public
	 */
	public function set_data($id, $mode, $u_action)
	{
		$this->id = $id;
		$this->mode = $mode;
		$this->u_action = $u_action;
	}

	/**
	 * Get Data form.
	 *
	 * @return array Having keys 'tpl_name' & 'page_title'
	 * @access public
	 */
	public function get_data()
	{
		return [
			'tpl_name' => 'acp_mas_' . $this->mode,
			'page_title' => $this->language->lang('ACP_MAS_TITLE') . ' - ' . $this->language->lang('ACP_MAS_MODE_' . strtoupper($this->mode)),
		];
	}

	/**
	 * Set Display form.
	 *
	 * @return void
	 * @access public
	 */
	public function setup()
	{
		$ext_name_mas = 'Member Avatar & Status [MAS]';
		$ext_by_dark1 = 'Dark❶ [dark1]';

		// Add our common language file
		$this->language->add_lang('lang_acp_mas', 'dark1/memberavatarstatus');
		$this->language->add_lang('lang_mas', 'dark1/memberavatarstatus');

		// Create a form key for preventing CSRF attacks
		add_form_key('acp_mas_' . $this->mode);

		// Set u_action in the template
		$this->template->assign_vars([
			'U_ACTION'		=> $this->u_action,
			'MAS_EXT_MODE'	=> $this->language->lang('ACP_MAS_MODE_' . strtoupper($this->mode)),
			'MAS_EXT_NAME'	=> $ext_name_mas,
			'MAS_EXT_DEV'	=> $ext_by_dark1,
		]);
	}

	/**
	 * Check Form On Submit .
	 *
	 * @return void
	 * @access protected
	 */
	protected function check_form_on_submit()
	{
		// Test if the submitted form is valid
		if (!check_form_key('acp_mas_' . $this->mode))
		{
			trigger_error('FORM_INVALID', E_USER_WARNING);
		}
	}

	/**
	 * Success Form On Submit.
	 * Used to Log & Trigger Success Err0r.
	 *
	 * @return void
	 * @access protected
	 */
	protected function success_form_on_submit()
	{
		// Add option settings change action to the admin log
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MAS_LOG_SET_SAV', time(), [$this->language->lang('ACP_MAS_MODE_' . strtoupper($this->mode))]);

		// Option settings have been updated and logged
		// Confirm this to the user and provide link back to previous page
		trigger_error($this->language->lang('ACP_MAS_LOG_SET_SAV', $this->language->lang('ACP_MAS_MODE_' . strtoupper($this->mode))) . adm_back_link($this->u_action), E_USER_NOTICE);
	}
}
