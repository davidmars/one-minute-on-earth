var EmbedPlayer={
    load:function(videoId){
        
        //alert(videoId);
        player.loadVideoById(videoId);
        /*
        var embed="<iframe id='mainPlayer' src='http://www.youtube.com/embed/dP15zlyra3c?enablejsapi=1&html5=1&autoplay=1&controls=0'></iframe>";
        $("#player").html(embed);
        */ 
        /*
        player = new YT.Player('mainPlayer', {
            events: {
                onReady: function(){
                    alert("ready")
                },
                onStateChange: function(){
                    alert("state changer")
                }
            }
        });
        */
    }
}