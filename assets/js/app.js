$(document).ready(function () {
    console.log('READY TO RUMBLE');

    dragWindows();
    nav();
    
    getTimeAndSetColor();
    newsletter();
    // syncSameVid();

    barba.use(barbaPrefetch);

    barba.init({
        timeout: 10000,
        //debug: true,
        preventRunning: true,
        transitions: [{
          name: 'opacity-transition',
          once(data) {
            // console.log($(data.next.html).find('.slider'));
            slider($(data.next.html).find('.slider'));
            preventSamePageReload();
          },
          leave(data) {
            return gsap.to(data.current.container, {
              autoAlpha: 0,
              duration: .33,
              onStart: function(){
                
              }
            });
          },
          enter(data) {
            return gsap.from(data.next.container, {
              autoAlpha: 0,
              duration: .33,
              onComplete: function(){
                // console.log(data.next.html);

                slider($(data.next.html).find('.slider'));
                $('.window--exhibitions').removeClass('window--is-open');
              }
            });

            preventSamePageReload();

          }
        }]
    });

    function dragWindows() {
        // Draggable.create('.window', {type: 'x,y', edgeResistance: 0.65, bounds: 'body', zIndexBoost: true});
        Draggable.create('.window--info', {
            type: 'x,y', edgeResistance: 0.65, bounds: {
                top: 40,
                left: 40,
                width: window.innerWidth - 80,
                // height: window.innerHeight - 80
                height: window.innerHeight - 80
            }, zIndexBoost: true
        });

        Draggable.create('.window--exhibitions', {
            type: 'x,y', edgeResistance: 0.65, bounds: {
                top: 0,
                left: 50,
                width: window.innerWidth - 40,
                // height: window.innerHeight - 80
                height: window.innerHeight
            }, zIndexBoost: true
        });
    };

    function nav() {

        var $winExhibitions = $('.window--exhibitions');
        var $winInfo = $('.window--info');

        $('.trigger--exhibitions').on('click', function (e) {
            e.preventDefault();

            if ($winExhibitions.hasClass('window--is-open')) {
                $winExhibitions.removeClass('window--is-open');
            } else {
                $winExhibitions.addClass('window--is-open');
            }

        });

        $('.trigger--info').on('click', function (e) {
            e.preventDefault();

            if ($winInfo.hasClass('window--is-open')) {
                $winInfo.removeClass('window--is-open');
            } else {
                $winInfo.addClass('window--is-open');
            }

        });

        $('.close-window').on('click', function () {
            $(this).parent('.window').removeClass('window--is-open');
        });

    };

    function slider(slider) {

        var $sliderIndex = $('.slider__index__current');
        var prevEventUrl = slider.data('previous-event');
        var nextEventUrl = slider.data('next-event');

        console.log('PREV : ' + prevEventUrl);
        console.log('NEXT : ' + nextEventUrl);

        // var $sliderAll = $('.slider__index__all');
        // var itemLength = $('.slide').length;
        var topEventShowAt = $('.top-event').data('show-at');

        //$sliderAll.html(itemLength);

        function getPrev() {
            var currentItem = $('.slider').find('.slide--active'),
                // prevItem = $('.slider').find('.slide--active').prev().length ? $('.slider').find('.slide--active').prev() : $('.slider').find('.slide').last();
                prevItem = currentItem.prev();

            if(prevItem.length){
                currentItem.removeClass('slide--active');
                prevItem.addClass('slide--active');
                $sliderIndex.html(prevItem.index() + 1);
            } else {
                if(nextEventUrl.length){
                    barba.go(nextEventUrl);
                }
            }

            

            

            // prevItem.prev().find('img').each(function () {
            //     var imgSrc = $(this).attr('src');
            //     new Image().src = imgSrc;
            // });

                // console.log(prevItem);
            if (prevItem.index() >= topEventShowAt) {
                $('.top-event').addClass('top-event--visible');
                $('.slider__index').addClass('slider__index--visible');
            } else {
                $('.top-event').removeClass('top-event--visible');
                $('.slider__index').removeClass('slider__index--visible');
            };

            if(currentItem.find('video').length){
                currentItem.find('video')[0].pause();
            }

            if(prevItem.find('video').length){
                prevItem.find('video')[0].play();
            };
        };

        function getNext() {
            var currentItem = $('.slider').find('.slide--active'),
                // nextItem = $('.slider').find('.slide--active').next().length ? $('.slider').find('.slide--active').next() : $('.slider').find('.slide').first(),
                nextItem = currentItem.next();

            if(nextItem.length){
                currentItem.removeClass('slide--active');
                nextItem.addClass('slide--active');
                $sliderIndex.html(nextItem.index() + 1);
            } else {
                // var url = currentItem.data('url')
                // barba.go(url);
                if(prevEventUrl.length){
                    barba.go(prevEventUrl);
                }
            };
            
            
            

            // nextItem.next().find('img').each(function () {
            //         var imgSrc = $(this).attr('src');
            //         new Image().src = imgSrc;
            //     });
            // console.log($('.slider').find('.slide--active').next().lenght);
            // console.log(nextItem.index());
            if (nextItem.index() >= topEventShowAt) {
                $('.top-event').addClass('top-event--visible');
                $('.slider__index').addClass('slider__index--visible');
            } else {
                $('.top-event').removeClass('top-event--visible');
                $('.slider__index').removeClass('slider__index--visible');
            };

            // if(currentItem.find('video').length){
            //     currentItem.find('video')[0].pause();
            //     var thisPosition = currentItem.find('video')[0].currentTime;
            //     var thisId = currentItem.find('video').data('video-id');
            //     var allSameVid = $('[data-video-id="' + thisId + '"]');
            //     allSameVid.each(function(){
            //         $(this)[0].currentTime = thisPosition;
            //         console.log($(this));
            //     })
                
            // }
            if(currentItem.find('video').length){
                currentItem.find('video')[0].pause();
            }

            if(nextItem.find('video').length){
                nextItem.find('video')[0].play();
            };

            // if(currentItem.hasClass('slide--previous-event')){
                
            // };

        };

        $('.prev-next').on('click', function (e) {
            e.preventDefault();
            $(this).hasClass('prev-next--prev') ? getPrev() : getNext();
        });

        document.onkeydown = function (t) {
            switch (t.which) {
                case 37:
                    getPrev();
                    break;
                case 39:
                    getNext();
                    break;
                default:
                    return;
            }
            t.preventDefault();
        };

        
    };


    function getTimeAndSetColor() {
        fetch('http://worldtimeapi.org/api/timezone/Europe/Zurich')
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
        $('.close-newsletter').on('click', function(e){
            $('.newsletter').removeClass('newsletter--is-open');
        });
    };

    function preventSamePageReload() {
        var links = document.querySelectorAll('a[href]');
        var cbk = function (e) {
            if (e.currentTarget.href === window.location.href) {
                e.preventDefault();
                e.stopPropagation();

                // if (!navIsClosed) {
                //     closeNavTl.play();
                // }
            }
        };

        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', cbk);
        }
    };

    // function syncSameVid(){

    //     // var currentVideoPlayingId;
    //     // var currentVideoPlayingIndex;
    //     var videos = $('video');

    

    //     // videos.on('play', function(e){
    //     //     console.log($(this).data('video-id'));
    //     //     currentVideoPlayingId = $(this).data('video-id');
    //     //     currentVideoPlayingIndex = e.target;
    //     //     // console.log(e.target);
    //     // });
    //     // var currentVideoPlayingId = videos

    //     videos.on('timeupdate', function(e){
    //         // console.log(videos[0].currentTime);
    //         $(this).data('video-id');
    //         var currentTimeNow = videos[0].currentTime;
    //         // console.log($('[data-video-id="'+ currentVideoPlayingId +'"]').length);
    //         // $('[data-video-id="'+ currentVideoPlayingId +'"]')[0]
    //         $('[data-video-id="'+ currentVideoPlayingId +'"]').not(currentVideoPlayingIndex).each(function(e){
    //             $(this)[0].currentTime = currentTimeNow;
    //         });
            
    //     });

    // };

});