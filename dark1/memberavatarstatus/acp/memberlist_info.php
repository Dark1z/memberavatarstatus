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
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Member Avatar & Status ACP module info.
 */
class memberlist_info
{
	public function module()
	{
		return array(
			'filename'	=> '\dark1\memberavatarstatus\acp\memberlist_module',
			'title'		=> 'ACP_MAS_TITLE',
			'modes'		=> array(
				'memberlist'=> array(
						'title'	=> 'ACP_MAS_MODE_MEMBERLIST',
						'auth'	=> 'ext_dark1/memberavatarstatus && acl_a_board',
						'cat'	=> array('ACP_MAS_TITLE')
					),
			),
		);
	}
}
