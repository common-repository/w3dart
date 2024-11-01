<?php
$w3dart_options = get_option('w3dart_options');
if (!isset($w3dart_options['w3dart_script_code'])) {
    $w3dart_script_code = "";
}
else{
    $w3dart_script_code = $w3dart_options['w3dart_script_code'];
}

if (!isset($w3dart_options['visible-for'])) {
    $w3dart_options['visible-for'] = "all";
}

if (!isset($w3dart_options['visible-for-roles'])) {
    $w3dart_options['visible-for-roles']=array();
}
if (!isset($w3dart_options['visible-for-backend'])) {
    $w3dart_options['visible-for-backend']="";
}
?>
<?php settings_errors(); ?>
<div class="w3dart-container">
    <div class="setting-title"><?php _e("Settings","w3dart");?></div>
    <form class="setting" action="options.php" id="w3-settings-form" method="post">
        <?php settings_fields( 'w3dart_options' ); ?>
        <div class="setting-row" data-type="all">
            <div class="setting-label"><?php _e("W3Dart Script Code","w3dart");?></div>
            <div class="setting-value">
                <textarea name="w3dart_options[w3dart_script_code]"><?php echo esc_attr($w3dart_script_code); ?></textarea>
            </div>
        </div>
        <div class="setting-row" data-type="all">
            <div class="setting-label"><?php _e("Enable W3Dart for","w3dart");?></div>
            <div class="setting-value">
                <label for="w3-visible-for-all">
			  	    <input type="radio" <?php echo esc_attr($w3dart_options['visible-for']=="all"?"checked":""); ?> name="w3dart_options[visible-for]" value="all" id="w3-visible-for-all"/> <span><?php _e("All Visitors","w3dart");?></span>
			    </label>
                <label for="w3-visible-for-users">
                    <input type="radio" <?php echo esc_attr($w3dart_options['visible-for']=="users"?"checked":""); ?> name="w3dart_options[visible-for]" value="users" id="w3-visible-for-users"/> <span><?php _e("Only users who are signed in","w3dart");?></span>
			    </label>
                <label for="w3-visible-for-roles">
                    <input type="radio" <?php echo esc_attr($w3dart_options['visible-for']=="roles"?"checked":""); ?> name="w3dart_options[visible-for]" value="roles" id="w3-visible-for-roles"/> <span><?php _e("Only users with a specific role","w3dart");?></span>
                </label>
            </div>
        </div>
        <div class="setting-row" data-type="all" id="w3-visible-roles">
            <div class="setting-value">
                <?php
                $wp_roles = new WP_Roles();
                $roles = $wp_roles->get_names();
                $ctn = 0;
                $check = false;
                foreach ($roles as $role_value => $role_name) {
                    foreach($w3dart_options['visible-for-roles'] as $lurole) {
                        $check = false;
                        if ($lurole === $role_value) {
                            $check = true;
                            break;
                        }
                    }
                    ?>
                    <p>
                        <input type="checkbox" <?php echo esc_attr($check?"checked":""); ?> name="w3dart_options[visible-for-roles][]" value="<?php echo esc_attr($role_value); ?>" id="w3-visible-for-role-<?php echo esc_attr($ctn);?>"/>
                        <label for="w3-visible-for-role-<?php echo esc_attr($ctn);?>"><?php echo esc_attr($role_name); ?></label>
                    </p>
                    <?php
                    $ctn++;
                }
                ?>
            </div>
        </div>  

        <div class="setting-row" data-type="all">
            <div class="setting-label"><?php _e("Visibility Settings","w3dart");?></div>
            <div class="setting-value">
                <input type="checkbox" <?php echo esc_attr($w3dart_options['visible-for-backend']=="backend"?"checked":""); ?> name="w3dart_options[visible-for-backend]" value="backend" id="w3-visible-for-backend"/>
				<label for="w3-visible-for-backend"><?php _e("Visible in Administration Backend","w3dart");?></label>
            </div>
        </div>

        <br>
        <button class="button button-primary" name="w3dart_save" id="save"><?php _e("Save","w3dart");?></button>
    </form>
</div>