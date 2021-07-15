'use strict'

import jQuery from 'jquery'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widget'
import MutationObserver from '@pollen-solutions/support/resources/assets/src/js/mutation-observer'

jQuery(function ($) {
  $.widget('tify.tifyTextRemaining', {
    widgetEventPrefix: 'text-remaining:',
    id: undefined,
    xhr: undefined,
    options: {
      classes: {
        wrapper: 'FieldTextRemaining-wrapper',
        infos: 'FieldTextRemaining-infos',
      },
      infos: {
        plural: '',
        singular: '',
        none: ''
      },
      limit: false
    },

    _create: function () {
      this.instance = this

      this.el = this.element

      this.id = this.el.data('id')

      this.flags = {
        isLimited: false
      }

      this._initOptions()
      this._initFlags()
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

    _initFlags: function () {
      this.flags.isLimited = !!(this.option('limit'))
    },

    _initControls: function () {
      this._initControlWrapper()
      this._initControlInfos()
      this._initControlField()
    },

    _initControlWrapper: function () {
      this.wrapper = this.el.wrap('<div data-control="text-remaining.wrapper"/>')
          .closest('[data-control="text-remaining.wrapper"]')
          .addClass(this.option('classes.wrapper'))
    },

    _initControlInfos: function () {
      this.infos = $('<span data-control="text-remaining.infos"/>', this.el)
          .appendTo(this.wrapper)
          .addClass(this.option('classes.infos'))
    },

    _initControlField: function () {
      this._doReached()
      this._onType()
    },

    // ACTIONS.
    // -----------------------------------------------------------------------------------------------------------------
    _doReached: function () {
      let max = parseInt(this.option('max') || 0)

      if (this.flags.isLimited) {
        this.el.val(this.el.val().substr(0, max))
      }

      let infos = this._getInfos(parseInt(max - this.el.val().length))
      this.infos
          .html(infos.html)
          .attr('aria-reached', infos.reached)

      this._trigger('type')
    },

    // EVENTS.
    // -------------------------------------------------------------------------------------------------------------
    _onType: function () {
      let self = this

      this.el.on('keyup.text-remaining' + this.instance.uuid, function (e) {
        e.stopPropagation()
        e.preventDefault()

        self._doReached()
      })
    },

    // GETTERS.
    // -----------------------------------------------------------------------------------------------------------------
    _getInfos: function (length) {
      let html = '',
          reached = ''

      if ((length > 1) || (length < -1)) {
        html = ('<b>' + length + '</b> ' + this.option('infos.plural')).trim()
      } else if (length === 0) {
        html = ('<b>' + length + '</b> ' + this.option('infos.none')).trim()
      } else {
        html = ('<b>' + length + '</b> ' + this.option('infos.singular')).trim()
      }

      if (length > 0) {
        reached = 'less'
      } else if (length < 0) {
        reached = 'more'
      } else {
        reached = 'exact'
      }

      return {html: html, reached: reached}
    }
  })

  $(document).ready(function () {
    $('[data-control="text-remaining"]').tifyTextRemaining()

    MutationObserver('[data-control="text-remaining"]', function (target) {
      $(target).tifyTextRemaining()
    })
  })
})