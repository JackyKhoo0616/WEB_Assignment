document.addEventListener("DOMContentLoaded", function () {
	let questionCount = 1; // Start with one question on the page

	document
		.getElementById("addQuestion")
		.addEventListener("click", function () {
			if (questionCount < 10) {
				questionCount++;
				const questionsContainer = document.getElementById("questions");
				let questionHTML = `
                <div class="question" id="question${questionCount}">
                    <label for="question${questionCount}">Question ${questionCount}</label>
                    <input type="text" name="question${questionCount}" id="question${questionCount}" placeholder="Enter The Question" required />
                    
                    <div class="options">
                        ${["A", "B", "C", "D"]
							.map(
								(option) => `
                        <div class="option">
                            <label for="option${questionCount}-${option}">Option ${option}</label>
                            <input type="text" name="option${questionCount}-${option}" id="option${questionCount}-${option}" placeholder="Enter Option ${option}"
                                required />
                        </div>
                        `
							)
							.join("")}
                    </div>

                    <label for="correctAnswer${questionCount}">Correct Answer</label>
                    <select name="correctAnswer${questionCount}" id="correctAnswer${questionCount}">
                        <option value="option${questionCount}-A">Option A</option>
                        <option value="option${questionCount}-B">Option B</option>
                        <option value="option${questionCount}-C">Option C</option>
                        <option value="option${questionCount}-D">Option D</option>
                    </select>
                    <div class="delete-icon" onclick="deleteQuestion(${questionCount})" data-tooltip="Delete Question">
                        <i class="bx bx-message-square-x"></i>
                    </div>
                </div>`;
				questionsContainer.insertAdjacentHTML(
					"beforeend",
					questionHTML
				);
			}
		});
});

function deleteQuestion(questionNumber) {
	let questionDiv = document.getElementById(`question${questionNumber}`);
	if (
		questionDiv &&
		confirm("Are you sure you want to delete this question?")
	) {
		questionDiv.remove();
	}
}
