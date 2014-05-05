<?php
/*-------------------------------------------------------*/
/* Jumpstart Child Theme - Rebel customized for eManager
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Custom Gravity Forms for eManager 2.0
/*-------------------------------------------------------*/
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );
/*-------------------------------------------------------*/
/* Load in Footer
/*-------------------------------------------------------*/
if ($options['gf_footer_scripts'] == 'Yes') {
    add_filter('gform_init_scripts_footer', '__return_true');

    add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );
    function wrap_gform_cdata_open( $content = '' ) {
        $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
        return $content;
    }
    add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );
    function wrap_gform_cdata_close( $content = '' ) {
        $content = ' }, false );';
        return $content;
    }
}
/*-------------------------------------------------------*/
/* Add disable Class
/*-------------------------------------------------------*/
if ($options['gf_disable'] == 'Yes') {
    add_action( 'wp_enqueue_scripts', 'gf_disableclass' );
        function gf_disableclass() {
            wp_register_script( 'gravity.disable-js', ME_REBEL_URI . '/assets/js/gravity.disable.js' );
            wp_enqueue_script('gravity.disable-js');
        }
}
/*-------------------------------------------------------*/
/* Product Experiment
/* Merge Tags as Dynamic Population Parameters
/* http://gravitywiz.com/2012/05/22/dynamic-products-via-post-meta/
/*-------------------------------------------------------*/
add_filter('gform_pre_render', 'gform_prepopluate_merge_tags');
function gform_prepopluate_merge_tags($form) {
     
    $filter_names = array();
     
    foreach($form['fields'] as &$field) {
         
        if(!rgar($field, 'allowsPrepopulate'))
            continue;
         
        // complex fields store inputName in the "name" property of the inputs array
        if(is_array(rgar($field, 'inputs')) && $field['type'] != 'checkbox') {
            foreach($field['inputs'] as $input) {
                if(rgar($input, 'name'))
                    $filter_names[] = array('type' => $field['type'], 'name' => rgar($input, 'name'));
            }
        } else {
            $filter_names[] = array('type' => $field['type'], 'name' => rgar($field, 'inputName'));
        }
         
    }
     
    foreach($filter_names as $filter_name) {
         
        $filtered_name = GFCommon::replace_variables_prepopulate($filter_name['name']);
         
        if($filter_name['name'] == $filtered_name)
            continue;
         
        add_filter("gform_field_value_{$filter_name['name']}", create_function("", "return '$filtered_name';"));
    }
     
    return $form;
}
/*-------------------------------------------------------*/
/* Require All Columns of List Field
/* http://gravitywiz.com/require-all-columns-of-list-field/
/*-------------------------------------------------------*/
class GWRequireListColumns {
 
    private $field_ids;
    
    public static $fields_with_req_cols = array();
 
    function __construct($form_id = '', $field_ids = array(), $required_cols = array()) {
 
        $this->field_ids = ! is_array( $field_ids ) ? array( $field_ids ) : $field_ids;
        $this->required_cols = ! is_array( $required_cols ) ? array( $required_cols ) : $required_cols;
        
        if( ! empty( $this->required_cols ) ) {
            
            // convert values from 1-based index to 0-based index, allows users to enter "1" for column "0"
            $this->required_cols = array_map( create_function( '$val', 'return $val - 1;' ), $this->required_cols );
            
            if( ! isset( self::$fields_with_req_cols[$form_id] ) )
                self::$fields_with_req_cols[$form_id] = array();
            
            // keep track of which forms/fields have special require columns so we can still apply GWRequireListColumns 
            // to all list fields and then override with require columns for specific fields as well
            self::$fields_with_req_cols[$form_id] = array_merge( self::$fields_with_req_cols[$form_id], $this->field_ids );
            
        }
        
        $form_filter = $form_id ? "_{$form_id}" : $form_id;
        add_filter("gform_validation{$form_filter}", array(&$this, 'require_list_columns'));
 
    }
 
    function require_list_columns($validation_result) {
 
        $form = $validation_result['form'];
        $new_validation_error = false;
 
        foreach($form['fields'] as &$field) {
 
            if(!$this->is_applicable_field($field, $form))
                continue;
 
            $values = rgpost("input_{$field['id']}");
 
            // If we got specific fields, loop through those only
            if( count( $this->required_cols ) ) {
 
                foreach($this->required_cols as $required_col) {
                    if(empty($values[$required_col])) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }
 
            } else {
                
                // skip fields that have req cols specified by another GWRequireListColumns instance
                $fields_with_req_cols = rgar( self::$fields_with_req_cols, $form['id'] );
                if( is_array( $fields_with_req_cols ) && in_array( $field['id'], $fields_with_req_cols ) )
                    continue;
                
                foreach($values as $value) {
                    if(empty($value)) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }
 
            }
        }
 
        $validation_result['form'] = $form;
        $validation_result['is_valid'] = $new_validation_error ? false : $validation_result['is_valid'];
 
        return $validation_result;
    }
 
