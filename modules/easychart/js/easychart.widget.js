(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.easychartWidget = {
    attach: function(context, settings) {

      // Create the Easychart plugin options based on the admin configuration.
      var $widget = $('.easychart-wrapper');

      window.easychart = new ec($('.easychart-embed', $widget)[0]);

      // Set the config.
      if ($('.easychart-config', $widget).val()) {
        window.easychart.setConfig(JSON.parse($('.easychart-config', $widget).val()));
      }

      // Set the data or csv url.
      if ($('.easychart-csv-url', $widget).val()) {
        window.easychart.setDataUrl($('.easychart-csv-url', $widget).val());
      }
      else if ($('.easychart-csv', $widget).val()) {
        window.easychart.setData(JSON.parse($('.easychart-csv', $widget).val()));
      }

      // Set the options.
      if (settings.easychart != undefined) {
        if (settings.easychart.easychartOptions) {
          window.easychart.setOptions(JSON.parse(settings.easychart.easychartOptions.replace('\r\n', '')));
        }

        // Set the templates.
        if (settings.easychart.easychartTemplates) {
          window.easychart.setTemplates(JSON.parse(settings.easychart.easychartTemplates.replace('\r\n', '')));
        }

        // Set the presets.
        if (settings.easychart.easychartPresets) {
          window.easychart.setPresets(JSON.parse(settings.easychart.easychartPresets.replace('\r\n', '')));
        }
      }

      // Listen to updates in the Easychart config.
      window.easychart.on('dataUpdate', function (data) {
        $('.easychart-csv', $widget).val(JSON.stringify(data));

        // Check if an url was set and store that too.
        if (window.easychart.getDataUrl()) {
          $('.easychart-csv-url', $widget).val(window.easychart.getDataUrl());
        }
      });

      window.easychart.on('configUpdate', function (config) {
        $('.easychart-config', $widget).val(JSON.stringify(config));
      });
    }
 }

})(jQuery, Drupal);
