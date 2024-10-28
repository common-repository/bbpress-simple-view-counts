<?php
//SETTINGS GUIDE
//http://kovshenin.com/2012/the-wordpress-settings-api/


class svcPluginConfigPage {

    private $options;

    //CONTRUCTOR
    public function __construct()
    {

        $this->options = get_option('SVC-options');

        // register actions
        add_action('admin_init', array($this, 'admin_init'));

    } // END public function __construct



    function admin_init() {

        if(!current_user_can('manage_options')){return;}

        //Register
        register_setting( 'my-settings-group', 'SVC-options', array($this,'settings_validate') );

        //Sections
        add_settings_section( 'svc-options-section',
                              'Configuration',
                               array($this,'section_one_callback'),
                              'bbPress_simple_view_count' );

        //Fields
        add_settings_field( 'hitCount', 'Track hit count', array($this,'option_checkbox'),
            'bbPress_simple_view_count', 'svc-options-section', array(
            'name' => 'SVC-options[hitCount]',
            'value' => $this->options['hitCount']
           ) );


        //Fields
        add_settings_field( 'memberCount', 'Track member count', array($this,'option_checkbox'),
            'bbPress_simple_view_count', 'svc-options-section', array(
                'name' => 'SVC-options[memberCount]',
                'value' => $this->options['memberCount']
            ) );

    }

    //SECTION CALLBACKS
    function section_one_callback() {

        echo "The plugin can track every time a topic is viewed, this counter is increased regardless of who is viewing it.
        You can also chose to track member views, this tracks unique views of registered members (ie if all ten of your forum members have seen the topic, it will show 10.";
    }


    function show_options_page() {

        //echo "test<p>";
        //print_r($this->options);die;

        ?>
        <div class="wrap">
            <h2>Simple View Counts</h2>
            <form action="options.php" method="POST">
                <?php settings_errors(); ?>
                <?php settings_fields( 'my-settings-group' ); ?>
                <?php do_settings_sections( 'bbPress_simple_view_count' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <p>Simple view counts records the number of times a topic is viewed and/or the number of members who have viewed the
        topic.  If you have any queries, post in the WordPress plugin forum area. You can also reach me on Twitter <a href="http://twitter.com/jezza101">@Jezza101</a> or
        via my <a href="http://www.blogercise.com">website</a>.</p>
    <?php
    }


    function settings_validate( $input ) {
        $output = $this->options;
       // print_r($input);die;

        $input['version'] = $output['version'];

        return $input;
    }


    //FIELD CALLBACKS

    //TEXTBOX
    function option_textbox( $args ) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $size  = intval($args['size']);

        echo "<input type='text' name='$name' size = '$size' value='$value' />";
    }
    //DROP DOWN
    function option_dropdown( $args ) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );
        $items = $args['items'];

        echo "<select id='drop_down_$name' name='$name'>";
        foreach($items as $item) {
            $selected = ($value==$item) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
    }

    //CHECKBOX
    function option_checkbox( $args ) {
        $name = esc_attr( $args['name'] );
        $value = esc_attr( $args['value'] );

        $html = "<input type='checkbox' id='checkbox_$name' name='$name'  value='1' ".checked( 1, $value, false ) ."/>";
        //$html .= "<label for='checkbox_$name'> Enable / Disable</label>";

        echo $html;

    } // end sandbox_checkbox_element_callback



}