    function is_applicable_field($field, $form) {
 
    if($field['pageNumber'] != GFFormDisplay::get_source_page($form['id']))
        return false;
 
    if($field['type'] != 'list' || RGFormsModel::is_field_hidden($form, $field, array()))
        return false;
 
    // if the field has already failed validation, we don't need to fail it again
    if(!$field['isRequired'] || $field['failed_validation'])
        return false;
 
    if(empty($this->field_ids))
        return true;
 
    return in_array($field['id'], $this->field_ids);
}
 
}
 
/**
 * Calculate Number of Days via Two Date Fields
 * http://gravitywiz.com/calculate-number-of-days-between-two-dates/
 */
class GWDayCount {
 
    private static $script_output;
 
    function __construct( $args ) {
 
        extract( wp_parse_args( $args, array(
            'form_id'          => false,
            'start_field_id'   => false,
            'end_field_id'     => false,
            'count_field_id'   => false,
            'include_end_date' => true,
            ) ) );
 
        $this->form_id        = $form_id;
        $this->start_field_id = $start_field_id;
        $this->end_field_id   = $end_field_id;
        $this->count_field_id = $count_field_id;
        $this->count_adjust   = $include_end_date ? 1 : 0;
 
        add_filter( "gform_pre_render_{$form_id}", array( &$this, 'load_form_script') );
        add_action( "gform_pre_submission_{$form_id}", array( &$this, 'override_submitted_value') );
 
    }
 
    function load_form_script( $form ) {
        
        // workaround to make this work for < 1.7
        $this->form = $form;
        add_filter( 'gform_init_scripts_footer', array( &$this, 'add_init_script' ) );
        
        if( self::$script_output )
            return $form;
 
        ?>
 
        <script type="text/javascript">
 
        (function($){
 
            window.gwdc = function( options ) {
 
                this.options = options;
                this.startDateInput = $( '#input_' + this.options.formId + '_' + this.options.startFieldId );
                this.endDateInput = $( '#input_' + this.options.formId + '_' + this.options.endFieldId );
                this.countInput = $( '#input_' + this.options.formId + '_' + this.options.countFieldId );
 
                this.init = function() {
 
                    var gwdc = this;
 
                    // add data for "format" for parsing date
                    gwdc.startDateInput.data( 'format', this.options.startDateFormat );
                    gwdc.endDateInput.data( 'format', this.options.endDateFormat );
 
                    gwdc.populateDayCount();
 
                    $(document).on( 'change', '#' + this.startDateInput.attr('id') + ', #' + this.endDateInput.attr('id'), function(){
                        gwdc.populateDayCount();
                    });
 
                }
 
                this.getDayCount = function() {
 
                    var startDate = this.parseDate( this.startDateInput.val(), this.startDateInput.data('format') )
                    var endDate = this.parseDate( this.endDateInput.val(), this.endDateInput.data('format') );
                    var dayCount = 0;
 
                    if( !this.isValidDate( startDate ) || !this.isValidDate( endDate ) )
                        return '';
 
                    if( startDate > endDate ) {
                        return 0;
                    } else {
 
                        var diff = endDate - startDate;
                        dayCount = diff / ( 60 * 60 * 24 * 1000 ); // secs * mins * hours * milliseconds
                        dayCount = Math.round( dayCount ) + this.options.countAdjust;
 
                        return dayCount;
                    }
 
                }
 
                this.parseDate = function( value, format ) {
 
                    if( !value )
                        return false;
 
                    format = format.split('_');
                    var dateFormat = format[0];
                    var separators = { slash: '/', dash: '-', dot: '.' };
                    var separator = format.length > 1 ? separators[format[1]] : separators.slash;
                    var dateArr = value.split(separator);
 
                    switch( dateFormat ) {
                    case 'mdy':
                        return new Date( dateArr[2], dateArr[0] - 1, dateArr[1] );
                    case 'dmy':
                        return new Date( dateArr[2], dateArr[1] - 1, dateArr[0] );
                    case 'ymd':
                        return new Date( dateArr[0], dateArr[1] - 1, dateArr[2] );
                    }
 
                    return false;
                }
 
                this.populateDayCount = function() {
                    this.countInput.val( this.getDayCount() ).change();
                }
 
                this.isValidDate = function( date ) {
                    return !isNaN( Date.parse( date ) );
                }
 
                this.init();
 
            }
 
        })(jQuery);
 
        </script>
 
        <?php
        self::$script_output = true;
        return $form;
    }
    
