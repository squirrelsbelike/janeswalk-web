
/**
 * ProfilePageView
 * 
 * @extends PageView
 */
var ProfilePageView = PageView.extend({

    /**
     * _currentTab
     * 
     * @protected
     * @var       String|null (default: null)
     */
    _currentTab: null,

    /**
     * init
     * 
     * @public
     * @param  jQuery element
     * @return void
     */
    init: function(element) {
        this._super(element);
        this._showProperStep();
        this._addTabClickEvents();
        this._setupDisplayPictureFlashWidget();
        this._addPictureDeleteEvent();
        this._addPromoteWalkClickEvent();
        this._addPromoteCityClickEvent();
        this._addPromoteBlogPostClickEvent();
        this._setupCityPromoteModalEvents();
        this._setupWalkPromoteModalEvents();
        this._setupBlogPostPromoteModalEvents();
        this._setupPromoteSlideshows();
    },

    /**
     * _addPictureDeleteEvent
     * 
     * @protected
     * @return    void
     */
    _addPictureDeleteEvent: function() {
        this._element.find('a[href="/index.php/profile/delete/"]').click(
            function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'DELETE',
                    url: $(this).attr('href'),
                    success: function() {
                        location.href = '/index.php/profile/#tab=picture&success=1';
                    }
                });
            }
        );
    },

    /**
     * _addPromoteBlogPostClickEvent
     * 
     * @protected
     * @return    void
     */
    _addPromoteBlogPostClickEvent: function() {
        var _this = this,
            $btn = this._element.find('.column.blogPosts .subactions .promote');
        $btn.click(
            function(event) {
                event.preventDefault();
                _this._element.find('.blogPostPromoteOverlay').show();
            }
        );
    },

    /**
     * _addPromoteCityClickEvent
     * 
     * @protected
     * @return    void
     */
    _addPromoteCityClickEvent: function() {
        var _this = this,
            $btn = this._element.find('#cityBlock .promoteBtn');
        $btn.click(
            function(event) {
                event.preventDefault();
                _this._element.find('.cityPromoteOverlay').show();
            }
        );
    },

    /**
     * _addPromoteWalkClickEvent
     * 
     * @protected
     * @return    void
     */
    _addPromoteWalkClickEvent: function() {
        var _this = this,
            $btn = this._element.find('.column.city .subactions .promote');
        $btn.click(
            function(event) {
                event.preventDefault();
                _this._element.find('.walkPromoteOverlay').show();
            }
        );
    },

    /**
     * _addTabClickEvents
     * 
     * @protected
     * @return    void
     */
    _addTabClickEvents: function() {

        // Nav tabs
        var _this = this;
        this._element.find('ul.nav-tabs li a').click(
            function(event) {
                event.preventDefault();
                _this._currentTab = $(this).attr('data-tab');
                _this._showCurrentTab();
            }
        );

        // Stand alone links
        this._element.find('.tabLink').click(
            function(event) {
                event.preventDefault();
                _this._currentTab = $(this).attr('data-tab');
                _this._showCurrentTab();
            }
        );
    },

    /**
     * _setupBlogPostPromoteModalEvents
     * 
     * @protected
     * @return    void
     */
    _setupBlogPostPromoteModalEvents: function() {
        var _this = this;
        this._element.find('.blogPostPromoteOverlay').find('.icon-twitter').click(
            function(event) {
                event.preventDefault();
                _this._showTwitterShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.blogPostPromoteOverlay').find('.icon-facebook').click(
            function(event) {
                event.preventDefault();
                _this._showFacebookShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    'Jane\'s Walk',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.blogPostPromoteOverlay').find('.icon-envelope').click(
            function(event) {
                event.preventDefault();
                _this._showEmailShareWindow(
                    'Jane\'s Walk in Toronto',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
    },

    /**
     * _setupCityPromoteModalEvents
     * 
     * @protected
     * @return    void
     */
    _setupCityPromoteModalEvents: function() {
        var _this = this;
        this._element.find('.cityPromoteOverlay').find('.icon-twitter').click(
            function(event) {
                event.preventDefault();
                _this._showTwitterShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.cityPromoteOverlay').find('.icon-facebook').click(
            function(event) {
                event.preventDefault();
                _this._showFacebookShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    'Jane\'s Walk',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.cityPromoteOverlay').find('.icon-envelope').click(
            function(event) {
                event.preventDefault();
                _this._showEmailShareWindow(
                    'Jane\'s Walk in Toronto',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
    },

    /**
     * _setupDisplayPictureFlashWidget
     * 
     * @protected
     * @return    void
     */
    _setupDisplayPictureFlashWidget: function() {
      window.ThumbnailBuilder_onSaveCompleted = function() {
        location.href = '/index.php/profile/#tab=picture&success=1';
      };
      var params = {
          bgcolor: '#ffffff',
          wmode: 'transparent',
          quality: 'high' 
        },
        flashvars = {
          width: this._element.find('#flashContainer').attr('data-width'),
          height: this._element.find('#flashContainer').attr('data-height'),
          image: this._element.find('#flashContainer').attr('data-imagepath'),
          save: this._element.find('#flashContainer').attr('data-savepath')
        };
      swfobject.embedSWF(
        this._element.find('#flashContainer').attr('data-flashpath'),
        'flashContainer',
        '500',
        '400',
        '10,0,0,0',
        'includes/expressInstall.swf',
        flashvars,
        params
      );
    },

    /**
     * _setupPromoteSlideshows
     * 
     * @protected
     * @return    void
     */
    _setupPromoteSlideshows: function() {
        this._element.find('#dashboardBlock .overlay, ')
    },

    /**
     * _setupWalkPromoteModalEvents
     * 
     * @protected
     * @return    void
     */
    _setupWalkPromoteModalEvents: function() {
        var _this = this;
        this._element.find('.walkPromoteOverlay').find('.icon-twitter').click(
            function(event) {
                event.preventDefault();
                _this._showTwitterShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.walkPromoteOverlay').find('.icon-facebook').click(
            function(event) {
                event.preventDefault();
                _this._showFacebookShareWindow(
                    'http://janeswalk.org/canada/toronto/',
                    'Jane\'s Walk',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
        this._element.find('.walkPromoteOverlay').find('.icon-envelope').click(
            function(event) {
                event.preventDefault();
                _this._showEmailShareWindow(
                    'Jane\'s Walk in Toronto',
                    $(this).closest('.option').find('.copy').text().trim()
                );
            }
        );
    },

    /**
     * _showCurrentTab
     * 
     * @protected
     * @return    void
     */
    _showCurrentTab: function() {
        this._element.find('ul.nav-tabs li.active').removeClass('active');
        this._element.find('ul.nav-tabs li a[data-tab="' + (this._currentTab) + '"]').parent().addClass('active');
        this._element.find('div.content div.block').addClass('hidden');
        this._element.find('div.content div.block[data-tab="' + (this._currentTab) + '"]').removeClass('hidden');
        location.hash = 'tab=' + (this._currentTab);
    },

    /**
     * _showEmailShareWindow
     * 
     * @protected
     * @param     String subject
     * @param     String body
     * @return    void
     */
    _showEmailShareWindow: function(subject, body) {
        subject = encodeURIComponent(subject);
        body = encodeURIComponent(body);
        var link = 'mailto:?subject=' + (subject) + '&body=' + (body);
        window.open(link);
    },

    /**
     * _showFacebookShareWindow
     * 
     * @protected
     * @param     String link
     * @param     String title
     * @param     String text
     * @return    void
     */
    _showFacebookShareWindow: function(link, title, text) {
        (new FacebookShareDialog({
            link: link,
            name: title,
            description: text
        })).show();
    },

    /**
     * _showProperStep
     * 
     * @protected
     * @return    void
     */
    _showProperStep: function() {
        if (location.hash !== '') {
            var pieces = location.hash.split('&'),
                hash = {},
                again;
            $(pieces).each(
                function(index, piece) {
                    again = piece.split('=');
                    hash[again[0].replace('#', '')] = again[1];
                }
            );
            this._currentTab = hash.tab;
            this._showCurrentTab();
            if (
                typeof hash.success !== 'undefined'
                && parseInt(hash.success) === 1
            ) {
                this._element.find('div.content div.block[data-tab="' + (this._currentTab) + '"]').addClass('success');
            }
        }
    },

    /**
     * _showTwitterShareWindow
     * 
     * @protected
     * @param     String link
     * @param     String text
     * @return    void
     */
    _showTwitterShareWindow: function(link, text) {
        link = encodeURIComponent(link);
        text = encodeURIComponent(text);
        var link = 'https://twitter.com/intent/tweet' +
            '?url=' + (link) +
            '&via=janeswalk' +
            '&text=' + (text);
        window.open(
            link,
            'Twitter Share',
            'width=640, height=320'
        );
    }
});