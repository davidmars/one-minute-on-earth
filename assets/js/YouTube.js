
var YtPlayer=function(jqContainer,YtId,w,h,disableAutoPlay){
    
    var autoplay=disableAutoPlay?0:1;
    
    
    var me=this;
    
    this.player=null;
    
    this.getPosition=function(){
        return me.player.getCurrentTime();
    }
    this.getDuration=function(){
        return me.player.getDuration();
    }
    this.pause=function(){
        me.player.pauseVideo();
    }
    this.play=function(){
        me.player.playVideo();
    }
    this.loadById=function(id){
        me.player.loadVideoById(id, 0);
    }
    this.seek=function(zeroToOne){
        zeroToOne=Math.min(1, zeroToOne);
        zeroToOne=Math.max(0, zeroToOne);
        var s=Utils.rapport(zeroToOne, 1, me.getDuration(), 0, 0)
        me.player.seekTo(s, true);
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
        console.log('Error: ' + errorCode);
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
        console.log('onPlaybackQualityChange event: ' + 'Playback quality changed to "' + newQuality + '"');
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
        console.log('onPlaybackRateChange event: ' + 'Playback rate changed to "' + newRate + '"');
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
        console.log('onStateChange event: Player state changed to: "' /*+ '" (' + getPlayerState(newState) + ')'*/);
        console.log(newState);
        console.log(me.getPlayerState());
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
            return 'video cued';
        case 3:
            return 'buffering';
        case 2:
            return 'paused';
        case 1:
            return 'playing';
        case 0:
            return 'ended';
        case -1:
            return 'unstarted';
        default:
            return 'Status uncertain';
        }
        
    }
    }


    var updateInfos=function(){
        var infos={
            duration:me.getDuration(),
            position:me.getPosition(),
            state:me.getPlayerState()
        }
        console.log(me.getPlayerState());
        dispatchEvent("onChange",infos);
        
        if(infos.state=="ended"){
            dispatchEvent("onVideoEnd",infos);
        }
    }
    
    
 

    var build=function(){
        console.log("build player in"); 
        console.log(jqContainer);
        me.player=new YT.Player(jqContainer[0], {
            height: h,
            width: w,
            videoId: YtId,
            
            playerVars: {
              autoplay:autoplay  
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
    
    var listeners=[];
    this.addEventListener=function(evt,fn){
        listeners.push({
            evt:evt,
            fn:fn
        })
    }
    var dispatchEvent=function(evt,param){
        for(var i=0;i<listeners.length;i++){
            if(listeners[i].evt==evt){
                listeners[i].fn(param);
            }
        }
    }
    

    
    build();
}



