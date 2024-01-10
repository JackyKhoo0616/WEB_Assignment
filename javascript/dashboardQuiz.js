window.onload = function () {
	console.log("dashboardQuiz.js loaded");
	// Create main div
	let quizWrapper = document.createElement("div");
	quizWrapper.className = "quiz-wrapper";

	// Create h2 element
	let h2 = document.createElement("h2");
	h2.textContent = "Quiz";

	// Append h2 to main div
	quizWrapper.appendChild(h2);

	// Create quizzes div
	let quizzesDiv = document.createElement("div");
	quizzesDiv.className = "quizzes";

	// Create individual quizzes
	for (let i = 1; i <= 4; i++) {
		let quizDiv = document.createElement("div");
		quizDiv.className = "quiz";

		let quizInfoDiv = document.createElement("div");
		quizInfoDiv.className = "quiz-info";

		let h3 = document.createElement("h3");
		h3.textContent = "Quiz " + i;

		quizInfoDiv.appendChild(h3);

		let viewButtonDiv = document.createElement("div");
		viewButtonDiv.className = "view-button";

		let a = document.createElement("a");
		a.href = "#";

		let button = document.createElement("button");
		button.type = "submit";
		button.textContent = "View";

		a.appendChild(button);
		viewButtonDiv.appendChild(a);

		quizDiv.appendChild(quizInfoDiv);
		quizDiv.appendChild(viewButtonDiv);

		quizzesDiv.appendChild(quizDiv);
	}

	// Create view-more div
	let viewMoreDiv = document.createElement("div");
	viewMoreDiv.className = "view-more";

	let a = document.createElement("a");
	a.href = "#";

	let p = document.createElement("p");
	p.textContent = "View More";

	let i = document.createElement("i");
	i.className = "bx bx-right-arrow-alt";

	a.appendChild(p);
	a.appendChild(i);

	viewMoreDiv.appendChild(a);

	// Append quizzes and view-more divs to main div
	quizWrapper.appendChild(quizzesDiv);
	quizWrapper.appendChild(viewMoreDiv);

	// Append main div to body (or any other parent element)
	document.body.appendChild(quizWrapper);
};
