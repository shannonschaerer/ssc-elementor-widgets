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
class ElementorSscTimelineWidget extends \Elementor\Widget_Base {


    public function get_style_depends() {
        return [ 'tailwind', 'widget-styles' ];
    }

    public function get_name() {
        return 'sscTimeline';
    }

    public function get_title() {
        return esc_html__( 'Timeline', 'elementor-ssc-timeline-widget' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_custom_help_url() {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    public function get_categories() {
        return [ 'general', 'site' ];
    }


    public function get_keywords() {
        return [ 'timeline', 'custom', 'lists' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'elementor-ssc-timeline-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'date',
            [
                'label' => esc_html__( 'Date', 'elementor-ssc-timeline-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'date', 'elementor-ssc-timeline-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elementor-ssc-timeline-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'title', 'elementor-ssc-timeline-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'location',
            [
                'label' => esc_html__( 'Location', 'elementor-ssc-timeline-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'location', 'elementor-ssc-timeline-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
            'responsibility',
            [
                'label' => esc_html__( 'Responsibility', 'elementor-ssc-timeline-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Responsible for the following: item #1, item #2.', 'elementor-ssc-timeline-widget' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        /* End repeater */

        $this->add_control(
            'responsibilities',
            [
                'label' => esc_html__( 'Responsibilities', 'elementor-ssc-timeline-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),           /* Use our repeater */
                'title_field' => '{{{ responsibility }}}',
            ]
        );


        $this->end_controls_section();


    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        ?>

        <div>
            <div class="mt-6 grid gap-8 grid-cols-timeline grid-rows-1">
                <div class="px-4 sm:px-0">
                    <span class="text-base leading-5 text-gray-900 uppercase"><?= $settings['date'] ?></span>
                </div>
                <div>
                    <div class="px-4 sm:px-0 mb-4">
                        <h3 class="text-base leading-5 text-gray-900 uppercase"><?= $settings['title'] ?></h3>
                        <span class="text-base text-gray-900"><?= $settings['location'] ?></span>
                    </div>
                    <?php if ($settings): ?>
                        <ul class="divide-y divide-gray-100 list-outside custom-list">
                            <?php foreach ( $settings['responsibilities'] as $item ): ?>
                                <li class="relative pl-4 text-sm"><?= $item['responsibility'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
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