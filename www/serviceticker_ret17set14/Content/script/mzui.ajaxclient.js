/*
 * mzui.ajaxclient JavaScript Library v1.0.0
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
    var active = false;

    ///
    /// Transact a Ajax message 
    /// Parameters:
    /// url: Url to transact
    /// msgClass: message class
    /// msgType: message type
    /// msgData: message data
    /// callback: function to be called when completed
    ///
    $.fn.transact = function (msgClass, msgType, msgData, callback) {

        return this.each(function () {

            /// Check if all parameters are passed

            if (!msgClass)
                throw new ReferenceError('mzui.ajaxclient.transact: Please provide a valid msgClass.');

            if (!msgType)
                throw new ReferenceError('mzui.ajaxclient.transact: Please provide a valid msgType.');

            if (!msgData)
                throw new ReferenceError('mzui.ajaxclient.transact: Please provide a valid msgData.');

            var sendMessage = {}

            sendMessage.msgClass = msgClass;
            sendMessage.msgType = msgType;
            sendMessage.msgData = msgData;
            sendMessage.msgStatus = 'OK';
            sendMessage.msgStatusMessage = '';

            var url = 'AjaxServer/GetData';

            var that = this;
            this.returnCallback = callback;

            /// Change the cursor
            $("body").css("cursor", "progress");

            $.ajax({
                url: url,
                cache: false,
                type: "POST",
                contentType: 'application/json, charset=utf-8',
                data: JSON.stringify({ 'ajaxMessage': sendMessage }),
                success: function (data) {

                    /// Change the cursor
                    $("body").css("cursor", "default");

                    /// Check the response
                    if (data.msgStatus != 'OK' && data.msgStatus != 'NOK')
                        throw new ReferenceError('mz.comm.ajaxclient.transact: Ajax response status error from server: ' + data.msgStatus);

                    if (data.msgClass != sendMessage.msgClass)
                        throw new ReferenceError('mz.comm.ajaxclient.transact: Ajax response class ( ' + data.msgClass + ') error from server: ' + data.msgStatusMessage);

                    if (data.msgType != sendMessage.msgType)
                        throw new ReferenceError('mz.comm.ajaxclient.transact: Ajax response type error from server: ' + data.msgType);

                    $.proxy(that.returnCallback(data), that);
                },
                error: function (error) {

                    /// Change the cursor
                    $("body").css("cursor", "default");

                    /// Throw the response error
                    throw new ReferenceError('mz.comm.ajaxclient.transact: Error receiving ajax response from server. ' + JSON.stringify(error));
                }
            });

        });
    }

}(jQuery));

