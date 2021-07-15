/* global tify, tinymce, tinyMCE */
'use strict'

import jQuery from 'jquery'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widget'
import MutationObserver from '@pollen-solutions/support/resources/assets/src/js/mutation-observer'

jQuery(function ($) {
  /* */
  if (typeof (tinyMCE) === 'undefined') {
    require('tinymce')
    require('tinymce/themes/silver/theme')
  }
  /**/

  if (tify.locale.language !== undefined) {
    try {
      require('tinymce-i18n/langs5/' + tify.locale.language)
    } catch (e) {
      console.log('Unavailable tinyMCE language ' + tify.locale.language)
    }
  }

  $.widget('tify.tifyTinymce', {
    widgetEventPrefix: 'tinymce:',
    id: undefined,
    options: {},

    _create: function () {
      this.instance = this

      this.el = this.element

      this._initOptions()
      this._initControls()
    },

    // INTIALIZATIONS
    // -----------------------------------------------------------------------------------------------------------------
    _initOptions: function () {
      $.extend(
          true,
          this.options,
          this.el.data('options') && $.parseJSON(decodeURIComponent(this.el.data('options'))) || {}
      )
    },

    _initControls : function () {
      let o = {branding: false}

      if (tify.locale.language !== undefined) {
        o.language = tify.locale.language
      }
      this.el.addClass('tifyTinymce'+ this.uuid)

      // @see https://www.tiny.cloud/docs/configure/integration-and-setup/
      o = $.extend(true, {
        base_url:  tify.base_url + '/node_modules/tinymce/',
        selector: '.tifyTinymce'+ this.uuid
      }, o, this.option())

      tinymce.init(o)
    }
  })

  $(document).ready(function () {
    $('[data-control="tinymce"]').tifyTinymce()

    MutationObserver('[data-control="tinymce"]', function (target) {
      $(target).tifyTinymce()
    })
  })
})