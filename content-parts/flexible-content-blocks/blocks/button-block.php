<?php
// Load values.
$buttonDefaultArray = array(
    'title' => 'Button Text Here',
    'url' => '#',
    'target' => '',
);

$buttonArray = get_sub_field('button_array') ?: $buttonDefaultArray;
$buttonColour = get_sub_field('button_colour');
$outlined = get_sub_field('button_outlined');
$buttonAlignment = get_sub_field('button_alignment') ?: 'button-left';
$blockEl = get_sub_field('convert_to_block_element');

if($blockEl) {
    $styles = 'style="display:block;"';
}
if($outlined) {
    $buttonColour .= ' button-outlined';
}

// Output
echo '<div class="fc-button-block '. $buttonAlignment .'" target="'. $buttonArray['target'] .'" '. $styles .'>';
    echo '<a class="button '. $buttonColour .'" href="'. $buttonArray['url'] .'" >'. $buttonArray['title'] .'</a>';
echo '</div>';  