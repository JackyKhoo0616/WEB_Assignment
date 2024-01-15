var textarea = document.getElementById("textarea");

textarea.addEventListener("input", function () {
	if (this.value.length > 255) {
		this.value = this.value.slice(0, 255);
	}
});

textarea.addEventListener("paste", function (e) {
	var pasteData = e.clipboardData.getData("text");
	if (pasteData.length > 255) {
		e.preventDefault();
		this.value += pasteData.slice(0, 255 - this.value.length);
	}
});
