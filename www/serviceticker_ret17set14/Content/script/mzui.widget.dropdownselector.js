/*
 * mzui.widgetDropDownSelector JavaScript Library v1.0.0
 * Extends jQuery plugin
 *
 * Copyright 2012, 2014 Mezasoft
 * http://www.mezasoft.com
 * Can´t be reproduced, copied or disclosed.
 * Proprietary and confidential.
 *
 *
 * Implements Mezasoft dropdown widget.
 *
 */

(function ($) {

    ///
    /// Attributes
    ///
    var version = "1.0.0";

    ///
    /// Creates a dropdown, get its data from the server dropdown type using ajax.
    ///
    $.widget("mzui.widgetDropDownSelector", {

        options: {

            dropDownName: "",   // Name of dropdown to get data from
            loadOnInit: true,    // Indicates weather the dropdown is loaded on init or will be loadad later
            // by calling the update method.
            smallSize: false    // Size of box
        },

        ///
        /// Create the report
        ///
        _create: function () {

        },

        ///
        /// Initialize the report
        ///
        _init: function () {

            var that = this;

            if (this.element[0].tagName !== 'DIV')
                throw new ReferenceError('mzui.widget.dropdownselector: Method works only on DIV types.');

            ///
            /// Clean the current element before continuing (to remove previous elements, if any)
            ///
            this.element.empty();

            ///
            /// Create the select element
            ///
            if (this.options.smallSize)
                this.select = $("<select class='form-control input-sm'></select>"); 
            else
                this.select = $("<select class='form-control'></select>");
            this.element.append(this.select);

            ///
            /// Update the data
            ///
            if (this.options.loadOnInit)
                this.update();
        },

        update: function () {

            var self = this;

            /// Get Ajax data, and callback to fill the select list
            $(this).transact('SelectList', this.options.dropDownName, ' ', this.ajaxDoneCallback);
        },

        ///
        /// loadSelectListData is called to load data to the select list
        ///
        loadSelectListData: function (options) {

            var htmlOptions = '';

            for (var i = 0; i < options.length; i++) {
                htmlOptions += '<option value="' + options[i].value + '">' + options[i].text + '</option>';
            }

            this.select.html(htmlOptions);

            $(this.select).trigger("change");
        },

        ///
        /// ajaxDoneCallback is called when the ajax transaction is complete
        ///
        ajaxDoneCallback: function (data) {

            var options = [];
            var opt = [];

            if (!data)
                throw new ReferenceError('mzui.widget.dropdownselector: No data returned from server.');

            for (var i = 0; i < data.msgData.length; i++) {
                opt = { 'value': data.msgData[i].value, 'text': data.msgData[i].name };
                options.push(opt);
            }


            this.loadSelectListData(options);
        },

        ///
        /// Get the the selected item value
        ///
        getSelectedValue: function () {

            return this.select.val();
        },

        ///
        /// Get the the selected item value
        ///
        getSelectedText: function () {

            return $(":selected", this).text();
        },

        ///
        /// Clean up the object
        ///
        _destroy: function () {

            this.select.remove();

        }
    });


}(jQuery));

