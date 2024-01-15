document.addEventListener("DOMContentLoaded", function () {
	const addQuestionBtn = document.getElementById("addQuestion");
	let questionCount = 1;

	function updateQuestionNumbers() {
		// Update the question numbers
		document.querySelectorAll(".question").forEach((question, index) => {
			question.querySelector('label[for^="question"]').innerText =
				"Question " + (index + 1);
			question
				.querySelector('label[for^="question"]')
				.setAttribute("for", "question" + (index + 1));
			question
				.querySelector("input[type=text]")
				.setAttribute("name", "question" + (index + 1));
			question
				.querySelector("input[type=text]")
				.setAttribute("id", "question" + (index + 1));
		});
	}

	function updateDeleteIcons() {
		// Add delete functionality to each delete icon
		document
			.querySelectorAll(".delete-icon")
			.forEach(function (deleteIcon) {
				deleteIcon.addEventListener("click", function (event) {
					event.preventDefault();
					if (
						confirm(
							"Are you sure you want to delete this question?"
						)
					) {
						this.closest(".question").remove();
						questionCount--;
						updateQuestionNumbers();
					}
				});
			});
	}

	addQuestionBtn.addEventListener("click", function () {
		if (questionCount < 10) {
			questionCount++;

			// Clone the first question div
			let newQuestion = document
				.querySelector(".question")
				.cloneNode(true);

			// Clear the input values in the cloned question
			newQuestion
				.querySelectorAll("input[type=text]")
				.forEach((input) => (input.value = ""));

			// Append the new question
			document.getElementById("questions").appendChild(newQuestion);

			// Update question numbers and delete icons for all questions
			updateQuestionNumbers();
			updateDeleteIcons();
		} else {
			alert("Maximum of 10 questions reached.");
		}
	});

	// Initialize delete functionality and question numbering for the first question
	updateDeleteIcons();
	updateQuestionNumbers();
});
