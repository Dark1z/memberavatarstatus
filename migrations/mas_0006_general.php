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
 * Migration stage 0006 : General
 */
class mas_0006_general extends migration
{
	static public function depends_on()
	{
		return ['\dark1\memberavatarstatus\migrations\mas_0005_review'];
	}

	public function update_data()
	{
		return [
			// Config Add
			['config.add', ['dark1_mas_avatar', 0]],
			['config.add', ['dark1_mas_online', 0]],
			['config.add', ['dark1_mas_col_off', '000000']],
			['config.add', ['dark1_mas_col_on', '00FF00']],

			// Module Remove
			['module.remove', ['acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_REVIEW']],
			['module.remove', ['acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_SEARCH']],
			['module.remove', ['acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWFORUM']],
			['module.remove', ['acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_VIEWONLINE']],
			['module.remove', ['acp', 'ACP_MAS_TITLE', 'ACP_MAS_MODE_MEMBERLIST']],

			// Module Add
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\general_module',
					'modes'				=> ['general'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\memberlist_module',
					'modes'				=> ['memberlist'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewonline_module',
					'modes'				=> ['viewonline'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewforum_module',
					'modes'				=> ['viewforum'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\search_module',
					'modes'				=> ['search'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_MAS_TITLE',
				[
					'module_basename'	=> '\dark1\memberavatarstatus\acp\review_module',
					'modes'				=> ['review'],
				],
			]],
		];
	}
}
