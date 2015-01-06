<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation{

  	var $menu = array();  //The array holding all navigation elements
  	var $sideMenu = array();  //The array holding side navigation elements
	var $out; // The HTML string to be returned
	
	
	/*
	 * Render the top nav
	 */
	function __construct(){
		
	}

	function init(){
		$CI =& get_instance();

		$this->menu = array
		(
			1 => 	array(
				'text'		=> 	'Home',	
				'link'		=> 	base_url().'home',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	0
			),
			2 => 	array(
				'text'		=> 	'People',	
				'link'		=> 	base_url() . 'person',
				'show_condition'=>	1,
				'icon-class'=>	'icon-user',
				'parent'	=>	0
			),							
			3 => 	array(
				'text'		=> 	'Reports',	
				'link'		=> 	base_url() . 'reports/dashboard',
				'show_condition'=>	1,
				'icon-class'=>	'icon-book',
				'parent'	=>	0
			),
			4 => 	array(
				'text'		=> 	'Courses',	
				'link'		=> 	base_url() . 'courses',
				'show_condition'=>	1,
				'icon-class'=>	'icon-list-alt',
				'parent'	=>	0
			),
			7 => 	array(
				'text'		=> 	"Gradebook Manager",	
				'link'		=> 	base_url().'gradebook',
				'show_condition'=>	1,
				'icon-class'=>	'icon-briefcase',
				'parent'	=>	0
			),
			5 => 	array(
				'text'		=> 	'Setup',	
				'link'		=> 	base_url() . 'setup',
				'show_condition'=>	1,
				'icon-class'=>	'icon-wrench',
				'parent'	=>	0
			),
			6 => 	array(
				'text'		=> 	'Help',	
				'link'		=> 	base_url() . 'home',
				'show_condition'=>	1,
				'icon-class'=>	'icon-question-sign',
				'parent'	=>	0
			),
			8 => 	array(
				'text'		=> "Manage School Terms",	
				'link'		=> 	base_url().'schoolterms/listing',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			),
			9 => 	array(
				'text'		=> 	 "Manage Grade Levels",	
				'link'		=> 	base_url().'gradelevels/listing',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			),
			10 => 	array(
				'text'		=> 	"Manage Classes",	
				'link'		=> 	base_url().'schoolclasses/listing',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			),
			11 => 	array(
				'text'		=> 	"Manage Class Periods",	
				'link'		=> 	base_url().'schoolperiods/listing',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			),
			12 => 	array(
				'text'		=> 	"Subject Manager",	
				'link'		=> 	base_url().'subjects',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			),
			13 => 	array(
				'text'		=> 	"Uer Defined Fields",	
				'link'		=> 	base_url().'udf',
				'show_condition'=>	1,
				'icon-class'=>	'icon-home',
				'parent'	=>	5
			)
		); 
	}
	
	/*
	 * load - Return HTML navigation string
	 */
	public function load($selected = null)
	{
		$this->init();
		$out = '<ul class="nav">';
		foreach ( $this->menu as $i=>$arr )
		{
			if ( is_array ( $this->menu [ $i ] ) ) {//must be by construction but let's keep the errors home
				if ( $this->menu [ $i ] [ 'show_condition' ] && $this->menu [ $i ] [ 'parent' ] == 0 ) //are we allowed to see this menu?
				{
					/*** Set class for current nav item ***/
					(strcasecmp($this->menu [ $i ] [ 'text' ], $selected) == 0 ) ? $class = "active" : $class = ""; //  Binary safe case-insensitive string comparison
					
					if($this->hasChildren($i))
					{
						$class .=" dropdown";
						$out .= "<li class=\"" . $class . "\">";
						$out .= "<a href=\"" . $this->menu [ $i ] [ 'link' ] . "\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
						$out .= "<i class=\"" . $this->menu[$i]['icon-class'] . "\"></i>&nbsp;";
						$out .= $this->menu [ $i ] [ 'text' ];
						$out .= '<b class="caret"></b>';
						$out .= '</a>';
						$out .= $this->getChildren ( $i ); //loop through children
						$out .= '</li>' . "\n";
					}else{
						$out .= "<li class=\"" . $class . "\">";
						if($this->menu [ $i ] [ 'link' ]!=null)	{
							$out .= "<a href=\"" . $this->menu [ $i ] [ 'link' ] . "\">";
							$out .= "<i class=\"" . $this->menu[$i]['icon-class'] . "\"></i>&nbsp;";
							$out .= $this->menu [ $i ] [ 'text' ];
							$out .= '</a>';
						} else {
							$out .= "<span>".$this->menu [ $i ] [ 'text' ]."</span>";
						}
						$out .= '</li>' . "\n";
					}
				}
			}
			else 
			{
				die ( sprintf ( 'menu nr %s must be an array', $i ) );
			}
		}

		$out .= '</ul>';
		return $out;
	}
	
	/*
	 * load - Return HTML navigation string
	 */
	public function load_side_nav($selected = null, $menu_elements = array ())
	{
		$out = '<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">';
		
		foreach ( $menu_elements as $i=>$arr )
		{
			if ( is_array ( $menu_elements [ $i ] ) ) {//must be by construction but let's keep the errors home
				if ( $menu_elements [ $i ] [ 'show_condition' ] && $menu_elements [ $i ] [ 'parent' ] == 0 ) //are we allowed to see this menu?
				{
					/*** Set class for current nav item ***/
					($i == $selected) ? $class = "active" : $class = ""; //  Binary safe case-insensitive string comparison
					
					//if($this->hasChildren($i))
					//{
						//$class .=" dropdown";
					//	$out .= "<li class=\"" . $class . "\">";
					//	$out .= "<a href=\"" . $menu_elements [ $i ] [ 'link' ] . "\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
				//		$out .= $menu_elements [ $i ] [ 'text' ];
				//		$out .= '<b class="caret"></b>';
				//		$out .= '</a>';
			//			$out .= $this->getChildren ( $i ); //loop through children
		//				$out .= '</li>' . "\n";
		
						$out .= "<li class=\"" . $class . "\">";
						if($menu_elements [ $i ] [ 'link' ]!=null)	{
							$out .= "<a href=\"" . $menu_elements [ $i ] [ 'link' ] . "\">";
							$out .= $menu_elements [ $i ] [ 'text' ];
							$out .= '</a>';
						} else {
							$out .= "<span>".$menu_elements [ $i ] [ 'text' ]."</span>";
						}
						$out .= '</li>' . "\n";
				}
			}
			else 
			{
				die ( sprintf ( 'menu nr %s must be an array', $i ) );
			}
		}

		$out .= '</ul>';
		return $out;
	}

	private function hasChildren($menu_id)
	{
		foreach ( $this->menu as $i=>$arr ){
		
			if ( $this->menu [ $i ] [ 'show_condition' ] && $this->menu [ $i ] [ 'parent' ] == $menu_id ) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
	/**
	 *
	 * getChildren - build an html string of the menu children
	 *
	 * @access private
	 *
	 * @return HTML or boolean
	 *
	 */
	private function getChildren ( $el_id )
	{
		$has_subcats = FALSE;
		$out = '';
		$out .= "\n".'	<ul class="dropdown-menu">' . "\n";
		foreach ( $this->menu as $i=>$arr ){
		
			if ( $this->menu [ $i ] [ 'show_condition' ] && $this->menu [ $i ] [ 'parent' ] == $el_id ) {//are we allowed to see this menu?
				$has_subcats = TRUE;
				
				$out .= "<li><a href=\"{$this->menu[ $i ][ 'link' ]}\">{$this->menu [ $i ] [ 'text' ]}</a>" . $this->getChildren ( $this->menu, $i ) . "</li>";
			}
		}
		$out .= '	</ul>'."\n";
		
		
		return ( $has_subcats ) ? $out : FALSE;
	}
}