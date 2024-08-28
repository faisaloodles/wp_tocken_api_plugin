<?php
// settings-page.php

function oodles_token_handler_settings_page() {
    ?>
    <div class="wrap">
        <h1>Oodles Token Handler Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting
            settings_fields('oodles_token_handler_settings_group');

            // Output setting sections and their fields
            do_settings_sections('oodles_token_handler_settings');

            // Output save settings button
            submit_button();
            ?>
        </form>
        <p>This will create a token that expires after 15 minutes. All these settings are available in the CRM.</p>
    </div>
    <?php
}
