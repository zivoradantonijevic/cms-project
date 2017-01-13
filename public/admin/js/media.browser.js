(function ($) {
    'use strict';

    function MediaBrowser(browser, options) {
        this.document = $(document);
        this.browser = $(browser);
        this.upload = this.browser.find('.media-upload');
        this.dropzone = this.upload.find('.dropzone');
        this.container = this.browser.find('.media-container');
        this.details = this.browser.find('.media-details');
        this.form = this.browser.find('.media-form');
        this.filter = this.browser.find('.media-filter');
        this.items = {
            files: [],
            paging: {
                "next_url": "",
                "current_page": 1,
                "per_page": 10
            }
        };
        this.selected = {};
        this.settings = $.extend({
            templates: {
                download: 'template-download',
                upload: 'template-upload',
                details: 'template-details',
                form: 'template-form'
            },
            url: {
                upload: 'index.php?r=media/ajax-upload',
                update: 'index.php?r=media/ajax-update',
                json: 'index.php?r=media-browser/get-json',
                insert: 'index.php?r=media-browser/field-insert'
            },
            editor: false,
            multiple: false,
            callback: '',
            autoload: true
        }, options);
        this.lockGetData = false;

        if (this.settings.callback !== '') {
            this.callback = this.settings.callback;
        }

        var self = this;

        this.actionGetData = function (data, paging) {
            if (this.lockGetData === false) {
                var url = '';

                if (paging === true) {
                    url = this.items.paging.next_url
                } else {
                    url = this.settings.url.json
                }

                $.ajax({
                    url: url,
                    data: self.filter.serializeObject(),
                    dataType: 'json',
                    success: function (response) {
                        if (paging === true) {
                            self.items.files = self.items.files.concat(response.files);
                            self.items.paging = response.paging;
                            self.container.append(tmpl(self.settings.templates.download, response));
                            self.lockGetData = false;
                        } else {
                            self.items = response;
                            self.container.html(tmpl(self.settings.templates.download, response));
                            self.lockGetData = false;
                        }
                    }
                })
            }
        };

        this.actionScroll = function () {
            var containerParent = self.container.parent();

            if ((this.container.height() <= containerParent.height()) && this.items.paging.next_url) {
                this.actionGetData(this.filter.serializeObject(), true);
                this.lockGetData = true;
            }

            containerParent.scroll(function () {
                var $this = $(this);

                if ((($this.height() * (3 / 2)) >= ((this).scrollHeight - $this.scrollTop) ) && self.items.paging.next_url) {
                    self.actionGetData(self.filter.serializeObject(), true);
                    self.lockGetData = true;
                }
            })
        };

        this.actionUpload = function () {
            this.upload.fileupload({
                    url: this.settings.url.upload,
                    dropZone: this.dropzone,
                    autoUpload: true,
                    filesContainer: this.container,
                    prependFiles: true
                })
                .fileupload("option", "redirect", window.location.href.replace(/\/[^\/]*$/, "/cors/result.html?%s"))
                .addClass('fileupload-processing');

            this.document.bind('dragover', function (e) {
                var found = false,
                    node = e.target,
                    foundDropzone,
                    timeout = window.dropZoneTimeout;

                if (!timeout) {
                    self.dropzone.addClass('in');
                } else {
                    clearTimeout(timeout);
                }

                do {
                    if ($(node).hasClass('dropzone')) {
                        found = true;
                        foundDropzone = $(node);
                        break
                    }
                    node = node.parentNode;
                } while (node !== null);

                self.dropzone.removeClass('in hover');

                if (found) {
                    foundDropzone.addClass('hover');
                }

                window.dropZoneTimeout = setTimeout(function () {
                    window.dropZoneTimeout = null;
                    self.dropzone.removeClass('in hover');
                }, 100);
            });

            self.upload.bind('fileuploaddone', function (e, data) {
                $.each(data.result, function (i, file) {
                    self.items.files[self.items.files.length] = file[0];
                });
            });

            self.upload.bind('fileuploadstart', function () {
                self.browser.find('a[href="#media-library"]').click();
            });
        };

        this.actionRemoveItem = function (id) {
            this.details.html('');
            this.form.html('');
            delete this.selected[id];
            var selectedIndex = Object.keys(this.selected);

            if (selectedIndex.length > 0) {
                var index = parseInt(selectedIndex[selectedIndex.length - 1]);
                $.each(this.items.files, function (i, file) {
                    if (file.id === index) {
                        self.details.html(tmpl(self.settings.templates.details, file));
                        self.form.html(tmpl(self.settings.templates.form, file));

                        return false
                    }
                });
            } else {
                this.browser.removeClass('visible-lr');
            }
        };

        this.actionAddItem = function (id, ui) {
            $.each(this.items.files, function (i, file) {
                if (id === file.id) {
                    self.details.html(tmpl(self.settings.templates.details, file));
                    file.for_editor = !!self.settings.editor;
                    self.form.html(tmpl(self.settings.templates.form, file));

                    if (!self.settings.multiple || self.settings.multiple === 'false') {
                        $(ui.selected).addClass('ui-selected').siblings().removeClass('ui-selected').each(
                            function (key, value) {
                                $(value).find('*').removeClass('ui-selected');
                            }
                        );
                        self.selected = {};
                    }

                    self.selected[id] = self.browser.find('.media-form-inner').first().serializeObject();
                    self.browser.addClass('visible-lr');

                    if (Object.keys(self.selected).length === 1) {
                        window.location.hash = 'media-' + id;
                    }

                    return false;
                }
            });
        };

        this.actionSelectItem = function () {
            this.container.on('touchstart mousedown', 'li', function (event, ui) {
                event.metaKey = true;
                var $this = $(this);

                if ($this.hasClass('ui-selected')) {
                    $this.removeClass('ui-selected');
                    self.actionRemoveItem($this.data('id'));

                    return false;
                }
            }).selectable({
                filter: 'li',
                tolerance: 'touch',
                selected: function (event, ui) {
                    var id = $(ui.selected).data('id');
                    self.actionAddItem(id, ui);
                },
                unselected: function (event, ui) {
                    var id = $(ui.unselected).data('id');
                    self.actionRemoveItem(id);
                }
            });
        };

        this.actionUpdateItem = function () {
            this.browser.on('blur', '.media-form-inner [id^="media-"]', function () {
                var $this = $(this),
                    parent = $this.parents('.media-form-inner'),
                    id = parent.data('id');

                self.selected[id] = parent.serializeObject();
            })
        };

        this.actionDeleteItem = function () {
            self.browser.on('click', '.delete-media', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var $this = $(this);

                if (confirm($this.data('confirm'))) {
                    $.ajax({
                        url: $this.data('url'),
                        type: "POST",
                        success: function () {
                            self.container.find('.media-item[data-id="' + $this.data('id') + '"]').remove();
                            self.details.html('');
                            self.form.html('');
                            delete self.selected[$this.data('id')];
                        }
                    });
                }
            });
        };

        this.actionUpdateAttribute = function () {
            self.browser.on('blur', '.media-form-inner [data-ajax-update]', function () {
                var $this = $(this),
                    parent = $this.parents('.media-form-inner');

                $.ajax({
                    url: self.settings.url.update,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        id: parent.data('id'),
                        attribute: $this.data('ajax-update'),
                        value: $this.val(),
                        _csrf: yii.getCsrfToken()
                    }
                });
            });
        };

        this.actionChangeLink = function () {
            self.browser.on('change', '#media-link-to', function () {
                var $this = $(this),
                    value = self.browser.find('#media-link-value');

                if ($this.val() === 'none') {
                    value.val('');
                    value.attr('readonly', true);
                } else if ($this.val() === 'custom') {
                    value.val('http://');
                    value.attr('readonly', false);
                } else {
                    value.val($this.val());
                    value.attr('readonly', true);
                }
            });
        };

        this.actionFilter = function () {
            this.filter.on('submit', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var $this = $(this);

                self.selected = {};
                self.actionGetData($this.serializeObject());
            });
        };

        this.actionInsert = function () {
            self.browser.on('click', '.insert-media', function (e) {
                e.preventDefault();

                if (Object.keys(self.selected).length === 0) {
                    return false;
                }

                $.ajax({
                    url: self.settings.url.insert,
                    data: {Media: self.selected, _csrf: yii.getCsrfToken()},
                    type: 'POST',
                    success: function (response) {
                        if (top.tinymce !== undefined && self.settings.editor) {
                            top.tinymce.activeEditor.execCommand("mceInsertContent", false, response);
                            window.top.$('#media-browser-modal').modal('hide');
                        }

                        if (window.top) {
                            if (self.callback && typeof window['top'][self.callback](response) === 'function') {
                                window['top'][self.callback](response);
                            }
                            window.top.$('#media-browser-modal').modal('hide');
                        }
                    }
                });
            });
        };

        this.actionInit = function () {
            this.actionGetData(this.filter.serializeObject());
            this.actionScroll();
            this.actionUpload();
            this.actionSelectItem();
            this.actionUpdateItem();
            this.actionDeleteItem();
            this.actionUpdateAttribute();
            this.actionChangeLink();
            this.actionFilter();
            this.actionInsert();
        };

        return this.actionInit();
    }

    $.fn.mediabrowser = function (options) {
        return this.each(function () {
            var $this = $(this);

            if ($this.data('mediabrowser')) {
                return;
            }

            var mediabrowser = new MediaBrowser(this, options);

            $this.data('mediabrowser', mediabrowser);
        });
    };
}(jQuery));