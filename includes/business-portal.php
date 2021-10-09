<?php

if( !function_exists('scratchcode_business_portal') ):
	function scratchcode_business_portal(){

        ob_start();

		if (!is_user_logged_in()) :
			wp_die('Please login first in order to access this page.');
			return;
		endif;

		$user = wp_get_current_user();
		$role = (!empty($user->roles)) ? $user->roles : '';

		if ( !in_array( 'administrator', $role )  &&  !in_array( 'business', $role )) :
			wp_die('Only admin or business can access this page.');
			return;
		endif;

		$userId = $user->ID;

		$args = [
			'post_type' => 'business',
			'post_status' => 'publish',
			'posts_per_page' => 1,
	        'orderby' => 'title',
	        'order' => 'ASC',
	        'meta_query' => [
	        	'relation'		=> 'OR',
	        	[
		            'key'     => 'user',
		            'value'   => $userId,
		            'compare' => '=',
    			],
	        ]
		];

		$company = scratchcode_er_get_post_types($args);

		if (!empty($company)) :

			$id = $company[0]->ID;
            $metas = get_post_meta($id);
            $userMeta = wp_get_current_user();
            $businessCategory = get_the_terms( $id, 'business_category' );
            $termId = '';

            if ( !empty($businessCategory[0]) ) :
                $termId = $businessCategory[0]->term_id;
            endif;
		?>

            <form id="businessRegistration" class="elementor-form scratchcode-form-wrapper" method="POST" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

                <?php wp_nonce_field('scratchcode_business_registration','scratchcode_business_registration_nounce'); ?>

                <input type="hidden" name="action" value="business_registration">
                
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $id; ?>">

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
                                            <input type="text" class="mbr-form-control" id="businessName" placeholder="Business Name" name="business_name" value="<?php echo (!empty($metas['business_name'][0])) ? $metas['business_name'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_address">Address</label>
                                            <input type="text" class="mbr-form-control" id="business_address" placeholder="Address" name="business_address" value="<?php echo (!empty($metas['business_address'][0])) ? $metas['business_address'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_postcode">Postcode</label>
                                            <input type="text" class="mbr-form-control" id="business_postcode" placeholder="Postcode" name="business_postcode" value="<?php echo (!empty($metas['business_postcode'][0])) ? $metas['business_postcode'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_phone_no">Phone No</label>
                                            <input type="tel" class="mbr-form-control" id="business_phone_no" placeholder="Phone No" name="business_phone_no" value="<?php echo (!empty($metas['business_phone_no'][0])) ? $metas['business_phone_no'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_email">Business Contact Email</label>
                                            <input type="email" class="mbr-form-control" id="business_email" placeholder="Business Contact Email" name="business_email" value="<?php echo (!empty($metas['business_email'][0])) ? $metas['business_email'][0] : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="mbr-col-sm-6">

                                        <div class="mbr-col-sm-12">
                                            <h3>Upload your logo</h3>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="buisness_image">Logo</label>
                                            <input type="file" class="mbr-form-control" id="buisness_image" placeholder="Logo" name="buisness_image" multiple="false">

                                            <?php if (!empty($metas['buisness_image'][0])) : 
                                                $company_logo = get_field('buisness_image', $id);
                                                $company_logo = wp_get_attachment_image_url( $company_logo, 'medium' );
                                                ?>
                                            <div class="image_wrapper">
                                                <?php echo '<img src="'.$company_logo.'">'; ?>
                                            </div>
                                        <?php endif; ?>
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
                                    <div class="mbr-col-sm-6">

                                        <div class="mbr-col-sm-12">
                                            <h3>Tell Us About Your Business</h3>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_web_url">Web URL Address</label>
                                            <input type="url" class="mbr-form-control" id="business_web_url" placeholder="Web URL Address" name="business_web_url" value="<?php echo (!empty($metas['business_web_url'][0])) ? $metas['business_web_url'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="businessCategory">Category of business</label>

                                            <select name="business_category" class="mbr-form-control" id="businessCategory" >
                                                <option value="">Select</option>
                                                <?php 
                                                    $terms = get_terms([
                                                        'taxonomy' => 'business_category',
                                                        'hide_empty' => false,
                                                    ]); 
                                                    if ( !empty($terms) ) :
                                                        foreach ( $terms as $term ) :

                                                            $selected = ($term->term_id ===  $termId) ? 'selected="selected"' : '';

                                                            echo '<option value="'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>';
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_description">Description</label>
                                            <textarea class="mbr-form-control" id="business_description" placeholder="Description" name="business_description" rows="3"><?php echo (!empty($metas['business_description'][0])) ? $metas['business_description'][0] : ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mbr-col-sm-6">

                                        <div class="mbr-col-sm-12">
                                            <h3>Social Links</h3>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_facebook_link">Facebook Link</label>
                                            <input type="url" class="mbr-form-control" id="business_facebook_link" placeholder="https://www.facebook.com/facebookid" name="business_facebook_link" value="<?php echo (!empty($metas['business_facebook_link'][0])) ? $metas['business_facebook_link'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_linkedIn_link">LinkedIn Link</label>
                                            <input type="url" class="mbr-form-control" id="business_linkedIn_link" placeholder="https://www.linkedin.com/linkedinid" name="business_linkedIn_link" value="<?php echo (!empty($metas['business_linkedIn_link'][0])) ? $metas['business_linkedIn_link'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_instagram_link">Instagram Link</label>
                                            <input type="url" class="mbr-form-control" id="business_instagram_link" placeholder="https://www.instagram.com/instagramid" name="business_instagram_link" value="<?php echo (!empty($metas['business_instagram_link'][0])) ? $metas['business_instagram_link'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="business_twitter_link">Twitter Link</label>
                                            <input type="url" class="mbr-form-control" id="business_twitter_link" placeholder="https://www.twitter.com/twitterid" name="business_twitter_link" value="<?php echo (!empty($metas['business_twitter_link'][0])) ? $metas['business_twitter_link'][0] : ''; ?>">
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
                                    <div class="mbr-col-sm-6">

                                        <div class="mbr-col-sm-12">
                                            <h3>Create Your Login Details</h3>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="mbr-form-control" id="first_name" placeholder="First Name" name="first_name" value="<?php echo (!empty($userMeta->first_name)) ? $userMeta->first_name : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="username">Username</label>
                                            <input type="text" class="mbr-form-control" id="username" placeholder="Username" name="username" disabled="disabled" value="<?php echo (!empty($userMeta->user_login)) ? $userMeta->user_login : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="tel" class="mbr-form-control" id="phone_number" placeholder="Phone Number" name="phone_number" value="<?php echo (!empty($metas['phone_number'][0])) ? $metas['phone_number'][0] : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="mbr-form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                                        </div>
                                    </div>

                                    <div class="mbr-col-sm-6">
                                        <div class="mbr-col-sm-12">
                                            <h3>&nbsp;</h3>
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="mbr-form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo (!empty($userMeta->last_name)) ? $userMeta->last_name : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="login_email">Email</label>
                                            <input type="email" class="mbr-form-control" id="login_email" placeholder="Email" name="login_email" value="<?php echo (!empty($userMeta->user_email)) ? $userMeta->user_email : ''; ?>">
                                        </div>

                                        <div class="mbr-col-sm-12 scratchcode-input-field-wrapper">
                                            <label for="password">Password</label>
                                            <input type="password" class="mbr-form-control" id="password" placeholder="Password" name="password">
                                        </div>
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
                            <input type="button" class="btn" id="btnSubmit" value="Submit"/>
                        </div>
                    </div>
                </div>
            </form>
			<div style="clear: both;">&nbsp;</div>
			<?php
        endif;

        return ob_get_clean();
		
	}
	add_shortcode( 'scratchcode_business_portal', 'scratchcode_business_portal' );
endif;
