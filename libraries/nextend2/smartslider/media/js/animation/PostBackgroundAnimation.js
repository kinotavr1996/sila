
(function ($, scope, undefined) {
    var SPEED = {
        'default': 5,
        superSlow: 20,
        slow: 10,
        normal: 5,
        fast: 3,
        superFast: 1.5
    };

    function PostBackgroundAnimation(slider, mainAnimation) {
        this.tween = null;
        this.lastTween = null;
        this.mainAnimation = mainAnimation;

        this.parameters = $.extend({
            data: 0,
            speed: 'default',
            slides: []
        }, mainAnimation.slider.parameters.postBackgroundAnimations);
        this.backgroundImages = slider.backgroundImages;

        this.tweens = [];

        var images = this.backgroundImages.getBackgroundImages();
        for (var i = 0; i < images.length; i++) {
            if (images[i]) {
                this.tweens[i] = this.getAnimation(i, images[i], {
                    slideW: 1,
                    slideH: 1
                });
                continue;
            }
            this.tweens[i] = false;
        }

        this.playOnce = mainAnimation.slider.parameters.layerMode.playOnce;

        var currentSlideIndex = mainAnimation.slider.currentSlideIndex;
        if (mainAnimation.slider.parameters.layerMode.playFirstLayer) {
            if (this.tweens[currentSlideIndex]) {
                this.tween = this.tweens[currentSlideIndex];
                slider.visible($.proxy(this.play, this));
            }
        } else {
            if (this.tweens[currentSlideIndex]) {
                this.tween = this.tweens[currentSlideIndex];
                this.tween.progress(1, false);
            }
        }

        slider.sliderElement.on('mainAnimationStart', $.proxy(function () {
            if (mainAnimation.hasBackgroundAnimation()) {
                slider.sliderElement.one('mainAnimationComplete', $.proxy(this.play, this));
            } else {
                this.play();
            }
        }, this));
        slider.sliderElement.on('mainAnimationComplete', $.proxy(this.stop, this));


        slider.sliderElement.on('SliderResize', $.proxy(function (e, ratios) {
            for (var i = 0; i < this.tweens.length; i++) {
                var tween = this.tweens[i];
                if (tween) {
                    if (tween == this.tween) {
                        tween.pause(0);
                        this.tween = this.tweens[i] = this.getAnimation(i, images[i], ratios);
                        slider.visible($.proxy(this.play, this));
                    } else {
                        this.tweens[i] = this.getAnimation(i, images[i], ratios);
                    }
                }
            }
        }, this));
    };

    /**
     *
     * @param i
     * @param {NextendSmartSliderBackgroundImage} backgroundImage
     * @returns {*}
     */
    PostBackgroundAnimation.prototype.getAnimation = function (i, backgroundImage, ratios) {
        var animationData = this.parameters.data,
            speed = this.parameters.speed;
        if (typeof this.parameters.slides[i] != 'undefined' && this.parameters.slides[i]) {
            animationData = this.parameters.slides[i].data;
            speed = this.parameters.slides[i].speed;
        }

        if (!animationData) {
            return false;
        }

        var properties = $.extend(true, {}, animationData.animations[Math.floor(Math.random() * animationData.animations.length)]);


        if (typeof properties.from.transformOrigin == 'undefined') {
            properties.from.transformOrigin = animationData.transformOrigin;
        }
        NextendTween.set(backgroundImage.image, {transformOrigin: properties.from.transformOrigin});

        properties.to.paused = true;
        if (typeof properties.from.x !== 'undefined') {
            properties.from.x *= ratios.slideW;
        }
        if (typeof properties.from.y !== 'undefined') {
            properties.from.y *= ratios.slideH;
        }

        if (typeof properties.to.x !== 'undefined') {
            properties.to.x *= ratios.slideW;
        }
        if (typeof properties.to.y !== 'undefined') {
            properties.to.y *= ratios.slideH;
        }
        return NextendTween.fromTo(backgroundImage.image, SPEED[speed], properties.from, properties.to);
    };

    PostBackgroundAnimation.prototype.start = function (currentSlideIndex, nextSlideIndex) {

        if (this.tweens[currentSlideIndex]) {
            if (this.mainAnimation.hasBackgroundAnimation()) {
                this.tweens[currentSlideIndex].pause();
            }
            this.lastTween = this.tweens[currentSlideIndex];
        } else {
            this.lastTween = false;
        }

        if (this.tweens[nextSlideIndex]) {
            this.tween = this.tweens[nextSlideIndex];
        } else {
            this.tween = false;
        }
    };

    PostBackgroundAnimation.prototype.play = function () {
        if (this.tween && (!this.playOnce || this.tween.progress() == 0)) {
            n2c.log('Post background animation: Play');
            this.tween.play();
        }
    };

    PostBackgroundAnimation.prototype.stop = function () {
        if (!this.playOnce && this.lastTween) {
            this.lastTween.pause(0);
        }
    };

    scope.NextendSmartSliderPostBackgroundAnimation = PostBackgroundAnimation;

})(n2, window);
