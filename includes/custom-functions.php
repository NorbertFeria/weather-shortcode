<?php

/**
 * The file that defines Custom functions PART 2
 *
 *
 * @link       https://https://github.com/NorbertFeria
 * @since      1.0.0
 *
 * @package    Weather_Shortcode
 * @subpackage Weather_Shortcode/includes
 */

/**
 * Function that fetches data from api uses transient data for caching if caching is set on plugin settings.
 *
 * @since    1.0.0
 * @param      string    $url       Url from witch data will fetched.
 * @param      string    $cache_key    cache key of the data if data used to store and retrieve from cache.
 * @param      string    $expiration_time    expiration duration of cached data.
 */
function fetchFromAPI($url, $cache_key, $expiration_time = 3600) {
    //check if settings allow cached result
    $cache_results = get_option('cache_results')

    if($cache_results == 1){
        // Check if data is already cached
        $cached_data = get_transient($cache_key); 

        if ($cached_data) {
            return $cached_data; // Return cached data if available
        }
    }

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        error_log('API request failed: ' . $response->get_error_message()); // Log error message
        return false; // Error occurred, handle accordingly
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!$data) {
        error_log('Failed to parse JSON response'); // Log error message
        return false; // Unable to parse JSON, handle accordingly
    }

    if($cache_results == 1){
        // Cache the API response
        $cache_set = set_transient($cache_key, $data, $expiration_time); 
        if (!$cache_set) {
            error_log('Failed to set transient cache'); // Log error message
        }
    }

    return $data; // Return the API response as an array
}

?>