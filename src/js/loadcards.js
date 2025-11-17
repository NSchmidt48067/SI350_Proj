// function that pulls data from files and then turns them into bootstrap cards
// that users can interact with.
async function comment_load(id) {
	// make query to backend
	let res = await fetch(`db/comments.php?id=${id}`)
		.then((resp) => {
			console.log(`fetching comments for id ${id}`);
			return resp.json();
		})
		.then((json) => {
			if ('error' in json) {
				throw new Error(json['error']);
			} else if ('comments' in json) {
				return json['comments'];
			}
		})
		.catch((e) => {
			console.log(e);
			return [];
		});

	return res;
}

function buildCards() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		// use ajax to get meal data (which should be in JSON format) from php file
		const data = xhttp.responseText;
		console.log('data ', data);
		// turn data into JSON format
		const json_data = JSON.parse(data);
		console.log('json_data', json_data);
		// build cards with data
		loadCards(json_data);
	};

	xhttp.open('GET', 'db/mealdata.php');
	xhttp.send();
}

// function to load all cards in index.html
async function loadCards(meals) {
	console.log('meals ', meals);
	// generate rows of cards (4 cards per row)
	var mealCards = [];
	for (var meal of JSON.parse(meals)) {
		console.log(meal);
		mealCards.push(
			createCard(
				meal['id'],
				meal['name'],
				meal['description'],
				meal['imgsrc'],
				await comment_load(meal['id'])
			)
		);
	}
	var innerHTML = '';
	var i = 0;
	for (var card of mealCards) {
		if (i % 4 == 0) {
			console.log('test1: ' + i);
			innerHTML += '<div class="row m-3">';
		}
		innerHTML += '<div class="col-sm-3">' + card + ' </div>';
		if (i % 4 == 3) {
			innerHTML += '</div>';
		}
		i++;
	}
	if (i % 4 != 3) {
		innerHTML += '</div>';
	}
	var x = document.getElementById('card-container');
	x.innerHTML += innerHTML;
}

function comment_create(id, comment, username) {
	// make post to backend
	fetch('db/comments.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({
			mealid: id,
			comment: comment,
			username: username,
		}),
	})
		.then((resp) => {
			return resp.json();
		})
		.then((json) => console.log(json))
		.catch((error) => {
			console.error(error);
		});

	resetCards();
}

function resetCards() {
	// get the comment
	$('.card').remove();

	buildCards();
}

function comment_form_open(id) {
	let comment = prompt('Please enter your comments on this meal:');
	console.log('comment', comment);
	if (!comment) {
		alert('You need to enter some text for a comment');
		return;
	}

	let username = 'test_user_99'; // need to get this somewhere else

	comment_create(id, comment, username);
}

// helper function to create card in loadCards()
function createCard(id, name, des, imgsrc, comments) {
	var cardTitle = name;
	var cardDes = des;
	var cardImg = imgsrc;
	var altImg =
		'https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png';
	console.log('comments', comments);
	var card = `
        <div id="${id}" class="card w-20">
            <img src="${cardImg}" class="card-img-top" alt="image reference not found">
            <div class="card-body">
                <h5 class="card-title">${cardTitle}</h5>
                <p class="card-text">${cardDes}</p>
            </div>
                <ul class="list-group list-group-flush">
                    ${comments
											.filter((comment, idx) => {
												return idx < 3;
											})
											.map((comment) => {
												return `<li class="list-group-item"><p>"${comment['comment']}"</p><p><em>- ${comment['username']}</em></p></li>`;
											})
											.join('\n')}
                    ${
											comments.length > 3
												? `<li class="list-group-item">${
														comments.length - 3
												  } More...</li>`
												: ''
										}
                </ul>
            <div class="card-body">
                <a onclick="comment_form_open(${id})" class="card-link">Leave a Comment</a>
            </div>
        </div>
    `;

	return card;
}

$(document).ready(() => {
	buildCards();
});
