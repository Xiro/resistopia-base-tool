
/****************
 * DIALOGS
 *****************/

var dialogCount = 0;

/**
 * @param data
 *
 * CONSTRUCTION DATA:
 * size: Dialog box size (sm, md, lg)
 * heading: Heading text
 * headingSize: Head tag to be used (h1, h2, h3, h4, h5, h6)
 * headingClass: Class attribute of heading. Default: "dialog-heading justified-top"
 * dialogId: ID of dialog wrapper, auto generated with incrementing ID
 * buttons: Array of objects containing either property "template" or "html" and optional "action" as callback
 * buttonContainerClass: Class of the div containing the rendered buttons
 * content: HTML to be used as dialog content
 * openOnLoad: Determines if the open method should be triggered after the start event
 * dialogClass: Layout  class of the dialog:
 * - "fit" will fit the content in the box, using a scrollbar if necessary
 * - "stretch" will always make the dialog its maximum size
 *
 * EVENTS
 * close(Dialog): Called when the "close" button was clicked
 * open(Dialog): Called when the dialog is opened
 * start: Called after the dialog was rendered and before its opened
 *
 * CONTENT ELEMENTS AFTER RENDERING:
 * wrapperElement: Dialog wrapper, displayed as grey, transparent background
 * boxElement: Actual dialog box
 * contentElement: Content element of dialog box
 */
function Dialog(data) {

    this.size = typeof data.size === "undefined" ? "md" : data.size;
    this.heading = typeof data.heading === "undefined" ? null : data.heading;
    this.headingSize = typeof data.headingSize === "undefined" ? "h1" : data.headingSize;
    this.headingClass = typeof data.headingClass === "undefined" ? "dialog-heading justified-top" : data.headingClass;
    this.dialogId = typeof data.dialogId === "undefined" ? 'dialog-' + dialogCount : data.dialogId;
    this.buttons = typeof data.buttons === "undefined" ? {close: {template: "close"}} : data.buttons;
    this.buttonContainerClass = typeof data.buttonContainerClass === "undefined" ? "" : data.buttonContainerClass;
    this.content = typeof data.content === "undefined" ? '' : data.content;
    this.dialogClass = typeof data.dialogClass === "undefined" ? 'fit' : data.dialogClass;
    this.openOnLoad = typeof data.openOnLoad === "undefined" ? true : data.openOnLoad;
    this.wrapperElement = null;
    this.boxElement = null;
    this.contentElement = null;

    this.close = typeof data.close !== "undefined" ? data.close : function (dialog) {
        if(typeof dialog === "undefined") {
            dialog = this;
        }
        dialog.wrapperElement.fadeOut(250, function () {
            dialog.wrapperElement.remove();
        });
    };
    this.open = typeof data.open !== "undefined" ? data.open : function (dialog) {
        if(typeof dialog === "undefined") {
            dialog = this;
        }
        dialog.wrapperElement.fadeIn(250);
    };
    this.start = typeof data.start !== "undefined" ? data.start : function (dialog) {};

    this.render = function() {
        var self = this;
        var dialogHtml = '<div class="dialog dialog-' + this.size + ' ' + this.dialogClass + '">';
        // heading
        if(this.heading) {
            dialogHtml += '<' + this.headingSize + ' class="' + this.headingClass + '">';
            dialogHtml += this.heading;
            dialogHtml += '</' + this.headingSize + '>';
        }
        // content
        dialogHtml += '<div class="dialog-content">';
        dialogHtml += this.content;
        dialogHtml += '</div>';
        dialogHtml += '</div>';

        // render dialog HTML to DOM

        if(this.wrapperElement === null) {
            var dialogWrapperHtml = '<div class="dialog-wrapper" id="' + this.dialogId + '" style="visibility:hidden">' + dialogHtml + '</div>';
            var prependDialogsTo = $("body");
            prependDialogsTo.prepend(dialogWrapperHtml);
            this.wrapperElement = prependDialogsTo.find("#" + this.dialogId);
            dialogCount++;
        } else {
            this.wrapperElement.html(dialogHtml);
        }
        this.boxElement = this.wrapperElement.find(".dialog");
        this.contentElement = this.wrapperElement.find(".dialog-content");

        // add buttons

        if(this.buttons) {
            this.boxElement.append('<div class="dialog-buttons ' + this.buttonContainerClass + '"></div>');
            var buttonContainer = this.boxElement.find(".dialog-buttons");
            $.each(this.buttons, function (name, buttonData) {
                if(buttonData.hasOwnProperty("template")) {
                    switch (buttonData.template) {
                        case "close":
                        case "cancel":
                        case "ok":
                            buttonData = {
                                html: '<button class="btn btn-primary dialog-close">' + ucfirst(buttonData.template) + '</button>',
                                action: function () {
                                    self.close(self);
                                }
                            };
                            break;
                    }
                }
                if(!buttonData.hasOwnProperty("html")) {
                    console.error("Dialog button must have HTML");
                    return null;
                }
                var buttonElement = $(buttonData.html);
                if(buttonData.hasOwnProperty("action")) {
                    buttonElement.click(function () {
                        buttonData.action(self);
                    });
                }
                buttonContainer.append(buttonElement);
            });
        }
        this.wrapperElement.click(function(e){
            // Only hide if the dialogs background was clicked
            if(e.target !== e.currentTarget) return;
            self.close(self);
        });

        // scroll content

        var elementsHeight = 0;
        this.wrapperElement.find(".dialog > *").each(function () {
            if ($(this).attr("class").indexOf("dialog-content") !== -1) {
                return;
            }
            elementsHeight += $(this).outerHeight();
            elementsHeight += parseInt($(this).css("marginTop").replace('px', ''));
            elementsHeight += parseInt($(this).css("marginBottom").replace('px', ''));
        });
        var maxContentHeight = this.wrapperElement.find(".dialog").height() - elementsHeight;
        if(this.dialogClass.indexOf("fit") !== -1) {
            if(maxContentHeight < this.contentElement.outerHeight()) {
                this.contentElement.css({
                    "max-height": maxContentHeight,
                    "overflow-y": "scroll"
                });
            }
        } else if(this.dialogClass.indexOf("stretch") !== -1) {
            this.contentElement.css("height", maxContentHeight);
        }

        this.start(this);
        this.wrapperElement.attr("style", "display:none");
        if(this.openOnLoad) {
            this.open(this);
        }
    };

    this.render();
}