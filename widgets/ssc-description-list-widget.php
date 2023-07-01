<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Pricing Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class ElementorSscDescriptionListWidget extends \Elementor\Widget_Base {


    public function get_style_depends() {
        return [ 'tailwind' ];
    }

    public function get_name() {
        return 'sscDescriptionList';
    }

    public function get_title() {
        return esc_html__( 'Description List', 'elementor-ssc-description-list-widget' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_custom_help_url() {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    public function get_categories() {
        return [ 'general', 'site' ];
    }


    public function get_keywords() {
        return [ 'description list', 'custom', 'lists', 'description' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'elementor-ssc-description-list-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elementor-ssc-description-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'title', 'elementor-ssc-description-list-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'term',
            [
                'label' => esc_html__( 'Term', 'elementor-ssc-description-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Term', 'elementor-ssc-description-list-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'elementor-ssc-description-list-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'This is a description.', 'elementor-ssc-description-list-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        /* End repeater */

        $this->add_control(
            'list_items',
            [
                'label' => esc_html__( 'List Items', 'elementor-ssc-description-list-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),           /* Use our repeater */
                'default' => [
                    [
                        'term' => esc_html__( 'Term #1', 'elementor-ssc-description-list-widget' ),
                        'description' => esc_html__( 'Description #1', 'elementor-ssc-description-list-widget' ),
                    ],
                    [
                        'term' => esc_html__( 'Term #2', 'elementor-ssc-description-list-widget' ),
                        'description' => esc_html__( 'Description #2', 'elementor-ssc-description-list-widget' ),
                    ],
                    [
                        'term' => esc_html__( 'Term #3', 'elementor-ssc-description-list-widget' ),
                        'description' => esc_html__( 'Description #3', 'elementor-ssc-description-list-widget' ),
                    ],
                ],
                'title_field' => '{{{ term }}}',
            ]
        );


        $this->end_controls_section();


    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        ?>

        <div>
            <div class="mt-6">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-normal leading-7 text-gray-900 uppercase"><?= $settings['title'] ?></h3>
                </div>
                <?php if ($settings): ?>
                <dl class="divide-y divide-gray-100">
                    <?php foreach ( $settings['list_items'] as $item ): ?>
                        <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900"><?= $item['term'] ?></dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $item['description'] ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <?php endif; ?>
            </div>
        </div>


        <?php

    }

    protected function getFiles() {
        $query_file_args = [
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'post_mime_type' => 'application/pdf',
            'posts_per_page' => - 1,
        ];

        $query_files = new WP_Query( $query_file_args );

        $files = [];
        foreach ( $query_files->posts as $file ) {
            $files[] = $file;
        }

        return $files;
    }

    protected function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824)
        {
            $bytes = floor(number_format($bytes / 1073741824, 2)) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = floor(number_format($bytes / 1048576, 2)) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = floor(number_format($bytes / 1024, 2)) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

}