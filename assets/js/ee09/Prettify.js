var Prettify={
    doTheJob:function(jq){
        var jq=$(jq);
        var nodes=jq.find(".prettyprint");
        var node;
        for(var i=0;i<nodes.length;i++){
            node=$(nodes[i]);
            if(!node.attr("data-prettyfied")){
                node.attr("data-prettyfied","true");
                var text=node.text();
                text=vkbeautify.xml(text);
                node.text(text);
                 prettyPrint();
            }
        }       
    }
}
