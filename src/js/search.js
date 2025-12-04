/**
 * Description: JS functions to assist with search functionality on the main page
 * Creation Date: 01DEC2025
 * Author: George Prielipp
 */

var globalCards;

function search(query, cards) {
	return cards.filter((card) =>
		card
			.querySelector('.card-title')
			.innerText.toLowerCase()
			.includes(query.toLowerCase())
	);
}

function updateSearch() {
	// get the search
	let query = $('#searchBar').val();

	if (query == '') {
		updateCards(globalCards);
	} else {
		updateCards(search(query, globalCards));
	}
}

function getHTML(el) {
	let d = document.createElement('div');
	d.appendChild(el);
	return d.innerHTML;
}

function updateCards(cards) {
	// need to construct the rows of 3
	let html = '';
	for (let i = 0; i < cards.length; i++) {
		if (i % 4 == 0) {
			html += '<div class="row m-3">';
		}

		html += '<div class="col-sm-3">' + getHTML(cards[i]) + ' </div>';

		if ((i + 1) % 4 == 0) {
			html += '</div>';
		}
	}

	$('#card-container').empty().append(html);
}

$(document).ready(function () {
	setTimeout(() => {
		globalCards = Array.from(document.querySelectorAll('.card'));
		console.log('global cards', globalCards);
		$('#searchBar').on('input', updateSearch);
	}, 1500); // try to make sure all of the other code has run before trying to grab the cards
});
