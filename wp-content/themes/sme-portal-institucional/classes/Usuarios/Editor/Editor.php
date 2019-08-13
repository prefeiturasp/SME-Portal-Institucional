<?php

namespace Classes\Usuarios\Editor;


class Editor
{

	const ROLE = 'editor';
	private $role_object;

	public function __construct()
	{
		$this->getRole();
		$this->addCap();
		add_action('admin_menu', array($this, 'escondeMenu' ));
	}

	public function getRole(){
		// get the the role object
		if (current_user_can('editor')) {
			$this->role_object = get_role('editor');
		}
	}

	public function addCap(){

		// add $cap capability to this role object
		if (current_user_can('editor')) {
			$this->role_object->add_cap('edit_theme_options');

			$this->role_object->add_cap( 'read' );
			$this->role_object->add_cap( 'read_card');
			$this->role_object->add_cap( 'read_private_cards' );
			$this->role_object->add_cap( 'edit_card' );
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'edit_others_cards' );
			$this->role_object->add_cap( 'edit_published_cards' );
			$this->role_object->add_cap( 'publish_cards' );
			$this->role_object->add_cap( 'delete_others_cards' );
			$this->role_object->add_cap( 'delete_private_cards' );
			$this->role_object->add_cap( 'delete_published_cards' );

			$this->role_object->add_cap( 'manage_cards' );
			$this->role_object->add_cap( 'assign_cards' );
		}
	}

	public function escondeMenu(){

		$usuario = wp_get_current_user();

		if ($usuario->roles[0] === 'editor') {

			remove_submenu_page( 'themes.php', 'themes.php' ); // hide the theme selection submenu
			remove_submenu_page( 'themes.php', 'widgets.php' ); // hide the widgets submenu
			// Remove Appearance -> Customize
			remove_submenu_page('themes.php', 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI']));
			global $submenu;
			unset($submenu['themes.php'][15]); // header_image
			unset($submenu['themes.php'][20]); // background_image
			remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Ftools.php&#038;autofocus%5Bcontrol%5D=background_image' ); // hide the background submenu

			remove_menu_page( 'wpcf7' );
			remove_menu_page('edit-comments.php');
			remove_menu_page('tools.php');


		}

	}

}

new Editor();