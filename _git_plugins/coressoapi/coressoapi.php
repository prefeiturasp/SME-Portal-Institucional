<?php
/**
* Plugin Name: CoreSSO Integração API
* Plugin URI: https://amcom.com.br/
* Description: Integração do Login do WordPress com o CoreSSO.
* Version: 1.2
* Author: AMcom
* Author URI: https://amcom.com.br/
**/

// Substituir a autenticacao do WordPress
add_filter( 'authenticate', 'demo_auth', 10, 3 );

function demo_auth( $user, $username, $password ){
    // Verifica se o usuario e senha foram preenchidos
    if($username == '' || $password == '') return;

    // URL da API
    $api_url = '';

    // Conversao do body para JSON
    $body = wp_json_encode( array(
        "login" => $username,
        "senha" => $password,
    ) );

    $response = wp_remote_post( $api_url ,
            array(
                'headers' => array( 
                    'x-api-eol-key' => '', // Chave da API
                    'Content-Type'=> 'application/json-patch+json'
                ),
                'body' => $body, // Body da requisicao
            ));

    $user = json_decode($response['body']);

    

    if( $response['response']['code']  != 200 ) {
        // Caso nao encontre o usuario retorna o erro na pagina
        $user = new WP_Error( 'denied', __("ERRO: Usuário/senha incorretos") );

    } else if( $response['response']['code'] == 200 ) {
        //echo $user->codigoRf;
        
        // Verifica se tem o codigo RF e busca os dados do usuario
        if($user->codigoRf){
            
            $rf = $user->codigoRf;
            
            $countRf = strlen($rf);

            if($countRf == 20){
                $usuario = $rf;
                $api_url = '';
                $response = wp_remote_post( $api_url, array(
                    'method'      => 'POST',                    
                    'headers' => array( 
                        'x-api-eol-key' => '',
                        'Content-Type' => 'application/json-patch+json'
                    ),
                    'body' => '['.$rf.']',
                    )
                );
                
                if ( is_wp_error( $response ) ) {
                    //$error_message = $response->get_error_message();
                    //echo "Something went wrong: $error_message";
                } else {
                    $user = json_decode($response['body']);                     
                }
                
                if(!$user){
                    echo $rf;
                    $api_url = '';
                    $response = wp_remote_get( $api_url ,
                        array( 
                            'headers' => array( 
                                'x-api-eol-key' => '',							
                            )
                        )
                    );

                    $user = json_decode($response['body']);
                }

            } else {
                $api_url = '';
                $response = wp_remote_get( $api_url ,
                    array( 
                        'headers' => array( 
                            'x-api-eol-key' => '',							
                        )
                    )
                );

                $user = json_decode($response['body']); 
            }
                       
        }        

        if($user->email){
            $email = $user->email;
        } elseif(is_array($user)) {
            $email = $user[0]->email;
        } else {
            $email = $rf . "@sme.prefeitura.sp.gov.br";
        }        
        
        
        // Verifica se o usuario ja esta cadastrado no WordPress
        $userobj = new WP_User();
        $user_wp = $userobj->get_data_by( 'email', $email ); // Does not return a WP_User object :(
        $user_wp = new WP_User($user_wp->ID); // Attempt to load up the user with that ID

        // Se nao estiver cadastrado faz a criacao do usuario
        if( $user_wp->ID == 0 ) {
             
            // Caso nao queira adicionar o usuario no WordPress
            // descomente a linha abaixo
            //$user_wp = new WP_Error( 'denied', __("ERROR: Not a valid user for this system") );

            // Recebe o nome completo do usuario            
            $name = $user->nome;            

            if($user->codigo){
                $codigo = $user->codigo;
            } elseif(is_array($user)) {
                $codigo = $user[0]->codigo;
            }

            if($user->email){
                $email = $user->email;
            } elseif(is_array($user)) {
                $email = $user[0]->email;
            } else {
                $email = $rf . "@sme.prefeitura.sp.gov.br";
            }

            if($user->nome){
                $nome = $user->nome;
            } elseif(is_array($user)) {
                $nome = $user[0]->nome;
            }

            if($codigo){

                $userdata = array( 'user_email' => $email,
                                    'user_login' => $email,
                                    'first_name' => $nome,                            
                                );
                $new_user_id = wp_insert_user( $userdata ); // Um novo usuario sera criado
                update_user_meta($new_user_id, "rf", $codigo);
                update_user_meta($new_user_id, "parceira", 1);

            } else {
                // Recebe o CPF
                $cpf = $user->cpf;

                // Divide o nome em Nome e Sobrenome
                $parts = explode(" ", $name);
                if(count($parts) > 1) {
                    $firstname = array_shift($parts);
                    $lastname = implode(" ", $parts);
                } else {
                    $firstname = $name;
                    $lastname = " ";
                }

                $userdata = array( 'user_email' =>$email,
                                    'user_login' =>$email,
                                    'first_name' => $firstname,
                                    'last_name' => $lastname,                                
                                );
                $new_user_id = wp_insert_user( $userdata ); // Um novo usuario sera criado
                update_user_meta($new_user_id, "rf", $username);
                if(strlen($username) != 6){
                    update_user_meta($new_user_id, "cpf", $cpf);
                }
                
                if(strlen($username) == 11 || strlen($username) == 6){
                    update_user_meta($new_user_id, "parceira", 1);
                }
            }

            
            
            // Carregar as novas informações do usuário
            $user_wp = new WP_User ($new_user_id);
            
        } 

    }

    // Comente esta linha se você deseja recorrer a autenticacao do WordPress
    // Util para momentos em que o servico externo esta offline
    remove_action( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
    remove_action( 'authenticate', 'wp_authenticate_email_password', 20, 3 );

    return $user_wp;
}

#########################################################################################
// Criacao do shortcode de login
//function intranet_add_login_shortcode() {
	//add_shortcode( 'intranet-login-form', 'intranet_login_form_shortcode' );
//}

// funcao callbacl do shortcode
function intranet_login_form_shortcode() {
	
	// Se ja estiver conectado
    if (is_user_logged_in() && !is_admin()):
        echo "<h2>Você já está conectado!</h2>";
    else:
    // Inclui o formulario de login
    ?>
    	<div class='wp_login_form'>
			<?php
                // Mensagem de erro exibida na tela
				$page_showing = basename($_SERVER['REQUEST_URI']);

				if (strpos($page_showing, 'failed') !== false) {
					echo '<p class="error-msg"><strong>ERRO:</strong> Usuário e/ou senha inválidos.</p>';
				} elseif (strpos($page_showing, 'blank') !== false ) {
					echo '<p class="error-msg"><strong>ERRO:</strong> Usuário e/ou senha estão vazios.</p>';
				}
			
                $args = array(
                'redirect' => home_url(), // Apos login redireciona para a home
                'id_username' => 'user', // ID no input de usuario
                'id_password' => 'pass', // ID no input da senha
                );
				
                wp_login_form( $args ); // Inclui o formulario de login
                
            ?>

		</div>
<?php
    endif;
}

// Carrega a funcao do shortcode
//add_action( 'init', 'intranet_add_login_shortcode' );


#####################################################################################

// Direcionar o usuario da pagina de login do WordPress para uma pagina de login customizada
function goto_login_page() {
	global $page_id;
	$login_page = home_url();
	$page = basename($_SERVER['REQUEST_URI']);

	if( $page == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		wp_redirect($login_page);
		exit;
	}
}
// Funcao desabilitada no momento, para habilitar descomente a linha abaixo
//add_action('init','goto_login_page');

// Se nao autenticar o usuario redireciona para o login novamente
// icluindo o parametro GET na URL
function login_failed() {
	global $page_id;
	$login_page = home_url();
	wp_redirect( $login_page . '?login=failed' );
	exit;
}
// Verifica se nao esta na pagina de login do WordPress
if( $pagenow == 'wp-login.php' && isset($_POST['login_page']) ){
	add_action( 'wp_login_failed', 'login_failed' );
}

// Se usuario/senha estiver vazio redireciona para o login novamente
// icluindo o parametro GET na URL
function blank_username_password( $user, $username, $password ) {
	global $page_id;
	$login_page = home_url();
	if( $username == "" || $password == "" ) {
		wp_redirect( $login_page . "?login=blank" );
		exit;
	}
}
// Verifica se nao esta na pagina de login do WordPress
if( $pagenow == 'wp-login.php' && isset($_POST['login_page']) ){
	add_filter( 'authenticate', 'blank_username_password', 1, 3);
}

// Se for acionado a funcao de Logout (sair) redireciona o usuario para a pagina de login
function logout_page() {
	global $page_id;
	$login_page = home_url();
	wp_redirect( $login_page . "?login=false" );
	exit;
}
add_action('wp_logout', 'logout_page');

// Inclui um input oculto no formulario de login personalizado
// Para que seja validado o usuario via API e nao pelo WordPress
add_filter('login_form_middle','my_added_login_field');
function my_added_login_field(){
     //Output your HTML
     $additional_field = '<div class="login-custom-field-wrapper"">
        <input type="hidden" value="1" name="login_page"></label>
     </div>';

     return $additional_field;
}

// Verifica se esta na pagina de Login do WordPress
// para validar o usuario pelo WordPress e NAO pela API
add_action( 'login_init', 'wpse8170_login_init' );
function wpse8170_login_init() {
	global $pagenow;
	if( $pagenow == 'wp-login.php' && !isset($_POST['login_page']) ){
		remove_filter( 'authenticate', 'demo_auth' );
		remove_filter( 'authenticate', 'blank_username_password');
	}    
}