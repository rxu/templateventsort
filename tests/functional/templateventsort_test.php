<?php
/**
 *
 * Template event prioritizing extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace rxu\templateventsort\tests\functional;

/**
 * @group functional
 */
class templateventsort_test extends \phpbb_functional_test_case
{
	static private $helper;

	static public function setUpBeforeClass(): void
	{
		global $phpbb_root_path;

		parent::setUpBeforeClass();

		self::$helper = new \phpbb_test_case_helpers(__CLASS__);
		self::$helper->copy_dir(__DIR__ . '/fixtures/ext/', $phpbb_root_path . 'ext/');
	}

	static protected function setup_extensions()
	{
		return ['rxu/templateventsort', 'foo/bar', 'foo/foo'];
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->login();
		$this->admin_login();

		$this->purge_cache();
	}

	/**
	* Check a controller for extension foo/bar.
	*/
	public function test_template_event_order()
	{
		global $phpbb_root_path;

		$crawler = self::request('GET', 'index.php');
		$quick_links_menu = $crawler->filter('ul[role="menu"]')->eq(0);
		$quick_links_menu_nodes = $quick_links_menu->filter('li:not([class])');
		$quick_links_menu_nodes_count = (int) $quick_links_menu_nodes->count();
		// Ensure foo/foo template event goes before foo/bar one
		$this->assertStringContainsString('FOO_FOO_QUICK_LINK', $quick_links_menu_nodes->eq($quick_links_menu_nodes_count - 2)->filter('span')->text());
		$this->assertStringContainsString('FOO_BAR_QUICK_LINK', $quick_links_menu_nodes->eq($quick_links_menu_nodes_count - 1)->filter('span')->text());

		// Change template events order to default, put foo/bar event before foo/foo one
		$this->logout();
		$this->disable_ext('foo/bar');
		$this->disable_ext('foo/foo');

		$this->assertTrue(copy(__DIR__ . '/fixtures/ext/foo/bar/event/template_event_order_higher.php', $phpbb_root_path . 'ext/foo/bar/event/template_event_order.php'));
		$this->assertTrue(copy(__DIR__ . '/fixtures/ext/foo/foo/event/template_event_order_lower.php', $phpbb_root_path . 'ext/foo/foo/event/template_event_order.php'));

		$this->install_ext('foo/bar');
		$this->install_ext('foo/foo');

		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', 'index.php');
		$quick_links_menu = $crawler->filter('ul[role="menu"]')->eq(0);
		$quick_links_menu_nodes = $quick_links_menu->filter('li:not([class])');
		$quick_links_menu_nodes_count = (int) $quick_links_menu_nodes->count();
		// Ensure foo/foo template event goes before foo/bar one
		$this->assertStringContainsString('FOO_BAR_QUICK_LINK', $quick_links_menu_nodes->eq($quick_links_menu_nodes_count - 2)->filter('span')->text());
		$this->assertStringContainsString('FOO_FOO_QUICK_LINK', $quick_links_menu_nodes->eq($quick_links_menu_nodes_count - 1)->filter('span')->text());
	}
}
