<?php
//adds copyright and copyright style field to media library

class iS_General_Copyright {
	public $config = null;

	public function __construct() {
		$this->config = iS_General_Config::get_instance();

		add_filter("attachment_fields_to_save", array($this, "add_copyright_field_to_media_uploader_save"), null, 2);
		add_filter("attachment_fields_to_edit", array($this, "add_copyright_field_to_media_uploader"), null, 2);

		add_filter("media_send_to_editor", array($this, "add_copyright_media_send_to_editor"), 10, 3);
		//add_filter("the_content", array($this, "show_copyright_html"));

	} // __construct()

	// public function be_enqueue_scripts() {
	// 	if(strstr($_SERVER["REQUEST_URI"], "upload.php") === false) { // in media lib buggy
	// 		add_action("wp_enqueue_media", array($this, "add_copyright_enqueue_media"), 11);
	// 	}
	// 	wp_register_script("copyright_be_js", STYLESHEETURL . "/".$this->config->get("modulName")."/js/copyright.backend.js", array("jquery"), time(), true);
	// 	wp_enqueue_script("copyright_be_js");
	// } // be_enqueue_scripts()


	function add_gallery_settings($fields) {
		return $this->add_copyright_fields($fields, "main_content");
	} // add_gallery_settings()

	function add_image_settings($fields) {
		return $this->add_copyright_fields($fields, "main_content");
	} // add_image_settings()

	function add_post_title_settings($fields) {
		return $this->add_copyright_fields($fields, "elements");
	} // add_post_title_settings()

	function add_copyright_fields($fields, $slug) {
		$fields["show_copyright"] = array(
			"label"             => esc_html__("Show copyright", $this->config->get("modulName")),
			"type"              => "yes_no_button",
			"option_category"   => "color_option",
			"options"           => array(
				"off" => esc_html__("No", "et_builder"),
				"on"  => esc_html__("Yes", "et_builder"),
			),
			"default_on_front"  => "on",
			"toggle_slug"       => $slug,
			"affects" => array(
				"copyright_style",
			),
		);
		$fields["copyright_style"] = array(
			"label"            => esc_html__("Copyrighs font style (fallback)", $this->config->get("modulName")),
			"description"      => esc_html__("Fallback if nothing is set on image.", $this->config->get("modulName")),
			"type"             => "select",
			"option_category"  => "basic_option",
			"options"          => array(
				"light"   => esc_html__("light", $this->config->get("modulName")),
				"dark"    => esc_html__("dark", $this->config->get("modulName")),
			),
			"toggle_slug"      => $slug,
			"default_on_front" => "light",
			"depends_show_if"  => "on",
		);

		return $fields;
	} // add_copyright_fields()
	function add_copyright_field_to_media_uploader($form_fields, $post) {
		$form_fields["copyright_field"] = array(
			"label" => __("Copyright"),
			"value" => get_post_meta($post->ID, "_custom_copyright", true),
			"helps" => "Set a copyright credit for the attachment"
		);

		$value = get_post_meta($post->ID, "_copyright_style", true);
		$form_fields["copyright_style"] = array(
			"label" => esc_html__("Copyright style", $this->config->get("modulName")),
			"input" => "html",
			"html"  => '<select name="attachments['.$post->ID.'][copyright_style]" id="attachments['.$post->ID.'][copyright_style]">
				<option value="">'.esc_html__("-", $this->config->get("modulName")).'</option>
				<option value="light" '.($value == "light" ? "selected" : "").'>'.esc_html__("light", $this->config->get("modulName")).'</option>
				<option value="dark" '.($value == "dark" ? "selected" : "").'>'.esc_html__("dark", $this->config->get("modulName")).'</option>
			</select>',
		);

		return $form_fields;
	} // add_copyright_field_to_media_uploader()

	function add_copyright_field_to_media_uploader_save($post, $attachment) {
		if (!empty($attachment["copyright_field"])) {
			update_post_meta($post["ID"], "_custom_copyright", $attachment["copyright_field"]);
		} else {
			delete_post_meta($post["ID"], "_custom_copyright");
		}

		if (!empty($attachment["copyright_style"]) && $attachment["copyright_style"] != "") {
			update_post_meta($post["ID"], "_copyright_style", $attachment["copyright_style"]);
		} else {
			delete_post_meta($post["ID"], "_copyright_style");
		}

		return $post;
	} // add_copyright_field_to_media_uploader_save()

