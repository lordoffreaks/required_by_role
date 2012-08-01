(function($) {
/**
 * Custom behavior for the module required_by_role
 * States api does not solve the problem.
 */
Drupal.behaviors.requiredByRole = {
  attach: function (context, settings) {

    jQuery(':input[name="instance[required]"]').change(function(){
      if(jQuery(this).is(':checked')){
        jQuery('#edit-instance-settings-required-by-role :checkbox').attr('disabled', 'disabled');
      }
      else {
       jQuery('#edit-instance-settings-required-by-role :checkbox').removeAttr('disabled');
      }
    })

  }
};

})(jQuery);
