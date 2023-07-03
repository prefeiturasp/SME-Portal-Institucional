<?php

$link = get_sub_field('link');
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
$embed .= '<div class="row m-0">';

foreach($jsonArrayResponse as $acervo){
    $qtdArquivos = count($acervo->arquivos_particionados);
    
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
    if(!$imagemShow){
        $imagemShow = 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';
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

    
    // Monta o HTML para ser retornado na pagina
    $embed .= '<div class="col-12 p-3 acervo-display">
        <div class="row m-0">
            <div class="col-sm-12 view-tag flag">
                <div class="img-mask shadow-sm">
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

$embed .= '</div>';

echo $embed;