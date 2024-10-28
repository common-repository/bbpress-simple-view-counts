<?php
/*
Plugin Name: bbpress Simple View Counts
Plugin URI: http://www.blogercise.com
Description: Counts and shows views in bbPress 2 forum
Author: jezza101
Version: 0.3
Author URI: http://www.blogercise.com
*/

 

//this plugin is maintained!
//contact me via my webpage, twitter @jezza101 or the forum support page on wordpress.org

const SVC_VERSION = 0.3;


class bbpress_simple_view_counts {


    private $options;
    private $pluginConfigPage;

    public function __construct() {

        $this->options = get_option('svc-options');
        //print_r($this->options);die;

        //FILTERS NEEDED TO SHOW THE VIEWS IN THE FRONT END
        add_action ('bbp_theme_after_topic_started_by', array($this,'show_views_forum_page'),60);
        add_filter('bbp_get_single_topic_description', array($this,'show_views_topic_page'), 100, 2);

        //LOAD WIDGET
        require_once(WP_PLUGIN_DIR .'/bbpress-simple-view-counts/most-viewed-widget.php');
        add_action('widgets_init', array($this,'register_widget'));

        if (is_admin()) {

            require_once(WP_PLUGIN_DIR .'/bbpress-simple-view-counts/admin-options.php');
            $this->pluginConfigPage =  new svcPluginConfigPage();

            register_activation_hook(__FILE__, array($this, 'activate'));
            add_action('admin_menu', array($this, 'register_my_custom_menu_page'));

            //handle upgrades
            if (empty($this->options['version']) || SVC_VERSION > $this->options['version']){
                //do upgrade
                $this->upgrade();
            }
        }
    }


    function register_widget() {
        register_widget('svpMostViewedWidget');
    }


    function register_my_custom_menu_page()
    {
        add_submenu_page('edit.php?post_type=forum', 'View Counts', 'View Count Options', 'administrator',
            'bbPress_simple_view_count', array($this->pluginConfigPage,'show_options_page'));
    }



    function show_views_forum_page() {

        //FORUM PAGE
        //ie the forum pages lists all the posts in the forum, let's add a view count

        $post_id = get_the_ID();
        $count   = get_post_meta( $post_id, 'bbp_svc_viewcounts', true );

        if (!empty($count)){
            echo '<br><span class="bbp-topic-started-by">Views: '.$count.'</span>';
        }
        return;
    }

    function show_views_topic_page( $content, $reply_id ) {

        $post_id = get_the_ID();

        //HITS
        IF ($this->options['hitCount']==1) {
            //get previous count and add one!
            $hitCount = get_post_meta($post_id, 'bbp_svc_viewcounts', true);
            $hitCount = $hitCount + 1;
            update_post_meta($post_id, 'bbp_svc_viewcounts', $hitCount) ;

            if ($hitCount==1){
                $text = ". This post has been viewed 1 time.";
            }
            else if (!empty($hitCount)){
                $text = ". This post has been viewed $hitCount times.";
            }
        }


        //MEMBER VIEWS
        IF ($this->options['memberCount']==1) {

            $user_ID = get_current_user_id();

            if ($user_ID > 0) {

                //record users who have seen this page
                $memberList = get_post_meta($post_id, 'bbp_svc_membercounts', true);

                $memberArray = explode('.',$memberList);
                $memberCount = sizeof($memberArray) -1;
                if(array_search($user_ID,$memberArray)===FALSE)
                {
                    $memberList = $memberList . $user_ID  . '.';
                    update_post_meta($post_id, 'bbp_svc_membercounts', $memberList) ;
                    $memberCount ++;
                }
                If($memberCount==1) {
                    $text .= " The post has been read by " . $memberCount . " member.";
                }else{
                    $text .= " The post has been read by " . $memberCount . " members.";
                }
            }
        }

        //echo"$text";

        //SHOW THE COUNTS

        //inject our view count into the topic, let's replace the full stop at the end of the details.
        //Better way to do this?
        if (!empty($text)){
            $content = str_replace(".",$text,$content);
        }

        //echo "<p>P:$post_id C:$count";
        return $content ;

    }


    public static function activate() {

        //same as upgrade for now...
        $options  = get_option("svc-options");

        //IF NO VERSION IS FOUND THEN THIS IS A NEW INSTALL
        if (empty($options['version'])){

            $options['version'] = SVC_VERSION;
            $options['hitCount'] = '1';
            $options['memberCount'] ='';

            update_option('SVC-options',$options);
        }

    }

    function upgrade(){

        $options  = get_option("svc-options");

        //IF NO VERSION IS FOUND THEN THIS IS A NEW INSTALL
        if (empty($options['version'])){

            $options['version'] = SVC_VERSION;
            $options['hitCount'] = '1';
            $options['memberCount'] ='';

            update_option('SVC-options',$options);
        }

        //ELSE
        //add new upgrades here
        if (SVC_VERSION == 0.3){
            //upgrade to next version

        }
    }
}

//Instatiate our plugin class
$bbpress_view_counts  = new bbpress_simple_view_counts();
