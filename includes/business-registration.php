<?php

/*@ Mail function */
if( !function_exists('scratchcode_mail') ):

	function scratchcode_mail($from, $to, $subject, $template){

		$headers[] = 'From: '. $from . "\r\n";
		$headers[] ='Reply-To: ' . $from . "\r\n";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$is_mail_sent = wp_mail($to, $subject, $template, $headers);
	}

endif;

if( !function_exists('scratchcode_business_registration_form') ):
	function scratchcode_business_registration_form(){
		ob_start();
		?>

<form id="businessRegistration" class="elementor-form scratchcode-form-wrapper" method="POST" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

  	<?php wp_nonce_field('scratchcode_business_registration','scratchcode_business_registration_nounce'); ?>
    <input type="hidden" name="action" value="business_registration">

    <section class="scratchcode-form-section">
		<div class="mbr-container">
			<div class="mbr-row">
				<div class="mbr-col-md-12 mx-auto">
					<div class="mbr-form-group mbr-row">
						<div class="mbr-col-sm-6">

							<div class="mbr-col-sm-12">
								<h3>How Can We Contact Your Business</h3>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="businessName">Business Name</label>
								<input type="text" class="mbr-form-control" id="businessName" placeholder="Business Name" name="business_name" tabindex="1">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_address">Address</label>
								<input type="text" class="mbr-form-control" id="business_address" placeholder="Address" name="business_address" tabindex="2">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_postcode">Postcode</label>
								<input type="text" class="mbr-form-control" id="business_postcode" placeholder="Postcode" name="business_postcode" tabindex="3">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_phone_no">Phone No</label>
								<input type="tel" class="mbr-form-control" id="business_phone_no" placeholder="Phone No" name="business_phone_no" tabindex="4">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_email">Business Contact Email</label>
								<input type="email" class="mbr-form-control" id="business_email" placeholder="Business Contact Email" name="business_email" tabindex="5">
							</div>
						</div>

						<div class="mbr-col-sm-6">

							<div class="mbr-col-sm-12">
								<h3>Upload your logo</h3>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="buisness_image">Logo</label>
								<input type="file" class="mbr-form-control" id="buisness_image" placeholder="Logo" name="buisness_image" tabindex="6">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<input type="checkbox" class="mbr-form-control chk-register" id="become_member" name="become_member" value="1" tabindex="7">
								<label for="become_member">Yes – I want to become a Member for £19.99 a month</label>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<input type="checkbox" class="mbr-form-control chk-register" id="contact_me" name="contact_me" value="1" tabindex="8">
								<label for="contact_me">Yes – I want to advertise and sponsor with you – contact me</label>
							</div>

								<input type="hidden" id="thank_you_url" name="thank_you_url" value="<?php echo get_field('thank_you_url', 'option'); ?>">
							
						</div>
						
					</div>
					
					
				</div>
			</div>
		</div>
	</section>

	<section class="scratchcode-form-section">
		<div class="mbr-container">
			<div class="mbr-row">
				<div class="mbr-col-md-12 mx-auto">
					<div class="mbr-form-group mbr-row">
						<div class="mbr-col-sm-6">

							<div class="mbr-col-sm-12">
								<h3>Tell Us About Your Business</h3>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_web_url">Web URL Address</label>
								<input type="url" class="mbr-form-control" id="business_web_url" placeholder="Web URL Address" name="business_web_url" tabindex="9">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="businessCategory">Category of business</label>
								<select name="business_category" class="mbr-form-control" id="businessCategory" tabindex="10">
									<option value="">Select</option>
									<?php 
										$terms = get_terms([
											'taxonomy' => 'business_category',
											'hide_empty' => false,
										]); 
										if ( !empty($terms) ) :
											foreach ( $terms as $term ) :
												echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
											endforeach;
										endif;
									?>
								</select>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_description">Description</label>
								<textarea class="mbr-form-control" id="business_description" placeholder="Description" name="business_description" rows="3" form="businessRegistration" tabindex="11"></textarea>
							</div>
						</div>

						<div class="mbr-col-sm-6">

							<div class="mbr-col-sm-12">
								<h3>Social Links</h3>
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_facebook_link">Facebook Link</label>
								<input type="url" class="mbr-form-control" id="business_facebook_link" placeholder="https://www.facebook.com/facebookid" name="business_facebook_link" tabindex="12">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_linkedIn_link">LinkedIn Link</label>
								<input type="url" class="mbr-form-control" id="business_linkedIn_link" placeholder="https://www.linkedin.com/linkedinid" name="business_linkedIn_link" tabindex="13">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_instagram_link">Instagram Link</label>
								<input type="url" class="mbr-form-control" id="business_instagram_link" placeholder="https://www.instagram.com/instagramid" name="business_instagram_link" tabindex="14">
							</div>

							<div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
								<label for="business_twitter_link">Twitter Link</label>
								<input type="url" class="mbr-form-control" id="business_twitter_link" placeholder="https://www.twitter.com/twitterid" name="business_twitter_link" tabindex="15">
							</div>
						</div>
						
					</div>
					
					
				</div>
			</div>
		</div>
	</section>

	<section class="scratchcode-form-section">
		<div class="mbr-container">
			<div class="mbr-row">
				<div class="mbr-col-md-12 mx-auto">
					<div class="mbr-form-group mbr-row">
						<div class="mbr-col-sm-12">

							<div class="mbr-col-sm-12">
								<h3>Create Your Login Details</h3>
							</div>
						</div>
					</div>
					<div class="mbr-form-group mbr-row mbr-mb-0">
						<div class="mbr-col-sm-6 scratchcode-input-field-wrapper">
							<label for="first_name">First Name</label>
							<input type="text" class="mbr-form-control" id="first_name" placeholder="First Name" name="first_name" tabindex="16">
						</div>
						
						<div class="mbr-col-sm-6 scratchcode-input-field-wrapper">
							<label for="last_name">Last Name</label>
							<input type="text" class="mbr-form-control" id="last_name" placeholder="Last Name" name="last_name" tabindex="17">
						</div>
					</div>
					<div class="mbr-form-group mbr-row mbr-mb-0">
						<div class="mbr-col-sm-6 scratchcode-input-field-wrapper">
							<label for="username">Username</label>
							<input type="text" class="mbr-form-control" id="username" placeholder="Username" name="username" tabindex="18">
						</div>
						
						<div class="mbr-col-sm-6 scratchcode-input-field-wrapper">
							<label for="phone_number">Phone Number</label>
							<input type="tel" class="mbr-form-control" id="phone_number" placeholder="Phone Number" name="phone_number" tabindex="19">
						</div>
					</div>
					<div class="mbr-form-group mbr-row mbr-mb-0">
						<div class="mbr-col-sm-6 scratchcode-input-field-wrapper">
							<label for="login_email">Email</label>
							<input type="email" class="mbr-form-control" id="login_email" placeholder="Email" name="login_email" tabindex="20">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="mbr-container">
		<div class="mbr-row">
			<div class="mbr-col-md-12 mx-auto">
				<span class="scratchcode-form-description">Included everything you need to? Then click the button below to submit your entry to our business directory. If you need to change any details in the future then <a href="https://www.startupdisruptors.co.uk/contact/">contact us</a> and let us know what needs to be changed.</span>
			</div>

			<div class="mbr-col-md-12 mx-auto">
				<input type="button" class="btn" id="btnSubmit" value="Submit" tabindex="21"/>
			</div>
		</div>
	</div>
</form>
<div style="clear: both;">&nbsp;</div>
		<?php
		return ob_get_clean();
	}
	add_shortcode( 'scratchcode_business_registration', 'scratchcode_business_registration_form' );
