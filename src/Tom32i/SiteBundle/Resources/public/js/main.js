function initList()
{
	$('body').on('click', goFullScreen);

	secrets_slides = $("#secrets .slide");
	currentSlide = secrets_slides.first();

	$("#secrets").height( currentSlide.height() );

	setInterval(changeSlide, 30000)
}

function changeSlide()
{
	var nextSlide = currentSlide.next(".slide").length ? currentSlide.next(".slide") : secrets_slides.first();

	nextSlide.addClass("active");
	currentSlide.removeClass("active");

	currentSlide  = nextSlide;
}

var secrets_slides, currentSlide;