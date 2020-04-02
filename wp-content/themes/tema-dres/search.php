<?php get_header(); ?>








<div class="inicio" style="display:none;">
<?php

$GLOBALS['z'] = 0;
//config número de posts
$GLOBALS['paginacao'] = 12;
$GLOBALS['arrayVerId'] = array();
    function busca_multisite()
    {
		function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}		

		
		
		
	$termo_buscado = get_search_query(); //termo da busca
		$z = 0;
		function alert($oque) {
			echo '<script>alert("'.$oque.'");</script>';
		}
	
	$arrayO = array('post','page','programa-projeto','agendaconselho','card'); //pega todos tipos de post (inclusive indesejáveis, então precisa excluir, no array abaixo)
	$excluidos = array('wp_block');	
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$termo_buscado = isset($_GET['s']) ? $_GET['s'] : ''; 
	$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
	$tipoconteudo = isset($_GET['tipoconteudo']) ? array($_GET['tipoconteudo']) : $arrayO;
	$categoria = isset($_GET['category']) ? $_GET['category'] : '';
	$ano = isset($_GET['ano']) ? $_GET['ano'] : '';
	$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
	$quaissites = isset($_GET['site']) ? $_GET['site'] : '';
	
		if($ano != '') {
			$quetipodedata =  array(
        'relation' => 'AND',
        array('year' => intval($ano)),
        array('year' => intval($ano)),
    );
		}
		else {
			$quetipodedata = array(
			'after'     => $periodo.' hours ago',
			'inclusive' => true,
		);
		}
		
		
		
	if($quaissites == '')
	$arraysites = array('1','2','3','4','5','6','7'); //array dos sites disponíveis
	else 
	$arraysites = array($quaissites);
		
		//echo get_search_query();
		//echo $termo_buscado;
		if ($tipoconteudo) 
			$tipoconteudo = $arrayO;
	$sites = array(
		's' => '',
		'post_status'    => 'publish',
		'sentence' => true,
		'site__in' => $arraysites,
		//informa a lista de sites que deseja ter nos resultados da busca
		'paged' => $paged,
		'orderby' => ['post_type' => 'ASC','id'=>'ASC','date' => 'DESC'],
		'public' => 'true',
		'posts_per_page' => -1, //função custom de paginação fora do wordpress
	    'date_query' => $quetipodedata,
	
	
		'post_type' => $arrayO,
		'category_name' => $categoria
	);

        $GLOBALS['i'] = 0;
		
		//para mudar a ordem dos sites (descomentar abaixo para verificar order atual)
		//print("<pre>".print_r(get_sites($sites),true)."</pre>");
		if($quaissites == '') {
		$sitesNovaOrdem =  array();
		$arraySitee = get_sites($sites);
		
		//aqui você coloca a nova ordem relativa à do print acima
		array_push(
			$sitesNovaOrdem,
			$arraySitee[3],//DRE
			$arraySitee[0],//Portal SME
			$arraySitee[4]//Conselho
			//$arraySitee[0],//portal SME
			//$arraySitee[3],//DRE
			//$arraySitee[4],//Conselho
			//$arraySitee[6],//portal SME
		);
		}
		else
			$sitesNovaOrdem = get_sites($sites);
			// verifica a nova ordem
		///////print("<pre>".print_r(($sitesNovaOrdem),true)."</pre>");
		if($_GET['s'] == '' && !isset($_GET['tipoconteudo']) == 1) {
			echo "<div style='text-align:left'><p>Nenhum termo foi digitado.</p> <p>faça uma nova pesquisa ou navegue abaixo em nossas ultimas noticias.</p></div>";
		}
		$anosArray = array();
	
		
        foreach (($sitesNovaOrdem) as $blog) {
			//aqui
	
            switch_to_blog($blog->blog_id);

            $busca_geral = new WP_Query($sites);

	
         /*    print("<pre>".print_r($busca_geral,true)."</pre>"); */


            if ($busca_geral->have_posts()) {
                //começo aqui
       
             
                while ($busca_geral->have_posts()) {
                    $busca_geral->the_post();
					
					
					                       /*     echo '<script>alert("'.ceil($GLOBALS['i']/$GLOBALS['paginacao']).'")</script>'; */

               if (!in_array(get_the_guid(), $GLOBALS['arrayVerId']))
{
				
$search = tirarAcentos($termo_buscado);					
$conta = false;
array_push($GLOBALS['arrayVerId'],get_the_guid());
$titulo = tirarAcentos(get_the_title());
$descricao = tirarAcentos(get_the_excerpt());
$conteudo = tirarAcentos(get_the_content());					
$post_tags = get_the_tags();
$stringTags = '';
					
if ( $post_tags ) {
    foreach( $post_tags as $tag ) {
	
		
	
		$stringTags.= $tag->name;
    }
	
}
		
if($titulo != '' && $termo_buscado != '') {
if(preg_match("/{$search}/i", $titulo) ||
preg_match("/{$search}/i", $descricao) ||
preg_match("/{$search}/i", $conteudo) ||
preg_match("/{$search}/i", $stringTags)) 
{
$GLOBALS['i']++;
}
			
			}
else {
$GLOBALS['i']++;
}
if($GLOBALS['i'] > ($GLOBALS['paginacao'] * ($pagina-1)) and ($GLOBALS['i'] <= ($GLOBALS['paginacao'] * ($pagina)) ))
{

	$post_date = get_the_date( 'Y' );
	$anoCheck = get_the_date( 'Y' ) == $ano ? null : 'dnones'; 		

	$temTermo = (strlen($termo_buscado) >= 1 ? true : false) ;
							   $a = 1;
				if($a == 1)	
				{		   
					
if($temTermo)						
$search = tirarAcentos($termo_buscado);
else
$search = '';
					
$esseTemSearch = false;

					
	if(preg_match("/{$search}/i", $titulo) ||
	   preg_match("/{$search}/i", $descricao) ||
	   preg_match("/{$search}/i", $conteudo) ||
	   preg_match("/{$search}/i", $stringTags)) 
	{
		    $esseTemSearch = true;
			$umadiante = true;
			
	}
	else {
	/*	$GLOBALS['i']--;  */
	/*	echo 'menosmenos'; */
	}

			
					
					if($esseTemSearch == false){
					
						continue;
						echo '<div class="postagemX dnone '.$GLOBALS['i'].'" >';						
						//echo "<script>alert('$titulo')</script>";
					
						}
					else {
					
						echo '<div class="postagemX '.$GLOBALS['i'].'">';
						$umadiante = true;
			
					}
				
				}
    ?>

				<div>
                  <div class="row">
                        <div class="col-sm-4">
                            <?php
                            if (has_post_thumbnail() != '') {
                                echo '<figure class="">';
                                the_post_thumbnail('medium', array(
                                    'class' => 'img-fluid rounded float-left'
                                ));
                                echo '</figure>';
                            } else {
                            
							if($esseTemSearch == true){ ?>
							 
                                <figure>
                                    <img class="img-fluid rounded float-left" src="https://hom-portal.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/03/placeholder06.jpg" width="100%">
                                </figure>
                            <?php
							}
								else {
									?>
							 
                                <figure>
                                    <img class="img-fluid rounded float-left" srcsetX="" width="100%">
                                </figure>
                            <?php
								}
									
                            }
                            ?>
                        </div>
                        <div class="col-sm-8">
							<h2><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                            
							<p><?php the_excerpt();?></p>
							
							<?php
							if(get_the_tags() != null){
								echo'<strong>Tag(s): </strong>';
								$posttags = get_the_tags();
								if ($posttags) {
								  foreach($posttags as $tag) {
									echo '<span class="tagcolor">' .$tag->name . '</span> '; 
								  }
								}
								echo'<br>';
							}
							?>
							
							<?php
							if(get_post_type() != ''){
								?>
							<strong>Tipo:</strong> <span class="tagcolor"><?php $tipopost = get_post_type();
								if( $tipopost == "post" ) echo  'Notícia';
								if( $tipopost == "programa-projeto" ) echo  'Programa e Projetos';
								if( $tipopost == "agendaconselho" ) echo  'Agenda do Conselho';
								if( $tipopost == "card" ) echo  'Cards';
								if( $tipopost == "page" ) echo  'Página'; ?>
							</span><br>
							<?php
							}
							?>
  
							<?php /*?><span><strong>Categoria(s):</strong> <?php
							  foreach (get_the_category() as $category) {
									echo  $category->name.", ";
								}
							?></span><br><?php */?>
                            
                            <span><strong>Publicado em:</strong> <?php the_time('d/m/Y G\hi'); ?> </span> -

                            <span><strong>Site:</strong>
								<a href="<?php echo get_site_url(); ?>">
									<?php echo get_bloginfo('description');?>
								</a>
							</span><br>
							<!--<span>na categoria: <?php // get_the_category(  )[0]->name; ?></span>-->

                        </div>

                    </div>
   <hr>
                  </div>
   </div>
            <?php
            
                        }
						if($esseTemSearch == false){
							
						}
					
                   
					}
                    }
            
            }
  
            //fim
            else {
                if($GLOBALS['i'] = 0)
                echo 'Não foi encontrado resultado para a pesquisa:' . '' . '"' . $termo_buscado . '"';

                break;
            }
            ?>
	
    <?php restore_current_blog();
        }
	//mescla as querys	
	function merge_querystring($url = null,$query = null,$recursive = false){ 
		if($url == null)
		return false;
		if($query == null)
		return $url;

		$url_components = parse_url($url);

		if(empty($url_components['query']))
		return $url.'?'.ltrim($query,'?');

		parse_str($url_components['query'],$original_query_string);
		parse_str(parse_url($query,PHP_URL_QUERY),$merged_query_string);
		if($recursive == true)
		$merged_result = array_merge_recursive($original_query_string,$merged_query_string);
		else
		$merged_result = array_merge($original_query_string,$merged_query_string);
		return str_replace($url_components['query'],http_build_query($merged_result),$url);
	}


