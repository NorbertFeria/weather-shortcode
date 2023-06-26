<?php

/**
 * The file that defines Custom functions added on PART 2 
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
 * PART 2
 * @since    1.0.0
 * @param      string    $url       Url from witch data will fetched.
 * @param      string    $cache_key    cache key of the data if data used to store and retrieve from cache.
 * @param      string    $expiration_time    expiration duration of cached data.
 */
function fetchFromAPI($url, $cache_key, $expiration_time = 3600) {
    
    //check if settings allow cached result
    $cache_results = get_option('cache_results');

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
        set_transient($cache_key, $data, $expiration_time); 
        $cache_set = get_transient($cache_key);
        if (!$cache_set) {
            error_log('Failed to set transient cache'); // Log error message
        }
    }
    
    return $data; // Return the API response as an array
}


/**
 * Function that fetches data from api uses transient data for caching if caching is set on plugin settings.
 * Part 3
 * @since    1.0.0
 * @param      string    $temperatureKelvin       temperature in Kelvin.
 * @return     string    $temperatureCelsius      temperature in Celsius.
 * 
 */
function kelvinToCelsius($temperatureKelvin) {
    $temperatureCelsius = $temperatureKelvin - 273.15;
    return $temperatureCelsius;
}

/**
 * Function that fetches data from api uses transient data for caching if caching is set on plugin settings.
 * Part 3
 * @since    1.0.0
 * @param      string    $temperatureKelvin       temperature in Kelvin.
 * @return     string    $temperatureCelsius      temperature in Celsius.
 * 
 */
function fetchFromOpenWeatherMap($city){
    // get the api key from the settings.
    $apiKey = get_option('api_key');
    // construct the url for openweathermap.
    $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . urlencode($apiKey);
    // create a city slug to use as part of cache_key for transient 
    $cityslug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $city)));
    
    $cache_key = $cityslug."-"."weatherdata"; 

    // get the weather data form the fetchFromAPI function using the url and cache_key
    $weather_data = fetchFromAPI($url, $cache_key);

    // get individual data   
    $weather_desc =  $weather_data["weather"][0]["description"];
    $weather_min = kelvinToCelsius($weather_data["main"]["temp_min"]);
    $weather_max = kelvinToCelsius($weather_data["main"]["temp_max"]);
    $weather_wind_speed = $weather_data["wind"]["speed"];
    $weather_clouds = $weather_data["clouds"]["all"];
    $name = $weather_data["name"];
    $country = $weather_data["sys"]["country"];

    //construct the string from individual data.
    $sdstr = $name." ".$country."  ".$weather_desc." temperature from ".$weather_min." to ".$weather_max." wind ".$weather_wind_speed." m/s clouds ".$weather_clouds."%" ;

    return $sdstr; // return the string 
}

?>