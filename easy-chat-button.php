<?php
/*
Plugin Name: Easy Chat Button
Description: Easy WhatsApp Button te permite agregar un botón flotante de WhatsApp en tu sitio web para que los visitantes puedan contactarte fácilmente a través de WhatsApp.
Version: 1.0
Author: MXideas
Author URI: https://mxideas.com/
*/

function easy_chat_button_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Configuración de Easy Chat Button</h1>
        <p>Aquí puedes ajustar las opciones y configuraciones relacionadas con el boton flotante de WhatsApp.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('easy_chat_button_options'); ?>
            <?php do_settings_sections('easy_chat_button_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Número de teléfono</th>
                    <td>
                        <input type="text" name="easy_chat_phone_number" value="<?php echo esc_attr(get_option('easy_chat_phone_number')); ?>" />


                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Mensaje predeterminado</th>
                    <td>
                        <textarea cols="40" rows="5" name="easy_chat_default_message"><?php echo esc_textarea(get_option('easy_chat_default_message')); ?></textarea>

                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Tamaño del botón en px</th>
                    <td>
                        <input type="number" name="easy_chat_button_size" value="<?php echo esc_attr(get_option('easy_chat_button_size')); ?>" min="1" step="1" />
                    </td>
                </tr>               
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function easy_chat_button_register_settings() {
    register_setting('easy_chat_button_options', 'easy_chat_default_message');
    register_setting('easy_chat_button_options', 'easy_chat_phone_number');
    register_setting('easy_chat_button_options', 'easy_chat_button_size');
}
add_action('admin_init', 'easy_chat_button_register_settings');

function easy_chat_button_plugin_menu() {
    add_submenu_page(
        'options-general.php',
        'Easy Chat Button Plugin',
        'Easy Chat Button',
        'manage_options',
        'easy_chat-button-settings',
        'easy_chat_button_plugin_settings_page'
    );
}
add_action('admin_menu', 'easy_chat_button_plugin_menu');

function easy_chat_button_enqueue_styles() {
    wp_enqueue_style('easy_chat-button-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'easy_chat_button_enqueue_styles');

function easy_chat_button_enqueue_scripts() {
    wp_enqueue_script('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js', array(), '5.15.4', false);
}
add_action('wp_enqueue_scripts', 'easy_chat_button_enqueue_scripts');

function easy_chat_button_add_button() {
    $phone_number = get_option('easy_chat_phone_number');
    $default_message = get_option('easy_chat_default_message');
    ?>
    <div id="easy_chat-button">
        <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($phone_number); ?>&text=<?php echo esc_attr(urlencode($default_message)); ?>" target="_blank">    
            <i style="color: #25D366; font-size: <?php echo esc_attr(get_option('easy_chat_button_size')); ?>px;" class="fas fa-comments"></i>
        </a>
    </div>
    <?php
}
add_action('wp_footer', 'easy_chat_button_add_button');