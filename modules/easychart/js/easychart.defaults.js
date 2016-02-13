(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.easychartDefaults = {
    attach: function(context, settings) {

      if (settings.easychart != undefined) {

        window.easychart = new ec();

        // Load & submit default options.
        if (settings.easychart.options !== undefined) {
          var options = JSON.stringify(window.easychart.getOptions(),null,4)
          $(".easychart-options").val(options);
          $("#easychart-admin").submit(function() {
            if (options == $(".easychart-options").val()) {
                $(".easychart-options").val("");
              }
          });
        }

        // Load & submit default templates.
        if (settings.easychart.templates != undefined) {
          var templates = JSON.stringify(window.easychart.getTemplates(),null,4)
          $(".easychart-templates").val(templates);
          $("#easychart-admin").submit(function() {
            if (templates == $(".easychart-templates").val()) {
              $(".easychart-templates").val("");
            }
          });
        }
      }
    }
  }

})(jQuery, Drupal);
