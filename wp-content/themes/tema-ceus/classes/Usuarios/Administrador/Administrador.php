<?php

namespace Classes\Usuarios\Administrador;


class Administrador
{
	const ROLE = 'administrator';
	private $role_object;

	public function __construct()
	{
		$this->getRole();
		$this->addCap();
		add_action('admin_menu', array($this, 'escondeMenu' ), 999);
	}

	public function getRole(){
		// get the the role object
		if (current_user_can(self::ROLE)) {
			$this->role_object = get_role(self::ROLE);
		}
	}

	public function addCap(){

		// add $cap capability to this role object
		if (current_user_can(self::ROLE)) {
			$this->role_object->add_cap('edit_theme_options');

			$this->role_object->add_cap( 'read' );

			$this->role_object->add_cap( 'read_card');
			$this->role_object->add_cap( 'read_private_cards' );
			$this->role_object->add_cap( 'edit_card' );
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'edit_others_cards' );
			$this->role_object->add_cap( 'edit_published_cards' );
			$this->role_object->add_cap( 'publish_cards' );
			$this->role_object->add_cap( 'delete_card' );
			$this->role_object->add_cap( 'delete_others_cards' );
			$this->role_object->add_cap( 'delete_private_cards' );
			$this->role_object->add_cap( 'delete_published_cards' );
			$this->role_object->add_cap( 'manage_cards' );
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'delete_cards' );
			$this->role_object->add_cap( 'assign_cards' );

			$this->role_object->add_cap( 'read_aba');
			$this->role_object->add_cap( 'read_private_abas' );
			$this->role_object->add_cap( 'edit_aba' );
			$this->role_object->add_cap( 'edit_abas' );
			$this->role_object->add_cap( 'edit_others_abas' );
			$this->role_object->add_cap( 'edit_published_abas' );
			$this->role_object->add_cap( 'publish_abas' );
			$this->role_object->add_cap( 'delete_others_abas' );
			$this->role_object->add_cap( 'delete_private_abas' );
			$this->role_object->add_cap( 'delete_published_abas' );
			$this->role_object->add_cap( 'manage_abas' );
			$this->role_object->add_cap( 'edit_abas' );
			$this->role_object->add_cap( 'delete_abas' );
			$this->role_object->add_cap( 'assign_abas' );

			$this->role_object->add_cap( 'publish_unidades');
			$this->role_object->add_cap( 'edit_unidade');
			$this->role_object->add_cap( 'edit_unidades' );
			$this->role_object->add_cap( 'edit_published_unidades');
			$this->role_object->add_cap( 'read_unidade' );
			$this->role_object->add_cap( 'read_private_unidades');
			$this->role_object->add_cap( 'delete_unidade' );
			$this->role_object->add_cap( 'delete_unidades' );
			$this->role_object->add_cap( 'delete_published_unidades');
			$this->role_object->add_cap( 'delete_others_unidades' );
			$this->role_object->add_cap( 'delete_private_unidades');
			$this->role_object->add_cap( 'edit_others_unidades' );
			$this->role_object->add_cap( 'edit_private_unidades');	

			$this->role_object->add_cap( 'read_contato');
			$this->role_object->add_cap( 'read_private_contatos' );
			$this->role_object->add_cap( 'edit_contato' );
			$this->role_object->add_cap( 'edit_contatos' );
			$this->role_object->add_cap( 'edit_others_contatos' );
			$this->role_object->add_cap( 'edit_published_contatos' );
			$this->role_object->add_cap( 'publish_contatos' );
			$this->role_object->add_cap( 'delete_contato' );
			$this->role_object->add_cap( 'delete_others_contatos' );
			$this->role_object->add_cap( 'delete_private_contatos' );
			$this->role_object->add_cap( 'delete_published_contatos' );
			$this->role_object->add_cap( 'manage_contatos' );
			$this->role_object->add_cap( 'edit_contatos' );
			$this->role_object->add_cap( 'delete_contatos' );
			$this->role_object->add_cap( 'assign_contatos' );

			$this->role_object->add_cap( 'read_botao');
			$this->role_object->add_cap( 'read_private_botoes' );
			$this->role_object->add_cap( 'edit_botao' );
			$this->role_object->add_cap( 'edit_botoes' );
			$this->role_object->add_cap( 'edit_others_botoes' );
			$this->role_object->add_cap( 'edit_published_botoes' );
			$this->role_object->add_cap( 'publish_botoes' );
			$this->role_object->add_cap( 'delete_botao' );
			$this->role_object->add_cap( 'delete_others_botoes' );
			$this->role_object->add_cap( 'delete_private_botoes' );
			$this->role_object->add_cap( 'delete_published_botoes' );
			$this->role_object->add_cap( 'manage_botoes' );
			$this->role_object->add_cap( 'edit_botoes' );
			$this->role_object->add_cap( 'delete_botoes' );
			$this->role_object->add_cap( 'assign_botoes' );

			$this->role_object->add_cap( 'manage_imagens' );
			$this->role_object->add_cap( 'edit_imagens' );
			$this->role_object->add_cap( 'delete_imagens' );
			$this->role_object->add_cap( 'assign_imagens' );
		}
	}

	public function escondeMenu(){

		$usuario = wp_get_current_user();

		if ($usuario->roles[0] === self::ROLE) {

			$menu_completo = get_field('menu_completo', 'user_'. $usuario->data->ID );

			if(!$menu_completo){				

				remove_menu_page( 'plugins.php' ); // Plugins
				remove_menu_page( 'wp-mail-smtp' ); // SMTP
				remove_menu_page('themes.php'); // Aparencias
				remove_menu_page( 'options-general.php' ); // Configuracoes
				remove_menu_page( 'acf-options-busca-manual' ); // Opcoes Gerais
				remove_menu_page('edit.php?post_type=acf-field-group'); // Campos Personalizados
				remove_menu_page('tools.php'); // Ferramentas
				
			}

		}

	}

}

new Administrador();