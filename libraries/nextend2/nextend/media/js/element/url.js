(function ($, scope, undefined) {

    var ajaxUrl = '',
        modal = null,
        cache = {},
        callback = function (url) {
        },
        lastValue = '';

    function NextendElementUrl(id, parameters) {
        this.element = $('#' + id);

        this.field = this.element.data('field');

        this.parameters = parameters;

        ajaxUrl = this.parameters.url;

        this.button = $('#' + id + '_button').on('click', $.proxy(this.open, this));

        this.element.siblings('.n2-form-element-clear')
            .on('click', $.proxy(this.clear, this));
    };

    NextendElementUrl.prototype = Object.create(NextendElement.prototype);
    NextendElementUrl.prototype.constructor = NextendElementUrl;

    NextendElementUrl.prototype.clear = function (e) {
        e.preventDefault();
        e.stopPropagation();
        this.val('#');
    };

    NextendElementUrl.prototype.val = function (value) {
        this.element.val(value);
        this.triggerOutsideChange();
    };

    NextendElementUrl.prototype.open = function (e) {
        e.preventDefault();
        callback = $.proxy(this.insert, this);
        lastValue = this.element.val();
        this.getModal().show();
    };

    NextendElementUrl.prototype.insert = function (url) {
        this.val(url);
    };

    NextendElementUrl.prototype.getModal = function () {
        if (!modal) {
            var getLinks = function (search) {
                if (typeof cache[search] == 'undefined') {
                    cache[search] =  $.ajax({
                        type: "POST",
                        url: NextendAjaxHelper.makeAjaxUrl(ajaxUrl),
                        data: {
                            keyword: search
                        },
                        dataType: 'json'
                    });
                }
                return cache[search];
            };

            var parameters = this.parameters;

            var lightbox = {
                    size: [
                        500,
                        590
                    ],
                    title: n2_('Lightbox'),
                    back: 'zero',
                    close: true,
                    content: '<form class="n2-form"></form>',
                    controls: ['<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Insert') + '</a>'],
                    fn: {
                        show: function () {
                            var button = this.controls.find('.n2-button'),
                                chooseImages = $('<a href="#" class="n2-button n2-button-medium n2-button-green n2-uc n2-h5" style="float:right; margin-right: 20px;">' + n2_('Choose images') + '</a>'),
                                form = this.content.find('.n2-form').on('submit', function (e) {
                                    e.preventDefault();
                                    button.trigger('click');
                                }).append(this.createTextarea(n2_('Content list') + " - " + n2_('One per line'), 'n2-link-resource', 'width: 446px;height: 100px;')).append(chooseImages).append(this.createInputUnit(n2_('Autoplay duration'), 'n2-link-autoplay', 'ms', 'width: 40px;')),
                                resourceField = this.content.find('#n2-link-resource').focus(),
                                autoplayField = this.content.find('#n2-link-autoplay').val(0);

                            chooseImages.on('click', function (e) {
                                e.preventDefault();
                                nextend.imageHelper.openMultipleLightbox(function (images) {
                                    var value = resourceField.val().replace(/\n$/, '');

                                    for (var i = 0; i < images.length; i++) {
                                        value += "\n" + images[i].image;
                                    }
                                    resourceField.val(value.replace(/^\n/, ''));
                                });
                            });

                            var matches = lastValue.match(/lightbox\[(.*?)\]/);
                            if (matches && matches.length == 2) {
                                var parts = matches[1].split(',');
                                if (parseInt(parts[parts.length - 1]) > 0) {
                                    autoplayField.val(parseInt(parts[parts.length - 1]));
                                    parts.pop();
                                }
                                resourceField.val(parts.join("\n"));
                            }

                            this.content.append(this.createHeading(n2_('Examples')));
                            this.createTable([
                                [n2_('Image'), 'http://smartslider3.com/image.jpg'],
                                ['YouTube', 'https://www.youtube.com/watch?v=MKmIwHAFjSU'],
                                ['Vimeo', 'https://vimeo.com/144598279'],
                                ['Iframe', 'http://smartslider3.com']
                            ], ['', '']).appendTo(this.content);

                            button.on('click', $.proxy(function (e) {
                                e.preventDefault();
                                var link = resourceField.val();
                                if (link != '') {
                                    var autoplay = '';
                                    if (autoplayField.val() > 0) {
                                        autoplay = ',' + autoplayField.val();
                                    }
                                    callback('lightbox[' + link.split("\n").filter(Boolean).join(',') + autoplay + ']');
                                }
                                this.hide(e);
                            }, this));
                        }
                    }
                },
                links = {
                    size: [
                        600,
                        430
                    ],
                    title: n2_('Link'),
                    back: 'zero',
                    close: true,
                    content: '<div class="n2-form"></div>',
                    fn: {
                        show: function () {

                            this.content.find('.n2-form').append(this.createInput(n2_('Keyword'), 'n2-links-keyword', 'width:546px;'));
                            var search = $('#n2-links-keyword'),
                                heading = this.createHeading('').appendTo(this.content),
                                result = this.createResult().appendTo(this.content),
                                searchString = '';

                            search.on('keyup', $.proxy(function () {
                                searchString = search.val();
                                getLinks(searchString).done($.proxy(function (r) {
                                    if (search.val() == searchString) {
                                        var links = r.data;
                                        if (searchString == '') {
                                            heading.html(n2_('No search term specified. Showing recent items.'));
                                        } else {
                                            heading.html(n2_printf(n2_('Showing items match for "%s"'), searchString));
                                        }

                                        var data = [],
                                            modal = this;
                                        for (var i = 0; i < links.length; i++) {
                                            data.push([links[i].title, links[i].info, $('<div class="n2-button n2-button-green n2-button-x-small n2-uc n2-h5">' + n2_('Select') + '</div>')
                                                .on('click', {permalink: links[i].link}, function (e) {
                                                    callback(e.data.permalink);
                                                    modal.hide();
                                                })]);
                                        }
                                        result.html('');
                                        this.createTable(data, ['width:100%;', '', '']).appendTo(this.createTableWrap().appendTo(result));
                                    }
                                }, this));
                            }, this))
                                .trigger('keyup').focus();
                        }
                    }
                };
            modal = new NextendModal({
                zero: {
                    size: [
                        parameters.hasPosts ? 700 : 500,
                        342
                    ],
                    title: n2_('Link'),
                    back: false,
                    close: true,
                    content: '<table class="n2-table-pane"><tr>' +
                    '<td><img src="' + parameters.imageUrl + parameters.image + '"/><p style="min-height:36px;">' + parameters.labelDescription + '</p><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + parameters.labelButton + '</a></td>' +
                    '<td><img src="' + parameters.imageUrl + '/element/link_lightbox.png"/><p style="min-height:36px;">' + n2_('Create lightbox from image, video or iframe.') + '</p><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Lightbox') + '</a></td>' +
                    '<td><img src="' + parameters.imageUrl + '/element/link_actions.png"/><p style="min-height:36px;">' + n2_('Create action for click or tap.') + '</p><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Actions') + '</a></td></tr></table>',
                    fn: {
                        show: function () {

                            var controls = this.content.find('td');

                            if (!parameters.hasPosts) {
                                controls.eq(0).css('display', 'none');
                            } else {
                                controls.eq(0).on('click', $.proxy(function (e) {
                                    e.preventDefault();
                                    this.loadPane('links');
                                }, this));
                            }

                            controls.eq(1).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                this.loadPane('lightbox');
                            }, this));
                            controls.eq(2).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                this.loadPane('actions');
                            }, this));
                        }
                    }
                },
                lightbox: lightbox,
                links: links,
                actions: {
                    size: [
                        500,
                        342
                    ],
                    title: n2_('Actions'),
                    back: 'zero',
                    close: true,
                    content: '<table class="n2-table-pane"><tr>' +
                    '<td><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Scroll to') + '</a></td>' +
                    '<td><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Go to slide') + '</a></td></tr>' +
                    '<tr><td><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Previous slide') + '</a></td>' +
                    '<td><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Next slide') + '</a></td></tr>' +
                    '<tr><td><a href="#" class="n2-button n2-button-big n2-button-grey n2-h4 n2-uc">' + n2_('Slide event') + '</a></td><td></td></tr>' +
                    '</table>',
                    fn: {
                        show: function () {
                            var controls = this.content.find('td');
                            controls.eq(0).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                this.loadPane('actionsScrollTo');
                            }, this));
                            controls.eq(1).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                this.loadPane('actionsGoTo');
                            }, this));
                            controls.eq(2).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                callback('PreviousSlide[]');
                                modal.hide();
                            }, this));
                            controls.eq(3).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                callback('NextSlide[]');
                                modal.hide();
                            }, this));
                            controls.eq(4).on('click', $.proxy(function (e) {
                                e.preventDefault();
                                this.loadPane('actionsSlideEvent');
                            }, this));
                        }
                    }
                },
                actionsSlideEvent: {
                    size: [
                        500,
                        212
                    ],
                    title: n2_('Actions') + ' - ' + n2_('Slide event'),
                    back: 'actions',
                    close: true,
                    content: '<form class="n2-form" style="text-align: center;"></form>',
                    controls: ['<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Insert') + '</a>'],
                    fn: {
                        show: function () {


                            var button = this.controls.find('.n2-button'),
                                form = this.content.find('.n2-form').on('submit', function (e) {
                                    e.preventDefault();
                                    button.trigger('click');
                                });
                            form.append(this.createInput(n2_('Event name'), 'n2-slide-index', 'width:300px;'));

                            var input = n2('#n2-slide-index').val('');
                            button.on('click', $.proxy(function (e) {
                                e.preventDefault();
                                callback('SlideEvent[' + input.val() + ']');
                                this.hide(e);
                            }, this));
                        }
                    }
                },
                actionsGoTo: {
                    size: [
                        500,
                        212
                    ],
                    title: n2_('Actions') + ' - ' + n2_('Go to slide'),
                    back: 'actions',
                    close: true,
                    content: '<form class="n2-form" style="text-align: center;"></form>',
                    controls: ['<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Insert') + '</a>'],
                    fn: {
                        show: function () {


                            var button = this.controls.find('.n2-button'),
                                form = this.content.find('.n2-form').on('submit', function (e) {
                                    e.preventDefault();
                                    button.trigger('click');
                                });
                            form.append(this.createInput(n2_('Slide index'), 'n2-slide-index', 'width:50px;'));

                            var input = n2('#n2-slide-index').val(0);
                            button.on('click', $.proxy(function (e) {
                                e.preventDefault();
                                callback('GoToSlide[' + input.val() + ']');
                                this.hide(e);
                            }, this));
                        }
                    }
                },
                actionsScrollTo: {
                    size: [
                        570,
                        412
                    ],
                    title: n2_('Actions') + ' - ' + n2_('Scroll to'),
                    back: 'actions',
                    close: true,
                    content: '<form class="n2-form"></form>',
                    controls: ['<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Insert') + '</a>'],
                    fn: {
                        show: function () {


                            var button = this.controls.find('.n2-button'),
                                form = this.content.find('.n2-form').on('submit', function (e) {
                                    e.preventDefault();
                                    button.trigger('click');
                                });
                            form.append(this.createInput(n2_('Scroll to'), 'n2-scroll-to', 'width:516px;'));

                            var input = n2('#n2-scroll-to').val('');

                            new NextendElementAutocompleteSimple("n2-scroll-to", ["top", "bottom", "beforeSlider", "afterSlider", "previousSlider", "nextSlider"]);
                            input.parent().addClass('n2-form-element-autocomplete ui-front');

                            button.on('click', $.proxy(function (e) {
                                e.preventDefault();
                                callback('ScrollTo[' + input.val() + ']');
                                this.hide(e);
                            }, this));

                            this.content.append(this.createHeading(n2_('Examples')));
                            this.createTable([
                                ['top', n2_('Scrolls to the top of the page')],
                                ['bottom', n2_('Scrolls to the bottom of the page')],
                                ['jQuery selector', n2_('You can use any jQuery selector to scroll to a specific element on the page. Example: "#pricing" scrolls to the element with the id of "pricing".')]
                            ], ['', '']).appendTo(this.content);
                        }
                    }
                }
            }, false);
        
            modal.setCustomClass('n2-url-modal');
        }
        return modal;
    };

    scope.NextendElementUrl = NextendElementUrl;

})(n2, window);