    function add_init_script( $return ) {
        
        $start_field_format = false;
        $end_field_format = false;
 
        foreach( $this->form['fields'] as &$field ) {
 
            if( $field['id'] == $this->start_field_id )
                $start_field_format = $field['dateFormat'] ? $field['dateFormat'] : 'mdy';
 
            if( $field['id'] == $this->end_field_id )
                $end_field_format = $field['dateFormat'] ? $field['dateFormat'] : 'mdy';
 
        }
        
        $script = "new gwdc({
                formId:             {$this->form['id']},
                startFieldId:       {$this->start_field_id},
                startDateFormat:    '$start_field_format',
                endFieldId:         {$this->end_field_id},
                endDateFormat:      '$end_field_format',
                countFieldId:       {$this->count_field_id},
                countAdjust:        {$this->count_adjust}
            });";
        
        GFFormDisplay::add_init_script( $this->form['id'], 'gw_display_count_' . $this->count_field_id, GFFormDisplay::ON_PAGE_RENDER, $script );
        
        // remove filter so init script is not output on subsequent forms
        remove_filter( 'gform_init_scripts_footer', array( &$this, 'add_init_script' ) );
        
        return $return;
    }
 
    function override_submitted_value( $form ) {
 
        $start_date = false;
        $end_date = false;
 
        foreach( $form['fields'] as &$field ) {
 
            if( $field['id'] == $this->start_field_id )
                $start_date = self::parse_field_date( $field );
 
            if( $field['id'] == $this->end_field_id )
                $end_date = self::parse_field_date( $field );
 
        }
 
        if( $start_date > $end_date ) {
 
            $day_count = 0;
 
        } else {
 
            $diff = $end_date - $start_date;
            $day_count = $diff / ( 60 * 60 * 24 ); // secs * mins * hours
            $day_count = round( $day_count ) + $this->count_adjust;
 
        }
 
        $_POST["input_{$this->count_field_id}"] = $day_count;
 
    }
 
    static function parse_field_date( $field ) {
 
        $date_value = rgpost("input_{$field['id']}");
        $date_format = empty( $field['dateFormat'] ) ? 'mdy' : esc_attr( $field['dateFormat'] );
        $date_info = GFCommon::parse_date( $date_value, $date_format );
 
        return strtotime( "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}" );
    }
 
}

/*-------------------------------------------------------*/
/* Custom Taxnomies for Gravity Forms
/* http://www.gravityhelp.com/forums/topic/custom-posts-and-custom-taxonomies
/*-------------------------------------------------------*/

add_action("gform_field_advanced_settings", "ounce_gform_field_advanced_settings", 10, 2);
function ounce_gform_field_advanced_settings($position, $form_id){
    
    if($position == 50){
        ?>
        <li id="populate_taxonomy_settings" style="display:block;">
            <label for="field_admin_label">
                <?php _e("Populate with a Taxonomy", "gravityforms"); ?>
                <?php gform_tooltip("form_field_custom_taxonomy") ?>
            </label>
            <input type="checkbox" id="field_enable_populate_taxonomy" onclick="togglePopulateTaxonomy(jQuery('#field_populate_taxonomy'), '');" /> Enable population with a taxonomy<br />
            
            <select id="field_populate_taxonomy" onchange="SetFieldProperty('populateTaxonomy', jQuery(this).val());" style="margin-top:10px; display:none;">
                <option value="" style="color:#999;">Select a Taxonomy</option>
            <?php
            $taxonomies = get_taxonomies('', 'objects');
            foreach($taxonomies as $taxonomy): ?>
            
                <option value="<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->label; ?></option>
                
            <?php endforeach; ?>
            </select>
            
        </li>
        <?php
    }
    
}

