<?php 
/*
Plugin Name: JBL Featured Widget
Version: 1.0.0
Plugin URI: https://www.joellisenby.com
Description: Add a featured widget
Author: Joel Lisenby
Author URI: https://www.joellisenby.com
Text Domain: jblfeature
*/

add_action( 'widgets_init', 'jblfeature_init' );

function jblfeature_init() {
	register_widget( 'jblfeature_widget' );
}

class jblfeature_widget extends WP_Widget {
  
  public function __construct() {
      $widget_options = array(
          'classname' => 'jblfeature-widget',
          'description' => 'Creates a feature widget consisting of image, description and link'
      );
      parent::__construct( 'jblfeature_widget', 'JBL Feature Widget', $widget_options );

      add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
  }

  public function admin_enqueue_scripts() {
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_media();
    wp_enqueue_script( 'jblfeature-media-upload', plugin_dir_url(__FILE__) . 'jblfeature-media-upload.js', array('jquery') );
  }

  public function widget( $args, $instance ) {
    echo $args['before_widget'];
?>
<div class="jblfeature-widget-container">
<a href='<?php echo esc_url( $instance['link_url'] ) ?>'>
<img src="<?php echo $instance['image'] ?>" alt="feature image" />
<div class='jblfeature-description'><?php echo wpautop( esc_html( $instance['description'] ) ) ?></div>
<div class='jblfeature-link'><?php echo esc_html( $instance['link_title'] ) ?></div>
</a>
</div>
  <?php
    echo $args['after_widget'];
  }

  public function update( $new_instance, $old_instance ) {  
    return $new_instance;
  }

  public function form( $instance ) {
    $image = !empty( $instance['image'] ) ? $instance['image'] : '';
    $description = !empty( $instance['description'] ) ? $instance['description'] : '';
    $link_title = !empty( $instance['link_title'] ) ? $instance['link_title'] : '';
    $link_url = !empty( $instance['link_url'] ) ? $instance['link_url'] : '';
?>
<p>
  <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
  <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
  <input class="upload_image_button" type="button" value="Upload Image" />
</p>
<p>
  <label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
  <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" ><?php echo esc_attr( $description ); ?></textarea>
</p>
<p>
  <label for="<?php echo $this->get_field_name( 'link_title' ); ?>"><?php _e( 'Link Title:' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'link_title' ); ?>" name="<?php echo $this->get_field_name( 'link_title' ); ?>" type="text" value="<?php echo esc_attr( $link_title ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_name( 'link_url' ); ?>"><?php _e( 'Link URL:' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
</p>
<?php
  }
}