<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use dark1\memberavatarstatus\core\avatar;

/**
 * Member Avatar & Status Event listener.
 */
class friendlist_listener implements EventSubscriberInterface
{
	/** @var avatar*/
	protected $avatar;

	/**
	 * Constructor for listener
	 *
	 * @param avatar	$avatar		dark1 avatar
	 * @access public
	 */
	public function __construct(avatar $avatar)
	{
		$this->avatar	= $avatar;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.ucp_modify_friends_template_vars'		=> 'mas_ucp_modify_friends_template_vars',
		];
	}



	/**
	 * MAS Friendlist Template Setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function mas_ucp_modify_friends_template_vars($event)
	{
		// Get Event Array `row` , `tpl_ary` & `which`
		$row = $event['row'];
		$tpl_ary = $event['tpl_ary'];
		$which = $event['which'];

		// Set Avatar
		$avatar = $this->avatar->mas_get_avatar('dark1_mas_fl', $row['user_id']);

		// Get Online Status
		$online = ($which === 'online') ? true : false ;

		// Add Avatar & Online Status to tpl_ary
		$tpl_ary = array_merge($tpl_ary, [
			'AVATAR_IMG'	=> $avatar,
			'S_ONLINE'		=> $online,
		]);

		// Assign tpl_ary to event -> tpl_ary
		$event['tpl_ary'] = $tpl_ary;
	}

}
