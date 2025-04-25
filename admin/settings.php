<div class="wrap">
    <h1>Robown Coming Soon Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('robown_cs_settings');
        $options = get_option('robown_cs_settings');
        ?>
        
        <table class="form-table">
            <tr>
                <th scope="row">Enable Coming Soon Page</th>
                <td>
                    <input type="checkbox" name="robown_cs_settings[enable_coming_soon]" 
                           value="1" <?php checked(1, $options['enable_coming_soon']); ?>>
                </td>
            </tr>
            
            <tr>
                <th scope="row">Site Title</th>
                <td>
                    <input type="text" name="robown_cs_settings[site_title]" 
                           value="<?php echo esc_attr($options['site_title']); ?>" class="regular-text">
                </td>
            </tr>
            
            <tr>
                <th scope="row">Heading</th>
                <td>
                    <input type="text" name="robown_cs_settings[heading]" 
                           value="<?php echo esc_attr($options['heading']); ?>" class="regular-text">
                </td>
            </tr>
            
            <tr>
                <th scope="row">Description</th>
                <td>
                    <textarea name="robown_cs_settings[description]" rows="5" 
                              class="large-text"><?php echo esc_textarea($options['description']); ?></textarea>
                </td>
            </tr>
            
            <tr>
                <th scope="row">Launch Date</th>
                <td>
                    <input type="date" name="robown_cs_settings[launch_date]" 
                           value="<?php echo esc_attr($options['launch_date']); ?>">
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div> 