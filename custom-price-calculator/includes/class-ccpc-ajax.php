<?php
/**
 * CCPCAjax
 *
 * The WineClubAjax Class.
 *
 * @class    WineClubAjax
 * @parent CCPC_Base
 * @category Class
 * @author   Vijendra
 */  
if ( ! class_exists( 'CCPC_Ajax', false ) ) : 
	class CCPC_Ajax extends CCPC_Base {

		public function __construct()
		{ 
		 
			add_action('wp_ajax_get_coffee_calculator_price', array($this, 'get_coffee_calculator_price_ajax_callback'));
			add_action('wp_ajax_nopriv_get_coffee_calculator_price', array($this, 'get_coffee_calculator_price_ajax_callback'));
			
			 // Add the shortcode
			 add_shortcode('coffee_calculator', array($this, 'coffee_calculator_shortcode'));
			 add_shortcode('coffee_calculator_result', array($this, 'coffee_calculator_result_shortcode'));
		}
		 

		public function get_ninja_forms_api_key()
		{
			$settings = get_option( 'ninja_forms_settings' );

			$apiURL = '';
			$apiKey = '';

			if(array_key_exists('ninja_forms_nf_nfacds_api_url', $settings))
			{
				$apiURL = trim( $settings['ninja_forms_nf_nfacds_api_url'] );
			}
			if(array_key_exists('ninja_forms_nf_nfacds_api_key', $settings))
			{
				$apiKey = trim( $settings['ninja_forms_nf_nfacds_api_key'] );
			} 

			return array('url' => $apiURL, 'key' => $apiKey);
		}

		public function coffee_calculator_shortcode()
        {
            ob_start();
            $options = array(); 
            $coffee_calculator_options = get_option('coffee_calculator_options');
            if(array_key_exists('options', $coffee_calculator_options))
            {
                $options = $coffee_calculator_options['options'];
            } 
 
            $employees = 0;
            $coffee_option = '';
            
            ?>
		   
			<div class="col-md-12">
				<div class="main-wrapper">
					<form action="" id="coffee_calculator" method="post">
						<div id="coffee-loader"></div>
						<!-- Step 1 starts -->
						<section class="inner-html " id="step1">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									
											<div class="form-group">
												<label for="employees">Hvor mange medarbejdere er I? <span>&#42;</span></label>
												<input type="number" class="form-control" id="employees" name="employees">
											</div>
											<div class="form-group">
												<label for="employees">Hvad er jeres holdning til kaffen? </label>
												<div class="row">
													<div class="col-md-4">
														<label for="radio-card-1" class="radio-card">
															<input type="checkbox" class="" name="radio-card[]" value="1" id="radio-card-1" checked />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">Vælg bæredygtig kaffe og vær med til at gøre en forskel. Denne kaffe er dyrket og høstet med omtanke for miljøet og lokalsamfundene. Med hver kop bæredygtig kaffe støtter du bæredygtige initiativer og bidrager til en mere ansvarlig kaffeindustri.</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																	<div class="img-wrapper">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-1.png" class="img-fluid" alt="leaf">
																		</div>
																	<h5>Bæredygtig</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-2" class="radio-card">
															<input type="checkbox" value="2" name="radio-card[]" id="radio-card-2" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Gå den grønne vej med økologisk kaffe. Vores økologiske kaffe er dyrket uden brug af kemiske midler og pesticider. Denne kaffe giver dig en ren og naturlig smagsoplevelse samtidig med, at den støtter bæredygtige landbrugspraksisser.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-2.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Økologisk</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-3" class="radio-card">
															<input type="checkbox" value="3" name="radio-card" id="radio-card-3" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Reducer dit klimaaftryk med klimavenlig kaffe. Denne kaffe er produceret med fokus på CO2-reduktion og miljøvenlige metoder. Ved at vælge klimavenlig kaffe gør du en positiv indvirkning på vores planet og bidrager til en mere bæredygtig fremtid.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-3.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Klimavenlig</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-4" class="radio-card">
															<input type="checkbox" value="4" name="radio-card[]" id="radio-card-4" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Denne kaffe byder på en udsøgt smag og aroma uden at gå på kompromis med kvaliteten. Perfekt til dig, der ønsker en klassisk kaffeoplevelse uden ekstra præferencer.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-4.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Konventionel, men god</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-5" class="radio-card">
															<input type="checkbox" value="5" name="radio-card[]" id="radio-card-5" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Få den bedste smagsoplevelse uden at sprænge budgettet. Vores budgetvenlige kaffe giver dig den perfekte balance mellem pris og kvalitet. God kaffe behøver ikke at være dyr. Vælg denne mulighed for en lækker kop kaffe til en overkommelig pris.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-5.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>God smag, men lav omkostning</h5>
																</div>
															</div>
														</label>
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-theme btn-block step1-btn">Gå videre</button>
										
									</div>
								</div>
							</div>
						</section>
						<!-- Step 1 ends -->

						<!-- Step 2 starts -->
						<section class="inner-html d-none" id="step2">
							<div class="container">
								
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="first_name">Fornavn<span>&#42;</span></label>
												<input type="text" class="form-control" id="first_name" name="first_name" value="">
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">
												<label for="postal_code">Postnummer <span>&#42;</span></label>
												<input type="text" class="form-control" id="postal_code" name="postal_code" value="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="business_name">Virksomhed <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_name" name="business_name" value="">
											</div>
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="business_email">E-mail <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_email" name="email" value="">
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">
												<label for="business_phone">Telefonnummer <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_phone" name="phone" value="">
											</div>
										</div>
									</div>
									<div class="row mt-15 mobile-section"> 
										<div class="col-md-6 mb-15">
											<button type="button" class="btn btn-theme btn-block step2-btn">Modtag din pris</button>
										</div>
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step1-back">Gå tilbage</button>
										</div>	
									</div> 
									<div class="row mt-15 desktop-section">
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step1-back">Gå tilbage</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-theme btn-block step2-btn">Modtag din pris</button>
										</div>
									</div> 
							</div>
						</section>
						<!-- Step 2 ends -->

						<!-- Step 3 starts -->
						<section class="inner-html d-none" id="step3">
							<div class="container">
								
									<div class="row total-amount">
										<div class="col-md-12">
											<div class="form-group text-center">
												<label>Estimeret omkostning pr. måned</label>
												<h4 class="mt-0 estimated_cost_per_month"><b>0kr.</b></h4>
											</div>
										</div>	
									</div>
									<div class="row total-per-cup">
										<div class="col-md-6">
											<div class="form-group text-center">
												<label>Pris pr. kop</label>
												<h4 class="mt-0 cost_per_cup"><b></b></h4>
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group text-center">
												<label>Pris pr. medarbejder /m </label>
												<h4 class="mt-0 cust_per_employee_month" ><b></b></h4>
											</div>
										</div>
									</div>
									<div class="row mt-60 mobile-section"> 
										<div class="col-md-6 mb-15">
											<button type="button" class="btn btn-theme btn-block step3-btn contact-btn" style="/* padding: 8px 16px!important; */">Kontakt os</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step2-back">Gå tilbage</button>
										</div>	
										
									</div> 
									<div class="row mt-130 desktop-section">
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step2-back">Gå tilbage</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-theme btn-block step3-btn contact-btn" style="/* padding: 8px 16px!important; */">Kontakt os</button>
										</div>
									</div> 
									 
							</div>
						</section>
						<!-- Step 3 ends -->
					</form>
				</div> 
			</div>
            <?php 
            return ob_get_clean();  
        }

		public function coffee_calculator_result_shortcode()
        {
            ob_start();
            $options = array(); 
            $coffee_calculator_options = get_option('coffee_calculator_options');
            if(array_key_exists('options', $coffee_calculator_options))
            {
                $options = $coffee_calculator_options['options'];
            } 

			$total_monthly_cost = '00 kr';
			$price_per_cup = '00 kr';
			$monthly_price_per_employee = '00 kr';
			
			if(isset($_GET['request']) && !empty($_GET['request']))
			{
				$request_id = $_GET['request'];

				$request_id = base64_decode(str_pad(strtr($request_id, '-_', '+/'), strlen($request_id) % 4, '=', STR_PAD_RIGHT));

				$total_monthly_cost = get_post_meta($request_id, 'total_monthly_cost', true); 
			    $price_per_cup = get_post_meta($request_id, 'price_per_cup', true); 
			    $monthly_price_per_employee = get_post_meta($request_id, 'monthly_price_per_employee', true); 
			}else{
				wp_redirect( site_url().'/prisberegner' ); //prisberegner-i-alt
			}
 
            $employees = 0;
            $coffee_option = '';
            
            ?>
		   
			<div class="col-md-12">
				<div class="main-wrapper">
					<form action="" id="coffee_calculator" method="post">
						<div id="coffee-loader"></div>
						<!-- Step 1 starts -->
						<section class="inner-html d-none" id="step1">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									
											<div class="form-group">
												<label for="employees">Hvor mange medarbejdere er I? <span>&#42;</span></label>
												<input type="number" class="form-control" id="employees" name="employees">
											</div>
											<div class="form-group">
												<label for="employees">Hvad er jeres holdning til kaffen? </label>
												<div class="row">
													<div class="col-md-4">
														<label for="radio-card-1" class="radio-card">
															<input type="checkbox" name="radio-card[]" value="1" id="radio-card-1" checked />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">Vælg bæredygtig kaffe og vær med til at gøre en forskel. Denne kaffe er dyrket og høstet med omtanke for miljøet og lokalsamfundene. Med hver kop bæredygtig kaffe støtter du bæredygtige initiativer og bidrager til en mere ansvarlig kaffeindustri.</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																	<div class="img-wrapper">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-1.png" class="img-fluid" alt="leaf">
																		</div>
																	<h5>Bæredygtig</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-2" class="radio-card">
															<input type="checkbox" value="2" name="radio-card[]" id="radio-card-2" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Gå den grønne vej med økologisk kaffe. Vores økologiske kaffe er dyrket uden brug af kemiske midler og pesticider. Denne kaffe giver dig en ren og naturlig smagsoplevelse samtidig med, at den støtter bæredygtige landbrugspraksisser.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-2.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Økologisk</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-3" class="radio-card">
															<input type="checkbox" value="3" name="radio-card[]" id="radio-card-3" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Reducer dit klimaaftryk med klimavenlig kaffe. Denne kaffe er produceret med fokus på CO2-reduktion og miljøvenlige metoder. Ved at vælge klimavenlig kaffe gør du en positiv indvirkning på vores planet og bidrager til en mere bæredygtig fremtid.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-3.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Klimavenlig</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-4" class="radio-card">
															<input type="checkbox" value="4" name="radio-card[]" id="radio-card-4" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Denne kaffe byder på en udsøgt smag og aroma uden at gå på kompromis med kvaliteten. Perfekt til dig, der ønsker en klassisk kaffeoplevelse uden ekstra præferencer.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-4.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>Konventionel, men god</h5>
																</div>
															</div>
														</label>
													</div>
													<div class="col-md-4">
														<label for="radio-card-5" class="radio-card">
															<input type="checkbox" value="5" name="radio-card[]" id="radio-card-5" />
															<div class="card-content-wrapper">
																<div class="querry">
																	<span class="tool_tip">
																		<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/question-mark.png" class="img-fluid" alt="leaf">
																		<span class="tooltiptext">
																		Få den bedste smagsoplevelse uden at sprænge budgettet. Vores budgetvenlige kaffe giver dig den perfekte balance mellem pris og kvalitet. God kaffe behøver ikke at være dyr. Vælg denne mulighed for en lækker kop kaffe til en overkommelig pris.
																		</span>
																	</span>
																</div>
																<span class="check-icon"></span>
																<div class="card-content">
																<div class="img-wrapper">
																	<img src="<?php echo CCPC_PLUGIN_URL; ?>/assets/img/icon-5.png" class="img-fluid" alt="leaf">
																</div>
																	<h5>God smag, men lav omkostning</h5>
																</div>
															</div>
														</label>
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-theme btn-block step1-btn">Gå videre</button>
										
									</div>
								</div>
							</div>
						</section>
						<!-- Step 1 ends -->

						<!-- Step 2 starts -->
						<section class="inner-html d-none" id="step2">
							<div class="container">
								
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="first_name">Fornavn<span>&#42;</span></label>
												<input type="text" class="form-control" id="first_name" name="first_name" value="">
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">
												<label for="postal_code">Postnummer <span>&#42;</span></label>
												<input type="text" class="form-control" id="postal_code" name="postal_code" value="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="business_name">Virksomhed <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_name" name="business_name" value="">
											</div>
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="business_email">E-mail <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_email" name="email" value="">
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">
												<label for="business_phone">Telefonnummer <span>&#42;</span></label>
												<input type="text" class="form-control" id="business_phone" name="phone" value="">
											</div>
										</div>
									</div>
									<div class="row mt-15 mobile-section"> 
										<div class="col-md-6 mb-15">
											<button type="button" class="btn btn-theme btn-block step2-btn">Modtag din pris</button>
										</div>
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step1-back">Gå tilbage</button>
										</div>	
									</div> 
									<div class="row mt-15 desktop-section">
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step1-back">Gå tilbage</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-theme btn-block step2-btn">Modtag din pris</button>
										</div>
									</div> 
							</div>
						</section>
						<!-- Step 2 ends -->

						<!-- Step 3 starts -->
						<section class="inner-html" id="step3">
							<div class="container">

									<div class="row total-amount">
										<div class="col-md-12">
											<div class="form-group text-center">
												<label>Estimeret omkostning pr. måned</label>
												<h4 class="mt-0 estimated_cost_per_month"><?php echo $total_monthly_cost; ?></h4>
											</div>
										</div>	
									</div>
									<div class="row total-per-cup">
										<div class="col-md-6">
											<div class="form-group text-center">
												<label>Pris pr. kop</label>
												<h4 class="mt-0 cost_per_cup"><?php echo $price_per_cup; ?></h4>
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group text-center">
												<label>Pris pr. medarbejder /m </label>
												<h4 class="mt-0 cust_per_employee_month" ><?php echo $monthly_price_per_employee; ?></h4>
											</div>
										</div>
									</div>
									<div class="row"> 
									<div class="col-md-12">
									<label>
										Ovenstående er vores estimerede pris for din kaffeløsning, men flere faktorer spiller ind, hvis vi skal udregne den helt rigtige pris. Kontakt os på knappen herunder for at få din pris.
									</label>
									</div>
									</div>
									<div class="row mt-60 mobile-section"> 
										<div class="col-md-6 mb-15">
											<button type="button" class="btn btn-theme btn-block step3-btn contact-btn" style="/* padding: 8px 16px!important; */">Kontakt os</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step2-back">Gå tilbage</button>
										</div>	
										
									</div> 
									<div class="row mt-60 desktop-section">
										<div class="col-md-6">
											<button type="button" class="btn btn-outline-theme btn-block step2-back">Gå tilbage</button>
										</div>	
										<div class="col-md-6">
											<button type="button" class="btn btn-theme btn-block step3-btn contact-btn" style="/* padding: 8px 16px!important; */">Kontakt os</button>
										</div>
									</div> 
									 
							</div>
						</section>
						<!-- Step 3 ends -->
					</form>
				</div> 
			</div>
            <?php 
            return ob_get_clean();  
        }

		public function get_coffee_calculator_price_ajax_callback()
		{ 
			$options = array();  

            $coffee_calculator_options = get_option('coffee_calculator_options');
            if(array_key_exists('options', $coffee_calculator_options))
            {
                $options = $coffee_calculator_options['options'];
            }  
			 
            $employees = 0;
            $coffee_option = '';
             

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
						

			$first_name = $_POST['first_name'];
			$postal_code = $_POST['postal_code'];
			$business_name = $_POST['business_name'];
			$business_phone = $_POST['business_phone'];
			$business_email = $_POST['business_email']; 

			$employees = $_POST['employees'];
			$ccoptions = $_POST['options'];

			$post_data = array();
			$post_data['first'] = $first_name;
			$post_data['email'] = $business_email; 
			$post_data['phone'] = $business_phone; 
			$post_data['postal_code'] = $postal_code; 
			$post_data['business_name'] = $business_name;  
			$title = 'Inquiry -'.$first_name .'-'.$business_name;

			$post_id = wp_insert_post(array ( 
				'post_type' => 'coffee-inquiry',
				'post_title' => $title, 
				'post_status' => 'publish', 
			 )); 
			if ($post_id) { 

			    update_post_meta($post_id, 'first_name', $first_name); 
			    update_post_meta($post_id, 'postal_code', $postal_code); 
			    update_post_meta($post_id, 'business_name', $business_name); 
			    update_post_meta($post_id, 'business_phone', $business_phone); 
			    update_post_meta($post_id, 'business_email', $business_email); 

			    update_post_meta($post_id, 'employees', $employees); 
			    update_post_meta($post_id, 'options', $ccoptions); 
			    update_post_meta($post_id, 'coffee_option', $coffee_option); 

				$this->AddContactOnActiveCampaignList($post_data);
			}

			if($employees > 0)
			{
				$decode_id = rtrim(strtr(base64_encode($post_id), '+/', '-_'), '=');
				$redirectURL = site_url().'/prisberegner-i-alt?request='.$decode_id;

				$monthly_price_amountArr = [];
				$gettotal =0;
				$gettotalArr = ['total_monthly_cost'=> 0, 'price_per_cup' => 0, 'monthly_price_per_employee' => 0];
				if(!empty($ccoptions))
				{
					foreach ($ccoptions as $key => $optt) {
						$coffee_option = 0;
						if(array_key_exists($optt, $options))
						{
							$row= [];
							$coffee_option = $options[$optt];

							$coffee_per_month = $employees * $average_employee_one_year / 12; 
							$total_monthly_cost = $coffee_per_month * $coffee_price * $coffee_option;
							$price_per_cup = $base_price_per_cup * $coffee_option;
							$monthly_price_per_employee = $total_monthly_cost / $employees;

							$row['total_monthly_cost2'] = $total_monthly_cost;
							$row['price_per_cup2'] = $price_per_cup;
							$row['monthly_price_per_employee2'] = $monthly_price_per_employee; 

							$is_acive = 0;
							if( $total_monthly_cost > $gettotal)
							{
								$gettotal = $total_monthly_cost;
								$is_acive = 1;
							}

							$total_monthly_cost = number_format($total_monthly_cost, 2, ',', '.'). ' kr';
							$price_per_cup = number_format($price_per_cup, 2, ',', '.'). ' kr';
							$monthly_price_per_employee = number_format($monthly_price_per_employee, 2, ',', '.'). ' kr';

							$row['total_monthly_cost'] = $total_monthly_cost;
							$row['price_per_cup'] = $price_per_cup;
							$row['monthly_price_per_employee'] = $monthly_price_per_employee;

							if($is_acive == 1) { $gettotalArr = $row; }

							$monthly_price_amountArr[] = $row;
						}
					}
				}

				$total_monthly_cost = $gettotalArr['total_monthly_cost'];
				$price_per_cup = $gettotalArr['price_per_cup'];
				$monthly_price_per_employee = $gettotalArr['monthly_price_per_employee'];

				// $total_monthly_cost = round($total_monthly_cost, 2) . " kr";
				// $price_per_cup = round($price_per_cup, 2) . " kr";
				// $monthly_price_per_employee = round($monthly_price_per_employee, 2) . " kr";

				update_post_meta($post_id, 'total_monthlyamount_selected', $gettotalArr); 
				update_post_meta($post_id, 'total_monthlyamount_arr', $monthly_price_amountArr); 
				update_post_meta($post_id, 'total_monthly_cost', $total_monthly_cost); 
			    update_post_meta($post_id, 'price_per_cup', $price_per_cup); 
			    update_post_meta($post_id, 'monthly_price_per_employee', $monthly_price_per_employee); 

				echo json_encode(array('status' => true, 'redirectURL'=>$redirectURL, 'total_monthly_cost' => $total_monthly_cost, 'price_per_cup' => $price_per_cup, 'monthly_price_per_employee' => $monthly_price_per_employee)); die;
			}else{
				update_post_meta($post_id, 'total_monthly_cost', 0); 
			    update_post_meta($post_id, 'price_per_cup', 0); 
			    update_post_meta($post_id, 'monthly_price_per_employee', 0); 
			} 
			echo json_encode(array('status' => false, 'total_monthly_cost' => 0, 'price_per_cup' => 0, 'monthly_price_per_employee' => 0)); die;
		}

		public function AddContactOnActiveCampaignList($post_data)
		{
			// Replace with your actual API URL and API Key
			// $api_url = 'https://merrildlavazza.api-us1.com/api/3/';
			// $api_key = '163b7c9f9dcf677a8e76a10d57403ab7c66e7f74198ce40788f546610014c922a18e6bce';

			$api_data = $this->get_ninja_forms_api_key();

			$api_url = $api_data['url'];
			$api_key = $api_data['key'];

			if ( empty($api_url) || empty($api_key) ) {
				return false;  
			} 
			$api_url = $api_url. '/api/3/';
 
			// ID of the list where you want to add the contact
			$list_id = 1;

			// API Endpoint to add a contact to a list
			$endpoint = 'contact/sync'; 

			// Data for the contact you want to add
			$data = array(
				'contact' => array(
					'email' => $post_data['email'],
					'firstName' => $post_data['first'], 
					'phone' => $post_data['phone'],  
					"fieldValues" => array(
						array( 
							"field" => "42",
							"value" => $post_data['phone']
						), 
						array( 
							"field" => "27",
							"value" => $post_data['postal_code']
						), 
						array( 
							"field" => "23",
							"value" => $post_data['business_name']
						), 
						array( 
							"field" => "5",
							"value" => "Hjemmeside"
						),
						array( 
							"field" => "6",
							"value" => "Prisberegner"
						),
					), 
				),
			);
			

			// Convert data to JSON
			$json_data = json_encode($data);

			// Initiate cURL session
			$ch = curl_init($api_url . $endpoint);

			// Set cURL options
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Api-Token: ' . $api_key,
			));

			// Execute cURL session and get the response
			$response = curl_exec($ch);

			// Close cURL session
			curl_close($ch);

			// Process the response (you may want to do error handling here)
			$response_data = json_decode($response, true);  
			//print_r($response_data['contact']['id']);
			if (array_key_exists('contact', $response_data)) {
				$this->addContentToListOnActivecampaign($response_data['contact']['id'], $list_id);
				$this->addContentToTagsOnActivecampaign($response_data['contact']['id']);
				//echo 'Contact added successfully to the list!';
			} else {
				//echo 'Error adding contact to the list: ' . $response_data['message'];
			}
		}

		function addContentToTagsOnActivecampaign($contact_id)
		{
			$api_data = $this->get_ninja_forms_api_key();

			$api_url = $api_data['url'];
			$api_key = $api_data['key'];

			if ( empty($api_url) || empty($api_key) ) {
				return false;  
			} 
			$api_url = $api_url. '/api/3/';
 
			$endpoint = 'contactTags'; 

			// Array of tags to add to the contact
			$tags_to_add = array('72', '55'); // Add as many tags as you want

			// Loop through the tags and make individual API requests for each tag
			foreach ($tags_to_add as $tag_name) {
				$data = array(
					'contactTag' => array(
						'contact' => $contact_id,
						'tag' => $tag_name,
					),
				); 

				// Convert data to JSON
				$json_data = json_encode($data);

				// Initiate cURL session
				$ch = curl_init($api_url . $endpoint);

				// Set cURL options
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Api-Token: ' . $api_key,
				));

				// Execute cURL session and get the response
				$response = curl_exec($ch);

				// Close cURL session
				curl_close($ch);

				// Process the response (you may want to do error handling here)
				$response_data = json_decode($response, true); 
				 
				if ($response_data['status'] === 1) {
					//echo "Tag '{$tag_name}' added to the contact successfully!<br>";
				} else {
					//echo "Error adding tag '{$tag_name}' to the contact: " . $response_data['message'] . "<br>";
				}
			}

			return true; 
		}

		function addContentToListOnActivecampaign($contact_id, $list_id)
		{
			// Replace with your actual API URL and API Key
			$api_data = $this->get_ninja_forms_api_key();

			$api_url = $api_data['url'];
			$api_key = $api_data['key'];

			if ( empty($api_url) || empty($api_key) ) {
				return false;  
			} 
			$api_url = $api_url. '/api/3/';
  
			$data = array(
				'contactList' => array(
					'contact' => $contact_id,
					'list' => $list_id,
					'status' => 1, // 1 for subscribed, 2 for unsubscribed
				),
			);  
			//print_r($data);
			// Convert data to JSON
			$json_data = json_encode($data); 

			$endpoint = 'contactLists'; 
			 // Initiate cURL session
			$ch = curl_init($api_url . $endpoint);

			// Set cURL options
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Api-Token: ' . $api_key,
			));

			// Execute cURL session and get the response
			$response = curl_exec($ch);

			// Close cURL session
			curl_close($ch);

			// Process the response (you may want to do error handling here)
			$response_data = json_decode($response, true); 
			//print_r($response_data);
		}

    }
endif;
new CCPC_Ajax();