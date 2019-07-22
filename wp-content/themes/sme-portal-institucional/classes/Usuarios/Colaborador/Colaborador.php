<?php

namespace Classes\Usuarios\Colaborador;

class Colaborador
{
	const ROLE = 'contributor';
	private $role_object;

	public function __construct()
	{
		$this->getRole();
		$this->removeCap();
		$this->addCap();
	}

	public function getRole(){
		// get the the role object
		if (current_user_can('contributor')) {
			$this->role_object = get_role('contributor');
		}
	}

	public function removeCap(){

		if (current_user_can('contributor')) {
			$caps = array(
				'upload_files',
				'edit_pages',
				'manage_links',
				'delete_pages',
				'delete_posts',
				'delete_published_posts',
				'edit_posts',
				'edit_published_posts',
				'publish_posts',
				'read_card',
				'edit_cards',
				'delete_cards',
				'delete_card',
				'manage_cards',
				'assign_cards',
			);

			foreach ($caps as $cap){
				$this->role_object->remove_cap($cap);
			}

		}

	}

	public function addCap(){
		// add $cap capability to this role object
		if (current_user_can('contributor')) {
			$this->role_object->add_cap('edit_pages');
			$this->role_object->add_cap('delete_pages');
			$this->role_object->add_cap('upload_files');

			$this->role_object->add_cap( 'read_card');
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'delete_cards' );

			$this->role_object->add_cap( 'manage_cards' );
			$this->role_object->add_cap( 'assign_cards' );

		}
	}

}

new Colaborador();

