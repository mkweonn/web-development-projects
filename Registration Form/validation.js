const EMAIL_REGEX = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const USC_REGEX = /^[^\s@]+@usc\.edu$/;
const WEBSITE_REGEX = /^(?:(?:https?|ftp):\/\/)?(?:www\.)?[a-z0-9-]+(?:\.[a-z0-9-]+)+[^\s]*$/i;
const PHONE_REGEX = /(^\d{3}\s\d{3}\s\d{4}$|^\d{3}-\d{3}-\d{4}$)/;
const PASSWORD_REGEX = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).*$/;

document.querySelector("#form").onsubmit = function() {
	// console.log("Form Submitted")
	let validForm = true

	const firstName = document.querySelector("#first").value.trim()
	if (firstName.length === 0) {
		validForm = false
		document.querySelector("#first-error").innerHTML = "First Name cannot be empty."
	} else if (/^[A-Z][a-z]*$/.test(firstName) == false) {
		validForm = false
		document.querySelector("#first-error").innerHTML = "Invalid First Name"
	} else {
		document.querySelector("#first-error").innerHTML = ''
	}

	const lastName = document.querySelector("#last").value.trim()
	if (lastName.length === 0) {
		validForm = false
		document.querySelector("#last-error").innerHTML = "Last Name cannot be empty."
	} else if (/^[A-Z][a-z]*$/.test(lastName) == false) {
		validForm = false
		document.querySelector("#last-error").innerHTML = "Invalid Last Name"
	} else {
		document.querySelector("#last-error").innerHTML = ''
	}

	const email = document.querySelector("#email").value.trim()
	console.log(email)

	if (email.length === 0) {
		validForm = false
		document.querySelector("#email-error").innerHTML = "Email cannot be empty."
	} else if (EMAIL_REGEX.test(email) == false) {
		validForm = false
		document.querySelector("#email-error").innerHTML = "Must be a valid email."
	} else if (USC_REGEX.test(email) == false) {
		validForm = false
		document.querySelector("#email-error").innerHTML = "Must be usc.edu email."
	} else {
		document.querySelector("#email-error").innerHTML = ''
	}

	const website = document.querySelector("#website").value.trim()
	if (website.length === 0) {
		validForm = false
		document.querySelector("#website-error").innerHTML = "Website cannot be empty."
	} else if (/^https?:\/\//.test(website) == false) {
		validForm = false
		document.querySelector("#website-error").innerHTML = "Must start with http:// or https://"
	} else if (WEBSITE_REGEX.test(website) == false) {
		validForm = false
		document.querySelector("#website-error").innerHTML = "Invalid URL"
	} else {
		document.querySelector("#website-error").innerHTML = ''
	}

	const phone = document.querySelector("#phone").value.trim()
	if (/^$/.test(phone)) {
		validForm = false
		document.querySelector("#phone-error").innerHTML = "Phone cannot be empty."
	} else if (PHONE_REGEX.test(phone) == false) {
		validForm = false
		document.querySelector("#phone-error").innerHTML = "Invalid phone format."
	} else {
		document.querySelector("#phone-error").innerHTML = ''
	}

	const password = document.querySelector("#password").value.trim()
	if (password.length === 0) {
		validForm = false
		document.querySelector("#password-error").innerHTML = "Password cannot be empty."
	} else if (PASSWORD_REGEX.test(password) == false) {
		validForm = false
		document.querySelector("#password-error").innerHTML = "Insecure password."
	} else {
		document.querySelector("#password-error").innerHTML = ''
	}

	if(validForm) {
		const atIndex = email.indexOf('@')
		const username = email.substring(0,atIndex)

		const number = phone.replace(/\s+/g, '-')
		document.querySelector("#success-submission").innerHTML = `Full Name: ${firstName} ${lastName} <br> Email: ${username} <br> Phone: ${number}`
	}

	// return validForm
	return false;
}