// action to inject supporting script to the form editor page
add_action("gform_editor_js", "ounce_gform_editor_scripts");
function ounce_gform_editor_scripts(){
    ?>
    <script type='text/javascript'>

        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
            
            var valid_types = new Array('select');
            if(jQuery.inArray(field['type'], valid_types) != -1) {
                jQuery('#populate_taxonomy_settings').show();
            } else {
                jQuery('#populate_taxonomy_settings').hide();
            }
            
            var populateTaxonomy = (typeof field['populateTaxonomy'] != 'undefined' && field['populateTaxonomy'] != '') ? field['populateTaxonomy'] : false;
            
            jQuery("#field_enable_populate_taxonomy").attr("checked", populateTaxonomy != false);
            togglePopulateTaxonomy(jQuery('#field_populate_taxonomy'), populateTaxonomy);
            
        });
        
        function togglePopulateTaxonomy(elem, taxonomy){
            
            var checked = jQuery("#field_enable_populate_taxonomy").attr('checked');
            
            if(checked){
                jQuery(elem).slideDown(function(){
                    jQuery(this).val(taxonomy); 
                });
            } else {
                jQuery(elem).slideUp(function(){
                    jQuery(this).val(taxonomy); 
                });
            }
            
            
        }
        
    </script>
    <?php
}

// filter to add a new tooltip
add_filter('gform_tooltips', 'ounce_gform_tooltips');
function ounce_gform_tooltips($tooltips){
   $tooltips["form_field_custom_taxonomy"] = "<h6>Populate with a Taxonomy</h6>Check this box to populate this field from a taxonomy.";
   return $tooltips;
}

// filter to populate taxonomy in designated fields
add_filter('gform_pre_render', 'ounce_gform_populate_taxonomy');
function ounce_gform_populate_taxonomy($form){
    
    foreach($form['fields'] as &$field){
        
        if(!$field['populateTaxonomy'])
            continue;
        
        $taxonomy = $field['populateTaxonomy'];
        $first_choice = $field['choices'][0]['text'];
        $field['choices'] = ounce_taxonomy_as_choices($taxonomy, $first_choice);
    }

    return $form;
}

function ounce_taxonomy_as_choices($taxonomy = "categories", $first_choice = '') {
    
    $terms = get_terms($taxonomy, 'orderby=name&hide_empty=0');
    $taxonomy = get_taxonomy($taxonomy);
    $choices = array();
    $i = 0;
    
    switch($first_choice){
    
    // if no default option is specified, dynamically create based on taxonomy name
    case '':
        $choices[$i]['text'] = "Select a {$taxonomy->labels->singular_name}";
        $choices[$i]['value'] = "";
        $i++;
        break;
        
    // populate the first item from the original choices array
    default:
        $choices[$i]['text'] = $first_choice;
        $choices[$i]['value'] = '';
        $i++;
        break;
    }
    
    foreach($terms as $term) {
        $choices[$i]['text'] = $term->name;
        $choices[$i]['value'] = $term->term_id;
        $i++;
    }
    
    return $choices;
}

add_action('gform_post_submission', 'ounce_gform_post_submission', 10, 2);
function ounce_gform_post_submission($entry, $form) {
    
    // if no post was created, return
    if(!$entry['post_id'])
        return;
    
    $terms = array();
    $i = 0;
    foreach($form['fields'] as $field){
        
        if(!$field['populateTaxonomy'])
            continue;
        
        $terms[$i]['taxonomy'] = $field['populateTaxonomy'];
        $terms[$i]['term_id'] = $entry[$field['id']];
        $i++;
    }
    
    // if we don't have any terms, return
    if(empty($terms))
        return;
    
    foreach($terms as $term) {
        wp_set_object_terms($entry['post_id'], (int) $term['term_id'], $term['taxonomy'], true);   
    }

}

/* end Custom Taxonomies for Graivty Forms */

/**
* Better Pre-submission Confirmation
* http://gravitywiz.com/2012/08/04/better-pre-submission-confirmation/
*/
 
class GWPreviewConfirmation {
 
    private static $lead;
 
    function init() {
 
        add_filter('gform_pre_render', array('GWPreviewConfirmation', 'replace_merge_tags'));
        add_filter('gform_replace_merge_tags', array('GWPreviewConfirmation', 'product_summary_merge_tag'), 10, 3);
 
    }
 
