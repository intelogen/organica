// Continuous Scroll Banner (31-August-2006)
// by Vic Phillips http://www.vicsjavascripts.org.uk

// To provide a continuous Scroll any number of images or HTML messages in a banner of any length
// For both Vertical or Horizontal Applications.
// With event call functions to Stop or Start the scroll
// and to change the direction between scroll left and right.
// The images or HTML content, and optional links may specified in an array
// or within HTML Coded <DIV>s
// The images or HTML content width and scroll speed are specified in the initialisation call.
// Optionally the Default
// width, height, background color, text color, text align, and font size
// may be assigned for each element in the array.
//
// There may be as many independent application as required on a page

// Application Notes

// **** The HTML Code
//
// The Banner parent is defined in the HTML code
// e.g.
// If the content is defined in an array
// <div id="fred1" style="position:relative;overflow:hidden;width:1200px;height:100px;border:solid black 1px;"
// onmouseover="zxcBannerStop(event);"
// onmouseout="zxcBannerStart(event);"
//  >
// </div>
//
// If the content is defined in within HTML Coded <DIV>s
// <div id="fred4" style="position:absolute;overflow:hidden;left:210px;top:225px;width:90px;height:100px;border:solid black 1px;text-align:center;"
// onmouseover="zxcBannerStop('fred4');"
// onmouseout="zxcBannerStart('fred4');"
// >
//  <div>
//   testing testing0 <br>
//   testing testing1 <br>
//   testing testing2 <br>
//   testing testing3 <br>
//   ........
//  </div>
// </div>
//
// This <DIV> must be assigned a unique ID name
// and must be assigned style attributes of 'position:relative;overflow:hidden;'
//
//


// **** The Content Array
//
// The Content Array defines each element of the banner in a field dimensioned array
// e.g.
// Field 0 defines a common directory path to the images, use '' if not required
// var ContentAry=['http://www.vicsjavascripts.org.uk/StdImages/']
//
// Subsequent fields are arrays defining the content data
//                type, content,               link url, width, height, bgcol,    txtcol,   txtalign, fontsize
//                0     1                      2         3      4       5         6         7         8
// ContentAry[1]=['TXT','Some Text to Display',''       ,''    ,''     ,'#FFCC66','#9966FF','center' ,'13px'];
// ContentAry[2]=['IMG','Zero.gif','',100  ,80   ,];
//
// Fields 0 and 1 are mandatory
// Fields 2 to 8 may be null(omitted if last) or assigned '' to use the defaults.
// Elements with link urls assigned are also assigned with a cursor 'hand' or 'pointer'
// Note:
// see  ****  External Function)


// **** Initialisation
//
// Each Banner must be initialised from a <BODY> or window onload event
// e.g.
// <body onload="zxcCSBanner('fred1',ImgPath,ContentAry,200,50);zxcCSBanner('fred2',ImgPath,ContentAry,200);" >
// where 'zxcCSBanner(' parameters are:
// parameter 0 = the unique ID name of the Banner <DIV>                       (string)
// parameter 1 = the type of banner 'H' = horizontal, 'V' = vertical.         (string, 'H' or 'V')
// parameter 2 = (optional) the default width of each element.                (digits or null)
// parameter 3 = (optional) the scroll speed (1 = fast, 500 = slow).          (digits or null)
// parameter 4 = (optional) the Content Array name.                           (array variable name, or omit)
//
// Optional parameters may be omitted from the right.
//


// **** Start Scroll
//
// The event call to start the scroll is
// from an external call <input type="button" name="" value="Start" onclick="zxcBannerStart('fred1',1);">
// or onmouseout="zxcBannerStart('fred1');"
//
// where
// parameter 0 = the unique ID name of the Banner <DIV> (string)
// parameter 1 = (optional) the scroll direction        (1 = right, -1 = left) (digits, 1 or -1)
//


