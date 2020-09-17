<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://cias.imus.vn
 * @since      1.0.0
 *
 * @package    Cias
 * @subpackage Cias/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cias
 * @subpackage Cias/public
 * @author     PVD <d@gmail.com>
 */

class Aias_Shortcode{
    	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */

    public function __construct( ){
        add_shortcode('show_post', [&$this, 'show_post']);
        add_shortcode('show_post_footer', [&$this, 'show_post_footer']);
        add_shortcode('sidebar_post', [&$this, 'sidebar_post']);
        add_shortcode('show_service_post', [&$this, 'show_service_post']);
        add_shortcode('cias_check_code', [&$this, 'cias_check_code']);
        add_shortcode('table_check_content', [&$this, 'table_check_content']);
    }
    // Shortcode Get post
    public function show_post($content){
        extract(shortcode_atts(array(
            'cias_post_type' => 'post',
            'number' => '',
            'cias_cat' => '',
            'cias_offset' => '',
            'orderby' => 'date',
        ), $content));
    
        $args = array(
            'post_type' => $cias_post_type,
            'category_name' => $cias_cat,
            'posts_per_page' => $number,
            'order' => 'DESC',
            'orderby' => $orderby,
            'offset' => $cias_offset,
        );
    
        ?>
        <div class="gird-news">
            <?php $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();?>
                    <div class="news vc_col-sm-12 " style="margin-bottom: 15px;">
                        <div class="box-posts">
                            <figure class="wpb_wrapper vc_figure post-thumbnail" style="padding: 0;">
                                <?php if (has_post_thumbnail()) {
                                        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                                        echo '<a href="' . esc_url(get_permalink(get_the_ID())) . '" title="' . the_title_attribute(array('echo' => 0)) . '">';
                                        echo get_the_post_thumbnail(get_the_ID(), 'full');
                                        echo '</a>';
                                    }?>
                            </figure>
                            <div class="post_heading">
                                <h3><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo wp_trim_words(get_the_title(get_the_ID()), 10, '...'); ?></a>
                                </h3>
                                <p><?php echo get_the_excerpt(); ?></p>
                                <p class="published"><img style="width:16px;margin-bottom: 3px;" src="<?php echo get_stylesheet_directory_uri(); ?>/images/clock-regular.svg" alt="">
                                    <?php echo get_the_date('d M Y', get_the_ID()); ?></p>
                            </div>
                        </div>
    
                    </div>
                <?php endwhile;
                endif;
                // Reset Post Data
                wp_reset_postdata();
                ?>
        </div>
        <?php
    }

    // Shortcode footer post
    public function show_post_footer($content){
        extract(shortcode_atts(array(
            'cias_post_type' => 'post',
            'number' => '',
            'cias_cat' => '',
            'orderby' => 'date',
        ), $content));
    
        $args = array(
            'post_type' => $cias_post_type,
            'category_name' => $cias_cat,
            'posts_per_page' => $number,
            'order' => 'DESC',
            'orderby' => $orderby,
        );?>
        <ul class="menu">
            <?php $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();?>
                        <li class="menu-item  ">
                            <a target="_blank" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo wp_trim_words(get_the_title(get_the_ID()), 10, '...'); ?></a>
                        </li><?php 
                    endwhile;
                endif;
                // Reset Post Data
                wp_reset_postdata();
            ?>
        </ul><?php
    }
    // show post service category
    public function sidebar_post() {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' =>  5,
            'category_name' => 'news',
            'order' => 'DESC',
            'orderby' => "date",
        );?>
        <div class="post-news">
            <?php $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();
                        ob_start();?>
                        <div class="news vc_col-sm-12 " style="margin-bottom: 15px;">
                            <div class="sidebar-news-post">
                                <figure class="wpb_wrapper vc_figure post-thumbnail vc_col-sm-4 ">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                        echo '<a href="' . esc_url(get_permalink(get_the_ID())) . '" title="' . the_title_attribute(array('echo' => 0)) . '">';
                                        echo get_the_post_thumbnail(get_the_ID(), 'full');
                                        echo '</a>';}?>
                                </figure>
                                <div class="post_heading  vc_col-sm-8">
                                    <div class="post_title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title(get_the_ID()); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div><?php
                    endwhile;
                endif;
                ob_end_clean();
                // Reset Post Data
                wp_reset_postdata();
            ?>
        </div><?php
    }


    // Shortcode service post
    public function show_service_post(){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'category_name' => 'service',
            'order' => 'DESC',
            'orderby' => "date",
        );?>
        <div class=" gird-sevice">
            <?php $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();?>
                    <div class="news vc_col-sm-4 " style="margin-bottom: 15px;">
                        <div class="sevice-box-posts">
                            <figure class="wpb_wrapper vc_figure post-thumbnail">
                                <?php
                                if (has_post_thumbnail()) {
                                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
                                    echo '<a href="' . esc_url(get_permalink(get_the_ID())) . '" title="' . the_title_attribute(array('echo' => 0)) . '">';
                                    echo get_the_post_thumbnail(get_the_ID(), 'full');
                                    echo '</a>';
                                }
                                ?>
                            </figure>
                            <div class="post_heading">
                                <div class="post_title"><a
                                        href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo wp_trim_words(get_the_title(get_the_ID()), 10, '...'); ?></a>
                                </div>
                                <p class="except"><?php echo wp_trim_words(get_the_excerpt(), 13, '...'); ?></p>
                                <?php if (get_field('buy')) : ?>
                                <a class="buy-now" href="<?php the_field('buy'); ?>">Mua ngay</a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div><?php
                    endwhile;
                endif;

                // Reset Post Data
                wp_reset_postdata();
                ?>
        </div>
    <?php
    }

    // check code
    public function cias_check_code(){
        ob_start();?>
        <div class="check-code" style="display:flex; justify-content:center; align-items:center">
        <?php wp_nonce_field( 'security' );?>
            <input type="text" name="service-code" id="service-code" style="padding: 7px 20px;border: 0;outline: 0;background: transparent; border-bottom: 2px solid #970000;text-align:center;text-transform: uppercase;">
            <button class="button btn btn-check" style="margin: 0 0 0 20px;padding: 10px 20px">Kiểm tra</button>
        </div>
        <?php
        ob_end_flush();
    }
    public function table_check_content(){
        ob_start();?>
        <div class="detail-code" style=" margin: 30px 0">
            <h2> Chi tiết mã Voucher </h2>
            <table style="width: 100%; margin: 30px 0">
                <thead style="background: #eee; border-bottom: 2px solid #fff;">
                    <tr>
                        <th>Mã</th>
                        <th>Loại sản phẩm</th>
                        <th>Đối tượng</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody style="background: #eee">
                    <tr id="table-check-content">
                        <td id="code"></td>
                        <td id="product"></td>
                        <td id="object"></td>
                        <td id="expired-date"></td>
                        <td id="status"></td>
                    </tr>
                </tbody>
            </table>
            <tfoot>
                <div class="btn-box" style="display: none; width: 100%; justify-content: space-between">
                    <a class="button btn btn-cancle" href="#">Hủy</a>
                    <a class="button btn btn-use" href="#">Sử dụng</a>
                </div>
            </tfoot>
        </div>
        <?php
        ob_end_flush();
    }

}
new Aias_Shortcode();