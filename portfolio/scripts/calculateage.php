<?php
function calculate_isak_age() {
    $start_date = new DateTime('2008-8-25');
    $current_date = new DateTime();
    $interval = $start_date->diff($current_date);
    return $interval->format('%y');
}