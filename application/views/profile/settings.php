<?php
$settings = isset($settings) && is_array($settings) ? $settings : array();
$schoolyear_options = isset($schoolyear_options) && is_array($schoolyear_options) ? $schoolyear_options : array();
$landing_page_options = isset($landing_page_options) && is_array($landing_page_options) ? $landing_page_options : array();
$flash_message = $this->session->flashdata('message');
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/student_settings.css">

<div class="col-md-12 grid-margin student-settings-page">
	<div class="student-settings-shell">
		<div class="student-settings-hero">
			<div>
				<h2>Student Settings</h2>
				<p>Manage how your portal looks, behaves, and protects your privacy.</p>
			</div>
			<a href="<?=site_url('dashboard')?>" class="student-settings-back">
				Back to Dashboard
			</a>
		</div>

		<?php if ($flash_message): ?>
		<div class="student-settings-alert">
			<i class="mdi mdi-check-circle-outline"></i>
			<span><?=htmlspecialchars($flash_message, ENT_QUOTES, 'UTF-8')?></span>
		</div>
		<?php endif; ?>

		<form action="<?=site_url('myprofile/save_settings')?>" method="post" class="student-settings-form">
			<div class="student-settings-grid">
				<section class="student-settings-card">
					<div class="student-settings-card-head">
						<h3>Appearance</h3>
						<p>Adjust the visual style of the student portal.</p>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Dark Mode</h4>
							<p>Use a darker color palette across the student portal.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" id="dark_mode" name="dark_mode" value="1" <?=!empty($settings['dark_mode']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row">
						<label for="font_size">Font Size</label>
						<select name="font_size" id="font_size" class="form-control">
							<option value="small" <?=$settings['font_size'] === 'small' ? 'selected' : ''?>>Small</option>
							<option value="medium" <?=$settings['font_size'] === 'medium' ? 'selected' : ''?>>Medium</option>
							<option value="large" <?=$settings['font_size'] === 'large' ? 'selected' : ''?>>Large</option>
						</select>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Compact Layout</h4>
							<p>Tighten spacing to fit more content on the screen.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" id="compact_layout" name="compact_layout" value="1" <?=!empty($settings['compact_layout']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
				</section>

				<section class="student-settings-card">
					<div class="student-settings-card-head">
						<h3>Portal Preferences</h3>
						<p>Choose how the portal opens and remembers your workspace.</p>
					</div>
					<div class="student-setting-row">
						<label for="default_landing_page">Default Landing Page</label>
						<select name="default_landing_page" id="default_landing_page" class="form-control">
							<?php foreach ($landing_page_options as $value => $label): ?>
							<option value="<?=htmlspecialchars($value, ENT_QUOTES, 'UTF-8')?>" <?=$settings['default_landing_page'] === $value ? 'selected' : ''?>><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="student-setting-row">
						<label for="default_schoolyear_id">Preferred School Year</label>
						<select name="default_schoolyear_id" id="default_schoolyear_id" class="form-control">
							<option value="">Use current school year</option>
							<?php foreach ($schoolyear_options as $value => $label): ?>
							<option value="<?= (int) $value ?>" <?=isset($settings['default_schoolyear_id']) && (int) $settings['default_schoolyear_id'] === (int) $value ? 'selected' : ''?>><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Remember Sidebar State</h4>
							<p>Keep the sidebar collapsed or expanded based on your last choice.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="remember_sidebar_state" value="1" <?=!empty($settings['remember_sidebar_state']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
				</section>

				<section class="student-settings-card">
					<div class="student-settings-card-head">
						<h3>Accessibility</h3>
						<p>Make the portal easier to read and navigate.</p>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>High Contrast</h4>
							<p>Increase color contrast for text and cards.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" id="high_contrast" name="high_contrast" value="1" <?=!empty($settings['high_contrast']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Reduce Motion</h4>
							<p>Turn off non-essential transitions and animations.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" id="reduce_motion" name="reduce_motion" value="1" <?=!empty($settings['reduce_motion']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Larger Text</h4>
							<p>Increase text size for easier reading on key pages.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" id="larger_text" name="larger_text" value="1" <?=!empty($settings['larger_text']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
				</section>

				<section class="student-settings-card">
					<div class="student-settings-card-head">
						<h3>Privacy</h3>
						<p>Control how much of your personal information is shown in the portal.</p>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Hide Mobile Number</h4>
							<p>Do not show your mobile number in the profile dropdown.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="hide_mobile_number" value="1" <?=!empty($settings['hide_mobile_number']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Hide Profile Photo</h4>
							<p>Replace the profile image with a neutral avatar placeholder.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="hide_profile_photo" value="1" <?=!empty($settings['hide_profile_photo']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Limit Personal Details</h4>
							<p>Show a simpler profile summary in shared portal spaces.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="limit_personal_details" value="1" <?=!empty($settings['limit_personal_details']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
				</section>

				<section class="student-settings-card">
					<div class="student-settings-card-head">
						<h3>Display Behavior</h3>
						<p>Customize what stands out on your dashboard and quick actions.</p>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Show Welcome Card</h4>
							<p>Keep the welcome banner visible on the dashboard.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="show_welcome_card" value="1" <?=!empty($settings['show_welcome_card']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Compact Dashboard Cards</h4>
							<p>Make quick action cards denser to fit more options on screen.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="compact_dashboard_cards" value="1" <?=!empty($settings['compact_dashboard_cards']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
					<div class="student-setting-row student-setting-row-toggle">
						<div>
							<h4>Emphasize Primary Actions</h4>
							<p>Highlight your main dashboard shortcuts with stronger accents.</p>
						</div>
						<label class="student-switch">
							<input type="checkbox" name="emphasize_primary_actions" value="1" <?=!empty($settings['emphasize_primary_actions']) ? 'checked' : ''?>>
							<span class="student-switch-slider"></span>
						</label>
					</div>
				</section>
			</div>

			<div class="student-settings-actions">
				<button type="submit" class="btn btn-primary btn-lg">
					<i class="mdi mdi-content-save-outline"></i> Save Settings
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(function () {
		var $body = $('body');
		var previewClasses = [
			'student-theme-dark',
			'student-layout-compact',
			'student-high-contrast',
			'student-reduce-motion',
			'student-font-large',
			'student-font-small'
		];

		function applyPreviewClasses() {
			$body.removeClass(previewClasses.join(' '));

			if ($('#dark_mode').is(':checked')) {
				$body.addClass('student-theme-dark');
			}

			if ($('#compact_layout').is(':checked')) {
				$body.addClass('student-layout-compact');
			}

			if ($('#high_contrast').is(':checked')) {
				$body.addClass('student-high-contrast');
			}

			if ($('#reduce_motion').is(':checked')) {
				$body.addClass('student-reduce-motion');
			}

			if ($('#larger_text').is(':checked')) {
				$body.addClass('student-font-large');
			} else {
				var fontSize = $('#font_size').val();
				if (fontSize === 'large') {
					$body.addClass('student-font-large');
				} else if (fontSize === 'small') {
					$body.addClass('student-font-small');
				}
			}
		}

		$('#dark_mode, #compact_layout, #high_contrast, #reduce_motion, #larger_text, #font_size').on('change', applyPreviewClasses);
		applyPreviewClasses();
	});
</script>