    public static function replace_merge_tags($form) {
 
        $current_page = isset(GFFormDisplay::$submission[$form['id']]) ? GFFormDisplay::$submission[$form['id']]['page_number'] : 1;
        $fields = array();
 
        // get all HTML fields on the current page
        foreach($form['fields'] as &$field) {
 
            // skip all fields on the first page
            if(rgar($field, 'pageNumber') <= 1)
                continue;
 
            $default_value = rgar($field, 'defaultValue');
            preg_match_all('/{.+}/', $default_value, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                // if default value needs to be replaced but is not on current page, wait until on the current page to replace it
                if(rgar($field, 'pageNumber') != $current_page) {
                    $field['defaultValue'] = '';
                } else {
                    $field['defaultValue'] = self::preview_replace_variables($default_value, $form);
                }
            }
 
            // only run 'content' filter for fields on the current page
            if(rgar($field, 'pageNumber') != $current_page)
                continue;
 
            $html_content = rgar($field, 'content');
            preg_match_all('/{.+}/', $html_content, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                $field['content'] = self::preview_replace_variables($html_content, $form);
            }
 
        }
 
        return $form;
    }
 
    /**
    * Adds special support for file upload, post image and multi input merge tags.
    */
    public static function preview_special_merge_tags($value, $input_id, $merge_tag, $field) {
        
        // added to prevent overriding :noadmin filter (and other filters that remove fields)
        if( !$value )
            return $value;
        
        $input_type = RGFormsModel::get_input_type($field);
        
        $is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
        $is_multi_input = is_array( rgar($field, 'inputs') );
        $is_input = intval( $input_id ) != $input_id;
        
        if( !$is_upload_field && !$is_multi_input )
            return $value;
 
        // if is individual input of multi-input field, return just that input value
        if( $is_input )
            return $value;
            
        $form = RGFormsModel::get_form_meta($field['formId']);
        $lead = self::create_lead($form);
        $currency = GFCommon::get_currency();
 
        if(is_array(rgar($field, 'inputs'))) {
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            return GFCommon::get_lead_field_display($field, $value, $currency);
        }
 
        switch($input_type) {
        case 'fileupload':
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = self::preview_image_display($field, $form, $value);
            break;
        default:
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = GFCommon::get_lead_field_display($field, $value, $currency);
            break;
        }
 
        return $value;
    }
 
    public static function preview_image_value($input_name, $field, $form, $lead) {
 
        $field_id = $field['id'];
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
        $source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];
 
        if(!$file_info)
            return '';
 
        switch(RGFormsModel::get_input_type($field)){
 
            case "post_image":
                list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
                $value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
                break;
 
            case "fileupload" :
                $value = $source;
                break;
 
        }
 
        return $value;
    }
 
    public static function preview_image_display($field, $form, $value) {
 
        // need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
        $input_name = "input_" . str_replace('.', '_', $field['id']);
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
 
        $file_path = $value;
        if(!empty($file_path)){
            $file_path = esc_attr(str_replace(" ", "%20", $file_path));
            $value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
        }
        return $value;
 
    }
 
    /**
    * Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
    */
    public static function create_lead( $form ) {
        
        if( empty( self::$lead ) ) {
            self::$lead = RGFormsModel::create_lead( $form );
            self::clear_field_value_cache( $form );
        }
        
        return self::$lead;
    }
 
    public static function preview_replace_variables($content, $form) {
 
        $lead = self::create_lead($form);
 
        // add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
        // beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
        // result in an infinite loop if not called first above
        add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);
 
        $content = GFCommon::replace_variables($content, $form, $lead, false, false, false);
 
        // remove filter so this function is not applied after preview functionality is complete
        remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));
 
        return $content;
    }
 
    public static function product_summary_merge_tag($text, $form, $lead) {
 
        if(empty($lead))
            $lead = self::create_lead($form);
 
        $remove = array("<tr bgcolor=\"#EAF2FA\">\n                            <td colspan=\"2\">\n                                <font style=\"font-family: sans-serif; font-size:12px;\"><strong>Order</strong></font>\n                            </td>\n                       </tr>\n                       <tr bgcolor=\"#FFFFFF\">\n                            <td width=\"20\">&nbsp;</td>\n                            <td>\n                                ", "\n                            </td>\n                        </tr>");
        $product_summary = str_replace($remove, '', GFCommon::get_submitted_pricing_fields($form, $lead, 'html'));
 
        return str_replace('{product_summary}', $product_summary, $text);
    }
    
    public static function clear_field_value_cache( $form ) {
        
        if( ! class_exists( 'GFCache' ) )
            return;
            
        foreach( $form['fields'] as &$field ) {
            if( GFFormsModel::get_input_type( $field ) == 'total' )
                GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
        }
        
    }
 
}
 
GWPreviewConfirmation::init();

