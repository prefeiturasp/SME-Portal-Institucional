<?php
    $terms = get_terms( array( 
        'taxonomy' => 'categoria-quebrada',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ) );

    $titulo = get_sub_field('titulo_formulario');
    $link = get_sub_field('link_privacidade');

    if(!$link && $link == ''){
        $link = get_home_url();
    }
?>

<div class="form-bg mb-4 order-1 order-sm-0" id="form-quebrada">
    <div class="container">

            <?php if($titulo) : ?>
                <div class="form-title"><?php echo $titulo; ?></div>
            <?php endif; ?>

            <form method="post" action="" enctype="multipart/form-data" id="quebrada-form">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nome*</label>
                        <input type="text" name="nome" class="form-control" id="name" placeholder="Digite nome e sobrenome">
                        <div class="invalid-tooltip">
                            Nome e Sobrenome são inválidos.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTelefone">Telefone*</label>
                        <input type="text" name="telefone" class="form-control" id="inputTelefone" placeholder="Digite seu telefone" required>
                        <div class="invalid-tooltip">
                            Telefone inválido.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTitulo">Título*</label>
                        <input type="text" name='title' class="form-control" id="inputTitulo" placeholder="Insira seu título" required>
                        <div class="invalid-tooltip">
                            O título precisa ter no mínimo 5 caracteres.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCategoria">Categoria*</label>
                        <select id="inputCategoria" name="categoria" class="form-control" required>
                            <option value="" selected>Escolha a categoria do envio</option>
                            <?php foreach($terms as $term): ?>
                                <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-tooltip">
                            Selecione uma categoria.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group  col-md-6">
                        <label for="inputLink">Link (Opcional)</label>
                        <input type="text" name="link" class="form-control" id="inputLink" placeholder="Digite o link que quer compartilhar">
                        <div class="invalid-tooltip">
                            URL inválida.
                        </div>
                    </div>
                    <div class="form-group  col-md-6">
                        <label>Envie um arquivo*</label>
                        
                        <div style="position: relative;">
                            <label class="custom-file-label" for="validatedCustomFile">Escolha um arquivo para enviar</label>
                            <input type="file" name="fileToUpload" class="custom-file-input" id="validatedCustomFile" data-file_types="ppt|pptx|pdf|doc|docx|jpg|jpeg|png|mp4|mov">
                            <div class="invalid-tooltip" id="alert">
                                Formato ou tamanho inválido
                            </div>
                        </div>               
                       
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="quebradaDescri">Descritivo*</label>
                        <textarea class="form-control" name="description" id="quebradaDescri" placeholder="Compartilha aqui com a gente o que você quer compartilhar!" rows="4" maxlength="300"></textarea>
                        <div class="invalid-tooltip">
                            No mínimo 10 e no máximo 300 caracteres.
                        </div>
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                         Eu autorizo a publicação parcial ou integral da minha mensagem e o armazenamento dos meus dados conforme a <a href="<?php echo $link; ?>">Política de Privacidade e Segurança</a>.
                        </label>
                        <div class="invalid-tooltip">
                            Você deve concordar antes de enviar.
                        </div>
                    </div>
                </div>

                <input type="hidden" name="action" value="new_post" />
                <?php wp_nonce_field( 'new-post' ); ?>

                <div class="text-right">
                    <!-- <button type="submit" class="btn btn-form-quebrada">Enviar</button> -->
                    <button onclick="validate();" class="btn btn-form-quebrada">Enviar</button>
                </div>
                
            </form>
        
    </div>
</div>

<?php
    if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

        // Do some minor form validation to make sure there is content
        if (isset ($_POST['title'])) {
            $title =  $_POST['title'];
        } else {
            echo 'Please enter a game  title';
        }
        if (isset ($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            echo 'Please enter the content';
        }
        $tags = $_POST['post_tags'];
    
        // Add the content of the form to $post as an array
        $new_post = array(
            'post_title'    => $title,
            'post_content'  => $description,
            'tags_input'    => array($tags),
            'post_status'   => 'pending',           // Choose: publish, preview, future, draft, etc.
            'post_type' => 'na-quebrada'  // Use a custom post type if you want to
        );
        //save the new post and return its ID
        $pid = wp_insert_post($new_post);

        if($pid){
            session_start();
            $_SESSION['success'] = true;
        }
    
        if($_POST['categoria'] && $_POST['categoria'] != ''){
            $categ = $_POST['categoria'];
            wp_set_post_terms($pid, $categ, 'categoria-quebrada', true);
        }

        if($_POST['nome'] && $_POST['nome'] != ''){
            $nome = $_POST['nome'];
            update_post_meta($pid, 'nome', $nome);
        }

        if($_POST['telefone'] && $_POST['telefone'] != ''){
            $telefone = $_POST['telefone'];
            update_post_meta($pid, 'telefone', $telefone);
        }

        if($_POST['link'] && $_POST['link'] != ''){
            $link = $_POST['link'];
            update_post_meta($pid, 'link', $link);
        }

        if ($_FILES["fileToUpload"]) {
            
            $tipo = $_FILES["fileToUpload"]['type'];
            $formatos = array(
                'image/jpg',
                'image/jpeg',
                'image/png',
                'video/mp4',
                'video/quicktime', // mov
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Word docx
                'application/msword', // Word doc
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Excel xlsx
                'application/vnd.ms-excel', // Excel xls
                'application/vnd.openxmlformats-officedocument.presentationml.presentation', // Power Point pptx
                'application/vnd.ms-powerpoint', // Power Point ppt
            );

            if(in_array($tipo, $formatos)){
                

                if ( ! function_exists( 'wp_handle_upload' ) ) {
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                }
 
                $upload_overrides = array( 'test_form' => false );
                $movefile = wp_handle_upload( $_FILES["fileToUpload"], $upload_overrides );
                                 
                
                // $filename should be the path to a file in the upload directory.
                $filename = $movefile['file'];
                
                // The ID of the post this attachment is for.
                $parent_post_id = $pid;
                
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype( basename( $filename ), null );
                
                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();
                
                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                
                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                
                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                if($attach_id && $attach_id != ''){                    
                    update_post_meta($pid, 'arquivo', $attach_id);
                }

                // Caso seja do tipo imagem colocar como Imagem destacada
                if($tipo == 'image/png' || $tipo == 'image/jpg' || $tipo == 'image/jpeg'){
                    set_post_thumbnail( $pid, $attach_id );
                }
                
            }

        }
    
    }
?>