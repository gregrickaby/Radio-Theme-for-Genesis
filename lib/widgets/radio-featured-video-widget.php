<?php
/*
Plugin Name: Radio - Featured Video
Plugin URI: http://gregrickaby.com
Description: Display a video with a headline in a widget.
Version: 1.0.0
Author: Greg Rickaby
Author URI: http://gregrickaby.com
License: GPLv2
*/

/**
 * Radio Featured Video
 *
 * @since 1.0.0
 *
 * @package Radio\Widgets
 */
class Radio_Featured_Video extends WP_Widget {


  /**
   * Register widget with WordPress.
   */
  public function __construct() {

    parent::__construct(
      'featured-video', // Base ID
      'Radio - Featured Video', // Name
      array( 'description' => __( 'Display a video with a headline in a widget.', 'radio' ), ) 
    );

  }


  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {

    extract( $args );

    echo $before_widget; ?>

        <div class="featured-video">
          <h4 class="widget-title"><?php echo sanitize_text_field( $instance['title'] ); ?></h4>
          <div class="featured-video-video">
            <?php echo $GLOBALS['wp_embed']->autoembed( $instance['video'] ); ?>
          </div>
          <?php if ( $instance['text'] ) { ?>
            <p class="featured-video-text"><?php echo sanitize_text_field( $instance['text'] ); ?></p>
          <?php } ?>
        </div><!-- .featured-video -->
    
    <?php
    echo $after_widget;

  }


  /**
   * Back-end widget form with defaults
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {

    // Set Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => 'Featured Video', 'description' => '', 'video' => '', 'width' => '370', 'height' => '208'  ) ); ?>

    <p><label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'radio' ); ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"></p>

    <p><label for="<?php echo $this->get_field_name( 'video' ); ?>"><?php _e( 'Video:', 'radio' ); ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'video' ); ?>" name="<?php echo $this->get_field_name( 'video' ); ?>" value="<?php echo esc_html( $instance['video'] ); ?>"><br />
        <small><em><?php _e( 'Enter the URL of a YouTube or Vimeo video to auto-embed. You can also use &lt;iframe&gt; embed code from another provider. Videos will automatically be scaled to fit.', 'radio' ); ?></em></small></p>

    <p><label for="<?php echo $this->get_field_name( 'text' ); ?>"><?php _e( 'Description:', 'child' ); ?></label>
        <textarea class="widefat" rows="10" cols="10" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_html( $instance['text'] ); ?></textarea>
        <small><em><?php _e( 'Optional. Enter a description. Basic HTML tags allowed.', 'child' ); ?></em></small></p>

  <?php }


  /**
   * Update form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated values to be saved.
   */
  public function update( $new_instance, $old_instance ) {

    $instance = array();

    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    $instance['description']  = sanitize_text_field( $new_instance['description'] );
    if ( current_user_can('unfiltered_html') )
      $instance['video'] =  $new_instance['video'];
    else
      $instance['video'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['video'] ) ) ); // wp_filter_post_kses() expects slashed
    if ( current_user_can( 'unfiltered_html' ) )
      $instance['text'] =  $new_instance['text'];
    else
      $instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
    return $instance;

  }

} // class Radio_Featured_Video

// Start the widget
add_action( 'widgets_init', function() { register_widget( 'Radio_Featured_Video' ); } );