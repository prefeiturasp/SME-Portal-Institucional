<?php

namespace Classes\Usuarios\Colaborador;

class Colaborador
{
	const ROLE = 'contributor';
	private $role_object;

	public function __construct()
	{
		$this->getRole();
		$this->addCap();
	}

	public function getRole(){
		// get the the role object
		if (current_user_can('contributor')) {
			$this->role_object = get_role('contributor');
		}
	}
	public function addCap(){
		// add $cap capability to this role object
		if (current_user_can('contributor') && !current_user_can('upload_files')) {
			$this->role_object->add_cap('upload_files');
		}
	}

}

new Colaborador();

