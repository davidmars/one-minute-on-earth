var FixElement={
    updateAll:function(scrollTop){
      FixElement.scrollTop=scrollTop;
      var els=$("[data-ui-fixed]");
      for(var i =0;i<els.length;i++){
          FixElement.update($(els[i]))
      }
    },
    update:function(jq){
        var minY=Number(jq.attr("data-ui-top"));
        var maxY=Number(jq.attr("data-ui-bottom"));
        jq.css("position","relative");
        jq.css("top","");
        var coords=jq.position();
        var pos=FixElement.scrollTop+minY;
        if(pos>coords.top){
            
            var bottomDif=(pos+Number(jq.height())) - ( $(document).height() - maxY );
            if(bottomDif>0){
               jq.css("position","absolute");
               pos-=bottomDif;
            }else{
               jq.css("position","fixed");
               pos= minY;
            }
            jq.css("top",pos+"px");
        }
    }
}


$(document).on("scroll",function(){
    //document.title=$(window).scrollTop();
    FixElement.updateAll($(window).scrollTop());
})



