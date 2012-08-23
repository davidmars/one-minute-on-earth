
var YtPlayer=function(jqContainer,YtId,w,h,disableAutoPlay,showcontrols,showinfo,muted){
    
    var autoplay=disableAutoPlay?0:1;
    var controls=showcontrols?1:0;
    var showinfo =showinfo ?1:0;

    
    
    var me=this;

    /**
     * will dispatch events
     */
    this.eventDispatcher=new EventDispatcher();
    
    /**
     * the youtUbe player object from YT Api
     */
    this.player=null;
    /**
     * sound will be tuned off
     */
    this.mute=function(){
        me.player.mute();
    }
    /**
     * sound will be tuned on
     */
    this.unMute=function(){
        me.player.unMute();
    }
    /**
     * return the current time code in seconds
     */
    this.getPosition=function(){
        return me.player.getCurrentTime();
    }
    /**
     * return the video duration in seconds
     */
    this.getDuration=function(){
        return me.player.getDuration();
    }
    /**
     * pause the video
     */
    this.pause=function(){
        me.player.pauseVideo();
    }
     /**
     * resume the video
     */
    this.play=function(){
        me.player.playVideo();
    }
    /**
     * 
     */
    this.seek=function(zeroToOne){
        zeroToOne=Math.min(1, zeroToOne);
        zeroToOne=Math.max(0, zeroToOne);
        var s=Utils.rapport(zeroToOne, 1, me.getDuration(), 0, 0)
        me.player.seekTo(s, true);
    }
    /**
     * load a video by youtube video id
     * @param id String a youtube video id, something like "4zlWpG4N-Ko"
     */
    this.loadById=function(id){
        me.player.loadVideoById(id, 0);
        me.eventDispatcher.dispatchEvent(YtPlayer.Events.BEFORE_START,me);
    }

    


    /**
    * The 'onPlayerError' function executes when the onError event fires.
    * It captures the error and adds it to an array that is displayed in
    * the "Errors" section of the demo.
    * @param {string} errorCode Mandatory A code that explains the error.
    */

    var onPlayerError=function(errorCode) {
        if (typeof errorCode == 'object' && errorCode['data']) {
            errorCode = errorCode['data'];
        }
        //console.log('Error: ' + errorCode);
    }
    

    /**
    * The 'onytplayerQualityChange' function executes when the
    * onPlaybackQualityChange event fires. It captures the new playback quality
    * and updates the "Quality level" displayed in the "Playback Statistics".
    * @param {string|Object} newQuality Mandatory The new playback quality.
    */

    var onytplayerQualityChange=function(newQuality) {
        if (typeof newQuality == 'object' && newQuality['data']) {
            newQuality = newQuality['data'];
        }
        //console.log('onPlaybackQualityChange event: ' + 'Playback quality changed to "' + newQuality + '"');
    }
    


    /**
    * The 'onytplayerPlaybackRateChange' function executes when the
    * onPlaybackRateChange event fires. It captures the new playback rate
    * and updates the "Plabyack rate" displayed in the "Playback Statistics".
    * @param {string|Object} newRate Mandatory The new playback rate.
    */

    var onytplayerPlaybackRateChange=function(newRate) {
        if (typeof newRate == 'object' && newRate['data']) {
            newRate = newRate['data'];
        }
        //console.log('onPlaybackRateChange event: ' + 'Playback rate changed to "' + newRate + '"');
    }




    /**
    * The 'onYouTubePlayerReady' function executes when the onReady event
    * fires, indicating that the player is loaded, initialized and ready
    * to receive API calls.
    * @param {object} event Mandatory A value that identifies the player.
    */
    var onYouTubeHTML5PlayerReady=function(event) {
        // No need to do any of this stuff if the function was called because
        // the user customized the player parameters for the embedded player.
        if (event) {
            var html5Player = event.target;
            if (html5Player /*&& playerVersion == 'html5'*/) {
                me.player = html5Player;

                // Ensure that a video is cued if using chromeless player.
                //if (vid && playerType == 'chromeless') {
                    //cueVideo(vid, 0);
                //}
                me.onReady();
                setInterval(updateInfos, 600);
                if(muted){
                    me.mute();
                }
                //addInformation();
                //updateytplayerInfo();
            }
        }
    }
    this.onReady=function(){}


    /**
    * The 'onytplayerStateChange' function executes when the onStateChange
    * event fires. It captures the new player state and updates the
    * "Player state" displayed in the "Playback statistics".
    * @param {string|Object} newState Mandatory The new player state.
    */
    var onytplayerStateChange=function(newState) {
        if (typeof newState == 'object' && newState['data']) {
            newState = newState['data'];
        }
        /*console.log('onStateChange event: Player state changed to: ";
        console.log(newState);
        console.log(me.getPlayerState());*/
            //updateHTML('playerstate', newState);
    }
    /**
    * The 'getPlayerState' function returns the status of the player.
    * @return {string} The current player's state -- e.g. 'playing', 'paused', etc.
    */
    this.getPlayerState=function() {
    if (me.player) {
        var playerState = me.player.getPlayerState();
        switch (playerState) {
        case 5:
            return YtPlayer.Status.VIDEO_CUED;
        case 3:
            return YtPlayer.Status.BUFFERING;
        case 2:
            return YtPlayer.Status.PAUSED;
        case 1:
            return YtPlayer.Status.PLAYING;
        case 0:
            return YtPlayer.Status.ENDED;
        case -1:
            return YtPlayer.Status.UNSTARTED;
        default:
            return YtPlayer.Status.STATUS_UNCERTAIN;
        }
        
    }
    }


    var updateInfos=function(){
        var infos={
            duration:me.getDuration(),
            position:me.getPosition(),
            state:me.getPlayerState(),
            muted:me.isMuted=me.player.isMuted()
        }
        //console.log(me.getPlayerState());
        me.eventDispatcher.dispatchEvent(YtPlayer.Events.CHANGE,infos);
        
        if(infos.state=="ended"){
            me.eventDispatcher.dispatchEvent(YtPlayer.Events.VIDEO_END,infos);
        }
    }
    
    
 

    var build=function(){
        me.eventDispatcher.dispatchEvent(YtPlayer.Events.BEFORE_START,me);
        console.log("build YT player in..."); 
        console.log(jqContainer);
        me.player=new YT.Player(jqContainer[0], {
            height: h,
            width: w,
            videoId: YtId,
            
            playerVars: {
              autoplay:autoplay,  
              showinfo:showinfo,  
              controls:controls  
            },
            events: {
                'onError': onPlayerError,
                'onPlaybackQualityChange': onytplayerQualityChange,
                'onPlaybackRateChange': onytplayerPlaybackRateChange,
                'onReady': onYouTubeHTML5PlayerReady,
                'onStateChange': onytplayerStateChange
            }
        });
    }

    build();
}

YtPlayer.Events={
    /**
     * on change something, it will return a YtPlayer infos as parameter
     */
    CHANGE:"onChange",
    /**
     * when a video finish
     */
    VIDEO_END:"onVideoEnd",
    /**
     * tipacally fired before loading a video
     */
    BEFORE_START:"onBeforeStart"
}
YtPlayer.Status={
    VIDEO_CUED:'video-cued',
    BUFFERING:'buffering',
    PAUSED:'paused',
    PLAYING:'playing',
    ENDED:'ended',
    UNSTARTED:'unstarted',
    STATUS_UNCERTAIN:'status-uncertain'
}




