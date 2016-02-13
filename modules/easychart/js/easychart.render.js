(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.easychartRender = {
    attach: function(context, settings) {
      if (settings.easychart != undefined) {
        var charts = settings.easychart;
        $.each(charts, function(key, value) {
          for (var i = 0; i < charts[key].length; i++) {
            var $container = $('.easychart-embed--' +  key  +'-' +  i)[0];
            window.easychart = new ec($container);

            var csv = JSON.parse(charts[key][i].csv);
            window.easychart.setData(csv);

            if (charts[key][i].config.length > 0) {
              var config = JSON.parse(charts[key][i].config);
              window.easychart.setConfig(config);
            }
          }
        });
      }
    }
  }

})(jQuery, Drupal);