// **** Stop  Scroll
//
// The event call to stop the scroll is
// <input type="button" name="" value="Stop" onclick="zxcBannerStop('fred1');">
// or  onmouseout="zxcBannerStop('fred1');"
//
// where
// parameter 0 = the unique ID name of the Banner <DIV> (string)
//
// **** Changing Direction
//
// The Scroll Direction may be changed by calling function 'zxcCngDirection('
// e.g.
//  <input type="button" name="" value="Left" onclick="zxcCngDirection('fred1',-1)">
//  <input type="button" name="" value="Toggle" onclick="zxcCngDirection('fred1')">
//  <input type="button" name="" value="Right" onclick="zxcCngDirection('fred1',1)">
// where 'zxcCngDirection(' parameters are:
// parameter 0 = the unique ID name of the Banner <DIV>                           (string)
// parameter 2 = the scroll direction (1 = right, -1 = left, omit or 0 = toggle) (digits, 1, 0, -1 or omit)



// ****  External Function (Array Applications)
//
// The Default action when a link url is clicked is to replace the current window with the specified url.
// The Function 'zxcExternal' is provided for other requirements.
// To access this function the url field must include the character '^|^'
// Clicking the frame will now call function 'zxcExternal' passing the url text to the function.
// This test may now be split using var zxcdata=zxcfun.split('|'); and the split fields used
// to meet the specific requirement


function zxcExternal(zxcfun){
// Example to call a function where the obj.url(field 2 of the array) is 'FunctionName^|^functionparameter'
// function 'FunctionName' will be called passing 'functionparameter' as a parameter
 var zxcdata=zxcfun.split('^|^');
 window[zxcdata[0]](zxcdata[1]);
}


// **** General
//
// All variable, function etc. names are prefixed with 'zxc' to minimise conflicts with other JavaScripts
// These character are easily changed to characters of choice using global find and replace.
//
// The Functional Code(about (4.75K) is best as an External JavaScript
//
// Tested with IE6 and Mozilla FireFox
//


// **** Customising Variables

var zxcBGColor='#FFFFCC';   // The default background color of banner elements (string)
var zxcTxtColor='black';      // The default text color of banner elements (string)
var zxcTxtAlign='center';   // The default text alignment of banner elements (string)
var zxcFontSize='22px';     // The default font size of banner elements (string)



// **** Example Image Path and Content Array

var ImgPath='http://www.vicsjavascripts.org.uk/StdImages/';
var ContentAry=[ImgPath]
ContentAry[1]=['IMG','Zero.gif',''];
ContentAry[2]=['IMG','One.gif','',100  ,80   ,];
//             type, content,               link,   width,  height,  bgcol,    txtcol,   txtalign, fontsize
//             0     1                      2       3       4        5         6         7         8
ContentAry[3]=['TXT','Some Text to Display',''     ,''     ,''     ,'#FFCC66','#9966FF','center'    ,'13px'];
ContentAry[4]=['IMG','Three.gif',''];
ContentAry[5]=['IMG','Four.gif',''];
ContentAry[6]=['IMG','Five.gif',''];
ContentAry[7]=['IMG','Six.gif',''];
ContentAry[8]=['IMG','Seven.gif',''];
ContentAry[9]=['IMG','Eight.gif',''];
ContentAry[10]=['IMG','Nine.gif','',100  ,80   ,];

var ImgPath2='../StdImages/';
var ContentAry2=[ImgPath]
ContentAry2[1]=['TXT','<div style="border:solid red 1px;height:73px;" ><br><span style="font-size:18px;font-weight:bold;" >Views from Egypt</span><br><br>MouseOver & Out to Stop and Start</div>',''     ,'298'     ,''     ,'#FFCC66','#000000','center'    ,'11px'];
ContentAry2[2]=['TXT','<br>The river Nile',''     ,''     ,''     ,'','','center'    ,'13px'];
ContentAry2[3]=['IMG','Egypt1.jpg','FunctionName^|^functionparameter'];
ContentAry2[4]=['TXT',' ',''     ,20     ,''     ,'#FFCC66','','center'    ,'13px'];
ContentAry2[5]=['IMG','Egypt2.jpg','http://www.vicsjavascripts.org.uk/ImageSliceViewer/Slice3/DSCF0087.htm'];
ContentAry2[6]=['TXT','<br>The Entrance<br>to<br>Luxor Temple',''     ,''     ,''     ,'','','center'    ,'13px'];
ContentAry2[7]=['TXT',' ',''     ,20     ,''     ,'#FFCC66','','center'    ,'13px'];
ContentAry2[8]=['IMG','Egypt3.jpg','http://www.vicsjavascripts.org.uk/ImageSliceViewer/Slice4/DSCF0059.htm'];
ContentAry2[9]=['TXT','<br>Massive Pillars<br>at<br>Karnak Temple',''     ,''     ,''     ,'','','center'    ,'13px'];
ContentAry2[10]=['IMG','Egypt4.jpg','http://www.vicsjavascripts.org.uk/ImageSliceViewer/Slice1/DSCF0058.htm'];
ContentAry2[11]=['TXT',' ',''     ,20     ,''     ,'#FFCC66','','center'    ,'13px'];
ContentAry2[12]=['IMG','WinterPalace.jpg','http://www.vicsjavascripts.org.uk/StdImages/WinterPalace.jpg'];
ContentAry2[13]=['TXT','<br>The<br>WinterPalace<br>Luxor',''     ,''     ,''     ,'','','center'    ,'13px'];


