/*
 TeeChart(tm) for JavaScript(tm)
 @fileOverview TeeChart for JavaScript(tm)
 v2.4 Feb 2018
 Copyright(c) 2012-2017 by Steema Software SL. All Rights Reserved.
 http://www.steema.com

 Licensed with commercial and non-commercial attributes,
 specifically: http://www.steema.com/licensing/html5

 JavaScript is a trademark of Oracle Corporation.
*/
var Tee=Tee||{};
(function(){Tee.CircularGauge=function(k,f){function D(c,d){c.hover.value!=d&&(c.hover.value=d,c.hover.valid=null!==d,requestAnimFrame(function(){c.chart.draw()}))}Tee.Series.call(this,k,f);this.useAxes=!1;this.min=0;this.max=100;this.value=this.step=0;this.angle=280;this.rotation=0;this.rotateText=!1;this.shape="circle";this.drag={enabled:!0};var h=this.bevel=new Tee.Format(this.chart);h.gradient.visible=!0;h.gradient.colors=["white"];h.shadow.visible=!1;h.visible=!1;h.stroke.fill="";var e=this.center=
new Tee.Format(this.chart);e.stroke.fill="";e.gradient.visible=!0;e.size=10;e.visible=!1;e.shadow.visible=!0;e.gradient.offset={x:2,y:-2};e.location={x:0,y:0};e.top=new Tee.Format(this.chart);e.top.size=40;e.top.visible=!0;e.top.stroke.fill="";e.top.gradient.colors=["silver","white"];e.top.gradient.visible=!0;e.top.gradient.direction="topbottom";var t=this.ticks=new Tee.Format(this.chart);t.length=6;t.stroke.fill="silver";t.visible=!0;t.outside=!0;t.triangle=!1;t.fill="white";var E=this.ticksBack=
new Tee.Format(this.chart);E.stroke.fill="";E.fill="black";E.gradient.visible=!0;E.gradient.colors=["red","yellow","green"];E.gradient.direction="rightleft";E.visible=!1;E.radius=0;var n=this.minor=new Tee.Format(this.chart);n.stroke.fill="silver";n.visible=!0;n.count=4;n.shape="";var F=this.minorBack=new Tee.Format(this.chart);F.stroke.fill="";F.visible=!1;F.fill="white";F.gradient.visible=!1;F.gradient.direction="leftright";F.gradient.colors=["green","yellow","red"];F.radius=0;this.hands=[];this.addHand=
function(){var c=new Tee.Format(this.chart);c.size=6;c.length=60;c.back=20;c.gradient.visible=!0;c.gradient.colors[0]="orange";c.shadow.visible=!0;c.shadow.blur=12;c.shadow.color="black";c.stroke.fill="";c.pointer=!0;c.shape="needle";c.visible=!0;this.hands.push(c);return c};var U=this.hand=this.addHand(),H=this.back=new Tee.Format(this.chart);H.fill="black";H.visible=!0;H.gradient.visible=!0;H.gradient.colors=["rgba(255,126,95,0.8)","rgba(254,180,123,0.8)"];H.stroke.fill="";var G=this.pointer=new Tee.Format(this.chart);
G.size=3;G.fill="black";G.stroke.fill="";G.visible=!1;var u=this.marks;h=u.format;u.location={x:0,y:10};u.visible=!0;h.fill="black";h.font.fill="black";h.gradient.visible=!0;h.gradient.colors=["rgba(255,126,95,0.6)","rgba(254,180,123,0.6)"];h.shadow.visible=!0;h.shadow.blur=8;h.shadow.color="black";var d=this.format;d.visible=!0;d.gradient.visible=!0;d.gradient.colors=["white"];d.shadow.visible=!0;d.font.style="12px Verdana";d.font.fill="black";d.font.visible=!0;d.size=2;d.round={x:6,y:6};d.padding=
.5;this.units=new Tee.Annotation(this.chart);this.units.transparent=!0;this.units.format.font.fill="black";this.units.location={x:0,y:24};this.bounds=this.getRect();this.hover.enabled=!0;var L,I,v=this;this.animate=new Tee.Animation(this.chart,function(c){v.value=L+c*(I-L);v.chart.draw()});this.animate.duration=100;this.animate.onstop=function(){v.value=I;if(v.onchange)v.onchange(v);v.chart.draw()};var M,w,J,R,x,A,B,C,N,O;this.calcBounds=function(){return this.bounds.custom?this.bounds:this.cellRect(this.bounds,
!0)};this.draw=function(){function c(b,c,d,e,p){0<b.radius&&(d=q*b.radius*.01);a.beginPath();a.arc(0,0,c,e,p,!1);a.arc(0,0,d,p,e,!0);b.draw(a,null,-d,-d,2*d,2*d)}function k(a,b,d){if(a.visible&&""!==a.fill)if(a.ranges&&0<a.ranges.length){var e=1.57,p=a.fill,V=a.gradient.visible,h=l.max-l.min,S=A-x;a.gradient.visible=!1;l.inverted&&(e+=S);for(var g=0;g<a.ranges.length;g++){var k=Math.min(l.max,a.ranges[g].value);var f=0===g?k:k-a.ranges[g-1].value+l.min;f=l.inverted?e-S*(f-l.min)/h:e+S*(f-l.min)/h;
a.fill=a.ranges[g].fill;""!==a.fill&&(l.inverted?c(a,b,d,f,e):c(a,b,d,e,f));e=f;if(k>=l.max)break}a.fill=p;a.gradient.visible=V}else c(a,b,d,1.57,1.57+(A-x))}function p(b){if(b.visible)if("circle"==l.shape)b.ellipse(B,C,g,m);else if("segment"==l.shape){a.beginPath();var c=l.units.visible?275:240,d=1.57+.01745*l.rotation+.5*(6.283-.01745*Math.max(c,l.angle)),e=.5*g,p=.5*m;a.arc(B,C,e,d,d+Math.max(.01745*c,h),!1);a.closePath();b.draw(a,null,B-e,C-p,g,m)}else b.rectangle(B-.5*g,C-.5*m,g,m);return b.visible}
function f(a,b,c){return a.enabled&&a.valid?Math.abs(b-a.value)<c?a:null:null}var h=.01745*this.angle,b=this.calcBounds();B=b.x+.5*b.width;C=b.y+.5*b.height;if(this.bounds.custom){var g=b.width;var m=b.height}else m=g=Math.min(b.width,b.height);var l=this,a=l.chart.ctx,q=g;for(x=.01745*l.rotation+.5*(6.283-h);6.283<=x;)x-=6.283;for(A=x+h;6.283<=A;)A-=6.283;this.drawHand=function(b){b.value=this.limitValue(b.value);var c=.01745*this.rotation+.5*(9.4248-h)+h*((this.inverted?this.max-b.value:b.value)-
this.min)/v;N=B+g*e.location.x*.005;O=C+m*e.location.y*.005;a.save();a.translate(N,O);a.rotate(c);c=b.size;var d=q*b.back*.005,p=Math.min(c,6),f=q*b.length*.005;a.beginPath();1<c?(a.moveTo(-d+p,-c),"needle"==b.shape?(a.quadraticCurveTo(-d,-c,-d,-c+p),a.lineTo(-d,c-p),a.quadraticCurveTo(-d,c,-d+p,c),a.lineTo(f,0)):(a.lineTo(-d+p,c),a.lineTo(f,c),a.lineTo(f,-c)),a.closePath()):(a.moveTo(-d,0),a.lineTo(f,0));1<c?b.draw(a,null,-d,-c,d+f,2*c):(b.stroke.prepare(),a.strokeStyle=b.fill,a.stroke());if(this.ondrawHand)this.ondrawHand(this,
b);b.pointer&&G.visible&&G.ellipse(.5*(J+w),0,G.size,G.size);a.restore()};p(d)&&(g*=1-.01*d.size,m*=1-.01*d.size,this.bounds.custom||(q=m=g));p(this.bevel)&&(g*=1-.002*d.size,m*=1-.002*d.size,this.bounds.custom||(q=m=g));p(H);var r=t.outside;b=this.min;var v=this.max-this.min,z=this.step;0===z&&(z=v/20);z=Math.max(.1,z);w=r?.48*q:.41*q;M=w-.01*q*t.length;R=r?.39*q:this.rotateText?.46*q:.48*q;J=r?.45*q:.38*q;d.font.prepare();var D=d.textHeight("Wj");D=Math.max(1,v/z/(q*h/6.283/D)|0);a.fillStyle=d.font.fill;
a.save();var K=B,P=C;l.bounds.custom&&(g>m?P+=.75*m*m/g:K+=.75*g*g/m);a.translate(K,P);a.rotate(x);k(E,M,w);k(F,J,w);K=z*h/v/n.count;P=x;var L=this.rotateText?0:.3*d.textHeight("Wj"),I=0;for(!t.visible&&r&&(R=.9*J);b<=this.max;){t.visible&&(r=f(this.hover,b,.2*z)||t,a.beginPath(),a.moveTo(0,M),t.triangle?(a.lineTo(-3,w),a.lineTo(3,w),a.closePath(),r.draw(a,-3,M,3,w)):(a.lineTo(0,w),r.stroke.prepare(),a.stroke()));if(d.font.visible&&0===I%D&&(360!=this.angle||b+z<=this.max)){r=R-d.textHeight()*d.padding;
a.translate(0,r);var Q=this.rotateText?3.1416:P;a.rotate(-Q);d.font.prepare();a.fillStyle=d.font.fill;var y=l.inverted?this.max-b:b;y=l.ongetText?l.ongetText(y):(y|0)==y?y.toFixed(0):y.toFixed(this.decimals);a.fillText(y,0,L);a.rotate(Q);a.translate(0,-r)}if(n.visible){if(b<this.max)for(r=0;r<n.count;r++)if(a.rotate(K),r<n.count-1){y=z/n.count;Q=b+(r+1)*y;y=f(this.hover,Q,.2*y)||n;if(Q>this.max)break;"ellipse"==n.shape?n.ellipse(0,.5*(J+w),n.size,n.size):(a.beginPath(),a.moveTo(0,J),a.lineTo(0,w),
y.stroke.prepare(),a.stroke())}}else a.rotate(K*n.count);P+=K*n.count;b+=z;I++}a.restore();u.visible&&(u.text=this.value.toFixed(this.decimals),u.resize(),u.position.x=B-.5*u.bounds.width+u.location.x*g*.01,u.position.y=C+u.location.y*m*.01,u.draw());b=this.units;b.visible&&(b.resize(),b.position.x=B-.5*b.bounds.width+b.location.x*g*.01,b.position.y=C+b.location.y*m*.01,b.draw(a));a.save();U.value=this.value;for(b=0;b<this.hands.length;b++)this.hands[b].visible&&this.drawHand(this.hands[b]);a.restore();
e.visible&&(b=q*e.size*.01,e.ellipse(N,O,b,b),e.top.visible&&(b=b*e.top.size*.01,e.top.ellipse(N,O,b,b)))};this.limitValue=function(c){return Math.min(this.max,Math.max(this.min,c))};this.setValue=function(c){c=this.limitValue(c);var d=this.value!=c;if(d)if(this.animate.active&&0<this.animate.duration)L=this.value,I=c,this.animate.animate(this.chart);else if(this.value=c,this.onchange)this.onchange(this);return d};this.onclick=function(){};this.clicked=function(){this.dragging=!1;return-1};this.inValue=
function(c,d){if(!d.contains(c))return!1;var e=c.x-N,f=c.y-O,h=Math.sqrt(e*e+f*f);for(e=Math.atan2(f,e)-.5*Math.PI;0>e;)e+=6.283;if(x>A){f=A;var b=x;var g=e>=b||e<=f}else b=A,f=x,g=e>=f&&e<=b;return g?(e=this.min+(this.max-this.min)*(x>A?e>b?(e-b)/(6.283-b+f):(6.283-b+e)/(6.283-b+f):(e-f)/(b-f)),this.inverted&&(e=this.max-e),c.value=e,c.inTicks=h>=Math.min(M,R)&&h<=w,!0):c.inTicks=!1};this.mousemove=function(c){var d=this.calcBounds();d=this.inValue(c,d);this.dragging||/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&
this.drag.enabled?(d&&this.setValue(c.value)&&this.chart.draw(),this.chart.newCursor="pointer"):c.inTicks&&this.drag.enabled?(D(this,c.value),this.chart.newCursor="pointer"):D(this,null)};var T={x:0,y:0};this.mousedown=function(c){if(this.drag.enabled){var d=this.calcBounds();this.chart.calcMouse(c,T);this.inValue(T,d)?(this.dragging=!0,this.hover.value=null,this.hover.valid=!1,this.setValue(T.value)&&this.chart.draw()):this.dragging=!1;return this.dragging}return!1}};Tee.CircularGauge.prototype=
new Tee.Series;Tee.CircularGauge.prototype.setChart=function(k,f){var D=Tee.Series.prototype.setChart;D(k,f);k.back.setChart(f);k.center.setChart(f);k.center.top.setChart(f);k.ticks.setChart(f);k.ticksBack.setChart(f);k.minor.setChart(f);k.minorBack.setChart(f);k.hand.setChart(f);k.units.setChart(f);k.pointer.setChart(f);k.bevel.setChart(f)}})();