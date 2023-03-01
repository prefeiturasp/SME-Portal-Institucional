<?php
    use Shuchkin\SimpleXLSX;

    //ini_set('error_reporting', E_ALL);
    //ini_set('display_errors', true);
    
    require_once __DIR__.'/src/SimpleXLSX.php';
?>

<div class="wrap">
<h2>Importar usuários</h2>
<form method="post" enctype="multipart/form-data">    
    <label for="file">Faça o upload do arquivo em formato XLSX</label><br>
    <input type="file" name="file" id="file" /><br><br>
    <input type="submit" class="button" value="Enviar" />
</form>
</div>

<?php

if (isset($_FILES['file'])) {
    echo '<h1>Resultados da importação</h1>';
    if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']) ) {
        
        $api_url = '';
        $usuarios = $xlsx->rows();
        echo "<table class='wp-list-table widefat fixed striped table-view-list posts' cellspacing='0'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th class='manage-column column-title'><strong>Usuario</strong></th>";
            echo "<th class='manage-column column-title'><strong>RF/EOL</strong></th>";
            echo "<th class='manage-column column-title'><strong>Status</strong></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach($usuarios as $usuario){
                //echo "<pre>";
                //print_r($usuario);
                //echo "</pre>";

                // Conversao do body para JSON
                $body = wp_json_encode( array(
                    'nome' => $usuario[0] . ' ' . $usuario[1],
                    'documento' => '1',
                    'codigoRF' => $usuario[2],
                    'email' => $usuario[3]
                ) );
                
                $response = wp_remote_post( $api_url, array(
                    'method'      => 'POST',                    
                    'headers' => array( 
                        'x-api-eol-key' => '',
                        'Content-Type' => 'application/json-patch+json'
                    ),
                    'body' => $body, // Body da requisicao
                    )
                );
                
                if ( is_wp_error( $response ) ) {
                    $error_message = $response->get_error_message();
                    echo "<tr>";
                    echo "<td>" . $usuario[0] . ' ' . $usuario[1] . "</td>";
                    echo "<td>" . $usuario[2] . "</td>";
                    echo "<td>Ocorreu um erro: $error_message</td>";
                    echo "</tr>";
                } else {
                    
                    $user = json_decode($response);

                    if($response['response']['code'] == 601){
                        echo "<tr>";
                            echo "<td>" . $usuario[0] . ' ' . $usuario[1] . "</td>";
                            echo "<td>" . $usuario[2] . "</td>";
                            echo "<td>" . $response['body'] . "</td>";
                        echo "</tr>";
                        //echo "Usuario: " . $usuario[0] . ' ' . $usuario[1] . " - RF/EOL: " . $usuario[2] . " - " . $response['body'] . " <br>";
                    } elseif($response['response']['code'] == 200){
                        echo "<tr>";
                            echo "<td>" . $usuario[0] . ' ' . $usuario[1] . "</td>";
                            echo "<td>" . $usuario[2] . "</td>";
                            echo "<td>Usuário cadastrado com sucesso!</td>";
                        echo "</tr>";
                        //echo "Usuario: " . $usuario[0] . ' ' . $usuario[1] . " - RF/EOL: " . $usuario[2] . " - Usuário cadastrado com sucesso <br>";
                    } else {
                        echo "<tr>";
                            echo "<td>" . $usuario[0] . ' ' . $usuario[1] . "</td>";
                            echo "<td>" . $usuario[2] . "</td>";
                            echo "<td>Ocorreu um erro, verifique os dados e tente novamente.</td>";
                        echo "</tr>";
                        //echo "Usuario: " . $usuario[0] . ' ' . $usuario[1] . " - RF/EOL: " . $usuario[2] . " - Ocorreu um erro, verifique os dados e tente novamente. <br>";
                    }
                    
                    //print_r($response['body']);
                    //print_r($response['response']);
                }
                
            }
            echo "</tbody>";
        echo "</table>";
     

    } else {
        echo SimpleXLSX::parseError();
    }
    
}