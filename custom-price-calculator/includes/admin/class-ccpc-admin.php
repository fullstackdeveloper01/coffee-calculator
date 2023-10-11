<?php
/**
 * CCPC_Admin
 *
 * The CCPC_Admin Class.
 *
 * @class CCPC_Admin 
 * @category Class
 * @author   Vijendra
 */  
if ( ! class_exists( 'CCPC_Admin', false ) ) : 
	class CCPC_Admin {

		public function __construct()
		{ 
            add_action( 'admin_menu', array($this, 'create_coffee_custom_price_calculator_setting_page' )); 

            //add metabox in membership area
			add_action( 'admin_init', array( $this, 'add_meta_boxes') );
            
        }

        public function add_meta_boxes() 
		{
			add_meta_box( 'coffee_inquiry_type_user', __( 'Coffee Inquiry Details', 'coffee-custom-price-calculator' ), array( $this, 'coffee_inquiry_type_user_field'), 'coffee-inquiry', 'normal', 'high' );
		}
		public function coffee_inquiry_type_user_field() 
		{
            $post_id = 0; 
            $first_name = '';
            $postal_code = '';
            $business_name = '';
            $business_phone = '';
            $business_email = '';
            $employees = '';
            $options = '';
            $coffee_option = ''; 
            $total_monthly_cost = '';
            $price_per_cup = '';
            $monthly_price_per_employee = '';

            if( !empty( get_the_ID() ))
			{ 
				$post_id = get_the_ID();
				$first_name = get_post_meta($post_id, 'first_name', true); 
				$postal_code = get_post_meta($post_id, 'postal_code', true); 
				$business_name = get_post_meta($post_id, 'business_name', true); 
				$business_phone = get_post_meta($post_id, 'business_phone', true); 
				$business_email = get_post_meta($post_id, 'business_email', true); 
				$employees = get_post_meta($post_id, 'employees', true); 
				$options = get_post_meta($post_id, 'options', true); 
				$coffee_option = get_post_meta($post_id, 'coffee_option', true);  
				$total_monthly_cost = get_post_meta($post_id, 'total_monthly_cost', true); 
				$price_per_cup = get_post_meta($post_id, 'price_per_cup', true); 
				$monthly_price_per_employee = get_post_meta($post_id, 'monthly_price_per_employee', true); 
 			}
            ?>
                <div class="form-group">
                    <h4 class=""><strong> First Name : </strong> <?php echo $first_name; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong>   Postal Code : </strong> <?php echo $postal_code; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong> Business Name : </strong> <?php echo $business_name; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong> Email : </strong> <?php echo $business_email; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong> Phone : </strong> <?php echo $business_phone; ?></h4>  
                </div>
                
                <div class="form-group">
                    <h4 class=""><strong> Employees : </strong> <?php echo $employees; ?></h4>  
                </div> 
                <div class="form-group">
                    <h4 class=""><strong>Coffee Option : </strong> <?php echo $coffee_option; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong>Estimated total monthly price for coffee : </strong> <?php echo $total_monthly_cost; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong>Estimated price per cup : </strong> <?php echo $price_per_cup; ?></h4>  
                </div>
                <div class="form-group">
                    <h4 class=""><strong>Estimated monthly price per employee : </strong> <?php echo $monthly_price_per_employee; ?></h4>  
                </div>
                 
            <?php

        }

        public function create_coffee_custom_price_calculator_setting_page(){
             add_options_page('Coffee Calculator Settings','Coffee Calculator','manage_options','coffee-calculator-settings',array($this, 'coffee_custom_price_calculator_settings_page'));
        }

        public function coffee_custom_price_calculator_settings_page()
        {
            // Check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            // Save the settings if the form is submitted
            if (isset($_POST['coffee_calculator_options'])) {
                $coffee_calculator_options = $_POST['coffee_calculator_options'];
                if(!empty($coffee_calculator_options) && !empty($coffee_calculator_options['options']))
                {
                    $row = 0;
                    $options = array();
                    foreach ($coffee_calculator_options['options'] as $key => $value) {
                        $row++;
                        $options[$row] = $value;
                    }
                    $coffee_calculator_options['options'] = $options;
                } 
                update_option('coffee_calculator_options', $coffee_calculator_options);
            }

            // Get the current options
            $options = get_option('coffee_calculator_options', array(
                    'coffee_price' => 0,
                    'one_cup_average' => 0,
                    'average_employee_one_year' => 0,
                    'base_price_per_cup' => 0,
                    'options'=> array(
                        'option_1' => 1.25,
                        'option_2' => 1.18,
                        'option_3' => 1.2,
                        'option_4' => 1,
                        'option_5' => 0.95
                        )
                    )); 
            ?>
 
        <div class="col-md-12">
            <form method="post" id="add_payment_card">
                <input type="hidden" name="action" value="add_new_payment_card" />
                <table class="form-table" id="coffee_calculator_options">
                    <tbody> 
                            <tr>
                                <th><h3>Coffee Calculator Setting</h3></th> 
                            </tr>
                            <tr>
                                <th><label for="coffee_price">Coffee Base Price:<span class="required_span"><sup>*</sup></span></label></th>
                                <td>
                                <input class="form-control" type="text" name="coffee_calculator_options[coffee_price]" id="coffee_price" value="<?php echo esc_attr($options['coffee_price']); ?>" placeholder="Enter Price..">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="average_employee_one_year">Average Consumption Per Employee a Year:<span class="required_span"><sup>*</sup></span></label></th>
                                <td>
                                <input class="form-control" type="text" name="coffee_calculator_options[average_employee_one_year]" id="average_employee_one_year" value="<?php echo esc_attr($options['average_employee_one_year']); ?>" placeholder="Enter Price..">
                                </td>
                            </tr>
                            
                            <tr>
                                <th><label for="one_cup_price">Average Amount of Coffee in 1 Cup (grams):<span class="required_span"><sup>*</sup></span></label></th>
                                <td>
                                <input class="form-control" type="text" value="<?php echo esc_attr($options['one_cup_average']); ?>" name="coffee_calculator_options[one_cup_average]" id="one_cup_price" placeholder="Enter 1 Cup Grams">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="base_price_per_cup">Base Price Per Cup:<span class="required_span"><sup>*</sup></span></label></th>
                                <td>
                                <input class="form-control" type="text" name="coffee_calculator_options[base_price_per_cup]" value="<?php echo esc_attr($options['base_price_per_cup']); ?>" id="base_price_per_cup" placeholder="Per Cup Price">
                                </td>
                            </tr>
                            <tr>
                                <th><h3>Type of coffee options</h3></th> 
                                <td><a class="addMoreOptions" href="javascript:void(0);">+ Add New</a></td>
                            </tr> 
                            <?php
                                $optionsCount = 0;

                                if(!empty($options['options']))
                                {
                                    $optionsCount = count($options['options']);

                                    foreach ($options['options'] as $name => $val) {
                                        $tr='';
                                        $tr .= '<tr class="option_'.$name.' options">';
                                        $tr .= '<th><label for="option_'.$name.'">Option '.$name.':</label></th>';
                                        $tr .= '<td>';
                                        $tr .= '<input class="form-control" type="text" value="'.$val.'" name="coffee_calculator_options[options]['.$name.']" id="option_'.$name.'" placeholder="Enter Price...">';
                                        $tr .= '<span data-id="'.$name.'" class="removeOptions">&times;</span>';
                                        $tr .= ' </td>';
                                        $tr .= '</tr>';  
                                        echo $tr;
                                    }
                                }
                            ?> 
                        </tbody>
                </table> 
                <?php submit_button(); ?>
            </form>
        </div>
        <div class="col-md-12">
                 <h3>Check Coffee Calculator</h3> 
                 <span>Shortcode for Coffee calculator: <code>[coffee_calculator]</code></span>
                 <br></br>
                <?php // echo do_shortcode('[coffee_calculator]'); ?>
        </div>

<script>
    jQuery(document).ready(function($) {
        var optionCount = '<?php echo $optionsCount ?>';
        $(document).on('click', '.addMoreOptions', function(){
             optionCount = parseInt(optionCount);
             optionCount = 1 + optionCount;

             var tr ='';
             tr += '<tr class="option_'+optionCount+' options">';
             tr += '<th><label for="option_'+optionCount+'">Option '+optionCount+':</label></th>';
             tr += '<td>';
             tr += '<input class="form-control" type="text" name="coffee_calculator_options[options]['+optionCount+']" id="option_'+optionCount+'" placeholder="Enter Price...">';
             tr += '<span data-id="'+optionCount+'" class="removeOptions">&times;</span>';
             tr += ' </td>';
             tr += '</tr>';  
             jQuery('#coffee_calculator_options tbody').append(tr);
        });
        
        $(document).on('click','.removeOptions',function () {
            $(".option_"+$(this).attr('data-id')).remove();
        });
    });

</script>
<style>
    span.removeOptions {
        font-size: 26px;
        cursor: pointer;
    }
</style>
        <?php
        }
    }
endif;
new CCPC_Admin();