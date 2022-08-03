<?php

// Modifica a lista de usuários no admin baseado no grupo para usuarios do tipo Editor
function modify_user_list($query){
    $user = wp_get_current_user();

    //if( ! current_user_can( 'edit_user' ) ) return $query;
	if ( !current_user_can( 'manage_options' ) ) {
		$user_id = $user->ID; 
		$user_group = get_user_meta($user_id, 'grupo', true);
		
		$meta_query = array(
			'relation' => 'OR',
		);
		if($user_group){
			foreach($user_group as $group){
				$meta_query[] = array(
					'key' => 'grupo', // name of custom field
					'value' => $group, // matches exaclty "123", not just 123. This prevents a match for "1234"
					'compare' => 'LIKE'
				);
			}
		}
		$query->set( 'meta_query', $meta_query );
	}

}
add_action('pre_get_users', 'modify_user_list');