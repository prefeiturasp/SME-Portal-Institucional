<div class="container">
    <div class="row">
        <div class="col-12">
            <p>
                <?php
                    $texto = get_sub_field('texto');

                    if($texto)
                        echo $texto;

                    echo ' <time datetime="' . get_the_modified_time('Y-m-d') . '">' . get_the_modified_time('d/m/Y') . '</time>';
                ?>
            </p>
        </div>
    </div>
</div>
    