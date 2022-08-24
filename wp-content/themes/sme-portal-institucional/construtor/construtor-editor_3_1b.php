<?php
$borda = get_sub_field('incluir_borda');
$class = '';
if($borda)
    $class = "bd-content";

echo '<div class="mt-3 mb-3 ' . $class . '">'.get_sub_field('fx_editor_2_2').'</div>';