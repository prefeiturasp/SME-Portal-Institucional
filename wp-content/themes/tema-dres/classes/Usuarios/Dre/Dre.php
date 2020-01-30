<?php
namespace Classes\Usuarios\Dre;

class Dre
{

	const ROLE = 'dre';
	private $role_object;

	public function __construct(){
		$this->removeRole();
		$this->addRole();
		$this->getRole();
		$this->addCap();
	}

	public function removeRole(){
		remove_role('dre');
	}

	public function addRole(){
		add_role('dre',
			__('Usuário DRE')
		);
	}

	public function getRole(){
		// get the the role object
		if (current_user_can('dre')) {
			$this->role_object = get_role('dre');
		}
	}

	public function addCap(){

		// add $cap capability to this role object
		if (current_user_can('dre')) {
			//$this->role_object->add_cap('edit_theme_options');

			$this->role_object->add_cap( 'read' );
			$this->role_object->add_cap( 'edit_posts' );

			$this->role_object->add_cap( 'read_contatoprincipal');
			$this->role_object->add_cap( 'read_private_contatoprincipals' );
			$this->role_object->add_cap( 'edit_contatoprincipal' );
			$this->role_object->add_cap( 'edit_contatoprincipals' );
			$this->role_object->add_cap( 'edit_others_contatoprincipals' );
			$this->role_object->add_cap( 'edit_published_contatoprincipals' );
			$this->role_object->add_cap( 'publish_contatoprincipals' );
			$this->role_object->add_cap( 'delete_contatoprincipal' );
			$this->role_object->add_cap( 'delete_others_contatoprincipals' );
			$this->role_object->add_cap( 'delete_private_contatoprincipals' );
			$this->role_object->add_cap( 'delete_published_contatoprincipals' );
			$this->role_object->add_cap( 'manage_contatoprincipals' );
			$this->role_object->add_cap( 'edit_contatoprincipals' );
			$this->role_object->add_cap( 'delete_contatoprincipals' );
			$this->role_object->add_cap( 'assign_contatoprincipals' );

			$this->role_object->add_cap( 'read_outroscontatos');
			$this->role_object->add_cap( 'read_private_outroscontatoss' );
			$this->role_object->add_cap( 'edit_outroscontatos' );
			$this->role_object->add_cap( 'edit_outroscontatoss' );
			$this->role_object->add_cap( 'edit_others_outroscontatoss' );
			$this->role_object->add_cap( 'edit_published_outroscontatoss' );
			$this->role_object->add_cap( 'publish_outroscontatoss' );
			$this->role_object->add_cap( 'delete_outroscontatos' );
			$this->role_object->add_cap( 'delete_others_outroscontatoss' );
			$this->role_object->add_cap( 'delete_private_outroscontatoss' );
			$this->role_object->add_cap( 'delete_published_outroscontatoss' );
			$this->role_object->add_cap( 'manage_outroscontatoss' );
			$this->role_object->add_cap( 'edit_outroscontatoss' );
			$this->role_object->add_cap( 'delete_outroscontatoss' );
			$this->role_object->add_cap( 'assign_outroscontatoss' );

			$this->role_object->add_cap( 'read_agenda');
			$this->role_object->add_cap( 'read_private_agendas' );
			$this->role_object->add_cap( 'edit_agenda' );
			$this->role_object->add_cap( 'edit_agendas' );
			$this->role_object->add_cap( 'edit_others_agendas' );
			$this->role_object->add_cap( 'edit_published_agendas' );
			$this->role_object->add_cap( 'publish_agendas' );
			$this->role_object->add_cap( 'delete_agenda' );
			$this->role_object->add_cap( 'delete_others_agendas' );
			$this->role_object->add_cap( 'delete_private_agendas' );
			$this->role_object->add_cap( 'delete_published_agendas' );
			$this->role_object->add_cap( 'manage_agendas' );
			$this->role_object->add_cap( 'edit_agendas' );
			$this->role_object->add_cap( 'delete_agendas' );
			$this->role_object->add_cap( 'assign_agendas' );


			$this->role_object->add_cap('upload_files');
			$this->role_object->add_cap('edit_files');

		}
	}
}

new Dre();