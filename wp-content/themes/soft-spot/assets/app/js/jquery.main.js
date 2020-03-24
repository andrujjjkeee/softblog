( function(){

    $( function () {

        "use strict";

        new Menu();

    } );

    var Menu = function( ) {

        //private properties
        var _obj = $( '#site-header__mobile-wrap' ),
            _wrap = _obj.find( '#site-header__mobile-layout' ),
            _mobileBtn = $( '#hamburger' ),
            _html = $( 'html' ),
            _body = $( 'body' ),
            _site = _body.find( '#site' ),
            _siteHeader = _site.find( '#site__header' ),
            _window = $( window ),
            _position = 0;

        //private methods
        var _onEvent = function() {

                _window.on( 'resize', function () {

                    if ( _window.outerWidth() > 992 ){
                        _mobileBtn.removeClass( 'is-active' );
                        _siteHeader.removeClass( 'is-active' );
                    }

                } );

                _site.on( 'click', function ( e ) {
                    if ( $( e.target ).closest( _obj ).length === 0 && $( e.target ).closest( _mobileBtn ).length === 0 && _obj.hasClass( 'is-show' ) ){
                        _hideMenu();
                    }
                } );

                _mobileBtn.on( 'click', function () {

                    if ( $( this ).hasClass( 'is-active' ) ){
                        _hideMenu();
                    } else {
                        _showMenu();
                    }

                } );

            },
            _hideMenu = function () {

                _mobileBtn.removeClass( 'is-active' );
                _siteHeader.removeClass( 'is-active' );

                _obj.removeClass( 'is-show' );
                _obj.removeAttr( 'style' );

                if ( _window.outerWidth() < 992 ){

                    _html.css( 'overflow-y', 'visible' );
                    _body.removeAttr( 'style' );
                    _site.removeAttr( 'style' );

                    _window.scrollTop( _position );

                }

            },
            _showMenu = function () {

                _mobileBtn.addClass( 'is-active' );
                _siteHeader.addClass( 'is-active' );

                _obj.addClass( 'is-show' );
                _obj.css( 'height', _wrap.outerHeight() + 20 );

                if ( _window.outerWidth() < 992 ){

                    _position = _window.scrollTop();

                    _html.css( 'overflow-y', 'hidden' );
                    _body.css( 'overflow-y', 'hidden' );

                    _site.css( {
                        'position': 'relative',
                        'top': _position * -1
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

} )();