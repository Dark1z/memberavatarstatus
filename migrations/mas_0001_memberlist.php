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
 * Migration stage 0001 : Memberlist
 */
class mas_0001_memberlist extends migration
{
	static public function depends_on()
	{
		return ['\dark1\memberavatarstatus\migrations\mas_0000_main'];
	}

	public function update_data()
	{
		return [
			// Config Add
			['config.add', ['dark1_mas_ml_av', 0]],
			['config.add', ['dark1_mas_ml_ol', 0]],
			['config.add', ['dark1_mas_ml_av_sz', 50]],

			// Module Add
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\memberlist_module',
					'modes'				=> ['memberlist'],
				],
			]],
		];
	}
}
