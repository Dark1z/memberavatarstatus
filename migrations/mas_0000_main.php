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
 * Migration stage 0000 : Main
 */
class mas_0000_main extends migration
{
	public function effectively_installed()
	{
		return isset($this->config['dark1_mas']);
	}

	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			// Config Add
			['config.add', ['dark1_mas', 1]],

			// Module Add
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MAS_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\main_module',
					'modes'				=> ['main'],
				],
			]],
		];
	}
}
