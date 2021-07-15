'use strict'

import jQuery from 'jquery'
import 'spectrum-colorpicker/spectrum'
import MutationObserver from '@pollen-solutions/support/resources/assets/src/js/mutation-observer'

/*
if (tify.locale.iso[1] !== undefined) {
  try {
    require('spectrum-colorpicker/i18n/jquery.spectrum-' + tify.locale.iso[1])
  } catch (e) {
    console.log('Unavailable spectrum language ' + tify.locale.iso[1])
  }
}
*/

jQuery(function ($) {
  $.widget('tify.tifyColorpicker', {
    widgetEventPrefix: 'colorpicker:',
    options: {
      classes: {}
    },
    controls: {},

    _create: function () {
      this.instance = this

      this.el = this.element

      this._initOptions()
      this._initControls()
    },

    // INITIALIZATIONS.
    // -----------------------------------------------------------------------------------------------------------------
    _initOptions: function () {
      $.extend(
          true,
          this.options,
          this.el.data('options') && $.parseJSON(decodeURIComponent(this.el.data('options'))) || {}
      )
    },

    _initControls: function () {
      let self = this
          /*o = $.extend({
            change: function (color) {
              $(obj).val(color.toHexString())
            }
          }, self.option())*/

      this.el.spectrum(self.option())
    }
  })

  $(document).ready(function () {
    $('[data-control="colorpicker"]').tifyColorpicker()

    MutationObserver('[data-control="colorpicker"]', function (i, target) {
      $(target).tifyColorpicker()
    })
  })
})