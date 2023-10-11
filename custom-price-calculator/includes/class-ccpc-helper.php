<?php
/**
 * CCPC_Helper
 *
 * The CCPC_Helper Class.
 *
 * @class CCPC_Helper 
 * @category Class
 * @author   Vijendra
 */  
if ( ! class_exists( 'CCPC_Helper', false ) ) : 
	class CCPC_Helper {

		public function __construct()
		{  
            //Enqueue Script
			add_action( 'wp_enqueue_scripts', array($this,  'coffee_calculator_script_style'));

            //register membership type post
			add_action('init',array($this,'register_gigs_post_type'));
        }

        //Enqueue Script
        public function coffee_calculator_script_style()
        {
            wp_enqueue_script('coffee-calculator-jquery', CCPC_PLUGIN_URL.'/assets/js/jquery.min.js');
			wp_enqueue_script( 'coffee-calculator-jquery' ); 

            //js for coffee calculator  
			wp_enqueue_script('coffee-calculator-front-js', CCPC_PLUGIN_URL.'/assets/js/coffee-front-ajax.js');
			wp_enqueue_script( 'coffee-calculator-front-js' ); 
			wp_localize_script('coffee-calculator-front-js','coffeeCalculator',array( 
				'ajax_url'			=> site_url().'/wp-admin/admin-ajax.php',
				'ajax_nonce'		=> wp_create_nonce('coffeeCalculator_nonce')
			));

			wp_enqueue_style('coffee-calculator-css', CCPC_PLUGIN_URL.'/assets/css/coffee-style.css',false,'2.2','all');
			wp_enqueue_style( 'coffee-calculator-css' ); 

            wp_enqueue_style('coffee-calculator-stylesheet', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap',false,'0.1','all');
			wp_enqueue_style( 'coffee-calculator-stylesheet' ); 


        }

        //Register Coffee Inquiry 
		public function register_gigs_post_type() 
		{ 
			/**
			 * Post Type: Coffee Inquiry.
			*/
			$labels = array(

				"name" => __( "Coffee Inquiry", "coffee-custom-price-calculator" ),

				"singular_name" => __( "Coffee Inquiry", "coffee-custom-price-calculator" ),

			);

			$coffee_args = array(

				"label" => __( "Coffee Inquiry", "coffee-custom-price-calculator" ),

				"labels" => $labels,

				"description" => "",

				"public" => true,

				"publicly_queryable" => false,

				"show_ui" => true,

				"delete_with_user" => false,

				"show_in_rest" => false,

				"rest_base" => "",

				"rest_controller_class" => "WP_REST_Posts_Controller",

				"has_archive" => true,

				"show_in_menu" => true,

				"show_in_nav_menus" => false,

				"exclude_from_search" => false,

				"capability_type" => "post",

				"map_meta_cap" => true,

				"hierarchical" => false,

				"rewrite" => array( "slug" => "coffee-inquiry", "with_front" => false, "pages" => false,),

				"query_var" => true,

				"supports" => array( "title" ),

                'capabilities' => array(
                    'create_posts' => false,  
                ),

                  'map_meta_cap' => true,
			);
			
			register_post_type( "coffee-inquiry", $coffee_args ); 
		}

        

        public function coffee_calculator_shortcode33()
        {
            ob_start(); // Start output buffering
            $options = array(); 
            $coffee_calculator_options = get_option('coffee_calculator_options');
            if(array_key_exists('options', $coffee_calculator_options))
            {
                $options = $coffee_calculator_options['options'];
            } 

            $employees = $_POST['employees'];
            $coffee_option = $_POST['coffee-option'];
            $employees = 0;
            $coffee_option = '';
            if (isset($_POST['employees']))
            {
                $employees = $_POST['employees']; 
            }
            if (isset($_POST['coffee-option']))
            {
                $coffee_option = $_POST['coffee-option']; 
            } 
            ?>
         
            <div class="calculator">
                <h1>COFFEE CALCULATOR</h1>
                <div class="calculator-wrapper">
                    <form action="" method="post" id="coffee-calculator">
                        <input type="hidden" name= "coffee_price_calculation">
                        <p>Total number of Employee</p>
                        <input type="number" id="employees" value="<?php echo $employees; ?>"  name="employees" placeholder="Number of Employee" require>
                        <p>Coffee Option: </p>
                        <select id="services" name="coffee-option" require>
                            <?php 
                                if(!empty($options))
                                {
                                    foreach ($options as $key => $price) {
                                        if($price == $coffee_option)
                                        {
                                            echo '<option selected value="'.$price.'">Option '.$key.'</option>';
                                        }else{  
                                            echo '<option value="'.$price.'">Option '.$key.'</option>';
                                        } 
                                    }
                                } 
                            ?>
                        </select>

                            <button type="submit" id="calculate">Calculate</button> 
                      
                            <?php
                            // If form is submitted 
                            if (isset($_POST['coffee_price_calculation']))
                            {

                                $coffee_price = 95; 
                                $one_cup_average = 0; 
                                $base_price_per_cup = 0;  
                                $average_employee_one_year = 5;  

                                if(array_key_exists('coffee_price', $coffee_calculator_options))
                                {
                                    $coffee_price = $coffee_calculator_options['coffee_price'];
                                }
                                if(array_key_exists('one_cup_average', $coffee_calculator_options))
                                {
                                    $one_cup_average = $coffee_calculator_options['one_cup_average'];
                                }
                                if(array_key_exists('base_price_per_cup', $coffee_calculator_options))
                                {
                                    $base_price_per_cup = $coffee_calculator_options['base_price_per_cup'];
                                }
                                if(array_key_exists('average_employee_one_year', $coffee_calculator_options))
                                {
                                    $average_employee_one_year = $coffee_calculator_options['average_employee_one_year'];
                                }
                                

                                $employees = $_POST['employees'];
                                $coffee_option = $_POST['coffee-option'];

                                if($employees > 0)
                                {
                        
                                    $coffee_per_month = $employees * $average_employee_one_year / 12; 
                                    $total_monthly_cost = $coffee_per_month * $coffee_price * $coffee_option;
                                    $price_per_cup = $base_price_per_cup * $coffee_option;
                                    $monthly_price_per_employee = $total_monthly_cost / $employees;

                                    echo '  <div class="tip amountShow"> <h5>Coffee Calculation Amount</h5>';

                                        echo '<span id="totalPrice">Estimated total monthly price for coffee: ' . round($total_monthly_cost, 2) . " DKK </span>";
                                        echo "<br>";
                                        echo '<span id="estimatedPricePerCup">Estimated price per cup: ' . round($price_per_cup, 2) . " DKK </span>";
                                        echo "<br>";
                                        echo '<span id="monthlyPricePerEmployee">Estimated monthly price per employee: ' . round($monthly_price_per_employee, 2) . " DKK </span>";
                                    echo " </div>";
                                }
                            }
                            ?> 
                    </form>
                </div>  
            </div>
        
            <?php
           
        
            return ob_get_clean(); // Return the buffered output

        }
  
    }
endif;
new CCPC_Helper();