	function add_copyright_enqueue_media() {
		?>
		<script type="text/html" id="tmpl-attachment-display-settings_copyright">
        <h2><?php _e('Attachment Display Settings'); ?></h2>

        <# if ('image' === data.type) { #>
            <label class="setting">
                <span><?php _e('Alignment'); ?></span>
                <select class="alignment"
                    data-setting="align"
                    <# if (data.userSettings) { #>
                        data-user-setting="align"
                    <# } #>>

                    <option value="left">
                        <?php esc_html_e('Left'); ?>
                    </option>
                    <option value="center">
                        <?php esc_html_e('Center'); ?>
                    </option>
                    <option value="right">
                        <?php esc_html_e('Right'); ?>
                    </option>
                    <option value="none" selected>
                        <?php esc_html_e('None'); ?>
                    </option>
                </select>
            </label>
        <# } console.log(data); #>

        <div class="setting">
            <label>
                <# if (data.model.canEmbed) { #>
                    <span><?php _e('Embed or Link'); ?></span>
                <# } else { #>
                    <span><?php _e('Link To'); ?></span>
                <# } #>

                <select class="link-to"
                    data-setting="link"
                    <# if (data.userSettings && ! data.model.canEmbed) { #>
                        data-user-setting="urlbutton"
                    <# } #>>

                <# if (data.model.canEmbed) { #>
                    <option value="embed" selected>
                        <?php esc_html_e('Embed Media Player'); ?>
                    </option>
                    <option value="file">
                <# } else { #>
                    <option value="none" selected>
                        <?php esc_html_e('None'); ?>
                    </option>
                    <option value="file">
                <# } #>
                    <# if (data.model.canEmbed) { #>
                        <?php esc_html_e('Link to Media File'); ?>
                    <# } else { #>
                        <?php esc_html_e('Media File'); ?>
                    <# } #>
                    </option>
                    <option value="post">
                    <# if (data.model.canEmbed) { #>
                        <?php esc_html_e('Link to Attachment Page'); ?>
                    <# } else { #>
                        <?php esc_html_e('Attachment Page'); ?>
                    <# } #>
                    </option>
                <# if ('image' === data.type) { #>
                    <option value="custom">
                        <?php esc_html_e('Custom URL'); ?>
                    </option>
                <# } #>
                </select>
            </label>
            <input type="text" class="link-to-custom" data-setting="linkUrl" />
        </div>

        <# if (data.type == 'image' && 'undefined' !== typeof data.sizes) { #>
            <label class="setting">
                <span><?php _e('Size'); ?></span>
                <select class="size" name="size"
                    data-setting="size"
                    <# if (data.userSettings) { #>
                        data-user-setting="imgsize"
                    <# } #>>
                    <?php
                    /** This filter is documented in wp-admin/includes/media.php */
                    $sizes = apply_filters('image_size_names_choose', array(
                        'thumbnail' => __('Thumbnail'),
                        'medium'    => __('Medium'),
                        'large'     => __('Large'),
                        'full'      => __('Full Size'),
                   ));

                    foreach ($sizes as $value => $name) : ?>
                        <#
                        var size = data.sizes['<?php echo esc_js($value); ?>'];
                        if (size) { #>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($value, 'full'); ?>>
                                <?php echo esc_html($name); ?> &ndash; {{ size.width }} &times; {{ size.height }}
                            </option>
                        <# } #>
                    <?php endforeach; ?>
                </select>
            </label>
        <# } #>


        <# if(data.type == 'image') { #>
            <label class="setting">
                <span><?php _e("Hide copyright", 'yourtxtdomain'); ?></span>
                <input class="alignment"
                    data-setting="copyright"
                    <# if (data.userSettings) { #>
                        data-user-setting="copyright"
                    <# } #>
                    type="checkbox"
                    name="copyright"
                    value="yes"
                />
            </label>
        <# } #>
    </script>
		<?php
	} // add_copyright_enqueue_media()

	function add_copyright_media_send_to_editor($html, $id, $attachment) {
		if(!isset($attachment["copyright"]) || $attachment["copyright"] != true) {
			$copyright = 'data-copyright-id="'.$id.'"';

			return str_replace("img ", "img ".$copyright." ", $html);
		}

		return $html;
	} // add_copyright_media_send_to_editor()
} // iS_General_Copyright()
