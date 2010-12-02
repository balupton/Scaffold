<?php
/**
 * Scaffold_Extension_PDStyles
 *
 * Preloads variables to use within the CSS from the WordPress PD Styles plugin.
 * 
 * @package 		Scaffold
 * @author 			Anthony Short <anthonyshort@me.com>
 * @copyright 		2009-2010 Anthony Short. All rights reserved.
 * @license 		http://opensource.org/licenses/bsd-license.php  New BSD License
 * @link 			https://github.com/anthonyshort/csscaffold/master
 */
class Scaffold_Extension_PDStyles extends Scaffold_Extension
{	
	/**
	 * @var array
	 */
	public $variables = array();
	
	/**
	 * Loop through each file and load the XML variables
	 * @access public
	 * @param $source
	 * @return string
	 */
	public function variables_start($source,$scaffold)
	{
		global $PDStylesFrontendController;
		
		$css_permalink = $PDStylesFrontendController->permalink;
		
		if ( $this->config['preview'] ) {
			
			$preview = get_option('pd-styles-preview');
			if( is_object( $preview[ $css_permalink ] ) ) {
				$this->variables = $preview[ $css_permalink ]->get('css');
			}

		}else if( is_object( $PDStylesFrontendController->options['variables'][ $css_permalink ] ) ) {
			$this->variables = $PDStylesFrontendController->options['variables'][ $css_permalink ]->get('css');
		}
		
		//	if ( !empty( $pdstyles['css_values'][$css_permalink] ) ) {
		//		$this->variables = $pdstyles['css_values'][$css_permalink];
		//	}
		
		return true;
	}
	
	/**
	 * Merge our variables with the variables object before they are replaced
	 * @access public
	 * @param $variables Scaffold_Extension_Variables
	 * @return void
	 */
	public function variables_replace(Scaffold_Source $source,Scaffold_Extension_Variables $var)
	{	
		$var->variables = $this->helper->array->merge_recursive($var->variables,$this->variables);
		
	}
	
}