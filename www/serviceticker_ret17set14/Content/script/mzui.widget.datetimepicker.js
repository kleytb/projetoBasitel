/*
 * mzui.widgetDateTimePicker JavaScript Library v1.0.0
 * Extends jQuery plugin
 *
 * Copyright 2012, 2014 Mezasoft
 * http://www.mezasoft.com
 * Can´t be reproduced, copied or disclosed.
 * Proprietary and confidential.
 *
 *
 * Implements Mezasoft application dialogs.
 *
 */

(function ($) {

    ///
    /// Attributes
    ///
    var version = "1.0.0";

    ///--------------------------------------------------------------
    /// dateTimePicker
    ///--------------------------------------------------------------

    ///
    /// Choose a date and time value.
    ///
    $.widget("mzui.widgetDateTimePicker", {

        options: {

            defaultDateTimeString: ''  // Initial date time to show on placeholder. Now if not present.
        },

        ///
        /// Create the datetimePicker
        ///
        _create: function () {
        },

        ///
        /// Init the datetimePicker
        ///
        _init: function () {

            var that = this;

            if (this.element[0].tagName !== 'DIV')
                throw new ReferenceError('mzui.dateTimePicker: Method works only on DIV types.');

            this.element.empty();

            /// Input Div
            this.inputDiv = $("<div class='input-group date'>");
            this.element.append(this.inputDiv);
            
            this.input = $("<input type='text' class='form-control' data-date-format='DD/MM/YY'/>");
            this.inputDiv.append(this.input);

            this.span = $('<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>');
            this.inputDiv.append(this.span);

            /// Set the default date time
            var defaultDateStr = '';
            var now = new Date();

            if (!this.options.defaultDateTimeString)
                defaultDateStr = now.toTimeString();
            else
                defaultDateStr = this.options.defaultDateTimeString;
                
                /// Apply the bootstrap datetime picker to the element
                this.inputDiv.datetimepicker({
                    language: 'en',  // The default language

            });
        },

        ///
        /// Get the current date and time
        ///
        getDateTime: function () {

            return this.inputDiv.data("DateTimePicker").getDate();

        },

        ///
        /// Get the current date and time
        ///
        setDateTime: function (dateTime) {

            this.inputDiv.data("DateTimePicker").setDate(dateTime);
        },

        ///
        ///
        /// Destroy the widget
        ///
        _destroy: function () {

            /// Remove the added elements
            this.inputDiv.remove();
        }
    });

}(jQuery));

