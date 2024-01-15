window.addEventListener("beforeunload", function () {
	sessionStorage.setItem(
		"scrollPosition",
		window.scrollY || window.pageYOffset
	);
});

window.addEventListener("load", function () {
	if (sessionStorage.getItem("scrollPosition") !== null) {
		window.scrollTo(0, sessionStorage.getItem("scrollPosition"));
	}
});
