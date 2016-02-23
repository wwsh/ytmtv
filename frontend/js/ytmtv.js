/*
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 */

var ytMtvPlayer; // global
var $ = jQuery.noConflict();

/**
 * Inits the recommended standard IFRAME version of the YouTube player.
 * @see google.com documentation for this.
 */
function initYtPlayer() {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

/**
 * This function creates an <iframe> (and YouTube player)
 * after the API code downloads. Invoked by the API.
 */
function onYouTubeIframeAPIReady() {
    ytMtvPlayer = new YT.Player('ytmtvplayer', {
        height: ytMtvOptions.height,
        width: ytMtvOptions.width,
        videoId: ytFirstVideoID,
        playerVars: {'autoplay': 1, 'controls': 0, 'showinfo': 0},
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

/**
 * This method is an event handler as seen above.
 * ENDED means video has ended. Thus, we need to load a new one.
 */
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        // This is where the JS hits our YT service
        $.post(
            ajaxUrl,
            {
                'action': 'get_video',
            },
            function (data) {
                console.log('New video ID: ' + data.videoID);
                ytMtvPlayer.loadVideoById(data.videoID);
            }
        )
    }
}

/**
 * Launch, man!
 */
$(document).ready(function () {
    if (typeof ytMtvOptions == 'undefined') {
        return;
    }

    initYtPlayer();
});
