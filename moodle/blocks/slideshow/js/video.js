/* Plugin for Cycle2; Copyright (c) 2012 M. Alsup; v20141007 */
!function(a){"use strict";function b(){try{this.playVideo()}catch(a){}}function c(){try{this.pauseVideo()}catch(a){}}var d='<div class=cycle-youtube><object width="640" height="360"><param name="movie" value="{{url}}"></param><param name="allowFullScreen" value="{{allowFullScreen}}"></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="opaque"></param><embed src="{{url}}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="{{allowFullScreen}}" wmode="opaque"></embed></object></div>';a.extend(a.fn.cycle.defaults,{youtubeAllowFullScreen:!0,youtubeAutostart:!1,youtubeAutostop:!0}),a(document).on("cycle-bootstrap",function(e,f){f.youtube&&(f.hideNonActive=!1,f.container.find(f.slides).each(function(b){if(void 0!==a(this).attr("href")){var c,e=a(this),g=e.attr("href"),h=f.youtubeAllowFullScreen?"true":"false";g+=(/\?/.test(g)?"&":"?")+"enablejsapi=1",f.youtubeAutostart&&f.startingSlide===b&&(g+="&autoplay=1"),c=f.API.tmpl(d,{url:g,allowFullScreen:h}),e.replaceWith(c)}}),f.slides=f.slides.replace(/(\b>?a\b)/,"div.cycle-youtube"),f.youtubeAutostart&&f.container.on("cycle-initialized cycle-after",function(c,d){var e="cycle-initialized"==c.type?d.currSlide:d.nextSlide;a(d.slides[e]).find("object,embed").each(b)}),f.youtubeAutostop&&f.container.on("cycle-before",function(b,d){a(d.slides[d.currSlide]).find("object,embed").each(c)}))})}(jQuery);