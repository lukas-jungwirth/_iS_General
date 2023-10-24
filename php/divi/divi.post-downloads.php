<?php

class iS_Post_Downloads extends ET_Builder_Module
{
	function init()
	{
		$this->config = iS_File_Manager_Config::get_instance();
		$this->name = esc_html__("Post Downloads", $this->config->get("modulName"));
		$this->plural = esc_html__("Post Downloads", $this->config->get("modulName"));
		$this->slug = "et_pb_post_downloads";
		$this->vb_support = "on";
		$this->vb_support = "on";

		$this->settings_modal_toggles = array(
			"general" => array(
				"toggles" => array(
					"main_content" => et_builder_i18n("Text"),
				),
			),
			"advanced" => array(
				"toggles" => array(
					"text" => array(
						"title" => et_builder_i18n("Text"),
						"priority" => 45,
						"tabbed_subtoggles" => true,
						"bb_icons_support" => true,
						"sub_toggles" => array(
							"label" => array(
								"name" => "label",
								"icon" => "text-label",
							),
							"value" => array(
								"name" => "value",
								"icon" => "text-value",
							),
						),
					),
					"width" => array(
						"title" => et_builder_i18n("Sizing"),
						"priority" => 65,
					),
				),
			),
		); // settings_modal_toggles

		$this->main_css_element = '%%order_class%%';

		$this->advanced_fields = array(
			"margin_padding" => array(
				"css" => array(
					"important" => "all",
				),
			),
			"text" => array(
				"use_background_layout" => true,
				"sub_toggle" => "value",
				"options" => array(
					"text_orientation" => array(
						"default" => "left",
					),
					"background_layout" => array(
						"default" => "light",
						"hover" => "tabs",
					),
				),
			),
			"button" => false,
		);
	} // advanced_fields

	function get_fields()
	{
		$fields = array(
			'heading_markup' => array(
				'label' => esc_html__("Define heading type", $this->config->get("modulName")),
				'type' => 'select',
				'option_category' => 'basic_option',
				'options' => array(
					'h1' => "H1",
					'h2' => "H2",
					'h3' => "H3",
					'h4' => "H4",
					'h5' => "H5",
					'h6' => "H6"
				),
				'default_on_front' => 'h2',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_preview' => array(
				'label' => esc_html__("Display preview", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_file_icon' => array(
				'label' => esc_html__("Display File Icon", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_download_icon' => array(
				'label' => esc_html__("Display Download Icon", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_metadata' => array(
				'label' => esc_html__("Display Metadata", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'description' => esc_html__("Displays metadata like file size and file type", $this->config->get("modulName")),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_caption' => array(
				'label' => esc_html__("Display caption", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_date' => array(
				'label' => esc_html__("Display creation date", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'description' => esc_html__("Displays creation date of post", $this->config->get("modulName")),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			'display_copyright' => array(
				'label' => esc_html__("Display copyright", $this->config->get("modulName")),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => et_builder_i18n('No'),
					'on' => et_builder_i18n('Yes'),
				),
				'default_on_front' => 'on',
				'toggle_slug' => 'config',
				'mobile_options' => false,
			),
			"hide_above" => array(
				"label"             => esc_html__("Hide element, if empty", $this->config->get("modulName")),
				"type"              => "select",
				"default_on_front"  => "0",
				"options"           => array(
					"0"       => esc_html__("Don't hide", $this->config->get("modulName")),
					"module"  => esc_html__("This module", $this->config->get("modulName")),
					"column"  => esc_html__("Colum around module", $this->config->get("modulName")),
					"row"     => esc_html__("Row around module", $this->config->get("modulName")),
					"section" => esc_html__("Section around module", $this->config->get("modulName")),
				),
				"option_category"   => "basic_option",
				"toggle_slug"       => "config",
				"mobile_options"    => false,
				"hover"             => "tabs",
			),
		);

		return $fields;
	}

	protected function _render_module_wrapper($output = '', $render_slug = '')
	{
		return $output;
	} // _render_module_wrapper()

	public function render($attrs, $content, $render_slug)
	{

		$display_preview = $this->props['display_preview'];
		$display_file_icon = $this->props['display_file_icon'];
		$display_download_icon = $this->props['display_download_icon'];
		$display_metadata = $this->props['display_metadata'];
		$display_caption = $this->props['display_caption'];
		$display_date = $this->props['display_date'];
		$display_copyright = $this->props['display_caption'];
		$heading_markup = $this->props['heading'];
		$hide_above = $this->props["hide_above"];

		wp_enqueue_style("post_downloads_css", STYLESHEETURL."/".$this->config->get("modulName")."/css/post-downloads.min.css", array(), time());
		wp_enqueue_script("post_downloada_js", STYLESHEETURL."/".$this->config->get("modulName")."/js/post-downloads.min.js", array("jquery"), time(), true);

		$download_files = rwmb_meta("file");
		$file_urls = array();
		foreach ($download_files as $file) {
			if (!empty($file["url"])) {
				$file_urls[] = $file["url"];
			}
		}

		//render download module by shortcode
		$fileClass = new iS_File_Single();

		$files = array();

		for ($i = 0; $i < sizeof($file_urls); $i++) {
			$fileOutput = $fileClass->renderShortcode(
				array(
					"url" => $file_urls[$i],
					"expand" => $expand == "on" ? true : false,
					"heading" => $heading_markup,
					"no-description" => $display_caption == "off" ? true : false,
					"no-date" => $display_date == "off" ? true : false,
					"no-metadata" => $display_metadata == "off" ? true : false,
					"no-download-icon" => $display_download_icon == "off" ? true : false,
					"no-file-icon" => $display_file_icon == "off" ? true : false,
					"no-preview" => $display_preview == "off" ? true : false,
					"no-copyright" => $display_copyright == "off" ? true : false,
				),
			);
			
			$files[] = $fileOutput;
		}

		$output = sprintf(
			'<div class="is_post_downloads %4$s" data-hide="%5$s">
				%1$s
				%2$s
				%3$s
			</div>',
			!empty($file_urls[0]) ? $files[0] : "", // 1
			!empty($file_urls[1]) ? $files[1] : "", // 2
			!empty($file_urls[2]) ? $files[2] : "", // 3
			empty($file_urls) ? "empty" : "", // 4
			$hide_above, // 5
		);

	
		return $output;
	} // render()

} // iS_Post_Downloads()

new iS_Post_Downloads();