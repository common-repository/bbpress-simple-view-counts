<?php

//ideas
//add how many posts to show


class svpMostViewedWidget extends WP_Widget {


    public function __construct() {
        parent::__construct(
            'svpMostViewedWidget', // Base ID
            '(bbPress) Most Viewed Topics', // Name
            array( 'description' => __( 'Simple view counts', 'text_domain' ), ) // Args
        );
    }

	public function widget( $args, $instance )
    {
        // outputs the content of the widget

        $title   = $instance['title'];
        $postage = $instance['postage'];

        //show all posts from last x days order by views and then post date

        switch ($postage){
            case 0:
                $after = '99 years ago';
                $note = 'Most Viewed posts ever (views)';
                break;
            case 1:
                $after = '1 day ago';
                $note = 'Most viewed posts in last day (views)';
                break;
            case 7:
                $after = '1 week ago';
                $note = 'Most viewed posts in last week (views)';
                break;
            case 30;
                $after = '1 month ago';
                $note = 'Most viewed posts in last month (views)';
                break;
            case 365;
                $after = '1 year ago';
                $note = 'Most viewed posts in last year (views)';
                break;
        }

        $args = array(
            'post_type'         => 'topic',
            'no_found_rows'     => true, //stops query after first rows found
            //    'nopaging' => true,
            'posts_per_page'    => 5,
            'orderby'           => 'meta_value_num',
            'meta_key'          => 'bbp_svc_viewcounts',

            'date_query' => array(
                array(
                    'after' => $after
                )
            )
        );

        //print_r($args);
        $query = new WP_Query($args);
        $output = '';

        if (!empty($title)) {
            $output .= '<h4 class="widget-title widgettitle">';
            $output .= $title;
            $output .= '</h4>';
        }

        $output .= "$note <p>";
        $output .= '<ul>';

        if ($query->have_posts()){
            while ($query->have_posts()) {
                $query->the_post();
                $name = get_the_title();

                $id = get_the_id() ;
                $views = get_post_meta($id,'bbp_svc_viewcounts',true);

                $output .= '<li><a href="' . get_the_permalink() . '">' . $name . ' ('.$views.')</a></li>';
                wp_reset_postdata();
            }
            $output .= '</ul><br>';
            echo $output;
    	}else
        {
            //no posts found?
        }
    }

	public function form( $instance ) {
		// outputs the options form on admin

    $title = $instance[ 'title' ];

    $form = '
        <p>
            <label for="'.$this->get_field_id( 'title' ).'">Title:</label>
            <input class="widefat" type="text" id="'.$this->get_field_id( 'title' )
            .'" name="'.$this->get_field_name( 'title' )
            .'" value="'.esc_attr( $title ).'">
        </p>';

      $form .='
        <label for="'.$this->get_field_id( 'postage' ).'">Only show posts of this age:</label>
        <select id="'.$this->get_field_id('postage').'" name="'.$this->get_field_name('postage').'" class="widefat" style="width:100%;">
        <option <'. selected( $instance['postage'], '0',false).' value="0">Posts from all time</option>
        <option <'. selected( $instance['postage'], '1',false).' value="1">1 day old</option>
        <option <'. selected( $instance['postage'], '7',false).' value="7">A week old</option>
        <option <'. selected( $instance['postage'], '30',false).' value="30">A month old</option>
        <option <'. selected( $instance['postage'], '365',false).' value="365">A year old</option>
        </select>

      ';

        echo $form;
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved

        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'postage' ] = strip_tags( $new_instance[ 'postage' ] );
        return $instance;
	}
}