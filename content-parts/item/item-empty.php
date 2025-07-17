<?php
$args = wp_parse_args(
    $args,
    array(
        'error_icon' => '<i class="fa-solid fa-triangle-exclamation fa-3x"></i>',
        'error_message' => 'Sorry, it looks like there are no posts that match your criteria.',
    )
);
$errorIcon = $args['error_icon'];
$errorMessage = $args['error_message'];

echo '<div class="content-error content-box">';
    echo $errorIcon;
    echo '<p>'.$errorMessage.'</p>';
echo '</div>';
