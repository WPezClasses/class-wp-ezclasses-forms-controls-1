<?php
/** 
 * Various form controls for building forms (for widgets and meta boxes, etc.)
 *
 * Dependencies: WP ezClasses Methods Static (https://Github.com/WPezClasses/class-wp-ezclasses-methods-static)
 *
 * PHP version 5.3
 *
 *
 * @package WP ezClasses
 * @since 0.5.0
 * @license MIT
 */
 
/*
 * == Change Log == 
 *
 */
 
 /*
  * ========================
  * Inspiration and References:
  *
  * https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
  *
  * http://www.w3.org/TR/html401/interact/forms.html#h-17.2.1
  * ========================
  */

if ( !defined('ABSPATH') ) {
	header('HTTP/1.0 403 Forbidden');
    die();
}
 
if ( !class_exists('Class_WP_ezClasses_Forms_Controls_1' ) ){
	class Class_WP_ezClasses_Forms_Controls_1 extends Class_WP_ezClasses_Master_Singleton {
	
		/**
		 * Note: We're not using the construct other than to get "global" properties defined in Class_WP_ezClasses_Master_Singleton
		 */
		public function __construct(){
			parent::__construct();
		}	

		/**
		 *
		 */
		public function ezc_init($arr_args = NULL){   
			//
		}
		
		
		/*
		 * Control: Text Input - Puts together the html and returns it. Also uses method: text_input_defaults(). Please see the text_input_defaults() for what you can pass in and how (i.e., array keys).
		 */
		public function text_input($arr_args = NULL){
			
			$str_to_return = '<!-- args passed to text_input was not an array -->';
			if ( is_array($arr_args) ){
			
				//TODO lang_code e.g. en_1
							
				$arr_args = array_merge($this->text_input_defaults('en_1'), $arr_args);
				if ( WP_ezMethods::array_key_pass($arr_args, 'arr_args') ){
					$arr_args['arr_args'] = array_merge($this->text_input_defaults_custom('en_1'), $arr_args['arr_args']);
				} else {
					$arr_args['arr_args'] = $this->text_input_defaults_custom('en_1');
				}
				
				$str_to_return =  $arr_args['html_tag_open'];
				if ( isset($arr_args['label']) && !empty($arr_args['label']) ){
					$str_to_return .= '<label for="' . $arr_args['field_id'] . '">';
					$str_to_return .= $arr_args['label'];
					$str_to_return .= '</label>';
				}
				
				$str_to_return .= $arr_args['html_tag_inner_open'];
				$str_to_return .= '<input '; 
				if ( isset($arr_args['field_class']) && !empty($arr_args['field_class']) ){
					$str_to_return .= ' class="' . $arr_args['field_class'] . '"';
				}
				$str_to_return .= ' id="' . $arr_args['field_id'] . '" name="' . $arr_args['field_name'] . '" type="text"';
				$str_to_return .= ' value="' . $arr_args['value'] .'" ';
				if ( isset($arr_args['arr_args']['size']) && !empty($arr_args['arr_args']['size']) ){
					$str_to_return .= 'size="' . $arr_args['arr_args']['size'] . '" ';
				}
				$str_to_return .= $arr_args['inline'] . ' />';
				$str_to_return .= $arr_args['html_tag_inner_close'];

				if ( isset($arr_args['footnote']) && !empty($arr_args['footnote']) ){
					$str_to_return .=  $arr_args['html_tag_footnote_open'] . $arr_args['footnote'] . $arr_args['html_tag_footnote_close'];
				}
				$str_to_return .= $arr_args['html_tag_close'];			
			}
			
			return $str_to_return;
		}
		
		
		/*
		 * TODO - Add language-centric defaults
		 */
		public function text_input_defaults($str_preset = 'en_1'){
		
			$arr_defaults = array(	
								'field_name'				=> 'text_input_default_name',
								'value'						=> '',
								'disabled'					=> false,
								'tabindex'					=> false,

								'label'						=> '',
								'field_id'					=> '',
								'field_class'				=> 'widefat',
								'size'						=> '',
								
								'lang'						=> '',
								'dir'						=> '',
								'title'						=> '',
								
								'inline'					=> '',																										// the content of this string will be added "as is"
								'html_tag_open'				=> '<div class="wp-ezc-forms-control-1-wrap-outer wp-ezc-forms-control-1-wrap-text-input">',				// before the label. wrap the whole lot
								'html_tag_close'			=> '</div>',			
								'html_tag_inner_open'		=> '<div class="wp-ezc-forms-controls-1-wrap-inner wp-ezc-forms-control-1-wrap-text-input">',				// wraps the actual select
								'html_tag_inner_close'		=> '</div>',
								'html_tag_footnote_open'	=> '<div class="wp-ezc-forms-controls-1-footnote wp-ezc-forms-controls-1-footnote-text-input">',			// wraps the footnote.
								'html_tag_footnote_close'	=> '</div>',								
								'footnote'					=> '',
							);
											
			return $arr_defaults;
		}
		
		/*
		 * Selectively override the defauls with your own. This array gets array_merge()'ed over top of the text_input_defaults() array. 
		 *
		 * Important: At the very least these are the key => value you should be passing in so that you can define / configure a proper and unique text input. 
		 */
		public function text_input_defaults_custom($str_preset = 'en_1'){
		
			$arr_arr_args_defaults = array(
										'field_name'				=> 'text_input_default_name',
										'label'						=> '',
										'field_id'					=> '',
										'size'						=> '',
									);
							
			return $arr_arr_args_defaults;
		}

		
		/*
		 * Control: Select - Puts together the html and returns it. Also uses method: select_defaults(). Please see the select_defaults() for what you can pass in and how (i.e., array keys).
		 */
		public function select($arr_args = NULL){
			
			$str_to_return = '<!-- args passed to select was not an array -->';
			if ( is_array($arr_args) && isset($arr_args['options']) && is_array($arr_args['options']) && ! empty($arr_args['options']) ){
							
				$str_defaults = 'en_1';
				if ( isset($arr_args['defaults']) && is_string($arr_args['defaults']) ){
					$str_defaults = $arr_args['defaults'];
				}
				
				$str_defaults_custom = 'en_1';
				if ( isset($arr_args['defaults_custom']) && is_string($arr_args['defaults_custom']) ){
					$str_defaults_custom = $arr_args['defaults_custom'];
				}
				
				$arr_array_merge_ez = array(
											$this->select_defaults(	$str_defaults ), 
											$this->select_defaults_custom( $str_defaults_custom ), 
											$arr_args
										);
				$arr_args = WP_ezMethods::array_merge_ez($arr_array_merge_ez);
				
				$str_to_return =  $arr_args['html_tag_open'];
				if ( isset($arr_args['label']) && !empty($arr_args['label']) ){
					$str_to_return .= '<label for="';
					$str_to_return .= $arr_args['field_name'];
					$str_to_return .= '">';
					$str_to_return .= $arr_args['label'];
					$str_to_return .= '</label>';
				}
				$str_to_return .= $arr_args['html_tag_inner_open'];
				$str_to_return .= '<select';
				$str_to_return .= ' class="' . $arr_args['field_class'] . '"';
				$str_to_return .= ' id="' . $arr_args['field_id'] . '"';
				$str_to_return .= ' name="' . $arr_args['field_name'] . '"';
				//
				// TODO - set size to some function of total options?
				//
				if ( $arr_args['size'] !== false ){
					$str_to_return .= ' size="' . $arr_args['size']  . '"';
				}
				//
				if ( $arr_args['disabled'] !== false ){
					$str_to_return .= ' disabled ';
				}
				
				//
				if ( $arr_args['tabindex'] != false && is_integer((int) $arr_args['tabindex']) ){					
					$str_to_return .= ' tabindex="' . $arr_args['tabindex'] . '"';
				}
				
				//
				if ( $arr_args['lang'] !== false ){
					$str_to_return .= ' lang="' . $arr_args['lang']  . '"';
				}
				
				//
				if ( $arr_args['dir'] == 'LTR' || $arr_args['dir'] == 'RTL' ){
					$str_to_return .= ' dir="' . $arr_args['dir']  . '"';
				}
				
				$str_to_return .= ' ' . $arr_args['inline'] . '>';
								
				foreach ( $arr_args['options'] as $key => $value ){
					if ( ! isset($arr_args['options_exclude'][$key]) ){
						$str_to_return .= '<option value="';
						$str_to_return .= $key;
						$str_to_return .= '"';
						 
						$str_to_return .= selected($key, $arr_args['value'], false);
						$str_to_return .= '>';
						$str_to_return .= $value;
						$str_to_return .= '</option>';
					}
				}
				$str_to_return .= '</select>';
				$str_to_return .= $arr_args['html_tag_inner_close'];
				
				if ( isset($arr_args['footnote']) && !empty($arr_args['footnote']) ){
					$str_to_return .=  $arr_args['html_tag_footnote_open'] . $arr_args['footnote'] . $arr_args['html_tag_footnote_close'];
				}
				$str_to_return .=  $arr_args['html_tag_close'];
			}
			
			return $str_to_return;
		}

		
		/*
		 *
		 */
		public function select_defaults($str_preset = 'en_1'){
		
			$arr_defaults = array(
			
								'field_name'				=> 'select_default_name',
								'size'						=> false,
								'value'						=> '',
								'disabled'					=> false,
								'tabindex'					=> false,

								'label'						=> '',
								'field_id'					=> '',
								'field_class'				=> 'widefat',
								'lang'						=> false,
								'dir'						=> 'LTR',
								'title'						=> '',
								'inline'					=> '',				// will be added "as is"
								'multiple'					=> false,			// TODO - allow for multiple values. Should this be its own method?

								'options'					=> array(),
								'options_exclude'			=> array(), 								
								
								'html_tag_open'				=> '<div class="wp-ezc-forms-controls-1-wrap-outer wp-ezc-forms-controls-1-wrap-select">',				// before the label. wrap the whole lot
								'html_tag_close'			=> '</div>',			
								'html_tag_inner_open'		=> '<div class="wp-ezc-forms-controls-1-wrap-inner wp-ezc-forms-controls-1-wrap-select">',				// wraps the actual select
								'html_tag_inner_close'		=> '</div>',
								'html_tag_footnote_open'	=> '<div class="wp-ezc-forms-controls-1-footnote wp-ezc-forms-controls-1-footnote-select">',				// wraps the footnote.
								'html_tag_footnote_close'	=> '</div>',								
								'footnote'					=> '',
							);
							
			return $arr_defaults;
		}
		
		/*
		 * Selectively override the defauls with your own. This array gets array_merge()'ed over top of the text_input_defaults() array. 
		 *
		 * Important: At the very least these are the key => value you should be passing in so that you can define / configure a proper and unique text input. 
		 */
		public function select_defaults_custom($str_preset = 'en_1'){
		
			$arr_args_defaults_custom = array(
											'field_name'				=> 'select_default_name',
											'value'						=> '',
											'label'						=> '',
											'field_id'					=> '',
											
											'options'					=> array(),
											'options_exclude'			=> array(), 							// e.g., key_value => true. For example, you have a list of 50 states but you only want the lower 48. This will allow you to selectively excluded Hawaii and Alaska
										);
							
			return $arr_args_defaults_custom;
		}
		
	
	
		/*
		 * Control: Text Input Textare - Puts together the html and returns it. Also uses method: text_input_textarea_defaults(). Please see the text_input_textarea_defaults() for what you can pass in and how (i.e., array keys).
		 */
		public function text_input_textarea($arr_args){
		
			$str_to_return = '<!-- args passed to text_input_textarea was not an array -->';
			if ( is_array($arr_args) ){
			
				$arr_args = array_merge($this->text_input_textarea_defaults('en_1'), $arr_args);
				if ( wpezMethods::array_key_pass($arr_args, 'arr_args') ){
					$arr_args['arr_args'] = array_merge($this->text_input_textarea_arr_args_defaults('en_1'), $arr_args['arr_args']);
				} else {
					$arr_args['arr_args'] = $this->text_input_textarea_arr_args_defaults('en');
				}
				
				$str_to_return =  $arr_args['html_tag_open'];
				if ( isset($arr_args['label']) && !empty($arr_args['label']) ){
					$str_to_return .= '<label for="';
					$str_to_return .= $arr_args['field_name'];
					$str_to_return .= '">';
					$str_to_return .= $arr_args['label'];
					$str_to_return .= '</label>';
				}
				
				$str_maxlength = '';
				if ( isset($arr_args['arr_args']['maxlength']) && !empty($arr_args['arr_args']['maxlength']) ){
					$str_maxlength = ' maxlength="' . $arr_args['arr_args']['maxlength'] . '" ';
				}
				$str_to_return .= $arr_args['html_tag_inner_open'];
				$str_to_return .= '<text_input_textarea name="' . $arr_args['field_name'] . '" id="' . $arr_args['field_id'] . '" class="' .  $arr_args['field_class'] . '" ';
				$str_to_return .= ' rows="' . $arr_args['arr_args']['rows'] . '" cols="' . $arr_args['arr_args']['cols'] . '"' . $str_maxlength . ' ' . $arr_args['inline']  .'>';
				$str_to_return .= $arr_args['value'];
				$str_to_return .= '</text_input_textarea>';
				$str_to_return .= $arr_args['html_tag_inner_close'];
				
				if ( isset($arr_args['footnote']) && !empty($arr_args['footnote']) ){
					$str_to_return .=   $arr_args['html_tag_footnote_open'] . $arr_args['footnote'] .  $arr_args['html_tag_footnote_close'];
				}
				$str_to_return .=  $arr_args['html_tag_close'];
			}
			return $str_to_return;
		}
		
		/*
		 *
		 */
		public function text_input_textarea_defaults($str_preset = 'en_1'){
		
			$arr_defaults = array(
								'field_name'				=> 'textarea_default_name',
								'value'						=> '',
								'label'						=> '',
								'field_id'					=> '',
								'field_class'				=> '',
								
								'rows'						=> '2',
								'cols'						=> '250',
								'maxlength'					=> '5000',	
								
								'inline'					=> '',																										// will be added "as is"
								'html_tag_open'				=> '<div class="wp-ezc-forms-controls-1-wrap-outer wp-ezc-forms-controls-1-textarea">',						// before the label. wrap the whole lot
								'html_tag_close'			=> '</div>',			
								'html_tag_inner_open'		=> '<div class="wp-ezc-forms-controls-1-wrap-inner wp-ezc-forms-controls-1-textarea">',			// wraps the actual select
								'html_tag_inner_close'		=> '</div>',
								'html_tag_footnote_open'	=> '<div class="wp-ezc-forms-controls-1-footnote wp-ezc-forms-controls-1-footnote-textarea">',				// wraps the footnote.
								'html_tag_footnote_close'	=> '</div>',								
								'footnote'					=> '',		
							);				
			return $arr_defaults;
		}
		
		/*
		 *
		 */
		public function text_input_textarea_defaults_custom($str_preset = 'en_1'){
		
			$arr_arr_args_defaults = array( 
										'field_name'				=> 'textarea_default_name',
										'field_id'					=> '',
										'rows'						=> '2',
										'cols'						=> '250',
										'maxlength'					=> '5000',		
							);				
			return $arr_arr_args_defaults;
		}
		
		/*
		 * http://en.wikipedia.org/wiki/File_select
		 */
		public function file_select($arr_args){
		
			$str_to_return = '<!-- args passed to file_select was not an array -->';
			if ( is_array($arr_args) ){
			
				$str_defaults = 'en_1';
				if ( isset($arr_args['defaults']) && is_string($arr_args['defaults']) ){
					$str_defaults = $arr_args['defaults'];
				}
				$arr_args = array_merge($this->file_select_defaults($str_defaults), $arr_args);
				
				$str_defaults_custom = 'en_1';
				if ( isset($arr_args['defaults_custom']) && is_string($arr_args['defaults_custom']) ){
					$str_defaults_custom = $arr_args['defaults_custom'];
				}
				
				$arr_args = array_merge($this->file_select_defaults_custom($str_defaults_custom), $arr_args);
				if ( WP_ezMethods::array_key_pass($arr_args, 'arr_args') ){
					$arr_args['arr_args'] = array_merge($this->file_select_defaults_custom($str_defaults_custom), $arr_args['arr_args']);
				} else {
					$arr_args['arr_args'] = $this->file_select_defaults_custom($str_defaults_custom);
				}
				
				$str_to_return =  $arr_args['html_tag_open'];
				if ( isset($arr_args['label']) && !empty($arr_args['label']) ){
					$str_to_return .= '<label for="' . $arr_args['field_name'] . '">';
					$str_to_return .= $arr_args['label'];
					$str_to_return .= '</label>';
				}
	
	// $str_to_return .= '<input type="file" name="pov_closed_caption_file" id="pov-closed-caption-file" style="width:100%"/></p>';

					
				$str_to_return .= $arr_args['html_tag_inner_open'];
				$str_to_return .= '<input '; 
				if ( isset($arr_args['field_class']) && ! empty($arr_args['field_class']) ){
					$str_to_return .= ' class="' . $arr_args['field_class'] . '"';
				}
				$str_to_return .= ' id="' . $arr_args['field_id'] . '" name="' . $arr_args['field_name'] . '" type="file" ';
				
				if ( $arr_args['accept'] !== false ){
					$str_to_return .= ' accept="' . $arr_args['accept'] .'" ';
				}
				
				if ( $arr_args['disabled'] !== false ){
					$str_to_return .= ' disabled="' . 'disabled' .'" ';
				}
				
				if ( $arr_args['autofocus'] !== false ){
					$str_to_return .= ' autofocus="' . 'autofocus' .'" ';
				}
				
				if ( $arr_args['required'] !== false ){
					$str_to_return .= ' required="' . 'required' .'" ';
				}
				
				if ( $arr_args['multiple'] !== false ){
					$str_to_return .= ' multiple="' . 'multiple' .'" ';
				}
				
				if ( isset($arr_args['arr_args']['size']) && !empty($arr_args['arr_args']['size']) ){
					$str_to_return .= 'size="' . $arr_args['arr_args']['size'] . '" ';
				}
				$str_to_return .= ' ' . $arr_args['inline'] . ' />';
				$str_to_return .= $arr_args['html_tag_inner_close'];

				if ( isset($arr_args['footnote']) && !empty($arr_args['footnote']) ){
					$str_to_return .=  $arr_args['html_tag_footnote_open'] . $arr_args['footnote'] . $arr_args['html_tag_footnote_close'];   
				}
				$str_to_return .= $arr_args['html_tag_close'];			
			}
			
			return $str_to_return;
		}
		
		/*
		 * without this WP will not recognize the input type: file
		 */
		/*
		 * USE:
		 * if ( is_admin() ){
		 * add_action('post_edit_form_tag', array($this->_obj_forms_controls_1, 'file_select_post_edit_form_tag'));
		 * }
		 *
		 * OR add enctype="multipart/form-data" to your <form> tag. e.g., echo '<form method="post" enctype="multipart/form-data">'
		 */
		public function file_select_post_edit_form_tag() {
			echo ' enctype="multipart/form-data"';
		}
		
		
		/*
		 * http://en.wikipedia.org/wiki/File_select
		 *
		 * http://www.w3.org/TR/html-markup/input.file.html
		 */		
		public function file_select_defaults(){
		
			$arr_defaults = array(
								'field_name'				=> 'file_select_default_name',
								'disabled'					=> false,
								'form'						=> '',								
								'accept'					=> false,
								'autofocus'					=> false,
								'required'					=> false,
								'multiple'					=> false,
								'label'						=> '',
								'field_id'					=> '',
								'field_class'				=> '',
								
								'inline'					=> '',																								// will be added "as is"
								'html_tag_open'				=> '<div class="wp-ezc-forms-controls-1-wrap-outer wp-ezc-forms-controls-1-wrap-file-select">',			// before the label. wrap the whole lot
								'html_tag_close'			=> '</div>',			
								'html_tag_inner_open'		=> '<div class="wp-ezc-forms-controls-1-wrap-inner wp-ezc-forms-controls-1-wrap-file-select">',			// wraps the actual select
								'html_tag_inner_close'		=> '</div>',
								'html_tag_footnote_open'	=> '<div class="wp-ezc-forms-controls-1-footnote wp-ezc-forms-controls-1-footnote-file-select">',			// wraps the footnote.
								'html_tag_footnote_close'	=> '</div>',								
								'footnote'					=> '',				
							);				
			return $arr_defaults;
		}
		
		/*
		 *
		 */
		public function file_select_defaults_custom($str_preset = 'en1'){
		
			$arr_arr_args_defaults = array( 
										'field_name'				=> 'file_select_default_name',
										'field_id'					=> '',
							);	
							
			return $arr_arr_args_defaults;
		}
		
		
		public function radio(){
		
			//TODO
		}
		
		public function radio_defaults(){
		
			//TODO
		}
		
		public function radio_defaults_custom(){
		
			//TODO
		}
		
		public function multi_select(){
		
			//TODO
		}
		
		
		
		public function multi_select_defaults(){
		
			//TODO
		}
		
		public function multi_select_defaults_custom(){
		
			//TODO
		}
		
		public function checkboxes(){
		
			//TODO
		}
		
		public function checkboxes_defaults(){
		
			//TODO
		}
		
		public function checkboxes_defaults_custom(){
		
			//TODO
		}
		
	}
}

?>