// **** Functional Code - NO NEED to Change


function zxcCSBanner(zxcid,zxcvh,zxcw,zxcspd,zxcaary){
 var zxcp=document.getElementById(zxcid);
 var zxcary=[]
 if (zxcaary){
  var zxcpth=zxcaary[0];
  for (var zxc0=1;zxc0<zxcaary.length;zxc0++){ zxcary[zxc0-1]=zxcaary[zxc0];  for (var zxc1=0;zxc1<zxcary[zxc0-1].length;zxc1++){ if (zxcary[zxc0-1][zxc1]==''){ zxcary[zxc0-1][zxc1]=null; } } }
 }
 else {
  var zxceles=zxcp.childNodes;
  for (var zxc0=0;zxc0<zxceles.length;zxc0++){ if (zxceles[zxc0].tagName=='DIV'){ zxcary.push([zxceles[zxc0],zxceles[zxc0].offsetWidth,zxceles[zxc0].offsetHeight]); } }
  for (var zxc1=0;zxc1<zxcary.length;zxc1++){ zxcp.removeChild(zxcary[zxc1][0]); }
 }
 var zxcwh=(zxcvh=='H')?[zxcp.offsetHeight,zxcp.offsetWidth,'left','top','width','height']:[zxcp.offsetWidth,zxcp.offsetHeight,'top','left','height','width'];
 zxcp.set=true;
 var zxcd=zxcStyle('DIV',{position:'absolute',left:'0px',top:'0px',width:zxcwh[0]+'px'});
 zxcp.appendChild(zxcd);
 zxcp.ary=[zxcd,zxcd.cloneNode(true),zxcd.cloneNode(true),zxcd.cloneNode(true)];
 for (var zxc2=1;zxc2<zxcp.ary.length;zxc2++){ zxcp.appendChild(zxcp.ary[zxc2]); }
 var zxcobj;
 for (var zxc3=0;zxc3<zxcp.ary.length;zxc3++){
  var zxccnt=0;
  var zxctp=0;
  for (var zxc4=0;zxc4<Math.max(zxcary.length,Math.ceil(zxcwh[1]/zxcwh[0])+1);zxc4++){
   if (typeof(zxcary[zxccnt][0])=='string'){
    if (zxcary[zxccnt][0].toUpperCase().match('I')){ zxcobj=zxcStyle('IMG'); zxcobj.src=zxcpth+zxcary[zxccnt][1]; }
    if (zxcary[zxccnt][0].toUpperCase().match('T')){ zxcobj=zxcStyle('DIV'); zxcobj.innerHTML=zxcary[zxccnt][1]; }
    if (zxcary[zxccnt][2]){ zxcobj.url=zxcary[zxccnt][2]; zxcStyle(zxcobj,{ cursor:((document.all)?'hand':'pointer')}); zxcobj.onclick=function(){ zxcLink(this); } }
    zxcStyle(zxcobj,{position:'absolute',backgroundColor:(zxcary[zxccnt][5]||zxcBGColor),color:(zxcary[zxccnt][6]||zxcTxtColor),textAlign:(zxcary[zxccnt][7]||zxcTxtAlign),fontSize:(zxcary[zxccnt][8]||zxcFontSize)});
    zxcobj.style[zxcwh[4]]=((zxcary[zxccnt][(zxcvh=='H')?3:4])||zxcw)+'px';
    zxcobj.style[zxcwh[5]]=((zxcary[zxccnt][(zxcvh=='H')?4:3])||zxcwh[0])+'px';
   }
   else {
    zxcobj=zxcary[zxccnt][0].cloneNode(true);
    zxcStyle(zxcobj,{position:'absolute',width:zxcary[zxccnt][1]+'px',height:zxcary[zxccnt][2]+'px'});
   }
   zxcobj.style[zxcwh[2]]=(zxctp)+'px';
   zxcobj.style[zxcwh[3]]='0px';
   zxcp.ary[zxc3].appendChild(zxcobj);
   zxcp.ary[zxc3].style[zxcwh[4]]=(parseInt(zxcobj.style[zxcwh[2]])+parseInt(zxcobj.style[zxcwh[4]]))+'px';
   zxctp+=parseInt(zxcobj.style[zxcwh[4]]);
   zxccnt=++zxccnt%zxcary.length;
  }
 }
 var zxchw=parseInt(zxcp.ary[0].style[zxcwh[4]]);
 for (var zxc4=0;zxc4<zxcp.ary.length;zxc4++){ zxcp.ary[zxc4].style[zxcwh[2]]=(zxchw*zxc4-zxchw)+'px'; }
 if (!zxcp.oopbr){ zxcp.oopbr=new zxcOOPBannerRotate(zxcp,zxcvh,zxcspd,zxchw); }
}

