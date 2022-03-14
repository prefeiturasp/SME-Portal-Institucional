<?php

/**
 * @link              https://www.linkedin.com/company/plainsurf/
 * @since             1.0
 * @package           PS User Login Count
 *
 * Plugin Name:       PS User Login Count
 * Description:       PS User Login Count plugin will help us to count the number of times the users logged into their WordPress account. Also it will display a user’s last login date & time.
 * Version:           2.3
 * Author:            PlainSurf Solutions
 * Author URI:        https://www.linkedin.com/company/plainsurf/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


namespace Plainsurf\WordPressPlugin;

class WP_User_Login_Count {

	public function init() {
		add_action( 'wp_login', array( $this, 'wp_count_user_login' ), 10, 2 );
		add_action( 'wp_login', array( $this, 'wp_last_time_login' ), 10, 2 );
		add_filter( 'manage_users_columns', array( $this, 'add_login_count_columns' ) );
		add_filter( 'manage_users_columns', array( $this, 'add_last_login_columns' ) );
		add_filter( 'manage_users_custom_column', array( $this, 'fill_login_count_columns' ), 10, 3 );
		add_filter( 'manage_users_custom_column', array( $this, 'fill_login_time_columns' ), 10, 3 );
		add_filter( 'manage_users_sortable_columns', array( $this, 'sortable_last_login_column' ), 10, 3 );
		add_action( 'pre_get_users', array( $this, 'sort_last_login_column' ), 10, 3 );
		add_filter( 'manage_users_sortable_columns', array( $this, 'sortable_login_count_column' ), 10, 3 );
		add_action( 'pre_get_users', array( $this, 'sort_login_count_column' ), 10, 3 );
	}


	/**
	 * Save user login count to Database.
	 *
	 * @param string $user_login username
	 * @param object $user WP_User object
	 */
	public function wp_count_user_login( $user_login, $user ) {

		$count = get_user_meta( $user->ID, 'wp_login_count', true );
		if ( ! empty( $count ) ) {
			$login_count = get_user_meta( $user->ID, 'wp_login_count', true );
			update_user_meta( $user->ID, 'wp_login_count', ( (int) $login_count + 1 ) );
		}
		else {
			update_user_meta( $user->ID, 'wp_login_count', 1 );
		}
	}
	public function wp_last_time_login( $user_login, $user ) {

			update_user_meta( $user->ID, 'wp_last_login', time() );
	}


	/**
	 * Add the login stat column to WordPress user listing
	 *
	 * @param string $columns
	 *
	 * @return mixed
	 */
	public function add_login_count_columns( $columns ) {
		$columns['login_count'] = __( 'Contador de Login' );

		return $columns;
	}
	public function add_last_login_columns( $columns ) {
		$columns['last_login'] = __( 'Last Login' );

		return $columns;
	}


	/**
	 * Fill the stat column with values.
	 *
	 * @param string $empty
	 * @param string $column_name
	 * @param int $user_id
	 *
	 * @return string|void
	 */
	public function fill_login_count_columns( $empty, $column_name, $user_id ) {

		if ( 'login_count' == $column_name ) {
			
			if ( get_user_meta( $user_id, 'wp_login_count', true ) !== '' ) {
				$login_count = get_user_meta( $user_id, 'wp_login_count', true );

				return "<strong>$login_count</strong>";
			}
			else {
				return __( 'No login record found.' );
			}
		}

		//return $empty;
	}
	public function fill_login_time_columns( $empty, $column_name, $user_id ) {

		if ( 'last_login' == $column_name ) {
			if ( get_user_meta( $user_id, 'wp_last_login', true ) !== '' ) {
			    //$the_login_date = human_time_diff($last_login);
				$last_login = get_user_meta( $user_id, 'wp_last_login', true );
				$the_login_date = date('M j, Y h:i a', $last_login);


				return "<strong>$the_login_date</strong>";
			}
			else {
				return __( 'No Record' );
			}
		}

		return $empty;
	}
	//Allow the last login columns to be sortable

	public function sortable_last_login_column( $columns ) {
	return wp_parse_args( array(
	 	'last_login' => 'last_login'
	), $columns );
 
	}
	//Allow the login count columns to be sortable

	public function sortable_login_count_column( $columns ) {
	return wp_parse_args( array(
	 	'login_count' => 'login_count'
	), $columns );
 
	}

	public function sort_last_login_column( $query ) {
	if( !is_admin() ) {
		return $query;
	}
 
	$screen = get_current_screen();
 
	if( isset( $screen->id ) && $screen->id !== 'users' ) {
		return $query;
	}
 
	if( isset( $_GET[ 'orderby' ] ) && $_GET[ 'orderby' ] == 'wp_last_login' ) {
 
		$query->query_vars['meta_key'] = 'wp_last_login';
		$query->query_vars['orderby'] = 'meta_value';
 
		}
 
	  return $query;
	}

	public function sort_login_count_column( $query ) {
	if( !is_admin() ) {
		return $query;
	}
 
	$screen = get_current_screen();
 
	if( isset( $screen->id ) && $screen->id !== 'users' ) {
		return $query;
	}
 
	if( isset( $_GET[ 'orderby' ] ) && $_GET[ 'orderby' ] == 'login_count' ) {
 
		$query->query_vars['meta_key'] = 'wp_login_count';
		$query->query_vars['orderby'] = 'meta_value';
 
		}
 
	  return $query;
	}


	/**
	 * Singleton class instance
	 * @return WP_User_Login_Count
	 */
	public static function get_instance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new self();
			$instance->init();
		}

		return $instance;
	}
}

WP_User_Login_Count::get_instance();