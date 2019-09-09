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

/**
 * Member Avatar & Status ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\dark1\memberavatarstatus\acp\main_module',
			'title'		=> 'ACP_MAS_TITLE',
			'modes'		=> array(
				'main'	=> array(
						'title'	=> 'ACP_MAS_MODE_MAIN',
						'auth'	=> 'ext_dark1/memberavatarstatus && acl_a_board',
						'cat'	=> array('ACP_MAS_TITLE')
				),
			),
		);
	}
}
