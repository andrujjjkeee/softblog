( function(){

    "use strict";

    $( function () {

        Preloader();

        /*$.each( $( '.popup__notifications' ), function() {
                    new TrueUser ();
                } );*/

        $.each( $( '#blog' ), function() {
            new Blog ( $( this ) );
        } );

        $.each( $( '#search' ), function() {
            new SearchForm ( $( this ) );
        } );

        $.each( $( '#to-top' ), function() {
            new ToTop ( $( this ) );
        } );

        $.each( $( 'iframe' ), function() {
            new SetSizeIframe ( $( this ) );
        } );

    } );

    var Blog = function ( obj ) {

        var _obj = obj,
            _blogWrap = _obj.find( '#blog__wrap' ),
            _blogList = _blogWrap.find( '#blog__list' ),
            _blogLoadMore = _obj.find( '#blog__load-more' ),
            _categoryList = $( '.categories' ),
            _categoryItem = _categoryList.find( '.categories__item' ),
            _currentId = _categoryItem.filter( '.is-active' ).data( 'id' ),
            _currentPage = 2,
            _maxPage = 2,
            _canSendRequest = true,
            // _url = 'php/blog.json',
            _url = $( '#site__wrap' ).data( 'action' ),
            _request = new XMLHttpRequest(),
            _window = $( window ),
            _body = $( 'html, body' ),
            _monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

        var _onEvents = function() {

                _window.on( {
                    'scroll': function () {
                        if ( ( _window.outerWidth() >= 768 ) &&  ( _window.scrollTop() + _window.height() >= _blogWrap.offset().top + _blogWrap.outerHeight() - 10 ) ) {
                            _loadData();
                        }
                    },
                    'resize': function () {
                        _blogWrap.css( 'height', _blogList.outerHeight() );
                    }
                } );

                _categoryItem.on( 'click', function () {
                    _changeCategory( $(this) );
                    return false;
                } );

                _blogLoadMore.on( 'click', function () {
                    _loadData();
                    return false;
                } );

            },
            _changeCategory = function ( obj ) {

                _currentPage = 1;
                _maxPage = 1;
                _canSendRequest = true;

                _categoryItem.removeClass( 'is-active' );
                obj.addClass( 'is-active' );

                _blogList.empty();
                _blogWrap.css( 'height', _window.outerHeight() / 2 );

                _currentId = obj.data( 'id' );

                _loadData();

                if ( _window.outerWidth() < 768 ) {
                    _blogWrap.css( 'height', _blogList.outerHeight() );

                    _body.animate( {
                        scrollTop: 0
                    }, 600);
                }

            },
            _setBlogItem = function ( data ) {

                var blogItem = data,
                    blogItemLink = blogItem.link,
                    blogItemImage = blogItem.image,
                    blogItemTitle = blogItem.title,
                    blogItemContent = blogItem.content,
                    blogItemDate = blogItem.date,
                    dateArr = blogItemDate.split('-'),
                    frameItem = $( '<article class="blog__item is-new" />' ),
                    blogContent;

                if ( blogItemImage ){
                    frameItem.append( '<a href="'+ blogItemLink +'" class="blog__picture"><img src="'+ blogItemImage +'" alt="'+ blogItemTitle +'"/></a>' );
                }

                blogContent = '<div class="blog__item-wrap"><div class="blog__info">' +
                    '<time class="blog__date" datetime="blogItemDate">'+ _monthNames[ dateArr[1] - 1 ] +' '+ dateArr[2] +', '+ dateArr[0] +'</time>' +
                    '<a href="https://twitter.com/intent/follow?original_referer=https%3A%2F%2Fsoftspotapp.com%2Fblog%2F&ref_src=twsrc%5Etfw&screen_name=softspotapp&tw_p=followbutton" class="twttr">\n' +
                    '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 49.3 40" style="enable-background:new 0 0 49.3 40;" xml:space="preserve">' +
                    '<path d="M49.3,4.7c-1.8,0.8-3.8,1.3-5.8,1.6c2.1-1.2,3.7-3.2,4.4-5.6c-2,1.2-4.1,2-6.4,2.5C39.6,1.2,37,0,34.1,0' +
                    'C28.5,0,24,4.5,24,10.1c0,0.8,0.1,1.6,0.3,2.3C15.9,12,8.4,8,3.4,1.8C2.6,3.3,2.1,5.1,2.1,6.9c0,3.5,1.8,6.6,4.5,8.4' +
                    'c-1.7-0.1-3.2-0.5-4.6-1.3c0,0,0,0.1,0,0.1c0,4.9,3.5,9,8.1,9.9c-0.8,0.2-1.7,0.4-2.7,0.4c-0.7,0-1.3-0.1-1.9-0.2c1.3,4,5,6.9,9.4,7' +
                    'c-3.5,2.7-7.8,4.3-12.6,4.3c-0.8,0-1.6,0-2.4-0.1C4.5,38.4,9.8,40,15.5,40c18.6,0,28.8-15.4,28.8-28.8c0-0.4,0-0.9,0-1.3' +
                    'C46.2,8.5,47.9,6.8,49.3,4.7z"/></svg>Follow @softspotapp</a></div>' +
                    '<a href="'+ blogItemLink +'" class="blog__content"><h2 class="blog__topic"><span>'+ blogItemTitle +'</span></h2>' +
                    '<div class="blog__text"><p>'+ blogItemContent +'</p></div></a></div>';

                frameItem.append( blogContent );

                return frameItem;

            },
            _loadData = function () {

                if( _canSendRequest && _currentPage <= _maxPage ){
                    _sendRequest();
                }

            },
            _sendRequest = function() {

                _canSendRequest = false;

                _request.abort();
                _blogWrap.addClass( 'is-loading' ).removeClass( 'is-empty' );

                _request = $.ajax( {
                    url: _url,
                    data: {
                        action: 'get_posts_by_category',
                        page: _currentPage,
                        taxId: _currentId
                    },
                    dataType: 'json',
                    timeout: 20000,
                    type: 'POST',
                    success: function ( data ) {
                        _setList( data );
                    },
                    error: function ( XMLHttpRequest ) {
                        if ( XMLHttpRequest.statusText != "abort" ) {
                            console.error( 'err' );
                        }
                    }
                } );

            },
            _setList = function( data ) {

                _maxPage = data.maxPages;

                if ( _maxPage === 0 ){
                    _blogLoadMore.addClass( 'is-hidden' );
                    _blogWrap.removeClass( 'is-loading' );
                    return false;
                }

                var blogData = data.blog,
                    blogItemTotal = blogData.length;

                if ( blogItemTotal === 0 ){
                    _canSendRequest = false;
                    _blogWrap.addClass( 'is-empty' ).removeClass( 'is-loading' );
                    return false;
                }

                $.each( blogData, function( index ) {

                    var blogFrame = _setBlogItem( this );

                    _blogList.append( blogFrame );

                    if ( index === blogItemTotal - 1 ){
                        _blogWrap.removeClass( 'is-loading' );
                        _canSendRequest = true;

                        _blogWrap.css( 'height', _blogList.outerHeight() );

                        var newItem = _blogList.find( '.is-new' );

                        newItem.each( function ( i ) {

                            var curItem = $( this );

                            _showNewItems( curItem, i );

                        } );

                        var image = newItem.find( 'img' );

                        image.on( 'load', function () {
                            _blogWrap.css( 'height', _blogList.outerHeight() );
                        } );

                    }

                } );

                _currentPage = _currentPage + 1;

                if ( _currentPage > _maxPage  ) {
                    _blogLoadMore.addClass( 'is-hidden' )
                } else {
                    _blogLoadMore.removeClass( 'is-hidden' );
                    _canSendRequest = true;
                }

            },
            _showNewItems = function ( item, index ) {

                var curItem = item;

                setTimeout( function() {
                    curItem.removeClass( 'is-new' );
                }, 100 * index );

            },
            _construct = function() {
                _onEvents();
                _loadData();
            };

        _construct()
    };

    var SearchForm = function( obj ) {

        //private properties
        var _obj = obj,
            _searchForm = _obj.find( '#search__form' ),
            _searchInput = _searchForm.find( 'input' ),
            _searchPopup = _obj.find( '#search__popup' ),
            _searchPopupScrollWrap = _searchPopup.find( '#search__popup-scroll-wrap' ),
            _resultWrap = _searchPopup.find( '#search__result' ),
            // _url = 'php/search.json',
            _url = $( $( '#site__wrap' ) ).data( 'action' ),
            _site = $( '#site' ),
            _ps = null,
            _timer = null,
            _witchLetterStat = 2,
            _request = new XMLHttpRequest();

        //private methods
        var _onEvent = function () {

                _site.on( 'click', function ( e ) {

                    if ( _searchPopup.hasClass( 'is-show' ) && $( e.target ).closest( _obj ).length == 0 ){
                        _hidePopup();
                    }

                } );

                _searchInput.on ( 'keyup', function( e ) {

                    var symbolNumber = _searchInput.val().length;

                    switch ( e.keyCode ) {
                        case 27:
                            _hidePopup();
                            break;
                        case 13, 27, 37, 38, 39, 40:
                            (e).preventDefault();
                            break;
                        default:
                            if( symbolNumber > _witchLetterStat ){

                                _request.abort();
                                clearTimeout( _timer );

                                _timer = setTimeout( function () {
                                    _searchForm.hasClass( 'is-show' ) ? _ajaxRequest() : _showPopup();
                                }, 500 );

                            } else if ( symbolNumber <= _witchLetterStat ) {

                                _request.abort();
                                clearTimeout( _timer );
                                _hidePopup();

                            }
                    }

                } );

            },
            _ajaxRequest = function () {

                _searchPopup.addClass( 'is-loading' );

                _request.abort();

                _request = $.ajax( {
                    url: _url,
                    data: {
                        action: 'get_search_result',
                        search_value: _searchInput.val()
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function ( data ) {
                        _loadData( data );
                    },
                    error: function ( XMLHttpRequest ) {
                        if ( XMLHttpRequest.statusText != "abort" ) {
                            console.error( 'err' );
                        }
                    }
                } );

            },
            _loadData = function ( data ) {

                var info;

                info = data.result;

                _resultWrap.empty();

                if ( !info ){
                    _searchPopup.addClass( 'is-empty' ).removeClass( 'is-loading' );

                    if ( _ps !== null ) {
                        _ps.destroy();
                        _ps = null;
                    }

                    return false;
                }

                var recipesTotal = info.length;

                if ( recipesTotal !== 0 ){

                    _searchPopup.removeClass( 'is-empty' );

                    $.each( info, function( index ) {

                        var recipesItem = _createItemFrame( this );

                        _resultWrap.append( recipesItem );

                        if ( index === recipesTotal - 1 ){

                            _searchPopup.removeClass( 'is-loading' );

                            _setWrapHeight();
                        }

                    } );

                } else {
                    _searchPopup.addClass( 'is-empty' ).removeClass( 'is-loading' );

                    if ( _ps !== null ) {
                        _ps.destroy();
                        _ps = null;
                    }

                }

            },
            _createItemFrame = function ( data ) {

                var recipesItem = data,
                    recipesItemLink = recipesItem.link,
                    recipesItemTitle = recipesItem.title,
                    frameItem = null;

                frameItem = '<a href="'+ recipesItemLink +'" class="search__result-item">' +
                    '<p>'+ recipesItemTitle +'</p></a>';

                return frameItem;

            },
            _showPopup = function () {

                _searchPopup.addClass( 'is-show' );
                _ajaxRequest();

            },
            _setWrapHeight = function () {

                _searchPopup.css( 'height', _resultWrap.outerHeight() + 37 );

                _searchPopup.on( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                    if ( _ps == null ){
                        _initScroll();
                    } else {
                        _ps.update();
                    }
                    _searchPopup.off( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend' );
                } );

            },
            _hidePopup = function () {

                if ( !_searchPopup.hasClass( 'is-show' ) ){
                    return false;
                }

                _searchPopup.removeClass( 'is-show' );

                _searchPopup.on( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
                    _resultWrap.empty();

                    if ( _ps !== null ) {
                        _ps.destroy();
                        _ps = null;
                    }

                    _searchPopup.off( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend' );

                } );


            },
            _initScroll = function () {

                if ( _searchPopupScrollWrap.outerHeight() > _searchPopup.outerHeight() - 37 ){

                    var searchPopupScrollWrap = document.querySelector( '#search__popup-scroll-wrap' );

                    _ps = new PerfectScrollbar( searchPopupScrollWrap, {
                        suppressScrollX: true
                    } );

                }

            },
            _construct = function() {
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var SetSizeIframe = function (obj) {

        //private properties
        var _obj = obj,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {
                    _setSize();
                } );

            },
            _setSize = function () {

                var videoWidth = _obj.outerWidth();

                _obj.css( 'height', videoWidth / 1.7777 + 'px' );

            },
            _construct = function() {
                _onEvent();
                _setSize();
            };

        //public properties

        //public methods

        _construct();

    };

    var ToTop = function( obj ) {

        //private properties
        var _obj = obj,
            _aside = $( '#site__aside' ),
            _body = $( 'html, body' ),
            _window = $( window );

        //private methods
        var _onEvent = function () {

                _window.on( 'scroll', function () {
                    if ( _window.scrollTop() >= _aside.offset().top + _aside.outerHeight() ) {
                        _obj.addClass( 'is-show' )
                    } else {
                        _obj.removeClass( 'is-show' )
                    }
                } );

                _obj.on( {
                    click: function() {

                        var curBtn = $( this );

                        _body.animate( {
                            scrollTop: 0
                        }, 600);

                        return false;
                    }
                } );

            },
            _construct = function() {
                _onEvent();
            };

        //public properties

        //public methods

        _construct();

    };

    var TrueUser = function(){

        //private properties

        //private methods
        var _checkUser = function () {

                // var trueUser = localStorage.getItem( 'trueUserSoftSpot' );

                // if ( !trueUser ) {
                $( '#popup' )[0].obj.openPopup( 'notifications' );
                // localStorage.setItem( 'trueUserSoftSpot', true )
                // }

            },
            _construct = function(){
                _checkUser();
            };

        //public properties

        //public methods

        _construct();

    };

    function Preloader () {

        var preloader = document.getElementById( 'preload' ),
            loadingLine = document.getElementById( 'preload__loading-line' ),
            heroSection;

        // OnEvents
        window.addEventListener( 'load', LoadLine );

        // Functions
        function LoadLine () {

            loadingLine.classList.add( 'load' );

            ShowSite();

        }
        function ShowSite () {

            preloader.classList.add( 'preload_loaded' );

            preloader.addEventListener( 'transitionend', function ( e ) {
                ( e.propertyName === 'opacity' ) && preloader.remove();

                if ( document.querySelectorAll( '.is-loading' ).length > 0 ) {
                    $( '.is-loading' ).removeClass( 'is-loading' );
                }

            } );

        }

    }

} )();