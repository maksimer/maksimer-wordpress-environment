<?php
/**
 * Plugin Name: Maksimer WordPress Environment
 * Plugin URI: http://www.maksimer.no
 * Description: Maksimer WordPress default settings.
 * Version: 1.0.1
 * Author: Maksimer
 * Author URI: http://www.maksimer.no
 */
if ( defined( 'MAKSIMER_WORDPRESS_ENVIRONMENT' ) ) return;

define( 'MAKSIMER_WORDPRESS_ENVIRONMENT', '1.0.1' );

if ( !defined('ABSPATH') ) die( 'You do not have permissions to access this file.' );

$maksimer_environment = new Maksimer_WordPress_Environment();

class Maksimer_WordPress_Environment {
	
	protected $date_format         = 'd.m.Y';
	protected $time_format         = 'H.i';
	protected $timezone_string     = 'Europe/Oslo';
	protected $start_of_week       = 1;
	protected $permalink_structure = '/%postname%/';


	public function __construct() {
		register_activation_hook( __FILE__, array( &$this,	'plugin_activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'plugin_deactivate' ) );
	}


	protected function change_user_cap() {
		$editor_role = get_role( 'editor' );
		if ( $editor_role ) {
			$editor_role->add_cap( 'edit_theme_options' );
		}
	}


	protected function set_permalinks() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( $this->permalink_structure );
	}


	protected function set_discussion_options() {
		update_option( 'default_comment_status', 'closed' );
		update_option( 'default_ping_status', 'closed' );
		update_option( 'comments_notify', '0' );
		update_option( 'comment_moderation', '1' );
		update_option( 'comment_registration', '1' );
		update_option( 'close_comments_for_old_posts', '2' );
		update_option( 'moderation_notify', '0' );
	}


	protected function set_time_options() {
		update_option( 'timezone_string', $this->timezone_string );
		update_option( 'start_of_week', $this->start_of_week );
		update_option( 'date_format', $this->date_format );
		update_option( 'time_format', $this->time_format );
	}


	public function plugin_activate()	{
		$this->change_user_cap();
		$this->set_time_options();
		$this->set_permalinks();
		$this->set_discussion_options();
		update_option( 'maksimer_wordpress_environment_version', MAKSIMER_WORDPRESS_ENVIRONMENT );
	}


	public function plugin_deactivate()	{

	}
}
