<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php 
 *
 * @package WordPress 
 */

$site = getenv('WORDPRESS_SITE');

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	  $_SERVER['REMOTE_ADDR'] = $ips[0];
}

/** Adicionado bloco para funcionamento do Proxy reverso Nginx SME  */

if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){

   $_SERVER['HTTPS'] = 'on';
   $_SERVER['SERVER_PORT'] = 443;

   define('WP_HOME', 'https://' . $site);
   define('WP_SITEURL', 'https://' . $site);
   
}
else{
  $_SERVER['HTTPS'] = 'off';
  $_SERVER['SERVER_PORT'] = 80;
  $_SERVER['REMOTE_ADDR'] = 'http://' . $site;

  define('WP_HOME', 'http://' . $site);
  define('WP_SITEURL', 'http://' . $site);
}


// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME'));

/** Usu�rio do banco de dados MySQL */
define( 'DB_USER',getenv('WORDPRESS_DB_USER'));

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD',getenv('WORDPRESS_DB_PASSWORD'));

/** Nome do host do MySQL */
define( 'DB_HOST',getenv('WORDPRESS_DB_HOST'));

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY') );
define( 'SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY') );
define( 'LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY') );
define( 'NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY') );
define( 'AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT') );
define( 'SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') );
define( 'LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT') );
define( 'NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT') );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX');

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */

define ('WP_MEMORY_LIMIT', '2048M');


//define( 'WP_POST_REVISIONS', 1 );

define('WP_DEBUG', getenv('WORDPRESS_DEBUG'));
define('WP_DEBUG_DISPLAY', getenv('WORDPRESS_DEBUG_DISPLAY'));

ini_set('error_reporting', E_ALL );
ini_set('display_errors','Off');

$cron_disabled = getenv('CRON_DISABLED');

if (
    !defined('DISABLE_WP_CRON') &&
    in_array(strtolower($cron_disabled), ['1', 'true', 'yes'], true)
) {
    define('DISABLE_WP_CRON', true);
}

//define('WP_ALLOW_MULTISITE', true);

//define('MULTISITE', true);
//define('SUBDOMAIN_INSTALL', false);
//https://github.com/wp-cli/wp-cli/issues/5565
//define('DOMAIN_CURRENT_SITE', $site);
//define('PATH_CURRENT_SITE', '/');
//define('SITE_ID_CURRENT_SITE', 1);
//define('BLOG_ID_CURRENT_SITE', 1);

/* Isto é tudo, pode parar de editar! :) */

/////////////////////////////////////////////////////////////////////////////
//////////////////habilita subir outros arquivos de midia//////////////////////
/////////////////////////////////////////////////////////////////////////////
//define( 'ALLOW_UNFILTERED_UPLOADS', true );
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////


/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
