String.prototype.killWhiteSpace = function () {
	return this.replace(/\s/g, '');
};
function activate(menu_a, menu_ul, obj) {
	menu_a.removeClass('active');
	//menu_ul.filter(':visible').slideUp('normal');
	$(obj).addClass('active').next().stop(true, true).slideDown('normal');
	//console.log("clicked1");
}

function deactivate(obj) {
	obj.removeClass('active');
	obj.next().stop(true, true).slideUp('normal');
	//console.log("clicked2");

}
var menu_ul, menu_a;
var page_title, profile_menu, blog_menu, projects_menu, files_menu, top, topAcedemics, topWorkExperience, topPersonalInterests;


$(document).ready(function () {
	var contentWidth = $(document).width() - $("#wrapper").width() - 60;
	$("#content").css("width", contentWidth);
	$(window).resize(function () {
		var contentWidth = $(document).width() - $("#wrapper").width() - 60;
		$("#content").css("width", contentWidth);
	});
	//alert("Welcome to my website. Please note, none of these pages are finished yet. They should be finished sometime this summer");
	console.log($('title').text());
	menu_ul = $('.menu > li > ul'), menu_a = $('.menu > li > a');
	//menu_ul.hide();

	top = $(document).scrollTop();

	page_title = $('title').text();
	profile_menu = $('#profile_menu');
	blog_menu = $('#blog_menu');
	projects_menu = $('#projects_menu');
	files_menu = $('#files_menu');

	if (page_title === "Profile") {
		topAcedemics = $('#acedemics').position().top;
		topWorkExperience = $('#work_experience').position().top;
		topPersonalInterests = $('#personal_interests').position().top;
	}

	if (page_title === profile_menu.text()) {
		activate(menu_a, menu_ul, profile_menu);
	} else if (page_title === blog_menu.text()) {
		activate(menu_a, menu_ul, blog_menu);
	} else if (page_title === projects_menu.text()) {
		activate(menu_a, menu_ul, projects_menu);
	} else if (page_title === files_menu.text()) {
		activate(menu_a, menu_ul, files_menu);
	} else {
		console.log("Page title not recognized");
	}

	menu_a.click(function (e) {
		e.preventDefault();
		if (page_title != $(this).text()) {
			window.location = "http://" + $(this).text() + ".agartner.com";
		} else if (!$(this).hasClass('active')) {
			activate(menu_a, menu_ul, $(this));
		} else {
			deactivate($(this));

		}
	});
	if ($('title').text() === "Profile") {
		$('.menu > li > ul > li').click(function () {
			switch ($(this).text().killWhiteSpace()) {
				case "Acedemics":
					jQuery.scrollTo($('#acedemics').position().top, 600);
					break;
				case "WorkExperience":
					jQuery.scrollTo($('#work_experience').position().top, 600);
					break;
				case "PersonalInterests":
					jQuery.scrollTo($('#personal_interests').position().top, 600);
					break;
				case "SeeAlso":
					jQuery.scrollTo($('#see_also').position().top, 600);
					break;
				default:
					console.log($(this).text().killWhiteSpace());
			}
		});
		$(document).scroll(function () {
			//the problem with this is it's being called every single scroll. It's not a problem on the initial scroll
			//but after that the elements are faded over and over again.

			/*TODO: only execute fade code if $().css("background-color") == "rgb(199, 199, 199)"; (have to use rgb)
			 : add top and bottom off points
			 :change font to black on grey background.
			 :use specific id rather than class
			 */
			top = $(document).scrollTop();
			var tempdisable = false;
			if (!tempdisable) {
				if (top >= topPersonalInterests - 5) {
					if ($("#profile_menu + ul .subitem3 a").css("background-color") != "rgb(199, 199, 199)") {
						tempdisable = true;
						console.log("personal");
						$("#profile_menu + ul .subitem3 a").css({
							'background-color': '#C7C7C7'
						}, 250, function () {
							tempdisable = false;
						});

						$("#profile_menu + ul .subitem2 a").css({
							'background-color': '#fff'
						}, 250);
						$("#profile_menu + ul .subitem1 a").css({
							'background-color': '#fff'
						}, 250);
					}

				} else if (top >= topWorkExperience - 5) {
					if ($("#profile_menu + ul .subitem2 a").css("background-color") != "rgb(199, 199, 199)") {
						tempdisable = true;
						console.log("work");
						$("#profile_menu + ul .subitem2 a").css({
							'background-color': '#C7C7C7'
						}, 250, function () {
							tempdisable = false;
						});

						$("#profile_menu + ul .subitem3 a").css({
							'background-color': '#fff'
						}, 250);
						$("#profile_menu + ul .subitem1 a").css({
							'background-color': '#fff'
						}, 250);
					}

				} else if (top >= topAcedemics - 5) {
					if ($("#profile_menu + ul .subitem1 a").css("background-color") != "rgb(199, 199, 199)") {
						tempdisable = true;
						console.log("acedemics");
						$("#profile_menu + ul .subitem1 a").css({
							'background-color': '#C7C7C7'
						}, 250, function () {
							tempdisable = false;
						});

						$("#profile_menu + ul .subitem2 a").css({
							'background-color': '#fff'
						}, 250);
						$("#profile_menu + ul .subitem3 a").css({
							'background-color': '#fff'
						}, 250);
					}

				} else {
					console.log("scrolling");
				}
			}
		});
	}

});

function getUrlVars() {
	var map = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
		map[key] = value;
	});
	return map
}

function showNotificationBar(message, duration, bgColor, txtColor, height) {

	/*set default values*/
	duration = typeof duration !== 'undefined' ? duration : 1500;
	bgColor = typeof bgColor !== 'undefined' ? bgColor : "#F4E0E1";
	txtColor = typeof txtColor !== 'undefined' ? txtColor : "#A42732";
	height = typeof height !== 'undefined' ? height : 40;
	/*create the notification bar div if it doesn't exist*/
	if ($('#notification-bar').size() === 0) {
		var HTMLmessage = "<div class='notification-message' style='text-align:center; line-height: " + height + "px;'> " + message + " </div>";
		$('body').prepend("<div id='notification-bar' style='display:none; width:100%; height:" + height + "px; background-color: " + bgColor + "; position: fixed; z-index: 100; color: " + txtColor + ";border-bottom: 1px solid " + txtColor + ";'>" + HTMLmessage + "</div>");
	}
	/*animate the bar*/
	$('#notification-bar').slideDown(function () {
		setTimeout(function () {
			$('#notification-bar').slideUp();
		}, duration);
	});
}