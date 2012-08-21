var ScrollHandler=function(jq){
    /**
    * not mootools
    */
    var jq=$(jq);
    /**
    * not him
    */
    var me=this;
    /**
    * the sections objects 
    */
    var sections=new Array();

    this.onScroll=function(){
        var scrollTop=jq.scrollTop();
        var theLimit=scrollTop+$(window).height()/2;
        var s;
        var offset;
        for(var i=0;i<sections.length;i++){
            s=sections[i];
            s.button.removeClass("active");
        }
        for(var i=0;i<sections.length;i++){
            s=sections[i];
            offset=s.section.offset();
            offset.bottom=offset.top+s.section.innerHeight();
            if(theLimit>=offset.top && theLimit<=offset.bottom){
                s.button.addClass("active");
            }
        }
    }
    this.getSectionsFromDom=function(){
        var ss=jq.find("["+ScrollHandler.HTML.SECTION+"]");
        var s;
        for(var i=0;i<ss.length;i++){
            s=new PageSection(ss[i]);
            sections.push(s);
            
        }
    }
    var init=function(){

        me.getSectionsFromDom();

        $(document).on('scroll',function(e){
            me.onScroll();
        })
    }
    init();
}

ScrollHandler.HTML={
    SECTION_BUTTON:"data-section-target",
    SECTION:"data-section"
}






var PageSection=function(jq){

    /**
     * section dom object
     */
    this.section=$(jq);
    /**
     * name of the section
     */
    this.name=this.section.attr("data-section");
    /**
     * button(s) related to the section
     */
    this.button=$("body").find("[data-section-target='"+this.name+"']");
    
    
    
}


$("body").on("click","[data-scroll-to-section]",function(){
    var target=$(this).attr("data-scroll-to-section");
    target=$("body").find("[data-section='"+target+"']")[0];
    var pos=$(target).offset().top;
    $("body").scrollTop(pos);
});