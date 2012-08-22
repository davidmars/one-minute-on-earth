var Main={
    rootUrl:"",
    body:$("body"),
    player:null,
    playerControler:null,
    init:function(){
       new ScrollHandler(Main.body);
       Prettify.doTheJob(Main.body); 
       Main.body.find("[data-ui='next']").on("click",function(){Main.nextRandom();});
    },
    toDoAfterAjax:function(){
        
    },
    nextRandom:function(){
        var vdos=$(Main.CTRL.EMBED_VDO);
        var vdo=vdos[Math.floor((vdos.length*Math.random()))];
        Main.loadVideo($(vdo))
    },
    loadVideo:function(jq){
        
       var videoId=jq.attr("data-vdo-id");
       //load details
       var detailsUrl=Main.rootUrl+"/moment/details/-w-"+videoId;
       console.log("-----------ajax------------"+detailsUrl);
       $.ajax({
           url:detailsUrl,
           success:function(data){
               //put template
              $(Main.CTRL.VIDEO_DETAILS).html(data);
              
              Prettify.doTheJob($(Main.CTRL.VIDEO_DETAILS));
              
           }
       });
       
       //hilite the video
       $(Main.CTRL.EMBED_VDO).removeClass("selected");
       jq.addClass("selected");
       
       
       //play the video
       if(!Main.player){
           Main.player=new YtPlayer($("#player"),videoId,"100%","100%",false,false,false,true);
           new PlayerControler(Main.player,$("#player-controler"));
           Main.player.addEventListener(YtPlayer.Events.VIDEO_END,Main.nextRandom);
       }else{
           Main.player.loadById(videoId);
       }
       
       
       
       //EmbedPlayer.load(videoId);
    }


}
Main.CTRL={
    EMBED_VDO:"[data-embed-vdo='true']",
    VIDEO_DETAILS:"[data-ajax-receiver='moment-details']"

}
$("body").on("click",Main.CTRL.EMBED_VDO,function(e){
    e.preventDefault();
    Main.loadVideo($(this));
})



Main.init();


var PlayerControler=function(player,jq){
    console.log("build player controler");
    
    var me=this;
    var jq=$(jq);
    var progressBar=jq.find("[data-ui='progress']");
    var progressBarContainer=jq.find("[data-ui='progressContainer']");
    
    var play=jq.find("[data-ui='play']");
    var pause=jq.find("[data-ui='pause']");
    var muteBtn=jq.find("[data-ui='mute']");
    var unMuteBtn=jq.find("[data-ui='unMute']");
    
    
    player.onReady=function(){
        console.log("on ready");
        jq.css("display","block");
        muteBtn.on("click",function(e){player.mute();})
        unMuteBtn.on("click",function(e){player.unMute();})
    }
    Main.player.addEventListener(YtPlayer.Events.VIDEO_END,
        function(){
            setPos(0);
        }
    );
    player.addEventListener(YtPlayer.Events.CHANGE,function(infos){
        //console.log(infos);
        //update progress
        if(!mouseIsDown && infos.state!="butffering"){
            var zeroToOne=Utils.rapport(infos.position, infos.duration, 1, 0, 0);
            setPos(zeroToOne);
        }
        //add good css classes
        for(s in YtPlayer.Status){
           jq.removeClass(YtPlayer.Status[s]); 
        }
        jq.addClass(infos.state);
        
        jq.removeClass("muted"); 
        jq.addClass(infos.muted ? "muted":"");
        
    });
    

    
    var mouseIsDown=false;
    var setPos=function(zeroToOne){
        var percent=Math.round(zeroToOne*100);
        progressBar.css("width",percent+"%");
    }
    
    
    play.on("click",function(){
        player.play();
    })
    pause.on("click",function(){
        player.pause();
    })
    
    
    progressBarContainer.on("mousedown",function(e){
        mouseIsDown=true;
        var zeroToOne=Utils.rapport(
            e.offsetX,
            progressBarContainer.width(),
            1,0,0);
        player.seek(zeroToOne);
        setPos(zeroToOne);
    });
    $("body").on("mouseup",function(e){
       mouseIsDown=false; 
    });
    $("body").on("mousemove",function(e){
        if(mouseIsDown){
        var zeroToOne=Utils.rapport(
                e.clientX,
                progressBarContainer.width()+progressBarContainer.offset().left,
                1,
                progressBarContainer.offset().left,
                0);
            player.seek(zeroToOne);
            setPos(zeroToOne);
            }
    });

}



function onYouTubePlayerAPIReady() {
    Main.nextRandom();
}