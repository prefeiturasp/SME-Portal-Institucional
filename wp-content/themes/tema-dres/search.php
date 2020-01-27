<?php
/*use Classes\TemplateHierarchy\Search\GetTipoDePost;*/
get_header(); ?>
<!--new GetTipoDePost();-->
<?php
$searchfor = get_search_query(); // Get the search query for display in a headline
?>
<?php $query_string=esc_attr($query_string); // Escaping search queries to eliminate potential MySQL-injections
$blogs = get_blog_list( 0,'all' );
foreach ( $blogs as $blog ): switch_to_blog($blog['blog_id']);
    $search = new WP_Query($query_string);
    if ($search->found_posts>0) {
        foreach ( $search->posts as $post ) {
            setup_postdata($post);
            $author_data = get_userdata(get_the_author_meta('ID'));
            ?>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-sm-4 pb-4 border-bottom">
                        <?php
                        if (has_post_thumbnail()) {
                            echo '<figure class="">';
                            the_post_thumbnail('medium', array('class' => 'img-fluid rounded float-left'));
                            echo '</figure>';
                        }
                        ?>
                    </div>
                    <div class="col-sm-8 pb-4 border-bottom">
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <span><?php the_time('d/m/Y') ?></span>
                            por <?php the_author_posts_link();?>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div id="entry-content"><?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
endforeach;
restore_current_blog(); // Reset settings to the current blog
?>
<?php
get_footer()
?>