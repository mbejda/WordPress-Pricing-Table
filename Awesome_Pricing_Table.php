<?php
/*
Plugin Name: Milo Tiny Pricing Table
Plugin URI: http://bejda.com
Description: This tiney pricing table is packed with functionality. The pricing columns are custom post types which you can import and export with the rest of your theme. To simple load the pricing table, use the shortcode with the post id's as columns.
Author: Milos Bejda
Version: 1
Author URI: http://bejda.com
*/
if(class_exists('wp_pricing_table') == false)
{
Define('AWPT', plugin_dir_path(__FILE__));
class wp_pricing_table
{
    function __construct()
    {
        add_action('init', array(
            &$this,
            'init'
        ));
        if (is_admin()) { // admin actions
            add_action('admin_init', array(
                &$this,
                'admin_init'
                ));

            add_action('save_post', array(
                &$this,
                'save_post'
            ), 1, 2); // save the custom fields
            
        } else {
            add_action('wp_enqueue_scripts', array(
                &$this,
                'wp_enqueue_scripts'
            ),15);
        }
        add_shortcode('pricing_table', array($this,'pricing_table_shortcode'));

    }
    public function init()
    {    
        $this->custom_post_type();   
    }
    public function admin_init()
    {
        add_meta_box('smashing-post-class', // Unique ID
            esc_html__('Awesome Pricing Table', 'pricing_table'), // Title
            array(
            &$this,
            'box_1'
        ), 
            'package', 
            'normal', 
            'default' 
            );
        
    }
    public function wp_enqueue_scripts()
    {
        wp_enqueue_style('AWPT_style', plugins_url('css/style.css', __FILE__),99); 
    }

    function box_1()
    {
        global $post;
        
        $pricing_table = get_post_meta($post->ID, 'pricing_table', true);      
?>
    <p>
        <br />
        <label for="pricing_table[color]"><?=_e("Color", 'pricing_table');?></label>
<select name="pricing_table[color]"  class="widefat">
    <?= "<option value='$pricing_table[color]' selected>$pricing_table[color] </option>" ?>
    <option value="small">small</option>
    <option value="tiny">tiny</option>
    <option value="medium">medium</option>
    <option value="pro">pro</option>
</select>
        <label for="pricing_table[active]"><?=_e("Active", 'pricing_table');?></label>

<select name="pricing_table[active]"  class="widefat">
    <?= "<option value='$pricing_table[active]' selected>$pricing_table[active] </option>" ?>
    <option value="unactive">unactive</option>
    <option value="active">active</option>

</select>


    <label for=""><?php
        _e("Signup Link", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[link]" value="<?= @esc_attr($pricing_table['link']); ?>" size="30" />

        <label for=""><?php
        _e("Header", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[header]" value="<?= @esc_attr($pricing_table['header']); ?>" size="30" />
        <label for=""><?php
        _e("Sub Header", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[subheader]" value="<?= @esc_attr($pricing_table['subheader']); ?>" size="30" />
        <label for=""><?php
        _e("Feature 1", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f1]" value="<?= @esc_attr($pricing_table['f1']); ?>" size="30" />
        <label for=""><?php
        _e("Feature 2", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f2]" value="<?= @esc_attr($pricing_table['f2']); ?>" size="30" />
            <label for=""><?php
        _e("Feature 3", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f3]" value="<?= @esc_attr($pricing_table['f3']); ?>" size="30" />
            <label for=""><?php
        _e("Feature 4", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f4]" value="<?= @esc_attr($pricing_table['f4']); ?>" size="30" />
            <label for=""><?php
        _e("Feature 5", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f5]" value="<?= @esc_attr($pricing_table['f5']); ?>" size="30" />
            <label for=""><?php
        _e("Feature 6", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f6]" value="<?= @esc_attr($pricing_table['f6']); ?>" size="30" />
            <label for=""><?php
        _e("Feature 7", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f7]" value="<?= @esc_attr($pricing_table['f7']); ?>" size="30" />
    <label $for=""><?php
        _e("Feature 8", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f8]" value="<?= @esc_attr($pricing_table['f8']); ?>" size="30" />
    <label $for=""><?php
        _e("Feature 9", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f9]" value="<?= @esc_attr($pricing_table['f9']); ?>" size="30" />
    <label $for=""><?php
        _e("Feature 10", 'pricing_table');
?></label>
        <input class="widefat" type="text" name="pricing_table[f10]" value="<?= @esc_attr($pricing_table['f10']); ?>" size="30" />
    </p>
    <?php  
    }
    function custom_post_type()
    {
        
        $labels = array(
            'name' => _x('Packages', 'Post Type General Name', 'pricing_table'),
            'singular_name' => _x('Package', 'Post Type Singular Name', 'pricing_table'),
            'menu_name' => __('Pricing Table', 'pricing_table'),
            'parent_item_colon' => __('Parent Package:', 'pricing_table'),
            'all_items' => __('All Packages', 'pricing_table'),
            'view_item' => __('View Package', 'pricing_table'),
            'add_new_item' => __('Add New Package', 'pricing_table'),
            'add_new' => __('New Package', 'pricing_table'),
            'edit_item' => __('Edit Package', 'pricing_table'),
            'update_item' => __('Update Package', 'pricing_table'),
            'search_items' => __('Search packages', 'pricing_table'),
            'not_found' => __('No packages found', 'pricing_table'),
            'not_found_in_trash' => __('No packages found in Trash', 'pricing_table')
        );
        $args   = array(
            'label' => __('package', 'pricing_table'),
            'description' => __('Package information page', 'pricing_table'),
            'labels' => $labels,
            'supports' => array(
                'title'
            ),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => 5,
            'menu_icon' => plugins_url('cur_dollar.png',__FILE__),
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'page'
        );
        register_post_type('package', $args);
    }
    
    function save_post($post_id, $post)
    {       
        $key   = 'pricing_table';
        $value = $_POST['pricing_table'];
        
        
        if (get_post_meta($post->ID, $key, FALSE)) { 
            update_post_meta($post->ID, $key, $value);
            
            
        } else { 
            add_post_meta($post->ID, $key, $value);
        }
        if (!$value)
            delete_post_meta($post->ID, $key);  
    }
    function pricing_table_shortcode($atts)
    {
        extract(shortcode_atts(array(
        'ids' => null
    ), $atts));
    
    if (isset($ids)) {
?>
<div class="awpt-row">
    <?php
        $id_array = explode(',', $ids);
        $r        = (12 / count($id_array));
        
        foreach ($id_array as $k => $v) {
            $pricing_table = get_post_meta($v, 'pricing_table', true);
            $this->loop_table($r, $pricing_table);
        }
?>
</div>
<?php
    }else{
    $args  = array(
        'post_type' => 'package'
    );
    $query = new WP_Query($args);
    $m     = wp_count_posts('package')->publish;
    $r     = (12 / $m);
    if ($query->have_posts()) {
?>
<div class="awpt-row">
    <?php
        while ($query->have_posts()) {
            $query->the_post();
            $pricing_table = get_post_meta($query->post->ID, 'pricing_table', true);
            $this->loop_table($r, $pricing_table);      
        }
?>
    </div>
    <?php
    }
    }
    }
function loop_table($r, $pricing_table)
{
?>
 <div class="col-md-<?= $r ?>  pricing-table <?= $pricing_table['color'] ?> <?=$pricing_table['active']?>">
            <div class="pricing-table-header-<?= $pricing_table['color'] ?>">
                 <h2><?= $pricing_table['header'] ?></h2>
                 <h3><?= $pricing_table['subheader'] ?></h3>
            </div>
            <div class="pricing-table-features">
                <p><?= $pricing_table['f1'] ?></p>
                <p><?= $pricing_table['f2'] ?></p>
                <p><?= $pricing_table['f3'] ?></p>
                <p><?= $pricing_table['f4'] ?></p>
                <p><?= $pricing_table['f5'] ?></p>
                <p><?= $pricing_table['f6'] ?></p>
                <p><?= $pricing_table['f7'] ?></p>
                <p><?= $pricing_table['f8'] ?></p>
                <p><?= $pricing_table['f9'] ?></p>
            </div>
            <div class="pricing-table-signup-<?= $pricing_table['color'] ?> pfooter">
                <p><a href="<?= $pricing_table['link'] ?>">Sign Up</a>
                </p>
            </div>
        </div>
<?php
}
}







$GLOBALS['wp_pricing_table'] = new wp_pricing_table();
}
?>