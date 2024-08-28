<?php
/**
 * Plugin Name: Oodles Token Handler
 * Description: Handles storing and refreshing the access token.
 * Version: 1.0
 * Author: M Faisal Siddiqui
 */

// Function to call the API and store the access token

// Register settings
// Include the settings page file
require_once plugin_dir_path(__FILE__) . 'settings-page.php';

// Define constants using options
define('OODLES_API_BASEURL', get_option('OODLES_API_BASEURL'));
define('OODLES_CLIENT_ID', get_option('OODLES_CLIENT_ID'));
define('OODLES_CLIENT_SECRET', get_option('OODLES_CLIENT_SECRET'));

// Add a "Settings" link to the plugin actions in the plugin list
function oodles_token_handler_plugin_action_links($links) {
    $settings_link = '<a href="options-general.php?page=oodles-token-handler">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'oodles_token_handler_plugin_action_links');

function oodles_token_handler_add_admin_menu() {
    add_options_page(
        'Oodles Token Handler', // Page title
        'Oodles Token Handler', // Menu title
        'manage_options', // Capability
        'oodles-token-handler', // Menu slug
        'oodles_token_handler_settings_page' // Callback function
    );
}
add_action('admin_menu', 'oodles_token_handler_add_admin_menu');

function oodles_token_handler_register_settings() {
    // Register the settings
    register_setting('oodles_token_handler_settings_group', 'OODLES_API_BASEURL');
    register_setting('oodles_token_handler_settings_group', 'OODLES_CLIENT_ID');
    register_setting('oodles_token_handler_settings_group', 'OODLES_CLIENT_SECRET');

    // Add settings section
    add_settings_section(
        'oodles_token_handler_section',
        'API Settings',
        'oodles_token_handler_section_callback',
        'oodles_token_handler_settings'
    );

    // Add settings fields
    add_settings_field(
        'oodles_api_baseurl',
        'API Base URL',
        'oodles_token_handler_text_field_callback',
        'oodles_token_handler_settings',
        'oodles_token_handler_section',
        array(
            'label_for' => 'OODLES_API_BASEURL',
            'name' => 'OODLES_API_BASEURL'
        )
    );

    add_settings_field(
        'oodles_client_id',
        'Client ID',
        'oodles_token_handler_text_field_callback',
        'oodles_token_handler_settings',
        'oodles_token_handler_section',
        array(
            'label_for' => 'OODLES_CLIENT_ID',
            'name' => 'OODLES_CLIENT_ID'
        )
    );

    add_settings_field(
        'oodles_client_secret',
        'Client Secret',
        'oodles_token_handler_text_field_callback',
        'oodles_token_handler_settings',
        'oodles_token_handler_section',
        array(
            'label_for' => 'OODLES_CLIENT_SECRET',
            'name' => 'OODLES_CLIENT_SECRET'
        )
    );
}
add_action('admin_init', 'oodles_token_handler_register_settings');

// Section callback
function oodles_token_handler_section_callback() {
    echo '<p>Enter your API details below:</p>';
}

// Field callback
function oodles_token_handler_text_field_callback($args) {
    $option = get_option($args['name']);
    echo '<input type="text" id="' . esc_attr($args['name']) . '" name="' . esc_attr($args['name']) . '" value="' . esc_attr($option) . '" class="regular-text">';
}

// Register settings page end here


function fetch_and_store_access_token() {
    $api_url = OODLES_API_BASEURL.'oauth/token'; //'http://127.0.0.1:8000/oauth/token'; // Replace with your API URL

    $body = array(
        'grant_type' => 'client_credentials',
        'client_id' => OODLES_CLIENT_ID, //'8', // Replace with your client_id
        'client_secret' => OODLES_CLIENT_SECRET, // '0FG3RUDxydjyD5aDsQaCFx01lcpmCmkYf9gkonWL' // Replace with your client_secret
    );

    $response = wp_remote_post($api_url, array(
        'body' => $body
    ));

    if (is_wp_error($response)) {
        // Handle error
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['access_token']) && isset($data['expires_in'])) {
        $access_token = $data['access_token'];
        $expires_in = $data['expires_in'];
        $expiration_time = time() + $expires_in; // Calculate the expiration timestamp

        // Store the access token and expiration time in the options table
        update_option('custom_access_token', $access_token);
        update_option('custom_access_token_expiration', $expiration_time);
    }
}

// Function to retrieve the access token
function get_access_token() {
    $access_token = get_option('custom_access_token');
    $expiration_time = get_option('custom_access_token_expiration');

    // Check if the token is expired
    if (time() > $expiration_time) {
        fetch_and_store_access_token();
        $access_token = get_option('custom_access_token');
    }

    return $access_token;
}

// Schedule an event to refresh the token daily
function schedule_token_refresh() {
    if (!wp_next_scheduled('refresh_access_token_event')) {
        wp_schedule_event(time(), 'daily', 'refresh_access_token_event');
    }
}
add_action('wp', 'schedule_token_refresh');

function refresh_access_token() {
    fetch_and_store_access_token();
}
add_action('refresh_access_token_event', 'refresh_access_token');

//--------------------------------------------------------------------------------
//create a short code for nonce filed for ajax securty that will be used inside form



//----------------------------------------------------------------
/// Function to make authenticated API request
function api_get_franchise() {
    
    $api_url = OODLES_API_BASEURL.'api/getfranchise';
    //$api_url = 'http://127.0.0.1:8000/api/getfranchise'; // Replace with your API endpoint

    $access_token = get_access_token();
    

    if (!$access_token) {
        // Handle error: Unable to retrieve access token
        error_log('No Access token to get franchise');
        return;
    }

    $response = wp_remote_get($api_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $access_token,
        ),
    ));
    
    

    if (is_wp_error($response)) {
        error_log('API Request Error: ' . $response->get_error_message());
        // Optionally, you can log more details such as error codes or additional data:
        // error_log('API Request Error Details: ' . print_r($response, true));
        return;
    }
    //$response['body']['access_token'] = $access_token;
    $body = wp_remote_retrieve_body($response);
    //$access_token= array('access_token' => $access_token);
    $data = json_decode($body, true);

     // Check if the data is valid.
     if (json_last_error() !== JSON_ERROR_NONE) {
        return wp_send_json_error('The API response is not a valid JSON.');
    }


    //$data ['access_token']=$access_token;

    $response_data = array(
        'data' => $data,
        'access_token' => $access_token
    );
    //$body = array_merge($access_token, $body);
    
    return wp_send_json_success( $response_data);
}


function my_ajax_access_token() {
      // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'custom-ajax-nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    $response_data = get_access_token();

    // Send response back to JavaScript
    wp_send_json_success($response_data);

    // End AJAX request
    wp_die();

}
add_action( 'wp_ajax_access_token', 'my_ajax_access_token' );
add_action( 'wp_ajax_nopriv_access_token', 'my_ajax_access_token' );

function my_ajax_get_franchise() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'custom-ajax-nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }
    // Make your response and echo it.
    $response_data = api_get_franchise();
    // Don't forget to stop execution afterward.
    wp_die();
}
add_action( 'wp_ajax_get_franchise', 'my_ajax_get_franchise' );
add_action( 'wp_ajax_nopriv_get_franchise', 'my_ajax_get_franchise' );


function enqueue_custom_scripts() {
    // Enqueue your script
    wp_enqueue_script('custom-ajax-script', plugin_dir_url(__FILE__) . 'myscript.js', array('jquery'), null, true);

    // Localize the script with the appropriate URL for AJAX requests
    wp_localize_script('custom-ajax-script', 'customAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('custom-ajax-nonce'), // Create nonce for security
        
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');