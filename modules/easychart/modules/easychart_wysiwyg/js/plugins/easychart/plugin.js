/**
 * @file
 * Drupal Easychart plugin.
 */

(function ($, Drupal, CKEDITOR) {

  'use strict';

  CKEDITOR.plugins.add('easychart', {

    init: function( editor ) {

      editor.ui.addButton('Easychart', {
        label: Drupal.t('Easychart'),
        command: 'addchart',
        icon: this.path + '/chart.png'
      });

      editor.addCommand('addchart', {
        allowedContent: '',
        requiredContent: '',
        modes: {wysiwyg: 1},
        canUndo: false,
        exec: function (editor, data) {
          var dialogSettings = {
            // data.dialogTitle
            title: 'Add chart',
            dialogClass: 'editor-chart-dialog'
          };
          //Drupal.ckeditor.openDialog(editor, Drupal.url('admin/config/media/easychart/charts'), data.existingValues, data.saveCallback, dialogSettings);
          Drupal.ckeditor.openDialog(editor, Drupal.url('admin/config/media/easychart/charts'), null, null, dialogSettings);
        }
      });

    }

  });

})(jQuery, Drupal, CKEDITOR);
