/**
 * RokFeature - A header showcase with sliding panels.
 * 
 * @version		1.0
 * 
 * @license		MIT-style license
 * @author		Djamil Legato <djamil@rockettheme.com>
 * @client		RocketTheme, LLC.
 * @copyright	Author
 */

var RokFeature = new Class({
	options: {
		'transition': Fx.Transitions.Quad.easeOut,
		'duration': 600,
		'opacity': 0.9,
		'autoplay': true,
		'delay': 5000
	},
	initialize: function(el, options) {
		this.element = $(el);
		if (!this.element) return;
		
		this.setOptions(options);
		
		this.images = RokFeatureImages;
		this.imagesFx = [];
		this.blocks = this.element.getElements('.rokfeature-option-block');
		this.tabs = this.blocks.getFirst();
		this.panels = this.tabs.getNext();
		this.bgs = this.panels.getElement('div');
		this.titles = this.element.getElements('.rokfeature-title');
		this.readon = this.element.getElements('.rokfeature-readon');
		
		this.current = -1;
		
		var self = this;
		if (this.titles.length) {
			this.titlesFx = [];
			this.titles.each(function(title, i) {
				this.titlesFx.push(new Fx.Style(title, 'opacity', {
					'duration': self.options.duration, 
					'transition': self.options.transition,
					'wait': false
				}).set((!i) ? 1 : 0));
			}, this);
		};
		
		if (this.readon.length) {
			this.readonsFx = [];
			this.readon.each(function(readon, i) {
				this.readonsFx.push(new Fx.Style(readon, 'opacity', {
					'duration': self.options.duration, 
					'transition': self.options.transition,
					'wait': false
				}).set((!i) ? 1 : 0));
			}, this);
		};
		
		var length = this.blocks.length;
		if (this.images.length == length && this.tabs.length == length && 
			this.panels.length == length && this.bgs.length == length) this.initImages().attachEvents();
			
		if (this.options.autoplay) this.next().start();
	},
	
	initImages: function() {
		this.imageContainer = this.element.getElement('.rokfeature-image');
		
		var self = this, div = new Element('div').inject(this.imageContainer, 'next');
		
		this.images.each(function(img, i) {
			self.images[i] = new Asset.image(img, {
				onload: function() {
					this.setStyles({
						'position': 'absolute',
						'top': 0,
						'right': 0,
						'z-index': 1
					}).inject(div);
					
					if (i > 0) this.setStyles({'visibility': 'hidden', 'opacity': 0});
					
					self.imagesFx[i] = new Fx.Style(this, 'opacity', {
						'duration': self.options.duration, 
						'transition': self.options.transition,
						'wait': false
					});
				}
			});
		});
		
		return this;
	},
	
	attachEvents: function() {
		var self = this;
		
		this.imonit = false;
		
		if (this.options.autoplay) {
			this.element.addEvents({
				'mouseenter': function() {
					self.stop();
					self.imonit = true;
				},
				'mouseleave': function() {
					self.next().start();
					self.imonit = false;
				}
			});
		};
		
		this.bgs.setOpacity(this.options.opacity);
		this.blocks.each(function(tab, i) {
			var size = this.panels[i].getSize().size;
			this.panels[i].setStyle('width', size.x);
			if (window.ie) this.panels[i].setStyle('height', size.y);
			
			var slide = new Fx.Slide(this.panels[i], {
				mode: 'horizontal', 
				wait: false,
				transition: this.options.transition,
				duration: this.options.duration
			}).hide();
			tab.addEvents({
				'mouseenter': function() {
					self.current = i;
					slide.slideIn();
					self.backgrounds(i);
					
					self.blocks.each(function(fix, j) {
						if (j != i) fix.fireEvent('collapse');
					});
				},
				'collapse': function() {
					slide.slideOut();
				},
				'mouseleave': function() {
					if (!self.imonit) slide.slideOut();
				}
			});
		}, this);
	},
	
	backgrounds: function(index) {
		this.imagesFx.each(function(fx, i) {
			if (i == index) {
				fx.start(1);
				if (this.titles.length) this.titlesFx[i].start(1);
				if (this.readon.length) this.readonsFx[i].start(1);
			} else {
				fx.start(0);
				if (this.titles.length) this.titlesFx[i].start(0);
				if (this.readon.length) this.readonsFx[i].start(0);
			}
		}, this);
	},
	
	start: function() {
		this.timer = this.next.periodical(this.options.delay, this);
	},
	
	stop: function() {
		$clear(this.timer);
	},
	
	next: function() {
		var prev = this.current;
		var next = (this.current + 1 > this.blocks.length - 1) ? 0 : (this.current + 1);

		if (this.blocks[prev]) this.blocks[prev].fireEvent('mouseleave');
		this.blocks[next].fireEvent('mouseenter');
		
		this.current = next;
		
		return this;
	}
});

RokFeature.implement(new Options, new Events);