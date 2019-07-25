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
				'edit_files',
				'edit_others_posts',
				'edit_published_posts',
				'edit_private_posts',
				'manage_options',
				'edit_pages',
				'edit_published_pages',
				'edit_others_pages',
				'edit_private_pages',
				'delete_others_pages',
				'delete_private_pages',
				'delete_published_pages',
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
			$this->role_object->add_cap('upload_files');
			$this->role_object->add_cap('edit_files');

			//$this->role_object->add_cap('edit_others_posts');
			//$this->role_object->add_cap('edit_private_posts');
			//$this->role_object->add_cap('edit_published_posts');
			//$this->role_object->add_cap('edit_posts');
			//$this->role_object->add_cap('publish_posts');
			//$this->role_object->add_cap('read_private_posts');
			//$this->role_object->add_cap('delete_posts');

			$this->role_object->add_cap('edit_pages');
			$this->role_object->add_cap('delete_pages');


			$this->role_object->add_cap('delete_published_pages');
			$this->role_object->add_cap('edit_published_pages');
			//$this->role_object->add_cap('edit_private_pages');

			$this->role_object->add_cap( 'read_card');
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'delete_cards' );

			$this->role_object->add_cap( 'manage_cards' );
			$this->role_object->add_cap( 'assign_cards' );

			$this->role_object->add_cap( 'edit_published_cards' );
			$this->role_object->add_cap( 'delete_published_card' );


		}
	}

}

new Colaborador();