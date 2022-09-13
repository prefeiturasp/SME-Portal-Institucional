<?php
namespace Classes\ModelosDePaginas\Inscricoes;


use Classes\Lib\Util;

class Inscricoes extends Util{

    public function __construct(){		
		$this->montaHtmlIncricoes();
	}

    public function montaHtmlIncricoes(){
            $user_id = get_current_user_id();
            $dre = get_field('dre', 'user_' . $user_id);
            $infos = get_field('endereco', 'user_' . $user_id);
            $user_meta = get_user_meta( $user_id );
            $current_user = wp_get_current_user();
            //echo "<pre>";
            //print_r($current_user->data->user_email);
            //echo "</pre>";
        ?>

            <div class="title-bg py-5 mb-4">
                <div class="container">
                    <h1><?= get_the_title($_GET['eventoid']); ?></h1>

                    <div class="infoline-ajust">
                        <img src="<?= get_template_directory_uri(); ?>/classes/assets/img/calendar.png" alt="icone calendário"> 
                        <span class="info-date-banner">
                            
                            <?php
                                $datas = get_field('agenda', $_GET['eventoid']);

                                $dataNum = '';
                                $dataNumCompare = array();
                                $i = 0;
                                foreach($datas as $data){
                                    if($i == 0 && !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ){
                                        $dataNum .= substr($data['data_hora'], 0, 2);
                                    } elseif( !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ) {
                                        $dataNum .= ', ' . substr($data['data_hora'], 0, 2);
                                    }
                                    $dataNumCompare[] = substr($data['data_hora'], 0, 2);
                                    $i++;
                                }
                                $dataNumCompare = array();

                                $last = end($datas);
                                $lastMont = substr($data['data_hora'], 3, 2);
                                $mes = convertMonth($lastMont);
                                echo $dataNum . ' - ' . $mes;										
                            ?> 
                        </span>
                    </div>

                    <div class="row bannerhome-infoline mt-2">
                        <div class="col-sm-12">						
                            <?php
                                $parceiro = get_field('parceiro', $_GET['eventoid']);
                                $nomeParceiro = get_the_title($parceiro);
                                $bairroParceiro = get_field('bairro_parceiro', $parceiro);
                            ?>
                            <div class="infoline-ajust">
                                <img src="<?= get_template_directory_uri(); ?>/classes/assets/img/map-pin.png" alt="icone mapa"> 
                                <span class="info-local-banner"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

		    <div class="container">
                <div class="col-md-10 offset-md-1">
                    <p><a href="<?= get_the_permalink($_GET['eventoid']); ?>" class="return-link">< Voltar para o evento</a></p>
                    <div class="inscricoes">

                        <form id="example-form" action="<?= get_the_permalink() . '?eventoid=' . $_GET['eventoid'];?>" method="POST">
                            <div>

                                <h3>Agendamento <br>e transporte</h3>
                                <section>
                                    <label for="nome_ue">Nome da UE:</label>
                                    <input id="nome_ue" name="nome_ue" value="<?= $infos['nome_da_ue']; ?>" type="text" class="required form-control">
                                    
                                    <label for="dre">DRE:</label>
                                    <select id="dre" name="dre" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="dre-bt" <?= $dre == 'dre-bt' ? "selected" : ''; ?>>DRE Butantã</option>
                                        <option value="dre-cs" <?= $dre == 'dre-cs' ? "selected" : ''; ?>>DRE Capela do Socorro</option>
                                        <option value="dre-cl" <?= $dre == 'dre-cl' ? "selected" : ''; ?>>DRE Campo Limpo</option>
                                        <option value="dre-fb" <?= $dre == 'dre-fb' ? "selected" : ''; ?>>DRE Freguesia/Brasilândia</option>
                                        <option value="dre-gn" <?= $dre == 'dre-gn' ? "selected" : ''; ?>>DRE Guaianases</option>
                                        <option value="dre-ip" <?= $dre == 'dre-ip' ? "selected" : ''; ?>>DRE Ipiranga</option>
                                        <option value="dre-it" <?= $dre == 'dre-it' ? "selected" : ''; ?>>DRE Itaquera</option>
                                        <option value="dre-jt" <?= $dre == 'dre-jt' ? "selected" : ''; ?>>DRE Jaçanã/Tremembé</option>
                                        <option value="dre-pe" <?= $dre == 'dre-pe' ? "selected" : ''; ?>>DRE Penha</option>
                                        <option value="dre-pi" <?= $dre == 'dre-pi' ? "selected" : ''; ?>>DRE Pirituba</option>
                                        <option value="dre-sa" <?= $dre == 'dre-sa' ? "selected" : ''; ?>>DRE Santo Amaro</option>
                                        <option value="dre-sma" <?= $dre == 'dre-sma' ? "selected" : ''; ?>>DRE São Mateus</option>
                                        <option value="dre-smi" <?= $dre == 'dre-smi' ? "selected" : ''; ?>>DRE São Miguel</option>
                                    </select>

                                    <label for="telefone_ue">Telefone da UE:</label>
                                    <input id="telefone_ue" name="telefone_ue" value="<?= $infos['telefone']; ?>" type="text" class="required form-control">

                                    <?php
                                        $agenda = get_field('agenda', $_GET['eventoid']);
                                        //echo "<pre>";
                                        //print_r($agenda);
                                        //echo "</pre>";
                                    ?>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <label for="data_hora">Data/Horário da visita:</label>
                                            <select id="data_hora" name="data_hora" class="required form-control">
                                                <option value="">Selecione</option>
                                                <?php
                                                    foreach($agenda as $horario){
                                                        if($horario['status'] == 'Disponível'){
                                                            echo "<option value='" . $horario['data_hora'] . "'>" . $horario['data_hora'] . "</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <?php /*
                                        <div class="col">
                                            <label for="nome_ue">Horário da visita:</label>
                                            <select id="dre" name="dre" class="form-control">
                                                <option>Default select</option>
                                            </select>
                                        </div>
                                        */ ?>

                                    </div>
                                    
                                    <hr>

                                    <label for="transporte">UE precisa de transporte da DRE ou Parceiro?:</label>
                                    <select id="transporte" name="transporte" class="form-control">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>

                                    <div id="info-transporte">
                                        <p><strong>Horários:</strong></p>
                                        <div class="row">
                                            <div class="col">
                                                <label for="saida_oni">Saída do ônibus para a Visita:</label>
                                                <input type="time" id="saida_oni" name="saida_oni" class="required form-control">
                                            </div>
                                            <div class="col">
                                                <label for="retorno_oni">Retorno à UE:</label>
                                                <input type="time" id="retorno_oni" name="retorno_oni" class="required form-control">
                                            </div>
                                        </div>

                                        <label for="end_ue">Endereço da UE:</label>
                                        <input id="end_ue" name="end_ue" type="text" value="<?= $infos['logradouro']; ?>, <?= $infos['numero']; ?> - <?= $infos['bairro']; ?>" class="required form-control">

                                        <label for="ponto_ue">Ponto de referência da UE:</label>
                                        <input id="ponto_ue" name="ponto_ue" type="text" class="required form-control">
                                    </div>
                                    

                                </section>

                                <h3>Dados dos <br>educadores</h3>
                                <section>

                                    <label for="nome_resp">Nome do responsável:</label>
                                    <input id="nome_resp" name="nome_resp" type="text" value="<?= $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0]; ?>" class="required form-control">

                                    <label for="contato_resp">Contato do responsável:</label>
                                    <input id="contato_resp" name="contato_resp" type="text" class="required form-control">

                                    <label for="email_resp">E-mail do responsável:</label>
                                    <input id="email_resp" name="email_resp" type="text" value="<?= $current_user->data->user_email; ?>" class="required form-control">

                                    <hr>

                                    <label for="nome_edu">Nome do educador 1:</label>
                                    <input id="nome_edu" name="nome_edu" type="text" class="required form-control">

                                    <label for="contato_edu">Contato do educador 1:</label>
                                    <input id="contato_edu" name="contato_edu" type="text" class="required form-control">

                                    <label for="nome_edu_2">Nome do educador 2 (opcional):</label>
                                    <input id="nome_edu_2" name="nome_edu_2" type="text" class="form-control">

                                    <label for="contato_edu_2">Contato do educador 2 (opcional):</label>
                                    <input id="contato_edu_2" name="contato_edu_2" type="text" class="form-control">
                                    
                                </section>

                                <h3>Dados dos estudantes e expectativa da visita</h3>
                                <section>

                                    <div class="row">
                                        <div class="col">
                                            <label for="estudantes">Número de estudantes:</label>
                                            <input type="number" name="estudantes" id="estudantes" class="required form-control">
                                        </div>
                                        <div class="col">
                                            <label for="ciclo">Ciclo/ano:</label>
                                            <select class="required form-control" required id="ciclo" multiple="multiple" name="ciclo[]">
                                                
                                                <?php
                                                $ano_series = get_terms( array(
                                                    'taxonomy' => 'ano-serie',
                                                    'hide_empty' => false,
                                                ) );
                                                foreach ($ano_series as $ano_serie){
                                                    ?>
                                                        <option value="<?php echo $ano_serie->term_id; ?>"><?php echo $ano_serie->name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <label for="faixa">Faixas etárias:</label>
                                    <select class="required form-control" id="faixa" multiple="multiple" name="faixa[]">
                                        <?php
                                        $faixa_etarias = get_terms( array(
                                            'taxonomy' => 'faixa-etaria',
                                            'hide_empty' => false,
                                        ) );
                                        foreach ($faixa_etarias as $faixa_etaria){
                                            ?>
                                                <option value="<?php echo $faixa_etaria->term_id; ?>"><?php echo $faixa_etaria->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    
                                    <hr>

                                    <label for="pcd">Existem pessoas com deficiência?</label>
                                    <select id="pcd" name="pcd" class="required form-control">
                                        <option value="" disabled selected>Informar</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>

                                    <div id="info-pcd" style="display: none;">

                                        <label for="tipo_pcd">Deficiências listadas:</label>
                                        <select class="required form-control" id="tipo_pcd" multiple="multiple" name="tipo_pcd[]">
                                            <?php
                                            $tipo_pcds = get_terms( array(
                                                'taxonomy' => 'tipo-pcd',
                                                'hide_empty' => false,
                                            ) );
                                            foreach ($tipo_pcds as $tipo_pcd){
                                                ?>
                                                    <option value="<?php echo $tipo_pcd->term_id; ?>"><?php echo $tipo_pcd->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <label for="pcd_outras">Outras deficiências:</label>
                                        <input id="pcd_outras" name="pcd_outras" type="text" class="form-control">

                                        <label for="pcd_obs">Observações:</label>
                                        <textarea id="pcd_obs" name="pcd_obs" class="form-control"></textarea>
                                    </div>

                                    <input type="hidden" name="sucesso" id="sucesso" value="0">

                                </section>
                                
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>

        <?php
            if($_POST['nome_ue']){
                $new_post = array(
                    'post_title'    => get_the_title($_GET['eventoid']),
                    'post_status'   => 'pending',           // Choose: publish, preview, future, draft, etc.
                    'post_type' => 'agendamento'  // Use a custom post type if you want to
                );
                //save the new post and return its ID
                $pid = wp_insert_post($new_post);

                if($_POST['nome_ue'] && $_POST['nome_ue'] != ''){
                    $nome_ue = $_POST['nome_ue'];
                    update_post_meta($pid, 'nome_ue', $nome_ue);
                }
                
                if($_POST['dre'] && $_POST['dre'] != ''){
                    $dre = $_POST['dre'];
                    update_post_meta($pid, 'dre', $dre);
                }

                if($_POST['telefone_ue'] && $_POST['telefone_ue'] != ''){
                    $telefone_ue = $_POST['telefone_ue'];
                    update_post_meta($pid, 'telefone_ue', $telefone_ue);
                }

                if($_POST['data_hora'] && $_POST['data_hora'] != ''){
                    $data_hora = $_POST['data_hora'];
                    //$datetime1 = new \DateTime($data_hora);
                    update_post_meta($pid, 'data_horario', $data_hora);
                }

                if($_POST['transporte'] && $_POST['transporte'] != ''){
                    $transporte = $_POST['transporte'];                    
                    update_post_meta($pid, 'transporte', $transporte);
                }

                if($_POST['saida_oni'] && $_POST['saida_oni'] != ''){
                    $saida_oni = $_POST['saida_oni'];                    
                    update_post_meta($pid, 'saida_onibus', $saida_oni);
                }

                if($_POST['retorno_oni'] && $_POST['retorno_oni'] != ''){
                    $retorno_oni = $_POST['retorno_oni'];                    
                    update_post_meta($pid, 'retorno_ue', $retorno_oni);
                }

                if($_POST['end_ue'] && $_POST['end_ue'] != ''){
                    $end_ue = $_POST['end_ue'];                    
                    update_post_meta($pid, 'endereco_ue', $end_ue);
                }

                if($_POST['ponto_ue'] && $_POST['ponto_ue'] != ''){
                    $ponto_ue = $_POST['ponto_ue'];                    
                    update_post_meta($pid, 'ponto_referencia', $ponto_ue);
                }

                if($_POST['nome_resp'] && $_POST['nome_resp'] != ''){
                    $nome_resp = $_POST['nome_resp'];                    
                    update_post_meta($pid, 'nome_responsavel', $nome_resp);
                }

                if($_POST['contato_resp'] && $_POST['contato_resp'] != ''){
                    $contato_resp = $_POST['contato_resp'];                    
                    update_post_meta($pid, 'contato_responsavel', $contato_resp);
                }

                if($_POST['email_resp'] && $_POST['email_resp'] != ''){
                    $email_resp = $_POST['email_resp'];                    
                    update_post_meta($pid, 'email_responsavel', $email_resp);
                }

                if($_POST['nome_edu'] && $_POST['nome_edu'] != ''){
                    $nome_edu = $_POST['nome_edu'];                    
                    update_post_meta($pid, 'nome_educador', $nome_edu);
                }

                if($_POST['contato_edu'] && $_POST['contato_edu'] != ''){
                    $contato_edu = $_POST['contato_edu'];                    
                    update_post_meta($pid, 'contato_educador', $contato_edu);
                }

                if($_POST['nome_edu_2'] && $_POST['nome_edu_2'] != ''){
                    $nome_edu_2 = $_POST['nome_edu_2'];                    
                    update_post_meta($pid, 'nome_educador_2', $nome_edu_2);
                }

                if($_POST['contato_edu_2'] && $_POST['contato_edu_2'] != ''){
                    $contato_edu_2 = $_POST['contato_edu_2'];                    
                    update_post_meta($pid, 'contato_educador_2', $contato_edu_2);
                }

                if($_POST['estudantes'] && $_POST['estudantes'] != ''){
                    $estudantes = $_POST['estudantes'];                    
                    update_post_meta($pid, 'num_estudantes', $estudantes);
                }

                if($_POST['ciclo'] && $_POST['ciclo'] != ''){
                    $ciclo = $_POST['ciclo'];                    
                    update_post_meta($pid, 'ciclo_ano', $ciclo);
                }

                if($_POST['faixa'] && $_POST['faixa'] != ''){
                    $faixa = $_POST['faixa'];                    
                    update_post_meta($pid, 'faixa_etaria', $faixa);
                }

                if($_POST['pcd'] && $_POST['pcd'] != ''){
                    $pcd = $_POST['pcd'];                    
                    update_post_meta($pid, 'pcd', $pcd);
                }

                if($_POST['tipo_pcd'] && $_POST['tipo_pcd'] != ''){
                    $tipo_pcd = $_POST['tipo_pcd'];                    
                    update_post_meta($pid, 'deficiencias_listadas', $tipo_pcd);
                }

                if($_POST['pcd_outras'] && $_POST['pcd_outras'] != ''){
                    $pcd_outras = $_POST['pcd_outras'];                    
                    update_post_meta($pid, 'outras_deficiencias', $pcd_outras);
                }

                if($_POST['pcd_obs'] && $_POST['pcd_obs'] != ''){
                    $pcd_obs = $_POST['pcd_obs'];                    
                    update_post_meta($pid, 'observacoes', $pcd_obs);
                }
            }

            echo $_POST['sucesso'];

            if($_POST['sucesso'] == 1){
                
                echo '<script type="text/javascript">
                    window.location = "' . get_permalink( $_GET['eventoid'] ) . '?cadastro=1"
                </script>';
            }

	}
}