'use strict'

import jQuery from 'jquery'
import Dropzone from 'dropzone/dist/min/dropzone.min'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widget'
import MutationObserver from '@pollen-solutions/support/resources/assets/src/js/mutation-observer'

jQuery(function ($) {
  $.widget('tify.tifyFileJs', {
    widgetEventPrefix: 'file-js:',
    options: {},

    _create: function () {
      this.instance = this

      this.el = this.element

      this._initOptions()
      this._initUploader()
      this._initEvents()
    },

    _initOptions: function () {
      $.extend(
          true,
          this.options,
          this.el.data('options') && $.parseJSON(decodeURIComponent(this.el.data('options'))) || {}
      )
    },

    _initUploader: function () {
      let self = this,
          exists = this.el.get(0).dropzone

      if (exists === undefined) {
        this.dropzone = new Dropzone(this.el.get(0), self.option('dropzone') || {})
      }
    },

    _initEvents: function () {
      let self = this

      // @see https://www.dropzonejs.com/#event-list
      // ex. $('[data-control="file-js"]').on('file-js:success', function (e, file, resp) { console.log(resp)})
      if (this.dropzone !== undefined) {
        let events = [
          // All of these receive the event as first parameter:
          'drag', 'dragstart', 'dragend', 'dragenter', 'dragover', 'dragleave',
          // All of these receive the file as first parameter:
          'addedfile', 'removedfile', 'thumbnail', 'error', 'processing', 'uploadprogress', 'sending', 'success',
          'complete', 'canceled', 'maxfilesreached', 'maxfilesexceeded',
          // All of these receive a list of files as first parameter and are only called if the uploadMultiple
          // option is true:
          'processingmultiple', 'sendingmultiple', 'successmultiple', 'completemultiple', 'canceledmultiple',
          // Special events:
          'totaluploadprogress', 'reset', 'queuecomplete'
        ]
        events.forEach(function (event) {
          self.dropzone.on(event, function (e) {
            self._trigger(event, e, arguments)
          })
        })
      }
    }
  })

  $(document).ready(function ($) {
    $('[data-control="file-js"]').tifyFileJs()

    MutationObserver('[data-control="file-js"]', function (i, target) {
      $(target).tifyFileJs()
    })
  })
})