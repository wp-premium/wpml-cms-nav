/*globals jQuery, wpml_cms_nav_ajxloaderimg */

jQuery(document).ready(function () {
	jQuery('#icl_navigation_show_cat_menu').change(function () {
		if (jQuery(this).prop('checked')) {
			jQuery('#icl_cat_menu_contents').fadeIn();
		} else {
			jQuery('#icl_cat_menu_contents').fadeOut();
		}
	});
	jQuery('#icl_navigation_form').submit(wpmlCMSNavSaveForm);
	jQuery('#icl_navigation_caching_clear').click(clearNavigationCache);
});

function clearNavigationCache() {
	var thisb = jQuery(this);
	thisb.prop('disabled', true);
	thisb.after(wpml_cms_nav_ajxloaderimg);
	jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: "action=wpml_cms_nav_clear_nav_cache",
		success: function () {
			thisb.prop('disabled', false);
			thisb.next().fadeOut();
		}
	});
}

function wpmlCMSNavSaveForm() {
	var form = jQuery(this);
	var submitButton = form.find(':submit');
	submitButton.prop('disabled', false);
	submitButton.addClass('disabled');
	submitButton.after(wpml_cms_nav_ajxloaderimg);
	jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: "action=wpml_cms_nav_save_form&" + form.serialize(),
		success: function () {
			submitButton.prop('disabled', false);
			submitButton.removeClass('disabled');
			submitButton.next().fadeOut();
		}
	});
	return false;
}