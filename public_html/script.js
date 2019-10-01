window.user_allowed = false;
window.iur = "test";
window.aur = "test";
window.check_att = false;
$(document).ready(function () {
    function updateBG() {
        if (!navigator.onLine) {
            setTimeout(function() {
                updateBG();
            }, 10000);
            return;
        }
        $.ajax({
            type: "get",
            url: "/s/i",
            dataType: "json",
            success: function (r) {
                if (r.url !== undefined && r.url != window.iur) {
                    window.iur = r.url;
                    $('.container').attr('style', 'background-image:linear-gradient(rgba(21, 9, 77, 0.68), rgba(21, 9, 77, 0.68)), url("'+r.url+'")');
                    $('.img-title').text(r.title);
                    $('.img-desc').text(r.desc);
                    setTimeout(function() {
                        updateBG();
                    }, 90000);
                } else {
                    setTimeout(function() {
                        updateBG();
                    }, 500);
                }
                
            }
        });
    }
    updateBG();

    function updateAudio() {
        $('.pp').removeClass('fa-pause').addClass('fa-play');
        $('.np').html('<div class="iloader"></div><span class="status">Loading</span>');
        $('.audio-info, .control').css('opacity', '0.4');
        $.ajax({
            type: "get",
            url: "/s/a",
            dataType: "json",
            success: function (r) {
                if (r.url === undefined || r.url == window.aurl) 
                {
                    setTimeout(() => {
                        updateAudio();
                    }, 500);
                    return;
                }
                window.aur = r.url;
                $('.np').html('<div class="iloader"></div><span class="status">Buffering</span>');
                $('.a-title').text(r.title);
                $('.a-artist').text(r.artist);
                $('.a-desc').text(r.desc);
                $('.audio-info, .control').css('opacity', '1').show();

                howlAudio = new Audio(r.url)
                howlAudio.preload = "auto";
                howlAudio.addEventListener('play', function(){
                    $('.allowd').fadeOut();
                    $('.pp').addClass('fa-pause').removeClass('fa-play');
                    $('.np').html('<span class="status">Now Playing</span>');
                });
                howlAudio.addEventListener('pause', function(){
                    $('.np').html('<span class="status">Paused</span>');
                    $('.pp').removeClass('fa-pause').addClass('fa-play');
                });
                howlAudio.addEventListener('stop', function(){
                    $('.pp').removeClass('fa-pause').addClass('fa-play');
                });
                howlAudio.addEventListener('error', function(e){
                    switch (e.target.error.code) {
                        case e.target.error.MEDIA_ERR_ABORTED:
                            if (!window.user_allowed) $('.allowd').fadeIn();
                            if (navigator.onLine) nextTrack(); else checkTheInternet();
                          break;
                        case e.target.error.MEDIA_ERR_NETWORK:
                            if (navigator.onLine) nextTrack(); else checkTheInternet();
                          break;
                        case e.target.error.MEDIA_ERR_DECODE:
                            if (navigator.onLine) nextTrack(); else checkTheInternet();
                          break;
                        case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
                            if (!window.user_allowed) $('.allowd').fadeIn();
                            if (navigator.onLine) nextTrack(); else checkTheInternet();
                          break;
                        default:
                          break;
                      }
                    
                });
                howlAudio.addEventListener('ended', function(){
                    if (navigator.onLine) nextTrack(); else checkTheInternet();
                });
                howlAudio.addEventListener('waiting', function(){
                    $('.np').html('<div class="iloader"></div><span class="status">Buffering</span>');
                });
                howlAudio.addEventListener('playing', function(){
                    $('.np').html('<span class="status">Now Playing</span>');
                });

                window.rr = r;
                playAudio(r);

            }
        });
    }

    function nextTrack() {
        try {
            howlAudio.pause();
            updateAudio();
        } catch (error) {
            if (!window.user_allowed) $('.allowd').fadeIn();
        }
    }

    function updateMediaSession(r) {
        if ('mediaSession' in navigator) {

            navigator.mediaSession.metadata = new MediaMetadata({
                title: r.title,
                artist: r.artist,
                artwork: [
                { src: 'https://justlisten.ir/logos/96.png',   sizes: '96x96',   type: 'image/png' },
                { src: 'https://justlisten.ir/logos/128.png', sizes: '128x128', type: 'image/png' },
                { src: 'https://justlisten.ir/logos/192.png', sizes: '192x192', type: 'image/png' },
                { src: 'https://justlisten.ir/logos/256.png', sizes: '256x256', type: 'image/png' },
                { src: 'https://justlisten.ir/logos/384.png', sizes: '384x384', type: 'image/png' },
                { src: 'https://justlisten.ir/logos/512.png', sizes: '512x512', type: 'image/png' },
                ]
            });
            
            navigator.mediaSession.setActionHandler('play', function(){
                if (howlAudio.paused) {
                    howlAudio.play();
                    navigator.mediaSession.playbackState = "playing";
                }
            });
            navigator.mediaSession.setActionHandler('pause', function (){
                if (!howlAudio.paused) {
                    howlAudio.pause();
                    navigator.mediaSession.playbackState = "paused";
                }
            });
            navigator.mediaSession.setActionHandler('nexttrack', nextTrack);
        }
    }

    function playAudio(r){
        try {
            var prom = howlAudio.play();

            if (prom !== undefined) {
                prom.then(function(tsetsdf) {
                    updateMediaSession(r);
                }).catch(function(fdgnjkshdf) {
                    if (!window.user_allowed) $('.allowd').fadeIn();
                });
            }
        } catch (erasdasdror) {
            if (!window.user_allowed) $('.allowd').fadeIn();
        }

    }

    updateAudio();

    $('.pp').click(function (e) { 
        e.preventDefault();
        try {
            if (!howlAudio.paused) {
                howlAudio.pause();
            } else {
                playAudio(rr);
            }
        } catch (errr) {
            if (!window.user_allowed) $('.allowd').fadeIn();
        }
    });

    $('.fa-step-forward').click(function (e) { 
        e.preventDefault();
        if (navigator.onLine) nextTrack(); else checkTheInternet();
    });

    $('.allowbtn').click(function (e) { 
        e.preventDefault();
        window.user_allowed = true;
        playAudio(rr);
        $(this).parent().fadeOut();
    });

    function checkTheInternet(itsme = false) {
        if (itsme) {
            if (!navigator.onLine) {
                window.check_att = true;
                $('.np').html('<i class="fa fa-plug" style="display:inline-block;vertical-align:midlle;width:15px;"></i><span class="status">No Internet</span>');
                setTimeout(() => {
                    checkTheInternet(true);
                }, 2000);
            } else {
                window.check_att = false;
                nextTrack();
            }
        } else {
            if (window.check_att) return;
            if (!navigator.onLine) {
                window.check_att = true;
                $('.np').html('<i class="fa fa-plug" style="display:inline-block;vertical-align:midlle;width:15px;"></i><span class="status">No Internet</span>');
                setTimeout(() => {
                    checkTheInternet(true);
                }, 2000);
            } else {
                window.check_att = false;
                nextTrack();
            }
        }
        
        
    }

    function slowChecker() {
        if (!navigator.onLine) checkTheInternet();
        setTimeout(() => {
            slowChecker();
        }, 60000);
    }
    setTimeout(() => {
        slowChecker();
    }, 10000);
});