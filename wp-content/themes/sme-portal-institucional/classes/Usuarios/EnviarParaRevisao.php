<?php

namespace Classes\Usuarios;


class EnviarParaRevisao
{
	public function __construct()
	{
		$this->page_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
		add_filter('init', array($this, 'reAprovePages'), '99', 2);
		add_filter( 'init', array($this, 'reAproveCards'), '99', 2 );
	}

	function reAproveCards() {
		$status = get_post_status($this->page_id);
		$post_type = get_post_type($this->page_id);

		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;

		if ($roles[0] == 'contributor' && 'card' === $post_type){
			if ($status == "publish"){
				wp_update_post(array(
					'ID'    =>  $this->page_id,
					'post_status'   =>  'pending'
				));
			}
		}
	}


	public function reAprovePages(){

		$status = get_post_status($this->page_id);

		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;

		if ($roles[0] == 'contributor') {
			if ($status == "publish"){
				wp_update_post(array(
					'ID'    =>  $this->page_id,
					'post_status'   =>  'pending'
				));
			}
		}
	}

}

new EnviarParaRevisao();