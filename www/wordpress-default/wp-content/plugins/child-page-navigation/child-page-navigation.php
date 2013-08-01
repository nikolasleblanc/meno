<?php
/*
    Plugin Name: Child Page Navigation
    Plugin URI: http://wordpress.org/extend/plugins/child-page-navigation/
    Description: Provides a theme-independent widget to display the child pages of the current page.
    Author: ITS Alaska
    Author URI: http://ITSCanFixThat.com/
    Version: 1.3.3

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class theme_navigation extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'theme_navigation', // Base ID
			'Child Page Navigation', // Name
			array('description' => '') // Args
		);
	}

	function form($instance){
		$instance['tiutle'] = apply_filters( 'widget_title', $instance['title'] ); ?>
	  <p>Title: <input name="cpn_title" id="cpn_title" type="text" <?php if(isset($instance['title']) && $instance['title'] != "") echo 'value="'.$instance['title'].'"'; ?> /></p>
	  <p>Sort by Sort Order? <input name="cpn_sort" id="cpn_sort" type="checkbox" <?php if(isset($instance['sort']) && $instance['sort']) echo 'checked="checked"'; ?> value="1" /></p>
	<?php }

	function update(){
		if(!isset($_POST['cpn_sort']))
			$_POST['cpn_sort'] = 0;
	
		foreach($_POST as $field => $val){
			if(substr($field,0,4) != "cpn_")
				continue;
			
			$opts[substr($field,4)] = attribute_escape($_POST[$field]);
			unset($_POST[$field]);
		}
		
		return $opts;
	}

	function widget($args,$instance){
		global $post;
		$instance['title'] = apply_filters( 'widget_title', $instance['title'] );
		
		$page_arr = array('child_of' => $post->ID, 'parent' => $post->ID);
		
		if($instance['sort'])
			$page_arr['sort_column'] = 'menu_order';

		$pages = get_pages($page_arr);
		
		if($post->post_parent && !count($pages))
			$page_arr['child_of'] = $page_arr['parent'] = $post->post_parent;
			$pages = get_pages($page_arr);
		
		if(!count($pages))
			return;

		echo $args['before_widget'];
		
		if(isset($instance['title']) && $instance['title'] != "")
			echo $args['before_title'].$instance['title'].$args['after_title'];
		
		echo "<ul>";
		
		foreach($pages as $page){
			echo "<li><a href='".get_permalink($page->ID)."'>".get_the_title($page->ID)."</a></li>";
		}
		
		echo "</ul>".$args['after_widget'];
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "theme_navigation" );' ) );