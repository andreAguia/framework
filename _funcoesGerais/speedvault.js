/*!
 * Speed Vault Video Gallery
 *
 * @author Hélio Chun - https://www.facebook.com/user128
 * JS code bug fix help by SergioCrisostomo - https://github.com/SergioCrisostomo
 * @version 1.1.0 - Square Base
 * @description Lazy load video gallery for Youtube, Vimeo and DailyMotion videos
 *
 * Inspired by a Stack Overflow question
 */

$(document).ready(function() {
	var $svThumb = $('.svThumb');
	
    $('#svList').wrapAll('<div id="svBox"></div>');
	$('#svBox').prepend('<div class="svPlayer"><div class="infoBox"><div class="nowPlaying"></div></div></div>');
	
	$svThumb.wrapInner('<div class="sv-text"></div>');
	$svThumb.prepend('<span class="sv-overlay"></span>');
	
	$(".sv-text").each(function () {
		var $numWords = $(this).text().length;

		if (($numWords >= 35) && ($numWords < 45)) {
			$(this).css("font-size", "15px");
		}
		else if ($numWords >= 46) {
			$(this).css("font-size", "14px");
		}
	});
	
});

$(document).ready(function() {
// Youtube Video
    $('.ytVideo').each(function() {
        var $videoID = $(this).attr('data-videoID'),
        $txt = $(this).text(),
        $ytVideo = $('<div class="meuVideo"> <iframe width="560" height="315" src="https://www.youtube.com/embed/' + $videoID + '?showinfo=1&autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe></div>'),
        $ytThumb = $('<img src="https://img.youtube.com/vi/' + $videoID + '/mqdefault.jpg" data-anchor="svBox"/>');
        
		$(this).prepend($ytThumb);
        $(this).click(function() {
            $('.meuVideo, .nowPlaying').remove();
            $('.svPlayer').prepend($ytVideo).hide().slideDown("fast");
			$('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
        });
    });

// Vimeo Video
    $('.vimeoVideo').each(function() {
        var $videoID = $(this).attr('data-videoID'),
        $txt = $(this).text(),
        $vimeoVideo = $('<div class="meuVideo><iframe src="https://player.vimeo.com/video/' + $videoID + '?title=1&byline=1&portrait=1&badge=1&autoplay=1" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>'),
        $thisElHack = this;
		
        $.getJSON('https://vimeo.com/api/v2/video/' + $videoID + '.json?callback=?', {
            format: "json"
        }, function(data) {
            var $vimeoThumb = data[0].thumbnail_large;
            $($thisElHack).prepend('<img src="' + $vimeoThumb + '" width="268" data-anchor="svBox"/>');
        });

        $(this).click(function() {
            $('.meuVideo, .nowPlaying').remove();
            $('.svPlayer').prepend($vimeoVideo).hide().slideDown("fast");
			$('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
        });
    });

// DailyMotion Video
    $('.dailyMVideo').each(function() {
        var $videoID = $(this).attr('data-videoID'),
        $txt = $(this).text(),
        $dailyMVideo = $('<div class="meuVideo"> <iframe frameborder="0" width="640" height="360" src="//www.dailymotion.com/embed/video/' + $videoID + '?autoplay=1" allowfullscreen></iframe></div>'),
        $thisElHack = this;
		
        $.getJSON('https://api.dailymotion.com/video/' + $videoID + '?fields=id,thumbnail_url', function(data) {
            var $dailyMThumb = data.thumbnail_url;
            $($thisElHack).prepend('<img src="' + $dailyMThumb + '" width="268" data-anchor="svBox"/>');
        });

        $(this).click(function() {
            $('.meuVideo, .nowPlaying').remove();
            $('.svPlayer').prepend($dailyMVideo).hide().slideDown("fast");
			$('.infoBox').prepend('<div class="nowPlaying"><h3 class="svTitle">'+ $txt +'</h3></div>');
			return false;
        });
    });
});

// Scroll to Top on image click
$(document).ready(function(){
    $('.svThumb').click(function() {
		
		var $thumbPath2 = $('.svThumb img').attr("data-anchor"),
		$thumbAnchor2 = $("#" + $thumbPath2),
		$leftAbsolute2 = $(".html,body");
		// fixed bug by swapping .position to .offset
		// added + (-40) pixels from top
		$thumbPosition2 = $thumbAnchor2.offset().top + (-40)
		console.log($thumbPosition2);
		$leftAbsolute2.animate({scrollTop: $thumbPosition2});
		
		$('.closeUiBtn').remove();
		$('#svBox').prepend('<div class="closeUiBtn">&times;</div>');
        return false;
    });
	// Fechar Videos
	$( document ).on( 'click', '.closeUiBtn', function() {
		$('.meuVideo, .nowPlaying, .closeUiBtn').remove();
		return false;
	});
});

$(document).ready(function(){
	function checkWidth() {
		
		var $svBoxParent = $("#svBox").parent().width(),
		$svBox = $("#svBox");
		
		if ($svBoxParent >= 900) {
			$svBox.removeClass();
			$svBox.addClass('mQuery900');
			console.log("900mQuery");
		} else if ($svBoxParent >= 700) {
			$svBox.removeClass();
			$svBox.addClass('mQuery700');
			console.log("700mQuery");
		}  else if ($svBoxParent <= 550) {
			$svBox.removeClass();
			$svBox.addClass('mQuery550');
			console.log("550mQuery");
		}
	}
	// Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);
	//Remove before shipping

});
