<?php
/**
* Plugin Name: CoreSSO Integração API - Visitas
* Plugin URI: https://amcom.com.br/
* Description: Integração do Login do WordPress com o CoreSSO.
* Version: 1.0
* Author: AMcom
* Author URI: https://amcom.com.br/
**/

function validate_dre($dre){
    switch ($dre) {
        case 'DIRETORIA REGIONAL DE EDUCACAO BUTANTA':
            return array(
                'dre' => 'dre-bt',
                'grupo' => 1693
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO CAMPO LIMPO':
            return array(
                'dre' => 'dre-cl',
                'grupo' => 1703
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO CAPELA DO SOCORRO':
            return array(
                'dre' => 'dre-cs',
                'grupo' => 1728
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO FREGUESIA/BRASILANDIA':
            return array(
                'dre' => 'dre-fb',
                'grupo' => 1729
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO GUAIANASES':
            return array(
                'dre' => 'dre-gn',
                'grupo' => 1730
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO IPIRANGA':
            return array(
                'dre' => 'dre-ip',
                'grupo' => 1731
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO ITAQUERA':
            return array(
                'dre' => 'dre-it',
                'grupo' => 1732
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO JACANA/TREMEMBE':
            return array(
                'dre' => 'dre-jt',
                'grupo' => 1733
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO PENHA':
            return array(
                'dre' => 'dre-pe',
                'grupo' => 1734
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO PIRITUBA/JARAGUA':
            return array(
                'dre' => 'dre-pi',
                'grupo' => 1735
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO SANTO AMARO':
            return array(
                'dre' => 'dre-sa',
                'grupo' => 1736
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO SAO MATEUS':
            return array(
                'dre' => 'dre-sma',
                'grupo' => 1737
            );
            break;

        case 'DIRETORIA REGIONAL DE EDUCACAO SAO MIGUEL':
            return array(
                'dre' => 'dre-smi',
                'grupo' => 1738
            );
            break;
        
        default:
            return $dre;
            break;
    }
}

// Substituir a autenticacao do WordPress
add_filter( 'authenticate', 'demo_auth', 10, 3 );

function demo_auth( $user, $username, $password ){
    // Verifica se o usuario e senha foram preenchidos
    if($username == '' || $password == '') return;

    // URL da API
    $api_url = 'https://hom-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/v1/autenticacao';

    // Conversao do body para JSON
    $body = wp_json_encode( array(
        "login" => $username,
        "senha" => $password,
    ) );

    $response = wp_remote_post( $api_url ,
            array(
                'headers' => array( 
                    'x-api-eol-key' => 'fe8c65abfac596a39c40b8d88302cb7341c8ec99', // Chave da API
                    'Content-Type'=> 'application/json-patch+json'
                ),
                'body' => $body, // Body da requisicao
            ));

    $user = json_decode($response['body']);

    

    if( $response['response']['code']  != 200 ) {
        // Caso nao encontre o usuario retorna o erro na pagina
        $user = new WP_Error( 'denied', __("ERRO: Usuário/senha incorretos") );

    } else if( $response['response']['code'] == 200 ) {

        // Verifica se tem o codigo RF e busca os dados do usuario
        if($user->codigoRf){
            $api_url = 'https://hom-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/AutenticacaoSgp/' . $user->codigoRf . '/dados';
            $response = wp_remote_get( $api_url ,
                array( 
                    'headers' => array( 
                        'x-api-eol-key' => 'fe8c65abfac596a39c40b8d88302cb7341c8ec99',							
                    )
                )
            );

            $user = json_decode($response['body']);   
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://hom2-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/AutenticacaoVisitas/login',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => array('login' => $user->codigoRf),
                            CURLOPT_HTTPHEADER => array(
                                            'x-api-eol-key: fe8c65abfac596a39c40b8d88302cb7341c8ec99'
                            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $escola = json_decode($response); 
           
        }

        if($user->email == null){
            $user->email = $user->codigoRf . '@sme.prefeitura.sp.gov.br';
        }
        
        // Verifica se o usuario ja esta cadastrado no WordPress
        $userobj = new WP_User();
        $user_wp = $userobj->get_data_by( 'email', $user->email ); // Does not return a WP_User object :(
        $user_wp = new WP_User($user_wp->ID); // Attempt to load up the user with that ID

        // Se nao estiver cadastrado faz a criacao do usuario
        if( $user_wp->ID == 0 ) {
            
            // Caso nao queira adicionar o usuario no WordPress
            // descomente a linha abaixo
            //$user_wp = new WP_Error( 'denied', __("ERROR: Not a valid user for this system") );

            // Recebe o nome completo do usuario            
            $name = $user->nome;

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

            if($escola->grupos[0] == 'c8b2ebd2-924d-494d-8767-498b2a4ddf66'){
                if(str_contains($escola->dre, 'COCEU')){
                    $role = 'administrator';
                } else {
                    $role = 'editor';
                }
            } else {
                $role = 'subscriber';
            }

            $userdata = array( 'user_email' => $user->email,
                                'user_login' => $user->email,
                                'first_name' => $firstname,
                                'last_name' => $lastname,
                                'role' => $role,                              
                            );
            $new_user_id = wp_insert_user( $userdata ); // Um novo usuario sera criado


            
            $dre = validate_dre($escola->dre);
            if($role == 'editor'){
                // Inserir Grupo
                update_user_meta($new_user_id, "grupo", array($dre['grupo']) );
                update_user_meta($new_user_id, "_grupo", 'field_5f9843469209b');
            }
            

            $endereço = explode(', ', $escola->enderecoUe); // Separar o endereco
            $diretor = explode(' - ', $escola->nomeDiretor); // Separar o endereco

            //Informacoes Unidade Escolar (UE)
            update_user_meta($new_user_id, "dre", $dre['dre']); // Inserir DRE
            update_user_meta($new_user_id, "endereco_nome_da_ue", $escola->nomeUe); // Inserir nome da UE
            update_user_meta($new_user_id, "endereco_logradouro", $endereço[0]); // Inserir endereco da UE
            update_user_meta($new_user_id, "endereco_numero", $endereço[1]); // Inserir numero da UE
            update_user_meta($new_user_id, "endereco_bairro", $endereço[2]); // Inserir bairro da UE
            update_user_meta($new_user_id, "endereco_telefone", $escola->telefoneUe); // Inserir telefone UE
            update_user_meta($new_user_id, "endereco_nome_diretor", $diretor[1]); // Inserir diretor da UE
            update_user_meta($new_user_id, "endereco_email_diretor", $escola->emailDiretor); // Inserir email diretor da UE
            
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
    $login_page = get_permalink( get_the_ID() );
	wp_redirect( $login_page . '/login/?login=failed' );
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
		wp_redirect( $login_page . "/login/?login=blank&eventoid=" . $_GET['eventoid'] );
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