/*-------------------------------------------------------*/
/* Gravity Forms Encryptorator
/* https://github.com/humanmade/Gravity-Forms-Encryptorator
/*-------------------------------------------------------*/
// TODO - Long entry details get truncated after they are encrypted which mean the short version is nonsensical, that breaks the detail list page view .
 
// Show a message in the admin if the public key path isn't working
if ($options['emgf_encryptorator'] == 'No') {
    define( 'HMGFE_PUBLIC_KEY', $options['emgf_ssl_key'] );

    if ( ! defined ( 'HMGFE_PUBLIC_KEY' ) || ( defined( 'HMGFE_PUBLIC_KEY' ) && ! HMGFE_PUBLIC_KEY ) || ( defined( 'HMGFE_PUBLIC_KEY' ) && ! is_readable( HMGFE_PUBLIC_KEY ) ) )
        add_action( 'admin_notices', function() { ?>
     
            <div id="hmgfe-warning" class="updated fade"><p><strong><?php _e( 'Gravity Forms Encryptorator is almost ready.', 'hmgfe' ); ?></strong> <?php printf( __( 'You need to set the path to your public key file by adding %2$s to your %1$s file.', 'hmgfe' ), '<code>wp-config.php</code>', '<code>define( \'HMGFE_PUBLIC_KEY\', \'path/to/your/keyfile.pem\' );</code>' ); ?></p></div>
     
        <?php } );
     
    add_filter( 'gform_save_field_value', function( $value, $lead, $field, $form ) {
     
        // Load the public key
        if ( defined( 'HMGFE_PUBLIC_KEY' ) && HMGFE_PUBLIC_KEY && file_exists( HMGFE_PUBLIC_KEY ) && is_readable( HMGFE_PUBLIC_KEY ) ) {
     
            $public_key = openssl_get_publickey( fread( $handle = fopen( HMGFE_PUBLIC_KEY, 'r' ), 8192 ) );
            fclose( $handle );
     
            // If we have a public key then encyrpt the data
            if ( ! empty( $public_key ) && openssl_seal( $value, $encrypted_value, $env_keys, array( $public_key ) ) )
                $value = base64_encode( $encrypted_value ) . ':::' . base64_encode( reset( $env_keys ) );
     
            // Free the key from memory
            openssl_free_key( $public_key );
     
        }
     
        return $value;
     
    }, 10, 4 );
     
    add_filter( 'gform_get_field_value', function( $value, $lead, $field ) {
     
        // If we have a decryption key
        if ( defined( 'HMGFE_PRIVATE_KEY' ) && HMGFE_PRIVATE_KEY && file_exists( HMGFE_PRIVATE_KEY ) && is_readable( HMGFE_PRIVATE_KEY ) ) {
     
            $private_key = openssl_get_privatekey( fread( $handle = fopen( HMGFE_PRIVATE_KEY, 'r' ), 8192 ) );
            fclose( $handle );
     
            if ( is_string( $value ) ) {
     
                $encrypted_value = base64_decode( reset( explode( ':::', $value ) ) );
                $env_key = base64_decode( end( explode( ':::', $value ) ) );
     
                // If we have a public key then encyrpt the data
                if ( $env_key && openssl_open( $encrypted_value, $decrypted_value, $env_key, $private_key ) )
                    $value = $decrypted_value;
     
            }
     
            // Decrypt data in arrays
            if ( is_array( $value ) )
     
                array_walk( $value, function( &$value ) use ( $private_key ) {
     
                    $encrypted_value = base64_decode( reset( explode( ':::', $value ) ) );
                    $env_key = base64_decode( end( explode( ':::', $value ) ) );
     
                    // If we have a public key then encyrpt the data
                    if ( $env_key && openssl_open( $encrypted_value, $decrypted_value, $env_key, $private_key ) )
                        $value = $decrypted_value;
     
            } );
     
            // Free the key from memory
            openssl_free_key( $private_key );
     
        }
     
        // If the data is encrypted and we don't have the decryption key
        if ( ! defined( 'HMGFE_PRIVATE_KEY' ) && defined( 'HMGFE_PUBLIC_KEY' ) ) {
     
            if ( is_string( $value ) && base64_decode( $value ) != $value )
                $value = str_pad( '', 49, '&#9608;' );
     
            elseif ( is_array( $value ) )
                $value = array_pad( array(), count( $value ), str_pad( '', 42, '&#9608;' ) );
     
        }
     
        return $value;
     
    }, 10, 3 );
}
?>