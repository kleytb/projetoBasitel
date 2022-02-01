/*
 * mzui.report JavaScript Library v1.0.0
 * Extends jQuery plugin
 *
 * Copyright 2012, 2014 Mezasoft
 * http://www.mezasoft.com
 * Can´t be reproduced, copied or disclosed.
 * Proprietary and confidential.
 *
 *
 * Implements Mezasoft report content.
 *
 */

(function ($) {

    ///
    /// Attributes
    ///
    var version = "1.0.0";

    ///--------------------------------------------------------------
    /// report
    ///--------------------------------------------------------------

    ///
    /// Creates a report table and get javascript report data
    ///
    $.widget("mzui.report", {

        options: {

            reportType: "",
            params: "", 
            errorGettingData: "Error getting report data from server.",
            tooManyRecordsMessage: "Your search returned too many data. Please retry with a shorter date/time interval.",
            noRegistersFoundMessage: "No data was found for this search. Please retry with different parameters.",
            exportMessage: "Export table data.\nPress Ctrl+C and Enter.\nThen open you preference program and press (CTRL+V) to save the data."
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
                throw new ReferenceError('mzui.report: Method works only on DIV types.');

            if (this.options.reportType === '')
                throw new ReferenceError('mzui.report: Please provide a reportType. Aborting.');

            ///
            /// Clean the current element before continuing (to remove previous report)
            ///
            this.element.empty();

            this.element.addClass("table-responsive small");

            this.mainTable = $("<table class='table table-striped table-bordered table-hover table-condensed'></table>");
            this.element.append(this.mainTable);

            /// Create the placeholder for eventual error message
            this.element.append($("<br />"));

            this.errorMessage = $("<p></p>");
            this.element.append(this.errorMessage);

            ///
            /// Submit the given data to ajax in order to get report data. On success plot the report or an
            /// error message
            ///

            ///
            /// Create the ajax call to gather report data and them goes to callback to build the report itself
            ///
            $(this).transact('Report', this.options.reportType, this.options.params, this.ajaxDoneCallback);
        },

        ///
        /// ajaxDoneCallback is called when the ajax transaction is complete
        ///
        ajaxDoneCallback: function (data) {

            var options = [];
            var opt = [];

            if (data.msgStatus != 'OK') {
                this.errorMessage.text(this.options.errorGettingData);
                throw new ReferenceError('mz.ui.report: Ajax response status error from server: Status=' + data.msgStatus + 'Message: ' + data.msgStatusMessage);
            }


            this.loadReportData(data.msgData);
        },

        ///
        /// loadReportData is called to load data to the report
        ///
        loadReportData: function (data) {

            var rowHTML = null;
            var curDOMElement = null;

            var curRow = null;

            var tHead = null;
            var tFoot = null;
            var tBody = null;

            ///
            /// First cleanup table and errorMessage
            ///
            this.cleanupReport();

            ///
            /// Check if the data volume is big
            ///
            if (data.length > 20000) {

                that.errorMessage.text(this.options.tooManyRecordsMessage);
                return;
            }

            ///
            /// Check if there is no data volume
            ///
            if (data.length <= 0) {

                that.errorMessage.text(this.options.noRegistersFoundMessage);
                return;
            }

            ///
            /// Check if contains data
            ///
            var hasTd = false;

            for (var x = 0; x < data.length; x++) {
                var args = data[x].name.split(";");
                if (args[1] == 'td') {
                    hasTd = true;
                    break;
                }
            }

            if (hasTd == false) {
                this.errorMessage.text(this.options.noRegistersFoundMessage);
                return;
            }

            for (var x = 0; x < data.length; x++) {

                ///
                /// Process the header, if present. (thead must be in the first piece of message)
                ///
                var args = data[x].name.split(";");

                ///
                /// Get the element type to process
                ///
                if (args[0] == 'title') {

                    var caption = $("<caption></caption>");
                    this.mainTable.append(caption);

                    var span = $("<span class='align-left'><strong>" + data[x].value + "</strong></span>");
                    caption.append(span);
                }


                if (args[0] == 'thead') {

                    if (tHead == null) {
                        tHead = $("<thead></thead>");
                        this.mainTable.append(tHead);
                    }

                    curDOMElement = tHead;
                }

                if (args[0] == 'tbody') {

                    if (tBody == null) {
                        tBody = $("<tbody></tbody>");
                        this.mainTable.append(tBody);
                    }

                    curDOMElement = tBody;
                }

                if (args[0] == 'tfoot') {

                    if (tFoot == null) {
                        tFoot = $("<tfoot></tfoot>");
                        this.mainTable.append(tFoot);
                    }

                    curDOMElement = tFoot;
                }


                ///
                /// Generate objects
                ///
                if (args[1] == 'tr') {
                    if (curDOMElement != null) {
                        var curRow = $("<tr></tr>");
                        curDOMElement.append(curRow);
                    }
                }

                if (args[1] == 'th') {
                    var cell = $("<th>" + this.getObjectFromAjaxValue(data[x].value) + "</th>");
                    curRow.append(cell);
                }


                if (args[1] == 'td') {

                    /// Footer data has different styling
                    if (curDOMElement == tFoot) {
                        cell = $("<td class='active'><strong>" + this.getObjectFromAjaxValue(data[x].value) + "</strong></td>");
                    }
                    else {
                        cell = $("<td>" + this.getObjectFromAjaxValue(data[x].value) + "</td>");
                    }

                    curRow.append(cell);
                }
            }
        },

        ///
        /// Cleanup the areas used to put the table data and the errorMessage.
        ///
        cleanupReport: function () {

            this.mainTable.empty();

            this.errorMessage.text("");

        },

        ///
        /// Return an object according to the value field received from ajax
        ///
        getObjectFromAjaxValue: function (value) {

            var args = value.split(";");

            switch (args[0]) {
                case 'Text':
                    return args[1];
                    break;

                case 'DateTime':
                    //          return Date.parse(args[1]);
                    return args[1];
                    break;

                case 'DateTimeInterval':
                    //                return Date.parse(args[1]);
                    return args[1].substr(0, args[1].length - 8);
                    break;

                case 'Int':
                    return parseInt(args[1]);
                    break;

                case 'Float': // Chop to 2 decimal strings
                    // Change ',' to '.' as javascript only accepts '.'
                    var newString = args[1].replace(",", ".");
                    var number = Number(newString);
                    return number.toFixed(2);
                    break;
            }

            return 'InvalidFormat';
        },

        ///
        /// Print the table to current printer
        ///
        _toFixed: function (value, precision) {
            var precision = precision || 0,
                neg = value < 0,
                power = Math.pow(10, precision),
                value = Math.round(value * power),
                integral = String((neg ? Math.ceil : Math.floor)(value / power)),
                fraction = String((neg ? -value : value) % power),
                padding = new Array(Math.max(precision - fraction.length, 0) + 1).join('0');

            return precision ? integral + '.' + padding + fraction : integral;
        },

        printTable: function () {

            var divToPrint = this.mainTable.get(0);

            newWin = window.open("");
            newWin.document.write('<html><head><title>' + divToPrint.caption + '</title>' +
                                '<link href="@Url.Content("~/Content/bootstrap.css")" rel="stylesheet" media="print">' +
                                '</head><body>');
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        },

        ///
        /// Export table data to CSV file
        ///
        exportTable: function () {

            var csv_value = $(this.mainTable).table2CSV({ delivery: 'value' });
            window.prompt(this.options.exportMessage, csv_value);

        },

        ///
        /// Destroy the widget
        ///
        _destroy: function () {

            ///  Remove the added elements
            this.errorMessage.remove();
            this.element.removeClass("container reportfilterbar");
        }
    });


}(jQuery));

