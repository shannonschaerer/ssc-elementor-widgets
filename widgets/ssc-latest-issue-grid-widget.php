<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
use ElementorPro\Modules\QueryControl\Module as Module_Query;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Latest Issue Grid Widget.
 *
 * Elementor widget that inserts a grid containing content from the lateest issue into the page.
 *
 * @since 1.0.0
 */
class ElementorSscLatestIssueGridWidget extends Widget_Base {

    /**
     * @var \WP_Query
     */
    protected $query = null;


    public function get_query() {
        return $this->query;
    }

    public function get_query_name() {
        return $this->get_name();
    }

    public function query_posts() {
        $query_args = [
            'posts_per_page' => $this->get_posts_per_page_value(),
            'paged' => $this->get_current_page(),
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->query = $elementor_query->get_query( $this, $this->get_query_name(), $query_args, [] );
    }

    public function get_style_depends() {
        return [ '' ];
    }

    public function get_name() {
        return 'sscLatestIssueGrid';
    }

    public function get_title() {
        return esc_html__( 'Latest Issue Grid', 'elementor-ssc-latest-issue-grid-widget' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_custom_help_url() {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    public function get_categories() {
        return [ 'general', 'site' ];
    }


    public function get_keywords() {
        return [ 'custom', 'grid' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'textdomain' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Related::get_type(),
            [
                'name' => $this->get_name(),
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', //use the one from Layout section
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'textdomain' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'name' => 'title',
                'label' => esc_html__( 'Title', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_conditional',
            [
                'label' => esc_html__( 'Conditional', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::TEXT,

                'default' => $this->getValue(),
                'placeholder' => esc_html__( 'Conditions', 'textdomain' ),
                'condition' => [
                    'title!' => '',
                ]
            ]
        );



        $this->end_controls_section();

    }

    protected function render() {
        $this->query_posts();
        $query = $this->get_query();

        if ( ! $query->found_posts ) {
            return;
        }

        // It's the global `wp_query` it self. and the loop was started from the theme.
        if ( $query->in_the_loop ) {
            //$this->current_permalink = get_permalink();
            //$this->render_post();
            echo 'in da loop';
        } else {

            while ( $query->have_posts() ) {
                $query->the_post();

                //$this->current_permalink = get_permalink();
                $this->render_post();
            }
        }

        wp_reset_postdata();
        $settings = $this->get_settings_for_display();
        $controls = $this->get_controls('title');
        $other = $this->get_settings('title');
        echo '<pre>';
        //var_dump($query);

        echo '</pre>';
        ?>

        <?php
        $args = array(
            'taxonomy'               => 'details',
        );
        $the_query = new WP_Term_Query($args);

        foreach ($the_query->get_terms() as $term) { ?>
            <?php //echo $term->name; ?>

        <?php } ?>


<!--        <div>-->
<!--            <div class="mt-6">-->
<!--                --><?php //if ($settings): ?>
<!--                    <dl class="divide-y divide-gray-100">-->
<!--                        --><?php //foreach ( $settings['list_items'] as $item ): ?>
<!--                            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">-->
<!--                                <dt class="text-sm font-medium leading-6 text-gray-900">--><?php //= $item['term'] ?><!--</dt>-->
<!--                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">--><?php //= $item['description'] ?><!--</dd>-->
<!--                            </div>-->
<!--                        --><?php //endforeach; ?>
<!--                    </dl>-->
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--        </div>-->


        <?php

    }

    private function getValue() {
        return 'hello';
        return $this->get_settings_for_display()['title'];
    }
    private function ssc_latest_issue_grid_get_issue( $post_type ) {
        $args = array(
        'taxonomy'               => 'details',
        );
        $the_query = new WP_Term_Query($args);

        $options = [];

        foreach ($the_query->get_terms() as $term) {
            $options[$term->slug] = $term->name;
        }

        return $options ?? [];
    }

    protected function get_posts_per_page_value() {
        return 'hello';
        return $this->get_current_skin()->get_instance_value( 'posts_per_page' );
    }

    public function get_current_page() {
        if ( '' === $this->get_settings_for_display( 'pagination_type' ) ) {
            return 1;
        }

        return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
    }


    protected function render_post() {
        the_title('<h3>', '</h3>');
        the_content();
//        $this->render_post_header();
//        $this->render_thumbnail();
//        $this->render_text_header();
//        $this->render_title();
//        $this->render_meta_data();
//        $this->render_excerpt();
//        $this->render_read_more();
//        $this->render_text_footer();
//        $this->render_post_footer();
    }

}
