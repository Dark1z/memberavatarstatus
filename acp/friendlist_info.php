<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\acp;

/**
 * Member Avatar & Status [MAS] ACP module info.
 */
class friendlist_info
{
	public function module()
	{
		return [
			'filename'	=> '\dark1\memberavatarstatus\acp\friendlist_module',
			'title'		=> 'ACP_MAS_TITLE',
			'modes'		=> [
				'friendlist'	=> [
						'title'	=> 'ACP_MAS_MODE_FRIENDLIST',
						'auth'	=> 'ext_dark1/memberavatarstatus && acl_a_board',
						'cat'	=> ['ACP_MAS_TITLE']
				],
			],
		];
	}
}
