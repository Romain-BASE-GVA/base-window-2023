$(document).ready(function () {
    console.log('READY TO RUMBLE');
    var isTransitioning = false,
        newsletterSeen = Cookies.get('newsletter-seen') == 'yes' ? true : false;

    dragWindows();
    nav();
    getTimeAndSetColor();
    newsletter();

    barba.use(barbaPrefetch);

    barba.init({
        timeout: 10000,
        //debug: true,
        preventRunning: true,
        transitions: [{
          name: 'opacity-transition',
          once(data) {
            slider($(data.next.html).find('.slider'), $(data.next.html).find('.top-event').data('show-at'));
            getAndSetCurrent($(data.next.html).find('.slider'));
            preventSamePageReload();
          },
          leave(data) {
            return gsap.to(data.current.container, {
              autoAlpha: 0,
              duration: .33,
              onStart: function(){
                isTransitioning = true;
                getAndSetCurrent($(data.next.html).find('.slider'));
              }
            });
          },
          enter(data) {
            return gsap.from(data.next.container, {
              autoAlpha: 0,
              duration: .33,
              onComplete: function(){
                isTransitioning = false;
                slider($(data.next.html).find('.slider'), $(data.next.html).find('.top-event').data('show-at'));
              }
            });

            preventSamePageReload();

          }
        }]
    });

    function dragWindows() {
        
        var exhibListDrag;
        var infoDrag;

        if(window.innerWidth >= 576){
            exhibListDrag = Draggable.create('.window-exhibitions', {
                type: 'x,y', edgeResistance: 0.65, bounds: document.querySelector('.screen-bounds-exhibitions'), zIndexBoost: true
            });

            infoDrag = Draggable.create('.window-info', {
                type: 'x,y', edgeResistance: 0.65, bounds: document.querySelector('.screen-bounds-infos'), zIndexBoost: true
            });
        };

        $(window).on('resize', function(){
            resetBounds();
        });

        var resetBounds = debounce(function() {

            if(window.innerWidth < 576){
                exhibListDrag[0].kill();
                infoDrag[0].kill();
                gsap.set('.window-exhibitions', {x: 0, y: 0});
                gsap.set('.window-info', {x: 0, y: 0});
            } else {
                exhibListDrag = Draggable.create('.window-exhibitions', {
                    type: 'x,y', edgeResistance: 0.65, bounds: document.querySelector('.screen-bounds-exhibitions'), zIndexBoost: true
                });
                infoDrag = Draggable.create('.window-info', {
                    type: 'x,y', edgeResistance: 0.65, bounds: document.querySelector('.screen-bounds-infos'), zIndexBoost: true
                });
            }

        }, 250);

    };

    function nav() {

        var $winExhibitions = $('.window-exhibitions');
        var $winInfo = $('.window-info');

        $('.trigger--exhibitions').on('click', function (e) {
            e.preventDefault();

            if ($winExhibitions.hasClass('is-open')) {
                $winExhibitions.removeClass('is-open');
            } else {
                $winExhibitions.addClass('is-open');

                if(window.innerWidth < 576 && $winInfo.hasClass('is-open')){
                    $winInfo.removeClass('is-open')
                }

            }

        });

        $('.trigger--info').on('click', function (e) {
            e.preventDefault();

            if ($winInfo.hasClass('is-open')) {
                $winInfo.removeClass('is-open');
            } else {
                $winInfo.addClass('is-open');

                if(window.innerWidth < 576 && $winExhibitions.hasClass('is-open')){
                    $winExhibitions.removeClass('is-open')
                }
            }

        });

        $('.close-window').on('click', function () {
            $(this).parent('.window-exhibitions').removeClass('is-open');
            $(this).parent('.window-info').removeClass('is-open');
        });

    };

    function slider(slider, showAt) {

        var $sliderIndex = $('.slider__index__current'),
            prevEventUrl = slider.data('previous-event'),
            nextEventUrl = slider.data('next-event'),
            topEventShowAt = showAt;
            // $('.top-event').data('show-at')

        function getPrev() {
            var currentItem = $('.slider').find('.slide--active'),
                prevItem = currentItem.prev();

            if(prevItem.length){
                currentItem.removeClass('slide--active');
                prevItem.addClass('slide--active');
                $sliderIndex.html(prevItem.index() + 1);

                if(currentItem.find('video').length){
                    currentItem.find('video')[0].pause();
                }

            } else {
                if(nextEventUrl.length){
                    barba.go(nextEventUrl);
                }
            }

            if (prevItem.index() >= topEventShowAt) {
                $('.top-event').addClass('top-event--visible');
                $('.slider__index').addClass('slider__index--visible');
            } else {
                $('.top-event').removeClass('top-event--visible');
                $('.slider__index').removeClass('slider__index--visible');
            };



            if(prevItem.find('video').length){
                prevItem.find('video')[0].play();
            };
        };

        function getNext() {
            var currentItem = $('.slider').find('.slide--active'),
                nextItem = currentItem.next();

            if(nextItem.length){
                currentItem.removeClass('slide--active');
                nextItem.addClass('slide--active');
                $sliderIndex.html(nextItem.index() + 1);

                if(currentItem.find('video').length){
                    currentItem.find('video')[0].pause();
                }
                
            } else {

                if(prevEventUrl.length){
                    barba.go(prevEventUrl);
                }
            };

            if (nextItem.index() >= topEventShowAt) {
                $('.top-event').addClass('top-event--visible');
                $('.slider__index').addClass('slider__index--visible');
            } else {
                $('.top-event').removeClass('top-event--visible');
                $('.slider__index').removeClass('slider__index--visible');
            };



            if(nextItem.find('video').length){
                nextItem.find('video')[0].play();
            };

        };

        $('.prev-next').on('click', function (e) {
            e.preventDefault();
            if(!isTransitioning){
                $(this).hasClass('prev-next--prev') ? getPrev() : getNext();
            }
        });

        document.onkeydown = function (t) {
            switch (t.which) {
                case 37:
                    if(!isTransitioning){
                        getPrev();
                    }
                    break;
                case 39:
                    if(!isTransitioning){
                        getNext();
                    }
                    break;
                default:
                    return;
            }
            t.preventDefault();
        };

        
    };


    function getTimeAndSetColor() {
        fetch('https://worldtimeapi.org/api/timezone/Europe/Zurich')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                var whatTimeIsItInGeneva = new Date(data.datetime);
                whatTimeIsItInGeneva = whatTimeIsItInGeneva.getHours();
                if (data.day_of_week < 6 && (whatTimeIsItInGeneva > 8 && whatTimeIsItInGeneva < 18)) {
                    console.log('the gallery is OPEN')
                    $('body').addClass('gallery-is-open');
                } else {
                    $('body').addClass('gallery-is-closed');
                }
            });
    };

    function newsletter() {

        if(!newsletterSeen){
            
            setTimeout(function(){
                $('.newsletter').addClass('newsletter--is-open');
            }, 5000);

        }

        $('.close-newsletter').on('click', function(e){
            $('.newsletter').removeClass('newsletter--is-open').css('z-index', '');
            Cookies.set('newsletter-seen', 'yes', { expires: 15 });
        });

        $('.window-info__item--nl').on('click', function(e){
            e.preventDefault();
            var zI = $('.window-info').css('z-index');
            $('.newsletter').addClass('newsletter--is-open').css('z-index', zI+1);
            
        });
    };

    function preventSamePageReload() {
        var links = document.querySelectorAll('a[href]');
        var cbk = function (e) {
            if (e.currentTarget.href === window.location.href) {
                e.preventDefault();
                e.stopPropagation();
            }
        };

        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', cbk);
        }
    };

    function getAndSetCurrent(slider){
        var currentID = slider.attr('id');
        $('.events .event').removeClass('event--current');
        $('[data-id="'+ currentID +'"]').addClass('event--current');
    };

    function debounce(func, wait, immediate) {
        var timeout;
      
        return function executedFunction() {
          var context = this;
          var args = arguments;
              
          var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
          };
      
          var callNow = immediate && !timeout;
          
          clearTimeout(timeout);
      
          timeout = setTimeout(later, wait);
          
          if (callNow) func.apply(context, args);
        };
      };

});