function zxcCngDirection(zxcid,zxcdir){
 var zxcoop=document.getElementById(zxcid).oopbr;
 if (!zxcoop){ return; }
 clearTimeout(zxcoop.to);
 zxcdir=zxcdir||-zxcoop.dir;
 if (zxcdir>0){ zxcoop.dir=1; }
 else { zxcoop.dir=-1; }
 zxcoop.rotate();
}

function zxcBannerStop(zxcid){
 var zxcoop=document.getElementById(zxcid).oopbr;
 if (!zxcoop){ return; }
 clearTimeout(zxcoop.to);
}

function zxcBannerStart(zxcid,zxcdir){
 var zxcoop=document.getElementById(zxcid).oopbr;
 if (!zxcoop){ return; }
 clearTimeout(zxcoop.to);
 zxcoop.dir=zxcdir||zxcoop.dir;
 zxcoop.rotate();
}

function zxcLink(zxcobj){
 if (zxcobj.url.match('^|^')){ zxcExternal(zxcobj.url); return; }
 window.top.location=zxcobj.url;
}

function zxcStyle(zxcele,zxcstyle){
 if (typeof(zxcele)=='string'){ zxcele=document.createElement(zxcele); }
 for (key in zxcstyle){ zxcele.style[key]=zxcstyle[key]; }
 return zxcele;
}


function zxcOOPBannerRotate(zxcp,zxcvh,zxcspd,zxchw){
 this.ref='zxcoobr'+zxcp.id;
 this.wh=(zxcvh=='H')?'left':'top';
 window[this.ref]=this;
 this.ary=zxcp.ary;
 this.spd=zxcspd||100;
 this.to=null;
 this.dir=1;
 this.h=zxchw;
}

zxcOOPBannerRotate.prototype.rotate=function(){
 this.ary[1].style[this.wh]=(parseInt(this.ary[1].style[this.wh])+this.dir)+'px';
 this.ary[0].style[this.wh]=(parseInt(this.ary[1].style[this.wh])-this.h)+'px';
 this.ary[2].style[this.wh]=(parseInt(this.ary[2].style[this.wh])+this.dir)+'px';
 this.ary[3].style[this.wh]=(parseInt(this.ary[2].style[this.wh])+this.h*2)+'px';
 if (this.dir<0&&parseInt(this.ary[1].style[this.wh])+this.h<0){
  this.ary[1].style[this.wh]=(parseInt(this.ary[2].style[this.wh])+this.h)+'px';
  this.ary.reverse();
 }
 if (this.dir>0&&parseInt(this.ary[1].style[this.wh])>this.h){
  this.ary[1].style[this.wh]=(parseInt(this.ary[2].style[this.wh])-this.h)+'px';
  this.ary.reverse();
 }
 this.setTimeOut('rotate();',this.spd);
}

zxcOOPBannerRotate.prototype.setTimeOut=function(zxcf,zxcd){
 this.to=setTimeout('window.'+this.ref+'.'+zxcf,zxcd);
}
