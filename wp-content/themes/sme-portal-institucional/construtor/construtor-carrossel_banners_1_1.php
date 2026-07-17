<div class="container my-4">
    <?php if ( have_rows( 'banners' ) ) : ?>
        <div class="banner-slider">
            <?php
            while ( have_rows( 'banners' ) ) :
                the_row();

                $desktop = get_sub_field( 'imagem' );
                $mobile = get_sub_field( 'imagem_mobile' );
                $url = get_sub_field( 'url' );

                if ( !$desktop ) {
                    continue;
                }
                ?>

                <div class="banner-slider__item">

                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>">
                    <?php endif; ?>

                    <picture>
                        <?php if ( $mobile ) : ?>
                            <source
                                media="(max-width: 767px)"
                                srcset="<?php echo esc_url( $mobile['url'] ); ?>"
                            >
                        <?php endif; ?>

                        <img
                            class="img-fluid w-100"
                            src="<?php echo esc_url( $desktop['url'] ); ?>"
                            alt="<?php echo esc_attr( $desktop['alt'] ); ?>"
                        >
                    </picture>

                    <?php if ($url) : ?>
                        </a>
                    <?php endif; ?>

                </div>
                <?php
            endwhile;
            ?>
        </div>
    <?php endif; ?>
</div>

<script>
    jQuery(function ($) {
        $('.banner-slider').slick({
            slidesToShow: 1,
            dots: false,
            autoplay: true,
            autoplaySpeed: 10000,
            prevArrow:'<i class="fa fa-angle-left slider-slick-prev" aria-hidden="true"></i>',
            nextArrow:'<i class="fa fa-angle-right slider-slick-next" aria-hidden="true"></i>',
        });
    })
</script>