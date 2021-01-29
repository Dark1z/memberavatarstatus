<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
 * @ignore
 */
use phpbb\db\migration\migration;

/**
 * Migration stage 0002 : Viewonline
 */
class mas_0002_viewonline extends migration
{
	static public function depends_on()
	{
		return ['\dark1\memberavatarstatus\migrations\mas_0001_memberlist'];
	}

	public function update_data()
	{
		return [
			// Config Add
			['config.add', ['dark1_mas_vo_pg_av', 0]],
			['config.add', ['dark1_mas_vo_pg_av_sz', 20]],
			['config.add', ['dark1_mas_vo_sb_av', 0]],
			['config.add', ['dark1_mas_vo_sb_av_sz', 20]],

			// Module Add
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewonline_module',
					'modes'				=> ['viewonline'],
				],
			]],
		];
	}
}
