/**
 * Portfolio Theme - Main JavaScript
 *
 * @package Portfolio
 */

( function () {
    'use strict';

    // ==========================================
    // DOM Ready
    // ==========================================
    document.addEventListener( 'DOMContentLoaded', function () {
        initMobileMenu();
        initScrollToTop();
        initPortfolioFilter();
        initSmoothScroll();
    } );

    // ==========================================
    // Mobile Menu Toggle
    // ==========================================
    function initMobileMenu() {
        var toggle = document.querySelector( '.menu-toggle' );
        var nav    = document.getElementById( 'site-navigation' );

        if ( ! toggle || ! nav ) {
            return;
        }

        toggle.addEventListener( 'click', function () {
            var isOpen = nav.classList.contains( 'nav-open' );
            nav.classList.toggle( 'nav-open' );
            toggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
        } );

        // Close menu when clicking outside
        document.addEventListener( 'click', function ( e ) {
            if ( ! nav.contains( e.target ) && ! toggle.contains( e.target ) ) {
                nav.classList.remove( 'nav-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
            }
        } );

        // Close menu on Escape key
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && nav.classList.contains( 'nav-open' ) ) {
                nav.classList.remove( 'nav-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
                toggle.focus();
            }
        } );
    }

    // ==========================================
    // Scroll To Top Button
    // ==========================================
    function initScrollToTop() {
        var btn = document.getElementById( 'scrollToTop' );
        if ( ! btn ) {
            return;
        }

        window.addEventListener( 'scroll', function () {
            if ( window.scrollY > 400 ) {
                btn.classList.add( 'visible' );
            } else {
                btn.classList.remove( 'visible' );
            }
        }, { passive: true } );

        btn.addEventListener( 'click', function () {
            window.scrollTo( { top: 0, behavior: 'smooth' } );
        } );
    }

    // ==========================================
    // Portfolio Filter (front-page isotope-like filter)
    // ==========================================
    function initPortfolioFilter() {
        var filterBtns = document.querySelectorAll( '.portfolio-filter .filter-btn[data-filter]' );
        var cards      = document.querySelectorAll( '#portfolio-grid .portfolio-card' );

        if ( ! filterBtns.length || ! cards.length ) {
            return;
        }

        filterBtns.forEach( function ( btn ) {
            btn.addEventListener( 'click', function () {
                var filter = this.dataset.filter;

                // Update active button
                filterBtns.forEach( function ( b ) {
                    b.classList.remove( 'active' );
                    b.setAttribute( 'aria-pressed', 'false' );
                } );
                this.classList.add( 'active' );
                this.setAttribute( 'aria-pressed', 'true' );

                // Show / hide cards
                cards.forEach( function ( card ) {
                    if ( filter === 'all' ) {
                        showCard( card );
                    } else {
                        var cats = ( card.dataset.category || '' ).split( ' ' );
                        if ( cats.indexOf( filter ) !== -1 ) {
                            showCard( card );
                        } else {
                            hideCard( card );
                        }
                    }
                } );
            } );
        } );
    }

    function showCard( card ) {
        card.style.display = '';
        card.setAttribute( 'aria-hidden', 'false' );
    }

    function hideCard( card ) {
        card.style.display = 'none';
        card.setAttribute( 'aria-hidden', 'true' );
    }

    // ==========================================
    // Smooth Scroll for Anchor Links
    // ==========================================
    function initSmoothScroll() {
        var anchors = document.querySelectorAll( 'a[href^="#"]' );
        anchors.forEach( function ( anchor ) {
            anchor.addEventListener( 'click', function ( e ) {
                var href = this.getAttribute( 'href' );
                if ( href === '#' ) {
                    return;
                }
                var target = document.querySelector( href );
                if ( target ) {
                    e.preventDefault();
                    var headerHeight = document.querySelector( '.site-header' )
                        ? document.querySelector( '.site-header' ).offsetHeight
                        : 0;
                    var targetTop = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
                    window.scrollTo( { top: targetTop, behavior: 'smooth' } );
                }
            } );
        } );
    }

} )();
