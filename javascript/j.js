$("document").ready(function () {
	$("#main-nav li a").mousedown(function () {
		$(this).addClass('shadow');
	});

	$("#main-nav li a,#sidebar nav ul > li").mouseup(function () {
		$(this).removeClass('shadow');
	});
	$("#main-nav li a").click(function () {
		$(".sidebar").toggleClass("slide_left");
		$("#container").toggleClass("slide_right");
	});

	$("#sidebar nav ul > li:nth-child(2)").click(function () {
		$(this).toggleClass('r1');
		if ($("#sidebar nav ul > li:nth-child(3)").hasClass('r2')) {
			$("#sidebar nav ul > li:nth-child(3)").removeClass('r2');
		}
	});

	$("#sidebar nav ul > li:nth-child(3)").click(function () {
		$(this).toggleClass('r2');
		if ($("#sidebar nav ul > li:nth-child(2)").hasClass('r1')) {
			$("#sidebar nav ul > li:nth-child(2)").removeClass('r1');
		}
	});
    $(".media").click(function() {
        $("this").toggleClass("change");
    });

});
