<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus;

/**
 * @ignore
 */
use phpbb\extension\base;

/**
 * Member Avatar & Status Extension base
 */
class ext extends base
{
	/** string Require phpBB v3.2.10 due to events. */
	const PHPBB_MIN_3_2_X = '3.2.10';

	/** string Require phpBB v3.3.1 due to events. */
	const PHPBB_MIN_3_3_X = '3.3.1';

	/**
	 * {@inheritdoc}
	 */
	public function is_enableable()
	{
		return $this->pbpbb_ver_chk();
	}

	/**
	 * phpBB Version Check.
	 *
	 * @return bool
	 */
	private function pbpbb_ver_chk()
	{
		$config = $this->container->get('config');

		$phpbb_version = phpbb_version_compare(PHPBB_VERSION, $config['version'], '>=') ? PHPBB_VERSION : $config['version'] ;
		list($v1, $v2) = explode('.', $phpbb_version);
		$phpbb_min_version = 'self::PHPBB_MIN_' . $v1 . '_' . $v2 . '_X';

		return defined($phpbb_min_version) ? phpbb_version_compare($phpbb_version, constant($phpbb_min_version), '>=') : false ;
	}
}
