if(screen.width < 678){
    jQuery('.mobile_hide').remove();
    console.log("mobile");
}
if((screen.width < 1280) && (screen.width >= 768)){
    jQuery('.tablet_hide').remove();
    console.log("tablet");
}
if(screen.width >= 1281){
     jQuery('.desktop_hide').remove();
     console.log("desktop");
 }
let x = document.getElementsByClassName("fullpagesection");
//console.log(x[0].getAttribute("anchor_id"));
//console.log(x[1].getAttribute("anchor_id"));
//console.log(x.length);
let anchors = [];
for (i = 0; i < x.length; i++) {
    //console.log(x[i].getAttribute("anchor_id"));
    anchors.push(x[i].getAttribute("anchor_id"));
}
//console.log(anchors.toString());
console.log(anchors.toString());

new fullpage('.sfull-section',{
        autoScrolling: true,
        navigation: true,
        anchors: anchors,
        navigationTooltips: anchors
})
    //}