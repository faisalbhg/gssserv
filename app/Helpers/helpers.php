<?php

// app/Helpers/helpers.php

if (!function_exists('custom_round')) {
    function custom_round($number) {
        // Multiply by 4, round to nearest integer, then divide by 4
	    /*$rounded = round($number * 4) / 4;

	    // Ensure the result is either .25, .50, or .75 by comparing the remainder after division
	    $remainder = fmod($rounded, 1);  // Get the fractional part
	    
	    // Adjust the value based on the remainder
	    if ($remainder >= 0.75) {
	        return floor($rounded) + 0.75;
	    } elseif ($remainder >= 0.50) {
	        return floor($rounded) + 0.50;
	    } elseif ($remainder >= 0.25) {
	        return floor($rounded) + 0.25;
	    } else {
	        return floor($rounded);
	    }*/
	    return round($number,2);
    }
}