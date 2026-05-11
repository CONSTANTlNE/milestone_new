(function ($) {
	"use strict";

gsap.registerPlugin(ScrollTrigger, SplitText);
gsap.config({
    nullTargetWarn: false,
    trialWarn: false
});

	/*----  Functions  ----*/

	function getpercentage(x, y, elm) { 
		elm.find('.pbmit-fid-inner').html(y + '/' + x);
		var cal = Math.round((y * 100) / x);
		return cal;
	}

	var pbmit_active_hover = function() {

		var pbmit_var = jQuery('.pbmit-element-static-box-style-1,.pbmit-element-static-box-style-2,.pbmit-element-service-style-3');

		if (!pbmit_var.length) {
			return;
		}

		pbmit_var.each(function() {
			var pbmit_Class = '.pbmit-static-box-style-1,.pbmit-hover-inner li,.pbmit-service-style-3:not(.swiper-slide-duplicate)';
			jQuery(this)
				.find(pbmit_Class).first()
				.addClass('pbmit-active');
			jQuery(this)
				.find(pbmit_Class)
				.on('mouseover', function() {
					jQuery(this).addClass('pbmit-active').siblings().removeClass('pbmit-active');
				});
		});
	}

	ScrollTrigger.matchMedia({
		"(max-width: 1200px)": function() {
			ScrollTrigger.getAll().forEach(t => t.kill());
		}
	});

	/** About strip: vertical parallax on the hero image (desktop only; mobile kills all ST above). */
	ScrollTrigger.matchMedia({
		"(min-width: 1201px)": function () {
			if (typeof gsap === "undefined") {
				return;
			}
			if (
				window.matchMedia &&
				window.matchMedia("(prefers-reduced-motion: reduce)").matches
			) {
				return;
			}
			var wrap = document.querySelector(".mb-hap-visual");
			var img = document.querySelector(".mb-hap-visual-img");
			if (!wrap || !img) {
				return;
			}

			gsap.fromTo(
				img,
				{ yPercent: 18, scale: 1.06 },
				{
					yPercent: -18,
					scale: 1.06,
					ease: "none",
					scrollTrigger: {
						trigger: wrap,
						start: "top bottom",
						end: "bottom top",
						scrub: 0.75,
						invalidateOnRefresh: true,
					},
				}
			);
		},
	});

	/* Static Box Slider */
	var pbmit_staticbox_hover_slide = function() {
		if (typeof Swiper !== 'undefined') {
			var pbmit_hover = new Swiper(".pbmit-static-image", {
				speed: 6000,
				effect: 'fade',
				allowTouchMove: false
			});
			var pbmit_desc = new Swiper(".pbmit-main-static-slider .pbmit-static-desc", {
				speed: 6000,
				effect: 'fade',
				allowTouchMove: false
			});

			jQuery('.pbmit-main-static-slider .swiper-static-slide-nav li').on('mouseover', function(e) {
				e.preventDefault();
				var myindex = jQuery(this).index();
				pbmit_hover.slideTo(myindex, 1000, false);
				pbmit_desc.slideTo(myindex, 1000, false);
			});		
		}
	}

	var pbmit_img_animation = function() {
		const pbmit_img_class = jQuery('.pbmit-animation-style1, .pbmit-animation-style2, .pbmit-animation-style3, .pbmit-animation-style4, .pbmit-animation-style5, .pbmit-animation-style6, .pbmit-animation-style7');
		
		pbmit_img_class.each(function() {
		const each_box = jQuery(this);
		
		new Waypoint({
			element: this, 
			handler: function(direction) {
			if (direction === 'down') {
				each_box.addClass('active');
			}
			},
			offset: '70%',
		});
		});
	}

	var pbmit_thia_sticky = function() {
		if(typeof jQuery.fn.theiaStickySidebar == "function"){
			jQuery('.pbmit-sticky-sidebar').theiaStickySidebar({
				additionalMarginTop: 100
			});
			jQuery('.pbmit-sticky-column').theiaStickySidebar({
				additionalMarginTop: 180
			});
		}
	}

	var pbmit_burger_menu = function() {
		if (jQuery('.header-style-3').length > 0) {

			jQuery('.header-style-3 .pbmit-header-overlay .pbmit-logo-area').clone().appendTo('.pbmit-burger-headerarea');
			jQuery('.header-style-3 .pbmit-header-overlay .pbmit-search-cart-box').clone().appendTo('.pbmit-burger-headerarea');
			
			jQuery('.header-style-3 .pbmit-header-overlay .main-navigation').clone().appendTo( '.pbmit-burger-menu-area-inner' ).insertBefore(".pbmit-burger-content");
			jQuery('.pbmit-burger-menu-area .main-navigation, .pbmit-burger-menu-area .main-navigation ul, .pbmit-burger-menu-area .main-navigation ul li, .pbmit-burger-menu-area .main-navigation ul li a').removeAttr('id');

			jQuery('.pbmit-burger-menu-area .main-navigation').removeClass('pbmit-navbar');
			jQuery('.pbmit-burger-menu-area .sub-menu-toggle').remove();

			jQuery('.pbmit-burger-menu-area ul.menu li:has(ul) > a').after("<span class='sub-menu-toggle'><i class='pbmit-base-icon-down-open-big'></i></span>");

			jQuery('.pbmit-burger-menu-area .sub-menu-toggle').on('click', function() {

				if (jQuery(this).siblings('.sub-menu, .children').css('display') == 'block'){			
					jQuery(this).siblings('.sub-menu, .children').slideUp();
					jQuery('i', jQuery(this)).removeClass('pbmit-base-icon-up-open-big').addClass('pbmit-base-icon-down-open-big');
				} else {
					jQuery(this).siblings('.sub-menu, .children').slideDown();
					jQuery('i', jQuery(this)).removeClass('pbmit-base-icon-down-open-big').addClass('pbmit-base-icon-up-open-big');
				}
				return false;
			});

			jQuery('.pbmit-burger-menu-link').click(function() {
				jQuery('.pbmit-burger-menu-area').addClass('show');
			});
			jQuery('.pbmit-burger-menu-area .pbmit-closepanel').click(function() {
				jQuery('.pbmit-burger-menu-area').removeClass('show');			
			});

		}
	}

	/**
	 * Staggered letter reveal (SplitText + GSAP).
	 * Usage: <h3 class="stagger-letters">Your heading</h3>
	 * Re-runs safely after HTMX swaps via window.initStaggerLetters().
	 */
	var initStaggerLetters = function () {
		if (typeof gsap === 'undefined' || typeof SplitText === 'undefined') {
			return;
		}
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}

		var nodes = document.querySelectorAll('.stagger-letters');
		if (!nodes.length) {
			return;
		}

		var run = function (el) {
			if (el.getAttribute('data-stagger-letters-done') === '1') {
				return;
			}
			el.setAttribute('data-stagger-letters-done', '1');
			var split;
			try {
				split = SplitText.create(el, { type: 'chars' });
			} catch (err) {
				return;
			}
			var chars = split.chars;
			if (!chars || !chars.length) {
				return;
			}
			gsap.from(chars, {
				y: 50,
				opacity: 0,
				stagger: 0.03,
				duration: 0.6,
				ease: 'back.out(1.7)'
			});
		};

		var useIO = typeof IntersectionObserver !== 'undefined';
		Array.prototype.forEach.call(nodes, function (el) {
			if (el.getAttribute('data-stagger-letters-done') === '1') {
				return;
			}
			if (!useIO) {
				run(el);
				return;
			}
			var obs = new IntersectionObserver(function (entries, o) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}
					o.unobserve(entry.target);
					run(entry.target);
				});
			}, { rootMargin: '0px 0px -8% 0px', threshold: 0.1 });
			obs.observe(el);
		});
	};

	window.initStaggerLetters = initStaggerLetters;

	/**
	 * Reveal wipe on headings (clip-path inset).
	 * Usage: <h2 class="mb-reveal-wipe">Title</h2>
	 * Re-runs safely after HTMX swaps via window.initRevealWipe().
	 */
	var initRevealWipe = function () {
		if (typeof gsap === 'undefined') {
			return;
		}

		var nodes = document.querySelectorAll('.mb-reveal-wipe');
		if (!nodes.length) {
			return;
		}

		var reduced =
			window.matchMedia &&
			window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		var run = function (el) {
			if (el.getAttribute('data-reveal-wipe-done') === '1') {
				return;
			}
			el.setAttribute('data-reveal-wipe-done', '1');
			if (reduced) {
				el.classList.add('mb-reveal-wipe--done');
				return;
			}
			var clipHidden = { clipPath: 'inset(0 100% 0 0)', webkitClipPath: 'inset(0 100% 0 0)' };
			var clipShown = { clipPath: 'inset(0 0% 0 0)', webkitClipPath: 'inset(0 0% 0 0)' };
			try {
				var tl = gsap.timeline({
					onComplete: function () {
						el.classList.add('mb-reveal-wipe--done');
						if (typeof gsap.set === 'function') {
							gsap.set(el, { clearProps: 'clipPath,webkitClipPath' });
						}
					},
				});
				tl.set(el, clipHidden).to(el, {
					clipPath: clipShown.clipPath,
					webkitClipPath: clipShown.webkitClipPath,
					duration: 1.8,
					ease: 'power3.inOut',
				});
			} catch (e) {
				el.classList.add('mb-reveal-wipe--done');
			}
		};

		var useIO = typeof IntersectionObserver !== 'undefined';
		Array.prototype.forEach.call(nodes, function (el) {
			if (el.getAttribute('data-reveal-wipe-done') === '1') {
				return;
			}
			if (el.getAttribute('data-reveal-wipe-observed') === '1') {
				return;
			}
			if (!useIO) {
				run(el);
				return;
			}
			el.setAttribute('data-reveal-wipe-observed', '1');
			var obs = new IntersectionObserver(
				function (entries, o) {
					entries.forEach(function (entry) {
						if (!entry.isIntersecting) {
							return;
						}
						o.unobserve(entry.target);
						run(entry.target);
					});
				},
				{ rootMargin: '0px', threshold: 0 }
			);
			obs.observe(el);
		});
	};

	window.initRevealWipe = initRevealWipe;

	jQuery(document).ready(function () {
		initRevealWipe();
	});

	// on resize
	jQuery(window).on('resize', function() {
		pbmit_img_animation();
	});

	// on load
	jQuery(window).on('load', function(){
		pbmit_img_animation();
		pbmit_active_hover();
		pbmit_staticbox_hover_slide();
		pbmit_thia_sticky();
		pbmit_burger_menu();
		initStaggerLetters();
		initRevealWipe();
		gsap.delayedCall(1, () =>
			ScrollTrigger.getAll().forEach((t) => {
				t.refresh();
			})
		);	
	});
})($);