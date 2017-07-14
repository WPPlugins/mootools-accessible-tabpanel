<?php
/*
Plugin Name: MooTools Accessible Tabpanel
Plugin URI: http://wordpress.org/extend/plugins/mootools-accessible-tabpanel/
Description: WAI-ARIA Enabled Tabpanel Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getArchives.php';

add_action("plugins_loaded", "MooToolsAccessibleTabpanel_init");
function MooToolsAccessibleTabpanel_init() {
    register_sidebar_widget(__('MooTools Accessible Tabpanel'), 'widget_MooToolsAccessibleTabpanel');
    register_widget_control(   'MooTools Accessible Tabpanel', 'MooToolsAccessibleTabpanel_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_MooToolsAccessibleTabpanel') ) {
        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('mootools-core', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tabpanel/lib/mootools-core.js'));
        wp_enqueue_script('mootools-core');

        wp_register_script('mootools-more', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tabpanel/lib/mootools-more.js'));
        wp_enqueue_script('mootools-more');

       
        wp_register_script('tabPane', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tabpanel/lib/tabPane.js'));
        wp_enqueue_script('tabPane');

        wp_register_script('MooToolsAccessibleTabpanel', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tabpanel/lib/MooToolsAccessibleTabpanel.js'));
        wp_enqueue_script('MooToolsAccessibleTabpanel');

        wp_register_style('MooToolsAccessibleTabpanel_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-tabpanel/lib/MooToolsAccessibleTabpanel.css'));
        wp_enqueue_style('MooToolsAccessibleTabpanel_css');
    }
}

function widget_MooToolsAccessibleTabpanel($args) {
    extract($args);

    $options = get_option("widget_MooToolsAccessibleTabpanel");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tabpanel',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    MooToolsAccessibleTabpanelContent();
    echo $after_widget;
}

function MooToolsAccessibleTabpanelContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $archives = get_my_archives();

    $options = get_option("widget_MooToolsAccessibleTabpanel");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tabpanel',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo '
<!--<div id="demo">
<div class="content">
    -->            
                <div id="demo_small">
                    <ul class="tabs">
                        <li class="tab">' . $options['archives'] . ' <span class="remove">&times;</span>
                        </li>
                        <li class="tab">' . $options['recentPosts'] . ' <span class="remove">&times;</span>
                        </li>
                        <li class="tab">' . $options['recentComments'] . ' <span class="remove">&times;</span>
                        </li>
                    </ul>
                    <div class="content">
                        <p><ul>
                	   ' . $archives . '
            		</ul></p>
                    </div>
                    <div class="content">
                        <p><ul>
                	   ' . $recentPosts . '
            		</ul></p>
                    </div>
                    <div class="content">
                        <p><ul>
                	   ' . $recentComments . '
            		</ul></p>
                    </div>
                </div>
<!--</div>
</div>-->
';
}

function MooToolsAccessibleTabpanel_control() {
    $options = get_option("widget_MooToolsAccessibleTabpanel");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Tabpanel',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['MooToolsAccessibleTabpanel-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['MooToolsAccessibleTabpanel-WidgetTitle']);
        update_option("widget_MooToolsAccessibleTabpanel", $options);
    }
    if ($_POST['MooToolsAccessibleTabpanel-SubmitArchives']) {
        $options['archives'] = htmlspecialchars($_POST['MooToolsAccessibleTabpanel-WidgetArchives']);
        update_option("widget_MooToolsAccessibleTabpanel", $options);
    }
    if ($_POST['MooToolsAccessibleTabpanel-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['MooToolsAccessibleTabpanel-WidgetRecentPosts']);
        update_option("widget_MooToolsAccessibleTabpanel", $options);
    }
    if ($_POST['MooToolsAccessibleTabpanel-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['MooToolsAccessibleTabpanel-WidgetRecentComments']);
        update_option("widget_MooToolsAccessibleTabpanel", $options);
    }
    ?>
    <p>
        <label for="MooToolsAccessibleTabpanel-WidgetTitle">Widget Title: </label>
        <input type="text" id="MooToolsAccessibleTabpanel-WidgetTitle" name="MooToolsAccessibleTabpanel-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="MooToolsAccessibleTabpanel-SubmitTitle" name="MooToolsAccessibleTabpanel-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleTabpanel-WidgetArchives">Translation for "Archives": </label>
        <input type="text" id="MooToolsAccessibleTabpanel-WidgetArchives" name="MooToolsAccessibleTabpanel-WidgetArchives" value="<?php echo $options['archives'];?>" />
        <input type="hidden" id="MooToolsAccessibleTabpanel-SubmitArchives" name="MooToolsAccessibleTabpanel-SubmitArchives" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleTabpanel-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="MooToolsAccessibleTabpanel-WidgetRecentPosts" name="MooToolsAccessibleTabpanel-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="MooToolsAccessibleTabpanel-SubmitRecentPosts" name="MooToolsAccessibleTabpanel-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleTabpanel-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="MooToolsAccessibleTabpanel-WidgetRecentComments" name="MooToolsAccessibleTabpanel-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="MooToolsAccessibleTabpanel-SubmitRecentComments" name="MooToolsAccessibleTabpanel-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
