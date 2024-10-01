const API_KEY = "a8fcabb488b5526d71aba2a16d1053b7"

function displayMovies(url) {
	$.ajax({
		url: url,
		dataType: "json",
		success: function(data) {
			console.log(data)
			console.log(data.results)

			document.querySelector("#num-results").innerHTML = data.results.length
			document.querySelector("#total-results").innerHTML = data.total_results

			document.querySelector("#movies-container").innerHTML = ""

			for (movie of data.results) {
				createMovieCard(movie)
			}
		},
		error: function(e) {
			alert("AJAX Error")
			console.log(e)
		}
	})
}

function createMovieCard(movie) {
	// bootstrap layout
	// <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3">
	// 			<div class="card">
	// 				<img class="card-img" src="https://via.placeholder.com/300" alt="placeholder Image">
	// 				<div class=card-body>
	// 					<h5 class="card-title">Movie Title</h5>
	// 					<p class="card-text">Release Date:</p>
	// 					<p class="card-text">Rating</p>
	// 				</div>
	// 			</div>
	// 			</div>
	// 		</div> 

	const container = document.createElement("div")
	container.classList.add("col-12", "col-sm-6", "col-md-4", "col-lg-3", "mt-3")

	const card = document.createElement("div")
	card.classList.add("card")

	const img = document.createElement("img")
	img.classList.add("card-img")

	if (movie.poster_path) {
		img.src = "https://image.tmdb.org/t/p/w500/"+ movie.poster_path
	} else {
		img.src="https://placehold.co/150x220"
	}

	img.alt = movie.title + " Poster"

	const cardBody = document.createElement("div")
	cardBody.classList.add("card-body")

	const title = document.createElement("h5")
	title.classList.add("card-title")
	title.innerHTML = movie.title

	const releaseDate = document.createElement("p")
	releaseDate.classList.add("card-text")
	releaseDate.innerHTML = "Release Date: " + movie.release_date

	const rating = document.createElement("p")
	rating.classList.add("card-text")
	rating.innerHTML = "Rating: " + movie.vote_average

	cardBody.appendChild(title)
	cardBody.appendChild(releaseDate)
	cardBody.appendChild(rating)

	card.appendChild(img)
	card.appendChild(cardBody)

	container.append(card)

	document.querySelector("#movies-container").appendChild(container)
}

displayMovies("https://api.themoviedb.org/3/movie/now_playing?api_key=" +API_KEY)

// handle form submission
document.querySelector('#search-form').onsubmit = function(){
	const term = document.querySelector('#search-term').value.trim();
	// const limit = document.querySelector('#search-limit').value.trim();
	// const limit = 10;
	// const url = "https://itunes.apple.com/search?term=" + term + "&limit=" + limit

	document.querySelector("#name-error").innerHTML = ""

	if (term.length == 0) {
		document.querySelector("#name-error").innerHTML = "Please enter your search"
	} else if (term.length > 0) {
		// const url = "https://api.themoviedb.org/3/search/movie?query=" + term + "&api_key=" + API_KEY 
		const url = "https://api.themoviedb.org/3/search/movie?query=" + term + "&api_key=" + API_KEY + "&include_adult=false&language=en-US&page=1"
		displayMovies(url);
	}
			return false;
}
