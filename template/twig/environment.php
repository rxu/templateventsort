<?php
/**
 *
 * Template event prioritizing extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace rxu\templateventsort\template\twig;

class environment extends \phpbb\template\twig\environment
{
	/**
	 * Gets the event dispatcher instance
	 *
	 * @return dispatcher_interface
	 */
	public function get_phpbb_dispatcher()
	{
		return $this->phpbb_dispatcher;
	}
}