endif;


/*
 *@ Create user, add companies and send activation mail
 */
if( !function_exists('scratchcode_business_registration_ajax_function') ):
	function scratchcode_business_registration_ajax_function() {

		$formdata = $_POST;
		$edit_id = (!empty($formdata['company_id'])) ? $formdata['company_id'] : '';
		$user_id = '';
		$company_id = $edit_id;

		/*@ If action or nounce not match */
		if(empty( $formdata['scratchcode_business_registration_nounce'] ) && $formdata['action'] !== 'scratchcode_business_registration'):

			$responseCode = 400;
			$response = [ 'msg' => 'Cheating huh!'];
			return wp_send_json($response, $responseCode);
			wp_die();
		endif;

		/*@ If details empty then return with error */
		if ( ( empty($edit_id) && ( empty($formdata['login_email']) || empty($formdata['username']) )) || empty($formdata['first_name']) || empty($formdata['last_name'])) :
			$responseCode = 400;
			$response = [ 'msg' => 'Please enter all data.'];
			return wp_send_json($response, $responseCode);
			wp_die();
		endif;

		/*@ If not edit */
		if (empty($edit_id)) :

			/*@ Check user exists or not */	
			$exists = email_exists( $formdata['login_email'] );
			if ( $exists ) :
			    $responseCode = 400;
				$response = [ 'isUserExist' => false, 'msg' => 'Sorry, Login email already exists'];
				return wp_send_json($response, $responseCode);
				wp_die();
			endif;

			$isUserExist = username_exists( $formdata['username'] );
			if ( $isUserExist ) :
			    $responseCode = 400;
				$response = [ 'isUserExist' => false, 'msg' => 'Sorry, Username already taken'];
				return wp_send_json($response, $responseCode);
				wp_die();
			endif;

			/*@ Create company login user with role `business `*/
		  	$new_company = array(
		        'user_pass' => NULL,
		        'user_login' => $formdata['username'],
		        'user_email' => sanitize_email($formdata['login_email']),
		        'first_name' => sanitize_text_field($formdata['first_name']),
		        'last_name' => sanitize_text_field($formdata['last_name']),
		        'role' => 'business'
		    );

			$user_id = wp_insert_user($new_company);
		else:

			/*@ Update user profile if required */
			$userMeta = wp_get_current_user();
			$user_id = $userMeta->ID;
			$user_email = $userMeta->user_email;
			$updateUser = [];
			
			if ( $user_email !== $formdata['login_email'] ) :
				/*@ Check user exists or not */	
				$exists = email_exists( $formdata['login_email'] );
				if ( $exists ) :
					$responseCode = 400;
					$response = [ 'isUserExist' => false, 'msg' => 'Sorry, Login email already exists'];
					return wp_send_json($response, $responseCode);
					wp_die();
				endif;

				$updateUser['user_email'] = $formdata['login_email'];
				$updateUser['ID'] = $user_id;	
			endif;

			update_user_meta( $user_id, 'first_name', $formdata['first_name']);
			update_user_meta( $user_id, 'last_name', $formdata['last_name']);
			
			if ( !empty($formdata['password']) && !empty($formdata['confirm_password']) ) :
				$updateUser['ID'] = $user_id;
				$updateUser['user_pass'] = $formdata['password'];
			endif;

			if (!empty($updateUser)) :
				wp_update_user( $updateUser );
			endif;
	    endif;

	    /*@ If user created successfull then add data into company post */
	    if ( !is_wp_error( $user_id ) || !empty($edit_id) ) {

	    	try{

	    		if (empty($edit_id)) :
			        // Create post object
					$company = array(
						'post_title'    => wp_strip_all_tags( $formdata['business_name'] ),
						'post_status'   => 'draft',
						'post_type' => 'business'
					);
					// Insert the post into the database
					$company_id = wp_insert_post( $company );
					$formdata['user'] = $user_id;
				endif;	

				if (!empty($formdata['business_category'])) :
					wp_set_object_terms( $company_id, intval($formdata['business_category']), 'business_category' );
				endif;

				unset($formdata['_wp_http_referer']);
				unset($formdata['scratchcode_business_registration_nounce']);
				unset($formdata['action']);
				unset($formdata['buisness_image']);
				unset($formdata['username']);
				$login_email = $formdata['login_email'];
				unset($formdata['login_email']);
				unset($formdata['first_name']);
				unset($formdata['last_name']);
				unset($formdata['password']);
				unset($formdata['confirm_password']);
				unset($formdata['business_category']);

				// These files need to be included as dependencies when on the front end.
			    require_once( ABSPATH . 'wp-admin/includes/image.php' );
			    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			    require_once( ABSPATH . 'wp-admin/includes/media.php' );
			    
	       		if (!empty($_FILES['buisness_image'])) :
	       			$logo = $_FILES['buisness_image'];
	       			$attachment_id = media_handle_upload( 'buisness_image', $company_id );
	       			$formdata['buisness_image'] = $attachment_id;
	       		endif;

				/*@ Inserting the data into the company post type */
				foreach ($formdata as $key => $data) :

					switch ($key) {
						case 'business_web_url':
						case 'business_linkedIn_link':
						case 'business_facebook_link':
						case 'business_instagram_link':
						case 'business_twitter_link':
					 		$data = esc_url($data);
					 		break;

					 	case 'business_email':
					 	case 'email_address':
					 	case 'login_email':
					 		$data = sanitize_email($data);
							break;

						case 'business_description':
							$data = wpautop(sanitize_textarea_field($data));
							break;
					 	
					 	default:
					 		if (!is_array($data)) :
					 			$data = sanitize_text_field($data);
					 		endif;  
					 		break;
					}

					if (empty($edit_id)) :
						add_post_meta($company_id, $key, $data);
					else:
						update_post_meta($edit_id, $key, $data);
					endif;
				endforeach;

				/*@ Sent mail to registrant */
				$sendto = sanitize_email($login_email);
				$subject = get_field('mail_subject', 'option');
				$mail_template = get_field('mail_template', 'option');
				$from_to = get_field('mail_send_from', 'option');

				if (empty($edit_id) && !empty($sendto) && !empty($subject) && !empty($mail_template) && !empty($from_to)):
					
					/*@ Create set password link */
					$user = new WP_User( (int) $user_id );
					$reset_key = get_password_reset_key( $user );
					$user_login = $user->user_login;

					/*$rp_link = '<a href="' . network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user_login), 'login') . '">Set password link</a>';*/

					$rp_link = '<a href="' . network_site_url("password-reset?somresetpass=true&somfrp_action=rp&key=$reset_key&uid=" . rawurlencode($user_id), 'login') . '">Set password link</a>';
					
                    $search = array('[PASS_LINK]');

                    $replace = array($rp_link);

                    $mail_template = str_replace($search, $replace, $mail_template);
					
					scratchcode_mail($from_to, $sendto, $subject, $mail_template);

					/*@ Send a mail to admin that new company has registered */
					$sendto = get_field('br_auto_mail_to', 'option');
			        $subject = get_field('br_auto_subject', 'option');
					$mail_template = get_field('br_auto_template', 'option');
					$from_to = get_field('br_auto_mail_from', 'option');

					$login_approve_url = add_query_arg( array( 'post' => $company_id, 'action' => 'edit' ), site_url('/').'wp-admin/post.php');

					$login_approve_link = '<a href='.esc_url($login_approve_url).'>LOGIN & APPROVE</a>';

                    $business_name = sanitize_text_field($formdata['business_name']);
					
                    $become_member = (sanitize_text_field($formdata['become_member'])) ? 'Yes' : 'No';
                    $contact_me = (sanitize_text_field($formdata['contact_me'])) ? 'Yes': 'No';
                    
                    $search = array('[LINK]', '[COMPANY_NAME]', '[BECOME_MEMBER]', '[CONTACT_ME]');

                    $replace = array($login_approve_link, $business_name, $become_member, $contact_me);

                    $mail_template = str_replace($search, $replace, $mail_template);
					
					scratchcode_mail($from_to, $sendto, $subject, $mail_template);
				endif;

				$responseCode = 200;
				if (empty($edit_id)) :
					$response = [ 'msg' => 'You have successfully registered. You will receive an email. Please set your password for login.'];
				else:
					$response = [ 'msg' => 'Profile successfully updated.'];
				endif;

				return wp_send_json($response, $responseCode);
				wp_die();

			} catch (Throwable $t){
			   
			   	$responseCode = 400;
				$response = [ 'msg' => $t->getMessage()];

				return wp_send_json($response, $responseCode);
				wp_die();
				
			} catch(\Exception $e){
	    		
	    		$responseCode = 400;
				$response = [ 'msg' => $e->getMessage()];

				return wp_send_json($response, $responseCode);
				wp_die();
	    	}

	    }else{

	    	$msg = $user_id->get_error_message();
	    	$responseCode = 400;
			$response = [ 'msg' => $msg];

			return wp_send_json($response, $responseCode);
			wp_die();
	    }
	}
	add_action( 'wp_ajax_scratchcode_business_registration', 'scratchcode_business_registration_ajax_function' ); 
	add_action( 'wp_ajax_nopriv_scratchcode_business_registration', 'scratchcode_business_registration_ajax_function' ); 
endif;
