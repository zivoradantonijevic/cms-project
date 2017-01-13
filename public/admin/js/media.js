(function ($) {
    'use strict';

    var mediaUpload = $('#media-upload'),
        dropzone = $('.dropzone');

    mediaUpload.fileupload({
        url: mediaUpload.data('url'),
        dropZone: dropzone,
        autoUpload: true,
        filesContainer: '.media-container'
    }).fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    ).addClass('fileupload-processing');

    $(document).bind('dragover', function (e) {
        var foundDropzone,
            timeout = window.dropZoneTimeout,
            found = false,
            node = e.target;

        if (!timeout) {
            dropzone.addClass('in');
        } else {
            clearTimeout(timeout);
        }

        do {
            if ($(node).hasClass('dropzone')) {
                found = true;
                foundDropzone = $(node);
                break;
            }
            node = node.parentNode;
        } while (node !== null);

        dropzone.removeClass('in hover');

        if (found) {
            foundDropzone.addClass('hover');
        }

        window.dropZoneTimeout = setTimeout(function () {
            window.dropZoneTimeout = null;
            dropzone.removeClass('in hover');
        }, 100);
    });
}(jQuery));
