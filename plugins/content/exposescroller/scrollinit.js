function zxcWWHS(){
 var winww,zxcwh,zxcws,zxcwc;
 if (document.all){
  zxcCur='hand';
  zxcwh=document.documentElement.clientHeight;
  zxcww=document.documentElement.clientWidth;
  zxcws=document.documentElement.scrollTop;
  if (zxcwh==0){
   zxcws=document.body.scrollTop;
   zxcwh=document.body.clientHeight;
   zxcww=document.body.clientWidth;
  }
 }
 else if (document.getElementById){
  zxcCur='pointer';
  zxcwh=window.innerHeight-20;
  zxcww=window.innerWidth-20;
  zxcws=window.pageYOffset;
 }
 zxcwc=Math.round(zxcww/2);
 return [zxcww,zxcwh];
}

function ReSize(){
 document.getElementById('fred1').style.width=(zxcWWHS()[0]-20)+'px';
}
function FunctionName(z){
 alert('The parameter '+z+'\nhas been passed to\nfunction name\nFunctName');
}
