<?php
// Load values.
$titleText = get_sub_field('title_text');
$titleSize = get_sub_field('title_size') ?: 'h2';
$titleColour = get_sub_field('title_colour');

// Output
echo '<div class="fc-title-block">';
    echo '<' . $titleSize .' class="' . $titleColour .'">' . $titleText .'</' . $titleSize .'>';
echo '</div>';