<?php
/**
 * As configura��es b�sicas do WordPress
 *
 * O script de cria��o wp-config.php usa esse arquivo durante a instala��o.
 * Voc� n�o precisa usar o site, voc� pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo cont�m as seguintes configura��es:
 *
 * * Configura��es do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configura��es do MySQL - Voc� pode pegar estas informa��es com o servi�o de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME'));

/** Usu�rio do banco de dados MySQL */
define( 'DB_USER',getenv('WORDPRESS_DB_USER'));

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD',getenv('WORDPRESS_DB_PASSWORD'));

/** Nome do host do MySQL */
define( 'DB_HOST',getenv('WORDPRESS_DB_HOST'));

/** Charset do banco de dados a ser usado na cria��o das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. N�o altere isso se tiver d�vidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves �nicas de autentica��o e salts.
 *
 * Altere cada chave para um frase �nica!
 * Voc� pode ger�-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Voc� pode alter�-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto ir� for�ar todos os
 * usu�rios a fazerem login novamente.
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
 * Voc� pode ter v�rias instala��es em um �nico banco de dados se voc� der
 * um prefixo �nico para cada um. Somente n�meros, letras e sublinhados!
 */
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX');

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibi��o de avisos
 * durante o desenvolvimento. � altamente recomend�vel que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informa��es sobre outras constantes que podem ser utilizadas
 * para depura��o, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */

// adjust Redis host and port if necessary 
define( 'WP_REDIS_HOST', getenv('WORDPRESS_REDIS_HOST') );
define( 'WP_REDIS_PORT', 6379 );

// change the prefix and database for each site to avoid cache data collisions
define( 'WP_REDIS_PREFIX', getenv('WORDPRESS_REDIS_PREFIX') );
define( 'WP_REDIS_DATABASE', 0 ); // 0-15

// reasonable connection and read+write timeouts
define( 'WP_REDIS_TIMEOUT', 1 );
define( 'WP_REDIS_READ_TIMEOUT', 1 );

define( 'WP_REDIS_MAXTTL',  getenv('WORDPRESS_REDIS_MAXTTL') );
define( 'WP_REDIS_DISABLED', getenv('WORDPRESS_REDIS_DISABLED') );

//define( 'WP_POST_REVISIONS', 1 );

define('WP_DEBUG', getenv('WORDPRESS_DEBUG'));
define('WP_DEBUG_DISPLAY', getenv('WORDPRESS_DEBUG_DISPLAY'));
define('WP_DEBUG_LOG', getenv('WORDPRESS_DEBUG_LOG'));

$cron_disabled = getenv('CRON_DISABLED');

if (
    !defined('DISABLE_WP_CRON') &&
    in_array(strtolower($cron_disabled), ['1', 'true', 'yes'], true)
) {
    define('DISABLE_WP_CRON', true);
}

error_reporting('E_ALL');
ini_set('display_errors', 1);

$site = getenv('WORDPRESS_SITE');

//define('WP_ALLOW_MULTISITE', false);
//define('MULTISITE', false);
//define('SUBDOMAIN_INSTALL', false);
//https://github.com/wp-cli/wp-cli/issues/5565
//define('DOMAIN_CURRENT_SITE', $site);
//define('PATH_CURRENT_SITE', '/');
//define('SITE_ID_CURRENT_SITE', 1);
//define('BLOG_ID_CURRENT_SITE', 1);


/* Isto � tudo, pode parar de editar! :) */

/** Caminho absoluto para o diret�rio WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

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


/** Configura as vari�veis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');


define('WP_MEMORY_LIMIT', '3056M');
///////////////////////////////////////////////////////////////////////////////
//////////////////habilita subir outros arquivos de midia//////////////////////
///////////////////////////////////////////////////////////////////////////////
//define( 'ALLOW_UNFILTERED_UPLOADS', true );
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////