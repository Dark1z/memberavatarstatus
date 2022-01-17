<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
 * @ignore
 */
use phpbb\db\migration\migration;

/**
 * Migration stage 0007 : Friendlist
 */
class mas_0007_friendlist extends migration
{
	static public function depends_on()
	{
		return ['\dark1\memberavatarstatus\migrations\mas_0006_general'];
	}

	public function update_data()
	{
		return [
			// Remove Config
			['config.remove', ['dark1_mas']],

			// Config Add
			['config.add', ['dark1_mas_fl_av', 0]],
			['config.add', ['dark1_mas_fl_ol', 0]],
			['config.add', ['dark1_mas_fl_av_sz', 20]],

			// Module Add
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\friendlist_module',
					'modes'				=> ['friendlist'],
				],
			]],
		];
	}
}