?>
<?php 


?>
<div style="width:100%;text-align: center;">
	<div class="pagination <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > 1 && $GLOBALS['i'] !== $GLOBALS['paginacao'] ? 'ok' : 'dnone';?>">
		<a href="" class="anterior <?=$pagina > 1 ? 'ok' : 'dnone';?>">Anterior</a><!--Ir para o anterior-->
		<a class="paginationA " href="#">&laquo;</a><!--Ir para o primeiro-->
		<a class="paginationB <?=$pagina >= 1 ? 'ok' : 'dnone';?>" href="<?=$pagina - 2;?>"><?=$pagina - 2;?></a>
		<a class="paginationB <?=$pagina >= 2 ? 'ok' : 'dnone';?>" href="<?=$pagina - 1;?>"><?=$pagina - 1;?></a>
		<a class="paginationA <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > $pagina + 0 ? 'ok' : 'dnone';?>" href=""></a>
		<a class="paginationA " href="<?=$pagina;?>"></a>
		<a class="paginationA <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > $pagina + 0 ? 'ok' : 'dnone';?>" href=""></a>
		<a class="a paginationA <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > $pagina + 1 ? 'ok' : 'dnone';?>"  href=""></a>
		<a class="b paginationA <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > $pagina + 2 ? 'ok' : 'dnone';?>"  href=""></a>
		<a class="c paginationA <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > $pagina + 3 ? 'ok' : 'dnone';?>"  href=""></a>

		<a class="d paginationA" href="">»</a><!--Ir para o ultimo-->
		<a href="" class="proximo <?=$pagina != ceil($GLOBALS['i']/$GLOBALS['paginacao'])  ? 'ok' : 'dnone';?>">Próximo</a><!--Ir para o próximo-->
	</div>
