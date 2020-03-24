<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
 * @ignore
 */
use phpbb\db\migration\migration;

class mas_0002_viewonline extends migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0001_memberlist');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas_vo_pg_av', 0)),
			array('config.add', array('dark1_mas_vo_pg_av_sz', 20)),
			array('config.add', array('dark1_mas_vo_sb_av', 0)),
			array('config.add', array('dark1_mas_vo_sb_av_sz', 20)),
		);
	}
}
