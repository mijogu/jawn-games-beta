<?php

if(!defined('ABSPATH'))
    exit;

if(!class_exists('acfe_field_button')):

class acfe_field_button extends acf_field{
    
    function __construct(){

        $this->name = 'acfe_button';
        $this->label = __('Button', 'acfe');
        $this->category = 'basic';
        $this->defaults = array(
            'button_value'  => __('Submit', 'acfe'),
            'button_type'   => 'button',
            'button_before' => '',
            'button_after'  => '',
            'button_class'  => 'button button-secondary',
            'button_id'     => '',
            'button_ajax'   => 0,
        );
        
        add_action('wp_ajax_acfe/fields/button',        array($this, 'ajax_request'), 99);
        add_action('wp_ajax_nopriv_acfe/fields/button', array($this, 'ajax_request'), 99);

        parent::__construct();

    }
    
    function ajax_request(){
        
        // vars
        $field_key = acf_maybe_get_POST('field_key', '');
        $post_id = acf_maybe_get_POST('post_id', 0);
        $acf = acf_maybe_get_POST('acf', array());
        
        // get field
        $field = acf_get_field($field_key);
        
        // field not found
        if(!$field){
            die;
        }
        
        // setup meta
        acfe_setup_meta($acf, 'acfe/button', true);
            
            // actions
            do_action("acfe/fields/button",                         $field, $post_id);
            do_action("acfe/fields/button/name={$field['name']}",   $field, $post_id);
            do_action("acfe/fields/button/key={$field_key}",        $field, $post_id);
        
        // reset
        acfe_reset_meta();
        
        die;
        
    }
      
    function render_field_settings($field){
        
        // Value
        acf_render_field_setting($field, array(
            'label'         => __('Button value', 'acfe'),
            'instructions'  => __('Set a default button value', 'acfe'),
            'type'          => 'text',
            'name'          => 'button_value',
        ));
        
        // Type
        acf_render_field_setting($field, array(
            'label'         => __('Button type', 'acfe'),
            'instructions'  => __('Choose the button type', 'acfe'),
            'type'          => 'radio',
            'name'          => 'button_type',
            'layout'        => 'horizontal',
            'choices'       => array(
                'button'        => __('Button', 'acfe'),
                'submit'        => __('Input', 'acfe'),
            ),
        ));
        
        // class
        acf_render_field_setting($field, array(
            'label'         => __('Button attributes','acf'),
            'instructions'  => '',
            'type'          => 'text',
            'name'          => 'button_class',
            'prepend'       => __('class', 'acf'),
        ));
        
        // id
        acf_render_field_setting($field, array(
            'label'         => '',
            'instructions'  => '',
            'type'          => 'text',
            'name'          => 'button_id',
            'prepend'       => __('id', 'acf'),
            '_append'       => 'button_class'
        ));
        
        // Before HTML
        acf_render_field_setting($field, array(
            'label'         => __('Before HTML', 'acfe'),
            'instructions'  => __('Custom HTML before the button', 'acfe'),
            'type'          => 'acfe_code_editor',
            'name'          => 'button_before',
            'rows'          => 4,
        ));
        
        // After HTML
        acf_render_field_setting($field, array(
            'label'         => __('After HTML', 'acfe'),
            'instructions'  => __('Custom HTML after the button', 'acfe'),
            'type'          => 'acfe_code_editor',
            'name'          => 'button_after',
            'rows'          => 4,
        ));
        
        // Ajax
        acf_render_field_setting($field, array(
            'label'         => __('Ajax Request', 'acfe'),
            'instructions'  => __('Trigger ajax event on click', 'acfe') . '. <a href="https://www.acf-extended.com/features/fields/button" target="_blank">' . __('See documentation', 'acfe') . '</a>',
            'name'          => 'button_ajax',
            'type'          => 'true_false',
            'ui'            => 1,
        ));
        
    }
    
    function render_field($field){
        
        // Before
        if($field['button_before']){
            echo $field['button_before'];
        }
        
        $ajax = false;
        
        if($field['button_ajax']){
            $ajax = 'data-ajax="1"';
        }
        
        // Button
        if($field['button_type'] === 'button'){
            
            echo '<button
                type="submit"
                id="' . esc_attr($field['button_id']) . '" 
                class="' . esc_attr($field['button_class']) . '" 
                name="' . esc_attr($field['name']) . '"
                value="' . esc_attr($field['button_value']) . '"
                ' . $ajax . '
                >' . esc_attr($field['button_value']) . '</button>';
        
        // Submit
        }elseif($field['button_type'] === 'submit'){
            
            echo '<input 
                type="submit"
                id="' . esc_attr($field['button_id']) . '" 
                class="' . esc_attr($field['button_class']) . '"
                name="' . esc_attr($field['name']) . '"
                value="' . esc_attr($field['button_value']) . '"
                ' . $ajax . '
                />';
            
        }
        
        // After
        if($field['button_after']){
            echo $field['button_after'];
        }
        
    }
    
}

// initialize
acf_register_field_type('acfe_field_button');

endif;