window.onload = function () {
	// Get the back button
	var backButton = document.querySelector(".back-button a");

	// Set the href attribute to the referrer
	backButton.href = document.referrer;
};
