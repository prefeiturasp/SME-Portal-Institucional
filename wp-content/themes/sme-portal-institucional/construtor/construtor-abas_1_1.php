<div class="container">
    <?php

    if(get_sub_field('fx_abas_1_1'))://repeater

        //loop menu aba
        echo '<ul class="nav nav-tabs float-none">';
            $count=0;
            $rand = generateRandomString(4);
            while(has_sub_field('fx_abas_1_1'))://verifica conteudo no repeater
                $count++;
                //echo $count;
                $aba_title = get_sub_field('fx_nome_abas_1_1');
                $id_aba = clean($aba_title);
                echo '<li class="nav-item">';
                    echo '<a class="nav-link" data-toggle="tab" href="#aba'. $count . $id_aba . $rand . '"><strong>'.get_sub_field('fx_nome_abas_1_1').'</strong></a>';
                echo '</li>';
            endwhile;
        echo '</ul>';

        //loop conteudo aba
        echo '<div class="tab-content">';
                $count=0;
            while(has_sub_field('fx_abas_1_1'))://verifica se editor no repeater
                    $count++;
                    //echo $count;
                    $aba_title = get_sub_field('fx_nome_abas_1_1');
                    $id_aba = clean($aba_title);
                    $ativar = get_sub_field('funcao_acervo');
                echo '<div class="tab-pane container mt-3 mb-3" id="aba'. $count . $id_aba . $rand . '">';

                    if($ativar){
                        $acervos = get_sub_field('acervos');
                        $colunas = get_sub_field('colunas');
                        $def_alt = get_sub_field('definir_altura');
                        $alt_min = get_sub_field('alt_min');                    

                        if($acervos){
                            echo '<div class="row">';
                                foreach($acervos as $acervo){

                                    $link = $acervo['link_acervo'];                                
                                    $link_embed = explode('acervo/', $link);
                                    $slug = str_replace('/', '', $link_embed[1]);

                                    $url = "https://acervodigital.sme.prefeitura.sp.gov.br/wp-json/wp/v2/acervo?slug=$slug";

                                    // Consulta Via API no Acervo
                                    $headers = [];
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                                        function ($curl, $header) use (&$headers) {
                                            $len = strlen($header);
                                            $header = explode(':', $header, 2);
                                            if (count($header) < 2) // ignore invalid headers
                                                return $len;

                                            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                                            return $len;
                                        }
                                    );
                                    $response = curl_exec($ch);                

                                    $jsonArrayResponse = json_decode($response);

                                    $embed = '';
                                    //$embed .= '<div class="row">';

                                    foreach($jsonArrayResponse as $acervo){
                                        if($acervo->arquivos_particionados){
                                            $qtdArquivos = count($acervo->arquivos_particionados);
                                        } else {
                                            $qtdArquivos = 1;
                                        }
                                        
                                        
                                        $get_format = '';
                                            
                                        if($acervo->substituir_capa_acervo_digital != ''){
                                            $imagem = get_media_api($acervo->substituir_capa_acervo_digital);
                                            $get_format = get_media_api($acervo->arquivo_acervo_digital);
                                            if($get_format->id == ''){			
                                                $get_format = get_media_api($acervo->arquivos_particionados_0_arquivo);
                                            }
                                        } else {
                                            $imagem = get_media_api($acervo->arquivo_acervo_digital);
                                            if($imagem->id == ''){			
                                                $imagem = get_media_api($acervo->arquivos_particionados_0_arquivo);
                                            }
                                        }

                                        $imagemShow = $imagem->media_details->sizes->full->source_url;
                                        $secondImage = $imagem->guid->rendered;
                                        $secondImage = str_replace('.pdf', '-pdf.jpg', $secondImage);
                                        
                                        if(!$imagemShow){
                                            $file_headers = @get_headers($secondImage);
                                            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                                $imagemShow = 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';
                                            } else {
                                                $imagemShow = $secondImage;
                                            }        
                                        }
                                        
                                        if($get_format == ''){
                                            $formato = explode("/", $imagem->mime_type);
                                        } else {
                                            $formato = explode("/", $get_format->mime_type);
                                        }
                                        
                                        if($formato[1] == 'VND.OPENXMLFORMATS-OFFICEDOCUMENT.SPREADSHEETML.SHEET' || $formato[1] == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
                                            $formato[1] = 'XLS';
                                        }

                                        if($formato[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document'){
                                            $formato[1] = 'DOC';
                                        }
                                        
                                        if(!$formato[1]){
                                            $formato[1] = 'INDEFINIDO';
                                        }

                                        

                                        if($acervo->categoria_acervo != ''){
                                            $categName = array();
                                            foreach($acervo->categoria_acervo as $categoria){
                                                $categName[] = get_categ_api($categoria)->name;
                                            }			
                                        }

                                        if($qtdArquivos > 1){
                                            $menuBtn = '';
                                            
                                            $menuBtn = '<div class="dropdown show">';
                                                $menuBtn .= '<a class="btn dropdown-toggle px-0" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Baixar</a><div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                                                    for ($i = 0; $i < $qtdArquivos; $i++) {
                                                        $chave = 'arquivos_particionados_' . $i . '_arquivo';
                                                        $arquivo = get_media_api($acervo->$chave);
                                                        $numArquivo = $i + 1;
                                                        $menuBtn .= '<a href="' . $arquivo->source_url . '" class="no-external">Baixar Arquivo ' . $numArquivo . '</a>';
                                                    }
                                                $menuBtn .= '</div>';

                                            $menuBtn .= '</div>';
                                        } else {
                                            $menuBtn = '<a href="' . $imagem->source_url . '" class="p3-4 no-external">Baixar</a>';
                                        }

                                        $style = '';
                                        if($def_alt && $alt_min){
                                            $style = 'style="height: ' . $alt_min . 'px;"';
                                        }
                                        
                                        // Monta o HTML para ser retornado na pagina
                                        $embed .= '<div class="col-12 col-sm-' . $colunas . ' p-3 acervo-display">
                                            <div class="row m-0">
                                                <div class="col-sm-12 view-tag flag">
                                                    <div class="img-mask shadow-sm"' . $style . '>
                                                        <img src="' . $imagemShow . '">
                                                        <span class="flag-pdf-full">' . $formato[1] . '</span>
                                                    </div>					
                                                </div>
                                                <div class="col-sm-12 mt-3 mb-3 p-0">
                                                    <h3 class="azul-claro-acervo"><a class="no-external" target="_blank" href="' . $acervo->link . '">' . $acervo->title->rendered . '</a></h3>
                                                    
                                                    <div class="links-flag">
                                                        <div class="cat-flag mb-2">' . implode(' / ', $categName) . '</div>
                                                        <div class="btn-acervo d-flex justify-content-between">							
                                                            <a href="' . $acervo->link . '" class="btn btn-outline-primary no-external">Ver detalhes</a>
                                                            ' . $menuBtn . ' 													
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>';
                                    }	

                                    //$embed .= '</div>';

                                    echo $embed;

                                }
                            echo '</div>';
                        }
                    } else {
                        echo get_sub_field('fx_editor_abas_1_1');
                    }

                    

                echo '</div>';

            endwhile;
        echo '</div>';

    endif;
    ?>
</div>