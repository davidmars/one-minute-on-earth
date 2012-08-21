<!--
<iframe id="ytplayer" type="text/html" width="100%" height="100%"
src="http://www.youtube.com/embed/?version=3&wmode=opaque&listType=playlist&list=PL01BCB0E07A3C606D&enablejsapi=1&playerapiid=ytplayer"
frameborder="0" allowfullscreen></iframe>
-->

<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
<div id="player"></div>
<?/*
<script>

// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
    //alert("ok");
    player = new YT.Player('player', {
    height: '100%',
    width: '100%',
    html5:1,
    videoId: '1_Dl-Nj_waY',
    html5:true,
    playerVars: {

    html5:true,
        autoplay:1,
        controls: 0,
        showinfo: 0 ,
        modestbranding: 1,
        wmode: "opaque"
    },
    events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
    }
    });
    player.mute();
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
    player.mute();
    setInterval(Main.updatePosition,10);
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
    done = true;
    }
    if (event.data == YT.PlayerState.ENDED) {
        Main.nextRandom();
    }
}
function stopVideo() {
    //player.stopVideo();
    player.nextVideo();
}
</script>

*/?>