</div>
<script>
function replaceQueryParam(param, newval, search) {
var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
var query = search.replace(regex, "$1").replace(/&$/, '');

return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}

jQuery('.anterior').eq(0).attr('href',replaceQueryParam('pagina', <?=$pagina-1; ?>  , window.location.search));
jQuery('.proximo').eq(0).attr('href',replaceQueryParam('pagina', <?=$pagina+1; ?>  , window.location.search));

jQuery('.paginationB').eq(0).attr('href',replaceQueryParam('pagina', <?=$pagina-2; ?>  , window.location.search)).text(<?=$pagina - 2; ?>);
jQuery('.paginationB').eq(1).attr('href',replaceQueryParam('pagina', <?=$pagina-1; ?>  , window.location.search)).text(<?=$pagina - 1; ?>);
jQuery('.paginationB').eq(2).attr('href',replaceQueryParam('pagina', <?=$pagina; ?>  , window.location.search)).text(<?=$pagina; ?>);
jQuery('.paginationA').eq(0).attr('href',replaceQueryParam('pagina', 1, window.location.search));
jQuery('.paginationA').eq(1).attr('href',replaceQueryParam('pagina', <?=$pagina; ?>  , window.location.search)).text(<?=$pagina; ?>);

jQuery('.paginationA').eq(2).attr('href',replaceQueryParam('pagina', <?=$pagina+1 <= ceil($GLOBALS['i']/$GLOBALS['paginacao']) ? $pagina+1 : $pagina; ?>, window.location.search)).text(<?=$pagina+1 <= ceil($GLOBALS['i']/$GLOBALS['paginacao']) ? $pagina+1 : $pagina; ?>);
jQuery('.paginationA').eq(3).attr('href',replaceQueryParam('pagina', <?=$pagina+2; ?>, window.location.search)).text(<?=$pagina+2; ?>);
<?php if( $GLOBALS['i']/$GLOBALS['paginacao'] >= $pagina+2) { ?>
	jQuery('.paginationA').eq(4).attr('href',replaceQueryParam('pagina', <?=$pagina+3; ?>, window.location.search)).text(<?=$pagina+3; ?>);
<?php } 
	else 
		echo "jQuery('.paginationA').eq(4).hide();";
	?>
	jQuery('.paginationA').eq(5).attr('href',replaceQueryParam('pagina', <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']); ?>, window.location.search)).text(<?=ceil($GLOBALS['i']/$GLOBALS['paginacao']); ?>);

jQuery('.paginationA').eq(6).attr('href',replaceQueryParam('pagina', <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']); ?>, window.location.search));

jQuery('.paginationB').eq(0).text() < 1 ? jQuery('.paginationB').eq(0).remove() : null
jQuery('.paginationB').eq(1).text() < 1 ? jQuery('.paginationB').eq(1).remove() : null
jQuery('.paginationA').eq(3).text() > <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']); ?> ? jQuery('.paginationA').eq(3).remove() : null
jQuery('.paginationA').eq(6).text() == '' ? jQuery('.paginationA').eq(6).remove() : null

jQuery('.paginationA').last().attr('href',replaceQueryParam('pagina', <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']); ?>, window.location.search));			

	jQuery('.paginationA').eq(1).attr('href',replaceQueryParam('pagina', <?=$pagina; ?>  , window.location.search)).text(<?=$pagina; ?>);

	jQuery('.paginationA').eq(1).attr('href',replaceQueryParam('pagina', <?=$pagina; ?>  , window.location.search)).text(<?=$pagina; ?>);

</script>

<?php


		//fim
		
			}					

    ?>


    <div  class="container ">

        <div class="row">

            <div class="col-sm-8">
<!--Busca Manual-->

<?php $campo_de_busca = get_search_query(); ?>


<?php if( have_rows('cadastro_busca_manual', 'option') ): ?>

    <?php while( have_rows('cadastro_busca_manual', 'option') ): the_row(); ?>
			<?php
				//$palavra_chave = array('dina');


$arrayPalavrasPost = explode(",",get_sub_field('palavras_chaves_busca_manual'));
$arrayPalavrasPost = array_map('trim', $arrayPalavrasPost);

//Retornos das variáveis abaixo.
//var_dump($arrayPalavrasPost);
//var_dump($campo_de_busca);

				
				if (in_array(trim($campo_de_busca), $arrayPalavrasPost)  ){
				

?>
				
					<?php 
						if($_GET["pagina"] <= 1){//mostrar somente se for a primeira página
						?>
							<div class="row">
							<div class="col-sm-4">
								<?php
								if(get_sub_field('imagem_busca_manual') != ''){
									?>
									<figure>
										<img class="img-fluid rounded float-left" src="<?php the_sub_field('imagem_busca_manual'); ?>" width="100%">
									</figure>
									<?php
								}else{
									?>
									<figure>
										<img class="img-fluid rounded float-left" src="https://hom-portal.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/03/placeholder06.jpg" width="100%">
									</figure>	
									<?php
								}
								?>
							</div>
							<div class="col-sm-8">
							
								<h2>
									
									<a href="<?php the_sub_field('url_busca_manual'); ?>" targetX="<?php the_sub_field('abrir_busca_manual'); ?>" rel="noopener" >
										<?php the_sub_field('titulo_busca_manual'); ?>
									</a>
									
								</h2>
								<p><?php the_sub_field('resumo_busca_manual'); ?></p>
								<p><strong>Tipo:</strong> <span class="tagcolor"><?php the_sub_field('tipo_busca_manual'); ?></span></p>
								
								
							</div>
						</div>
						<hr>
						<?php
						}
					?>
						
					
					
					<?php
				}
			?>
			
    <?php endwhile; ?>
<?php endif; ?>
<!--Busca Manual-->				
				
				
                <?php busca_multisite(); ?>

            </div>

            <div style="display: none;" class="col-sm-4">


            </div>



        </div>

    </div>
    </div>
    </form>

<?php 
$ano_agora = date('Y');
$date_range = range(2013, $ano_agora);
$anosArray = $date_range;

		echo '<div class="transportX" style="display:none;"><option value="">Todos os anos</option>';
			
		(sort($anosArray));
							 foreach ((array_unique($anosArray)) as $ano) {
			echo '<option value="'.$ano.'">'.$ano.'</option>';
		
							 }
		echo '</div>';
?>
    <script>
		
function mudaNomes(nomevelho, nomenovo){
for (i = 0; i < jQuery('option').length; i++) {
	if(nomenovo !== '')
	jQuery('option').eq(i).html() == nomevelho ? jQuery('option').eq(i).html(nomenovo) : null
	else 
	jQuery('option').eq(i).html() == nomevelho ? jQuery('option').eq(i).hide() : null	
}
}
//REMOVE OU MODIFICA OS NOMES DE TODOS OS SELECTS DO FILTRO
mudaNomes('post', 'Notícia');
mudaNomes('nav_menu_item', '');
mudaNomes('/portal/', 'Site Principal');
		

var i;
var o = 0;
var elll = document.querySelectorAll('.postagemX');
for (i = 0; i < elll.length ; i++) {
   (elll[i].style.display) == 'none' ? o++ : console.log('n');
}
elll.length - o > 0 ? console.log('oi') : jQuery('.inicio .container .row .col-sm-8').html('<p>Não há conteúdo disponível para o termo buscado.</p><p>Por favor informe um novo termo no campo "Buscar".</p>')

//remove duplicados da paginação
var valoresOpt = [];
	jQuery('.paginationA').each(function(){
	   if(jQuery.inArray(this.text, valoresOpt) >-1){
		if(this.text != "")
		jQuery(this).remove()
	   }else{
		valoresOpt.push(this.text);
	   }
	});

//adiciona dinamicamente o filtro de ano
jQuery('[name=ano]').html(jQuery('.transportX').html())
		
var ativaAgora = new URL(location.href).searchParams.get('pagina');
for (i = 0; i < document.querySelectorAll('.pagination.ok a').length ; i++) {
   jQuery('.pagination.ok a').eq(i).text() == ativaAgora ?  jQuery('.pagination.ok a').eq(i).addClass('active') : null
}
jQuery( "[targetx='_blank']"  ).click(function(e) {
e.preventDefault();
window.open(e.target.href, '_blank');
});
//ultimo js a ser executado deve ser o abaixo		
jQuery('.inicio').show()
    </script>             

<?php 


//var_dump($GLOBALS['z']);
get_footer(); ?>
</div>