/*
 * mzui.messagegetter JavaScript Library v1.0.0
 * Extends jQuery plugin
 *
 * Copyright 2012, 2014 Mezasoft
 * http://www.mezasoft.com
 * Can´t be reproduced, copied or disclosed.
 * Proprietary and confidential.
 *
 *
 * Implements Mezasoft application ajax communications.
 *
 */

(function ($) {

    ///
    /// Attributes
    ///
    var version = "1.0.0";

    ///
    /// Get message from server.
    /// Parameters:
    /// code: message code
    /// type: message type (ErrorMessage for error message, Message for normal message)
    /// callback: callback function to be called when completed
    ///
    $.fn.getMessage = function (type, code, callback) {

        return this.each(function () {

            /// Check if all parameters are passed

            if (!type)
                throw new ReferenceError('mzui.messagegetter.transact: Please provide a valid type.');

            if (type !== 'ErrorMessage' && type !== 'Message')
                throw new ReferenceError('mzui.messagegetter.transact: Please provide a valid type (ErrorMessage or Message).');

            if (!code)
                throw new ReferenceError('mzui.messagegetter.transact: Please provide a valid code.');

            /// Get Ajax data, and callback to fill the select list


            $(this).transact('InternationalizationMessage', type, code, callback);
        })
    }

}(jQuery));

