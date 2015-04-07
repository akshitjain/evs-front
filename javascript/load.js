$("document").ready(function () {

		var loader = document.querySelector('.circle');
		var logo = document.querySelector('.logo');
		var header = document.getElementsByTagName('header');


		$('.container').addClass('start');
		var length = loader.getTotalLength();
		loader.style.strokeDasharray = length + ' ' + length;
		loader.style.strokeDashoffset = length;
		window.addEventListener('scroll', noscroll);
		$('.circle').one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
			function (e) {
				$('.container').removeClass('start');
				$('.container').addClass('end');
				setInterval(function () {
					window.removeEventListener('scroll', noscroll);
					$('.container').addClass('hideload');
				}, 1500);

			});

		function noscroll() {
			window.scrollTo(0, 0);
		}


});