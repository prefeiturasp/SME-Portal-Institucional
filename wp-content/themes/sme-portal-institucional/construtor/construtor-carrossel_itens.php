<?php
// Slick
wp_register_style('slick', STM_THEME_URL . 'classes/assets/css/slick.css', null, null, 'all');
wp_enqueue_style('slick');

wp_register_style('slick-theme', STM_THEME_URL . 'classes/assets/css/slick-theme.css', null, null, 'all');
wp_enqueue_style('slick-theme');

$colunas = get_sub_field('colunas');
$cor = get_sub_field('cor');
$itens = get_sub_field('itens');
$estilo = get_sub_field('estilo');
if(!$estilo) {
    $estilo = 'padrao';
}

//echo "<pre>";
//print_r($itens);
//echo "</pre>";

?>

<div class="container">
    <div class="portais-destaques estilo-<?= $estilo; ?>" style="overflow: hidden;">        
        <div class="row">
            <div class="col-10 offset-1">
                <div class="slider portais">

                    <?php if($itens): ?>
                        <?php foreach($itens as $item) :?>
                            <div class="portais-sistemas">
                                <a href="<?= $item['url']; ?>" class="no-external"><img src="<?= $item['icone']['url']; ?>" alt="<?= $item['icone']['alt']; ?>" srcset=""></a>
                                <h3><a href="<?= $item['url']; ?>" class="no-external"><?= $item['titulo']; ?></a></h3>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .portais .slick-arrow,
    .portais .portais-sistemas h3 a{
        color: <?= $cor; ?>;
    }
</style>


<?php
// Portais e Sistemas
wp_register_script('slick',  STM_THEME_URL . 'classes/assets/js/slick.js', array ('jquery'), false, false);
wp_enqueue_script('slick');

if($estilo == 'padrao') {
    $nav_left = '<span class="slick-arrow arrow-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>';
    $nav_right = '<span class="slick-arrow arrow-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>';
} else {
    $nav_left = '<span class="slick-arrow arrow-left"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>';
    $nav_right = '<span class="slick-arrow arrow-right"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></span>';
}
?>

<script>
    var $s = jQuery.noConflict();
    $s(document).ready(function(){
        $s('.portais').slick({
            slidesToShow: <?= $colunas; ?>,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            prevArrow:'<?= $nav_left; ?>',
            nextArrow:'<?= $nav_right; ?>',
            responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
        });
    });
</script>