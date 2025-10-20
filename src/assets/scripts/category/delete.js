const deleteButtons = document.querySelectorAll("#delete");

deleteButtons.forEach((button) => {
	button.addEventListener("click", () => {
		const categoryUid = button.getAttribute("date-uid");
		const languageCode = button.getAttribute("data-language-code");
		const csrf = button.getAttribute("data-csrf");

		if (confirm("Are you sure you want to delete this category?")) {
			let form = document.createElement("form");
			form.method = "POST";
			form.action = "/dashboard/category/delete";
			form.style.display = "none";

			let uidInput = document.createElement("input");
			uidInput.name = "categoryUid";
			uidInput.value = categoryUid;

			let languageInput = document.createElement("input");
			languageInput.name = "language";
			languageInput.value = languageCode;

			let csrfInput = document.createElement("input");
			csrfInput.name = "page_csrf";
			csrfInput.value = csrf;

			form.appendChild(languageInput);
			form.appendChild(uidInput);
			form.appendChild(csrfInput);

			document.body.appendChild(form);

			form.submit();
		}
	});
});
