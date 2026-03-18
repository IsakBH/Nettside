<?php
function afp_years_since_shortcode() {
    $start_date = new DateTime('2008-8-25');
    $current_date = new DateTime();
    $interval = $start_date->diff($current_date);
    return $interval->format('%y');
}

echo afp_years_since_shortcode();