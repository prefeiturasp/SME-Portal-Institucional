<?php
if( ! function_exists( 'better_commets' ) ):
function better_commets($comment, $args, $depth) {
    ?>
    <div <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="container listing" style="display: none;">
            <div class="comment row d-none d-sm-block">
                <div class="thumbnail-comment col-1 p-0">
                    <div class="min-block">
                            <?php
                                $apelido = get_comment_author_url( get_comment_ID() );
                                $autor = get_comment( get_comment_ID() )->user_id;
                                $imagem = get_field('imagem', 'user_' . $autor);
                                
                                if($apelido && !$autor){
                                    $apelido = str_replace('http://', '', $apelido);
                                    echo "<p>" . $apelido[0] . "</p>";
                                } elseif($autor > 0 && $imagem){
                                    $image_attributes = wp_get_attachment_image_src( $imagem, 'thumbnail' );
                                    if($image_attributes[0]){
                                        echo "<img src='" . $image_attributes[0] . "'>";
                                    }
                                } elseif($autor > 0){
                                    $display_name = get_user_by( 'id', $autor )->display_name ;
                                    echo "<p>" . $display_name[0] . "</p>";
                                } else {
                                    $display_name = get_comment_author();
                                    echo "<p>" . $display_name[0] . "</p>";
                                }
                            ?>
                    </div>
                </div>
                <div class="comment-block col-11">
                    <div class="comment-arrow"></div>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.','5balloons_theme') ?></em>
                            <br />
                        <?php endif; ?>
                        <span class="comment-by">
                            <?php
                                $apelido = get_comment_author_url( get_comment_ID() );
                                $autor = get_comment( get_comment_ID() )->user_id;
                                if($apelido && !$autor){
                                    $apelido = str_replace('http://', '', $apelido);
                                    echo '<span class="autor-name">' . $apelido . '</span> (' . get_comment_author() . ')';
                                } elseif($autor > 0){
                                    $display_name = get_user_by( 'id', $autor )->display_name ;
                                    echo '<span class="autor-name">' . $display_name . '</span>';
                                } else {
                                    echo '<span class="autor-name">' . get_comment_author() . '</span>';
                                }
                            ?>
                            
                        </span>
                        <?php comment_text() ?>
                </div>
            </div>

            <div class="comment row d-flex d-sm-none">
                <div class="thumbnail-comment col-2 p-0">
                    <div class="min-block">
                            <?php
                                $apelido = get_comment_author_url( get_comment_ID() );
                                $autor = get_comment( get_comment_ID() )->user_id;
                                $imagem = get_field('imagem', 'user_' . $autor);
                                
                                if($apelido && !$autor){
                                    $apelido = str_replace('http://', '', $apelido);
                                    echo "<p>" . $apelido[0] . "</p>";
                                } elseif($autor > 0 && $imagem){
                                    $image_attributes = wp_get_attachment_image_src( $imagem, 'thumbnail' );
                                    if($image_attributes[0]){
                                        echo "<img src='" . $image_attributes[0] . "'>";
                                    }
                                } elseif($autor > 0){
                                    $display_name = get_user_by( 'id', $autor )->display_name ;
                                    echo "<p>" . $display_name[0] . "</p>";
                                } else {
                                    $display_name = get_comment_author();
                                    echo "<p>" . $display_name[0] . "</p>";
                                }
                            ?>
                    </div>
                </div>
                <div class="comment-block col-10 d-flex align-items-center">
                    <div class="comment-arrow"></div>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.','5balloons_theme') ?></em>
                            <br />
                        <?php endif; ?>
                        <span class="comment-by">
                            <?php
                                $apelido = get_comment_author_url( get_comment_ID() );
                                $autor = get_comment( get_comment_ID() )->user_id;
                                if($apelido && !$autor){
                                    $apelido = str_replace('http://', '', $apelido);
                                    echo '<span class="autor-name">' . $apelido . '</span> (' . get_comment_author() . ')';
                                } elseif($autor > 0){
                                    $display_name = get_user_by( 'id', $autor )->display_name ;
                                    echo '<span class="autor-name">' . $display_name . '</span>';
                                } else {
                                    echo '<span class="autor-name">' . get_comment_author() . '</span>';
                                }
                            ?>
                            
                        </span>
                        
                </div>

                <div class="comment-block col-12">
                    <?php comment_text() ?>
                </div>

            </div>
        </div>
    </div>
    
<?php
        }
endif;

?>