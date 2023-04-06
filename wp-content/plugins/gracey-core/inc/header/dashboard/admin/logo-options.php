<?php

if ( ! function_exists( 'gracey_core_add_logo_options' ) ) {
    /**
     * Function that add general options for this module
     */
    function gracey_core_add_logo_options() {
        $qode_framework = qode_framework_get_framework_root();

        $page = $qode_framework->add_options_page(
            array(
                'scope'       => GRACEY_CORE_OPTIONS_NAME,
                'type'        => 'admin',
                'slug'        => 'logo',
                'icon'        => 'fa fa-cog',
                'title'       => esc_html__( 'Logo', 'gracey-core' ),
                'description' => esc_html__( 'Global Logo Options', 'gracey-core' ),
                'layout'      => 'tabbed',
            )
        );

        if ( $page ) {

            $header_tab = $page->add_tab_element(
                array(
                    'name'        => 'tab-header',
                    'icon'        => 'fa fa-cog',
                    'title'       => esc_html__( 'Header Logo Options', 'gracey-core' ),
                    'description' => esc_html__( 'Set options for initial headers', 'gracey-core' ),
                )
            );

            $header_tab->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_logo_height',
                    'title'       => esc_html__( 'Logo Height', 'gracey-core' ),
                    'description' => esc_html__( 'Enter logo height', 'gracey-core' ),
                    'args'        => array(
                        'suffix' => esc_html__( 'px', 'gracey-core' ),
                    ),
                )
            );

            $header_tab->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_logo_padding',
                    'title'       => esc_html__( 'Logo Padding', 'gracey-core' ),
                    'description' => esc_html__( 'Enter logo padding value (top right bottom left)', 'gracey-core' ),
                )
            );

            $header_tab->add_field_element(
                array(
                    'field_type'    => 'select',
                    'name'          => 'qodef_logo_source',
                    'title'         => esc_html__( 'Logo Source', 'gracey-core' ),
                    'options'       => array(
                        'image'    => esc_html__( 'Image', 'gracey-core' ),
                        'svg-path' => esc_html__( 'SVG Path', 'gracey-core' ),
                        'textual'  => esc_html__( 'Textual', 'gracey-core' ),
                    ),
                    'default_value' => 'image',
                )
            );

            $logo_image_section = $header_tab->add_section_element(
                array(
                    'title'      => esc_html__( 'Image settings', 'gracey-core' ),
                    'name'       => 'qodef_logo_image_section',
                    'dependency' => array(
                        'show' => array(
                            'qodef_logo_source' => array(
                                'values'        => 'image',
                                'default_value' => 'image',
                            ),
                        ),
                    ),
                )
            );

            $logo_image_section->add_field_element(
                array(
                    'field_type'    => 'image',
                    'name'          => 'qodef_logo_main',
                    'title'         => esc_html__( 'Logo - Main', 'gracey-core' ),
                    'description'   => esc_html__( 'Choose main logo image', 'gracey-core' ),
                    'default_value' => defined( 'GRACEY_ASSETS_ROOT' ) ? GRACEY_ASSETS_ROOT . '/img/logo.png' : '',
                    'multiple'      => 'no',
                )
            );

            $logo_image_section->add_field_element(
                array(
                    'field_type'  => 'image',
                    'name'        => 'qodef_logo_dark',
                    'title'       => esc_html__( 'Logo - Dark', 'gracey-core' ),
                    'description' => esc_html__( 'Choose dark logo image', 'gracey-core' ),
                    'multiple'    => 'no',
                )
            );

            $logo_image_section->add_field_element(
                array(
                    'field_type'  => 'image',
                    'name'        => 'qodef_logo_light',
                    'title'       => esc_html__( 'Logo - Light', 'gracey-core' ),
                    'description' => esc_html__( 'Choose light logo image', 'gracey-core' ),
                    'multiple'    => 'no',
                )
            );

            // Hook to include additional options after section part
            do_action( 'gracey_core_action_after_header_logo_image_section_options_map', $page, $header_tab, $logo_image_section );

            $logo_svg_path_section = $header_tab->add_section_element(
                array(
                    'title'      => esc_html__( 'SVG settings', 'gracey-core' ),
                    'name'       => 'qodef_logo_svg_path_section',
                    'dependency' => array(
                        'show' => array(
                            'qodef_logo_source' => array(
                                'values'        => 'svg-path',
                                'default_value' => 'image',
                            ),
                        ),
                    ),
                )
            );

            $logo_svg_path_section->add_field_element(
                array(
                    'field_type'  => 'textarea',
                    'name'        => 'qodef_logo_svg_path',
                    'title'       => esc_html__( 'Logo SVG Path', 'gracey-core' ),
                    'description' => esc_html__( 'Enter your logo icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'gracey-core' ),
                )
            );

            // Hook to include additional options before section part
            do_action( 'gracey_core_action_before_header_logo_svg_path_section_options_map', $page, $header_tab, $logo_svg_path_section );

            $logo_svg_path_section_row = $logo_svg_path_section->add_row_element(
                array(
                    'name'  => 'qodef_logo_svg_path_section_row',
                    'title' => esc_html__( 'SVG Styles', 'gracey-core' ),
                )
            );

            $logo_svg_path_section_row->add_field_element(
                array(
                    'field_type' => 'color',
                    'name'       => 'qodef_logo_svg_path_color',
                    'title'      => esc_html__( 'Color', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_svg_path_section_row->add_field_element(
                array(
                    'field_type' => 'color',
                    'name'       => 'qodef_logo_svg_path_hover_color',
                    'title'      => esc_html__( 'Hover Color', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_svg_path_section_row->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_logo_svg_path_size',
                    'title'      => esc_html__( 'SVG Icon Size', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            // Hook to include additional options after section part
            do_action( 'gracey_core_action_after_header_logo_svg_path_section_options_map', $page, $header_tab, $logo_svg_path_section );

            $logo_textual_section = $header_tab->add_section_element(
                array(
                    'title'      => esc_html__( 'Textual settings', 'gracey-core' ),
                    'name'       => 'qodef_logo_textual_section',
                    'dependency' => array(
                        'show' => array(
                            'qodef_logo_source' => array(
                                'values'        => 'textual',
                                'default_value' => 'image',
                            ),
                        ),
                    ),
                )
            );

            $logo_textual_section->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_logo_text',
                    'title'       => esc_html__( 'Logo Text', 'gracey-core' ),
                    'description' => esc_html__( 'Fill your text to be as Logo image', 'gracey-core' ),
                )
            );

            // Hook to include additional options before section part
            do_action( 'gracey_core_action_before_header_logo_textual_section_options_map', $page, $header_tab, $logo_textual_section );

            $logo_textual_section_row = $logo_textual_section->add_row_element(
                array(
                    'name'  => 'qodef_logo_textual_section_row',
                    'title' => esc_html__( 'Typography Styles', 'gracey-core' ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'color',
                    'name'       => 'qodef_logo_text_color',
                    'title'      => esc_html__( 'Color', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'color',
                    'name'       => 'qodef_logo_text_hover_color',
                    'title'      => esc_html__( 'Hover Color', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'font',
                    'name'       => 'qodef_logo_text_font_family',
                    'title'      => esc_html__( 'Font Family', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_logo_text_font_size',
                    'title'      => esc_html__( 'Font Size', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_logo_text_line_height',
                    'title'      => esc_html__( 'Line Height', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_logo_text_letter_spacing',
                    'title'      => esc_html__( 'Letter Spacing', 'gracey-core' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'select',
                    'name'       => 'qodef_logo_text_font_weight',
                    'title'      => esc_html__( 'Font Weight', 'gracey-core' ),
                    'options'    => gracey_core_get_select_type_options_pool( 'font_weight' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'select',
                    'name'       => 'qodef_logo_text_text_transform',
                    'title'      => esc_html__( 'Text Transform', 'gracey-core' ),
                    'options'    => gracey_core_get_select_type_options_pool( 'text_transform' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'select',
                    'name'       => 'qodef_logo_text_font_style',
                    'title'      => esc_html__( 'Font Style', 'gracey-core' ),
                    'options'    => gracey_core_get_select_type_options_pool( 'font_style' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'select',
                    'name'       => 'qodef_logo_text_text_decoration',
                    'title'      => esc_html__( 'Text Decoration', 'gracey-core' ),
                    'options'    => gracey_core_get_select_type_options_pool( 'text_decoration' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            $logo_textual_section_row->add_field_element(
                array(
                    'field_type' => 'select',
                    'name'       => 'qodef_logo_text_hover_text_decoration',
                    'title'      => esc_html__( 'Hover Text Decoration', 'gracey-core' ),
                    'options'    => gracey_core_get_select_type_options_pool( 'text_decoration' ),
                    'args'       => array(
                        'col_width' => 3,
                    ),
                )
            );

            // Hook to include additional options after section part
            do_action( 'gracey_core_action_after_header_logo_textual_section_options_map', $page, $header_tab, $logo_textual_section );

            // Hook to include additional options after module options
            do_action( 'gracey_core_action_after_header_logo_options_map', $page, $header_tab );
        }
    }

    add_action( 'gracey_core_action_default_options_init', 'gracey_core_add_logo_options', gracey_core_get_admin_options_map_position( 'logo' ) );
}
