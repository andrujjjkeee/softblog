( function(){

    "use strict";

    $( function () {

        new Preload();

        new TrueUser();

        new Hero (  $( '#hero' ) );

        new Toggle( $( '#toggle' ) );

        new HowItWorks( $( '#how-it-works__slider' ) );

        $.each( $( '.is-hide' ), function() {
            new ShowHiddenObjects( $( this ) );
        } );

        $.each( $( '.is-animate' ), function() {
            new Animate( $( this ) );
        } );

        $.each( $( '.tabs' ), function() {
            new Tabs( $( this ) );
        } );

        $.each( $( '.anchor' ), function() {
            new Anchor ( $( this ) );
        } );

        $.each( $('.wpcf7'), function () {
            new ContactForm7Checker( $(this) );
        } );

    } );

    var Anchor = function ( obj ) {

        var _obj = obj,
            _body = $( 'html, body' );

        var _onEvents = function() {

                _obj.on( {
                    click: function() {

                        var curBtn = $( this ),
                            curMargin = curBtn.data( 'margin' ) || 20;

                        _body.animate( {
                            scrollTop: $( curBtn.attr( 'href' ) ).offset().top - curMargin
                        }, 600);

                        return false;
                    }
                } );

            },
            _construct = function() {
                _onEvents();
            };

        _construct()
    };

    var Animate = function( obj ) {

        //private properties
        var _obj = obj,
            _objWrap = _obj.find( '#'+ _obj.attr( 'id' ) +'-wrap' ),
            _image = _objWrap.find( 'img' ),
            _objHeight = _obj.outerHeight(),
            _screenBefore = $( window ).outerHeight() * _obj.data( 'screen' ),
            _objSpaceBefore = _obj.data( 'hide' ),
            _percentage = _objSpaceBefore * 100/ _objHeight,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( {
                    'scroll': function () {
                        _animate();
                    },
                    'resize': function () {
                        _objSpaceBefore = _obj.data( 'hide' );

                        _objHeight = _obj.outerHeight();
                        _objSpaceBefore = _obj.data( 'hide' );
                        _percentage = _objSpaceBefore * 100/ _objHeight;

                        _setIndentation();

                    }
                } );

                _image.on( 'load', function () {

                    _objHeight = _obj.outerHeight();
                    _objSpaceBefore = _obj.data( 'hide' );
                    _percentage = _objSpaceBefore * 100/ _objHeight;

                    _setIndentation();

                } );

            },
            _animate = function () {

                var topBorder = _window.scrollTop() + _window.outerHeight() - _screenBefore;

                if ( topBorder >= _obj.offset().top && topBorder <= _obj.offset().top + _objHeight  ){

                    _objWrap.css( 'transform', 'translateY('+ ( 100 - ( ( topBorder - _obj.offset().top ) * 100 / _objHeight ) ) * _percentage / 100 +'%)' )

                } else if ( topBorder >= _obj.offset().top + _objHeight ){

                    _objWrap.css( 'transform', 'translateY(0)' )

                }

            },
            _setIndentation = function() {

                _objWrap.css( 'transform', 'translateY('+ _percentage +'%)' );

                _animate();

            },
            _construct = function() {
                _onEvent();
            };

        //public properties

        //public methods

        _construct();
    };

    var ContactForm7Checker = function( obj ) {

        //private properties
        var _obj = obj,
            _form = _obj.find( 'form' ),
            _preload = _obj.next( '.loader' ),
            _popup = $( '#popup' ),
            _subscribeSection = _popup.find( '.popup__content-subscribe' ),
            _thanksSection = _popup.find( '.popup__content-thanks' ),
            _timer;

        //private methods
        var _onEvent = function() {

                _form.on( 'submit', function () {
                    _showPreload();
                } );

                _obj.on( {
                    'wpcf7:invalid': function(){
                        _obj.find( ' .wpcf7-not-valid' ).first().focus();
                        _hidePreload();
                    },
                    'wpcf7:spam': function(){
                        _hidePreload();
                    },
                    'wpcf7:mailsent': function(){
                        _showSuccessMessage();
                    },
                    'wpcf7:mailfailed': function(){
                        _hidePreload();
                    }
                } );

            },
            _showPreload = function () {

                _preload.addClass( 'is-loading' );

            },
            _hidePreload = function () {

                _preload.removeClass( 'is-loading' );

            },
            _showSuccessMessage = function () {

                _hidePreload();
                _form[0].reset();

                _subscribeSection.addClass( 'is-hide' );
                _thanksSection.addClass( 'is-show' );

                _timer = setTimeout( function () {
                    _subscribeSection.removeClass( 'is-hide' );
                    _thanksSection.removeClass( 'is-show' );
                    _popup[0].obj.closePopup();
                },5000 );

            },
            _construct = function() {
                _onEvent();
            };

        //public properties

        //public methods

        _construct();
    };

    var Hero = function(obj) {

        //private properties
        var _obj = obj,
            _window = $( window ),
            _windowWidth;

        //private methods
        var _setHeroHeight = function () {

                _obj.css( 'height', _window.outerHeight() );

            },
            _onEvent = function () {

                _windowWidth = _window.outerWidth();

                _window.on( {
                    'resize': function () {
                        if ( _windowWidth !== _window.outerWidth() && _window.outerWidth() <1200 ) {
                            _setHeroHeight();
                            _windowWidth = _window.outerWidth();
                        } else if ( _window.outerWidth() >= 1200 ) {
                            _obj.removeAttr( 'style' );
                        }
                    },
                    'scroll': function () {

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

    var Preload = function () {

        //private properties
        var _header = $( '#site-header' ),
            _hero = $( '#hero' );

        //private methods
        function _showSite() {

            _hero.removeClass( 'is-loading' );
            _header.removeClass( 'is-loading' );

        };

        //public properties

        //public methods

        document.addEventListener( 'DOMContentLoaded', _showSite() );

    };

    var ShowHiddenObjects = function( obj ) {

        //private properties
        var _obj = obj,
            _objSpaceBefore = _obj.data( 'space' ),
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _window.on( 'scroll', function () {

                    var topBorder = _window.scrollTop() + _window.outerHeight() * _objSpaceBefore,
                        objTop = _obj.offset().top + _obj.outerHeight();

                    if ( topBorder >= objTop ){
                        _obj.removeClass( 'is-hide' );
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
    
    var Tabs = function( obj ) {

        //private properties
        var _obj = obj,
            _tabBtnWrap = _obj.find( '.tabs__item-wrap' ),
            _tabBtn = _tabBtnWrap.find( '.tabs__item' ),
            _swiperSlider = _tabBtnWrap.find( '.swiper-container' ),
            _tabWrap = _obj.find( '.tabs__wrap' ),
            _tabContent = _tabWrap.find( '.tabs__content' ),
            _swiper = null,
            _window = $( window );

        //private methods
        var _onEvent = function() {

                _tabBtn.on( 'click', function () {
                    var curBtn = $( this ),
                        curBtnIndex = curBtn.index();

                    _showTabWrap( curBtnIndex );

                    return false;
                } );

                _window.on( 'resize', function () {
                    _initScroll();
                    _setContentHeight();
                } );

                window.addEventListener( 'load', _initScroll );

            },
            _showTabWrap = function ( num ) {

                var curTabIndex = num,
                    curTabBtn = _tabBtn.eq( curTabIndex ),
                    activeContent = _tabContent.eq( curTabIndex );

                _tabBtn.removeClass( 'is-active' );
                curTabBtn.addClass( 'is-active' );

                _tabContent.removeClass( 'is-show' );
                activeContent.addClass( 'is-show' );

                _scrollToActive();
                _setContentHeight();

            },
            _setContentHeight = function () {

                var activeContent = _tabContent.filter( '.is-show' );

                _tabWrap.css( 'height', activeContent.outerHeight() );

            },
            _initScroll = function () {

                var tabBtnWidth = 0;

                _tabBtn.each( function () {
                    tabBtnWidth = $( this ).outerWidth() + tabBtnWidth + 50;
                } );

                if ( _swiper === null && tabBtnWidth > _window.outerWidth() ) {

                    _swiper = new Swiper( _swiperSlider, {
                        slidesPerView: 'auto',
                        speed: 500,
                        threshold: 10,
                        centeredSlides: true,
                    } );

                    _scrollToActive();

                } else if ( _swiper !== null && tabBtnWidth <= _window.outerWidth() ) {

                    _swiper.destroy();
                    _swiper = null;


                } else if ( _swiper !== null ){

                    _swiper.update();
                    _scrollToActive();

                }

            },
            _scrollToActive = function () {

                var activeItem = _tabBtnWrap.find( '.is-active' );

                if ( _swiper !== null ){

                    _swiper.slideTo( activeItem.index() );

                }

            },
            _checkActive = function () {

                var activeTabBtn = _tabBtn.filter( '.is-active' );

                if ( activeTabBtn.length > 0 ) {
                    activeTabBtn.trigger( 'click' )
                } else {
                    _tabBtn.eq( 0 ).trigger( 'click' );
                }

            },
            _construct = function() {
                _onEvent();
                _checkActive();
            };

        //public properties

        //public methods

        _construct();
    };

    var Toggle = function( obj ) {

        //private properties
        var _obj = obj,
            _activeState = _obj.find( '#toggle__active' );

        //private methods
        var _onEvent = function() {

                _obj.on( 'click', function () {
                    _switchButton();
                    $( '#how-it-works__slider' )[0].obj.changeSlider();
                } )

            },
            _switchButton = function(){

                _activeState.hasClass( 'is-on-left' ) ?
                    _activeState.removeClass( 'is-on-left' ).addClass( 'is-on-right' ):
                    _activeState.removeClass( 'is-on-right' ).addClass( 'is-on-left' );

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

                var trueUser = localStorage.getItem( 'trueUserSoftSpot' );

                if ( !trueUser ) {
                    $( '#popup' )[0].obj.openPopup( 'subscribe' );
                    localStorage.setItem( 'trueUserSoftSpot', true )
                }

        },
        _construct = function(){
            _checkUser();
        };

        //public properties

        //public methods

        _construct();

    };

    var HowItWorks = function( obj ) {

        //private properties
        var _obj = obj,
            _self = this,
            _data = _obj.data( 'toggle' ),
            _curSlider = 0,
            _curData = [],
            _slidesTotal = 0,
            _swiperSlider = _obj.find( '#how-it-works__slider-content' ),
            _swiperWrap = _swiperSlider.find( '#how-it-works__swiper' ),
            _nextSlideWrap = _swiperSlider.find( '#how-it-works__next-slide' ),
            _afterNextSlideWrap = _swiperSlider.find( '#how-it-works__after-next-slide' ),
            _btnPrev = _swiperSlider.find( '#how-it-works__prev-btn' ),
            _btnNext = _swiperSlider.find( '#how-it-works__next-btn' ),
            _textFrame = $( '#how-it-works__text-frame' ),
            _text = _textFrame.find( 'div' ),
            _window = $( window ),
            _swiper = null,
            _timer = null,
            _atFirst = true;

        //private methods
        var _setSliderContent = function(){

                _swiperSlider.addClass( 'is-loading' );
                _obj.removeAttr( 'data-toggle' );
                _atFirst = true;

                if ( _swiper !== null ){
                    _swiper.destroy( true, true );
                    _swiper = null;
                }

                _setTextHeight();

                switch (_curSlider) {
                    case 0:
                        _curData = _data[ 'pet-parent' ];
                        _swiperSlider.removeClass( 'is-slide-for-vet' )
                                .addClass( 'is-slide-for-pet-parent' );
                        _curSlider = 1;
                        break;
                    case 1:
                        _curData = _data[ 'vet' ];
                        _swiperSlider.removeClass( 'is-slide-for-pet-parent' )
                                .addClass( 'is-slide-for-vet' );
                        _curSlider = 0;
                        break;
                }
                var swiperWrap = $( '<div class="swiper-wrapper"/>' );

                _slidesTotal = _curData.length;

                $.each( _curData, function( index ) {

                    var blogFrame = _setSlider( this );

                    swiperWrap.append( blogFrame );

                    if ( index === _slidesTotal - 1 ){

                        _swiperWrap.html( swiperWrap );

                        if ( _slidesTotal > 1 ) {
                            _initSlider();
                            _btnNext.removeClass( 'is-hide' );
                            _btnPrev.removeClass( 'is-hide' );
                            _nextSlideWrap.removeClass( 'is-hide' );
                            _afterNextSlideWrap.removeClass( 'is-hide' );
                        } else {
                            _btnNext.addClass( 'is-hide' );
                            _btnPrev.addClass( 'is-hide' );
                            _nextSlideWrap.addClass( 'is-hide' );
                            _afterNextSlideWrap.addClass( 'is-hide' );
                        }

                        _timer = setTimeout( function () {

                            _swiperSlider.removeClass( 'is-loading' );

                            clearTimeout( _timer );
                            _timer = null;
                        }, 300 );

                    }

                } );

            },
            _onEvents = function() {

                _window.on( 'resize', function () {
                    _updateSliderWrap();
                } );

            },
            _updateSliderWrap = function() {

                _atFirst = true;

                if ( _swiper !== null ){
                    _swiper.destroy( true, true );
                    _swiper = null;
                }

                _swiperSlider.css( 'height', _swiperWrap.outerHeight() );

                _initSlider();

            },
            _setSlider = function( data ) {

                var slideData = data,
                    slideTitle = slideData.title,
                    slidePicture = slideData.image,
                    slide;

                slide = $( '<div class="how-it-works__slide swiper-slide">' +
                    '<div class="how-it-works__pic">' +
                    '<img src="'+ slidePicture +'" alt="'+ slideTitle +'"/>' +
                    '</div><p>'+ slideTitle +'</p></div>' );

                return slide;

            },
            _initSlider = function() {

                if ( _window.outerWidth() < 768 ){

                    _swiper = new Swiper( _swiperWrap, {
                        effect: 'fade',
                        slidesPerView: 1,
                        speed: 400,
                        spaceBetween: 30,
                        threshold: 10,
                        loop: true,
                        navigation: {
                            nextEl: _btnNext,
                            prevEl: _btnPrev
                        }
                    } );

                } else {

                    _swiper = new Swiper( _swiperWrap, {
                        effect: 'fade',
                        slidesPerView: 1,
                        speed: 400,
                        spaceBetween: 30,
                        threshold: 10,
                        loop: true,
                        navigation: {
                            nextEl: _btnNext,
                            prevEl: _btnPrev
                        },
                        on: {
                            init: function () {

                                var curSlide = _swiperWrap.find( '.swiper-slide-active' ).data( 'swiper-slide-index' );

                            },
                            slideNextTransitionStart: function () {

                                if ( !_atFirst ){

                                    _swiperSlider.addClass( 'is-next-load' );

                                    _timer = setTimeout( function () {
                                        _swiperSlider.removeClass( 'is-next-load' ).addClass( 'is-next-loaded' );
                                        clearTimeout( _timer );
                                        _timer = null;
                                    }, 200 );

                                } else {
                                    _atFirst = false;
                                }

                            },
                            slideNextTransitionEnd: function () {

                                _swiperSlider.removeClass( 'is-next-loaded' );

                                var curSlide = _swiperSlider.find( '.swiper-slide-active' ).data( 'swiper-slide-index' ),
                                    nextSlide =  curSlide + 1,
                                    afterNextSlide = curSlide + 2;

                                if ( nextSlide == _slidesTotal ){
                                    nextSlide = 0;
                                    afterNextSlide = 1;
                                } else if ( afterNextSlide == _slidesTotal ){
                                    afterNextSlide = 0;
                                }

                                _nextSlideWrap.find( '.how-it-works__slide' ).remove();
                                _nextSlideWrap.append( _setSlider ( _curData[ nextSlide ] ) );

                                _afterNextSlideWrap.find( '.how-it-works__slide' ).remove();
                                _afterNextSlideWrap.append( _setSlider ( _curData[ afterNextSlide ] ) );

                                _swiperSlider.removeClass( 'is-next-loaded' );

                            },
                            slidePrevTransitionStart: function () {

                                _swiperSlider.addClass( 'is-prev-load' );

                                _timer = setTimeout( function () {
                                    _swiperSlider.removeClass( 'is-prev-load' ).addClass( 'is-prev-loaded' );
                                    clearTimeout( _timer );
                                    _timer = null;
                                }, 200 );

                            },
                            slidePrevTransitionEnd: function () {

                                _swiperSlider.removeClass( 'is-prev-loaded' );

                                var curSlide = _swiperSlider.find( '.swiper-slide-active' ).data( 'swiper-slide-index' ),
                                    nextSlide =  curSlide + 1,
                                    afterNextSlide = curSlide + 2;

                                if ( nextSlide == _slidesTotal ){
                                    nextSlide = 0;
                                    afterNextSlide = 1;
                                } else if ( afterNextSlide == _slidesTotal ){
                                    afterNextSlide = 0;
                                }

                                _nextSlideWrap.find( '.how-it-works__slide' ).remove();
                                _nextSlideWrap.append( _setSlider ( _curData[ nextSlide ] ) );

                                _afterNextSlideWrap.find( '.how-it-works__slide' ).remove();
                                _afterNextSlideWrap.append( _setSlider ( _curData[ afterNextSlide ] ) );

                                _swiperSlider.removeClass( 'is-prev-loaded' );

                            }
                        }
                    } );

                }

            },
            _setTextHeight = function() {

                _text.removeClass( 'active' );

                _textFrame.css( 'height', _text.eq( _curSlider ).addClass( 'active' ).outerHeight() )

            },
            _construct = function() {
                _onEvents();
                _setSliderContent();

                _obj[0].obj = _self;

            };

        //public properties

        //public methods
        _self.changeSlider = function () {
            _setSliderContent();
        };

        _construct();
    };

} )();