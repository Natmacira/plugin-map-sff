/**
 * This file handles the retrieval of form entries.
 *
 * Uses '/ajax.js';
 */

document.addEventListener('DOMContentLoaded', function () {
	var map = L.map('map').setView([1.212951, -19.312874], 2); //New Delhi coordinates.

	var markers = [];

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	document.getElementById('map-sff-filters').addEventListener('submit', function (e) {
		e.preventDefault();

		var ajax = new AJAX();
		var endpoint = document.getElementById('map-sff-endpoint');
		var getEntriesNonce = document.getElementById('map_sff_get_entries_map_nonce');

		ajax.url = endpoint.value;
		ajax.method = 'POST';
		ajax.parameters = new FormData();
		ajax.parameters.append('action', 'map_sff_get_entries_map'); //this corresponds to wp_action: wp_ajax_map_sff_get_entries_map.
		ajax.parameters.append('map_sff_get_entries_map_nonce', getEntriesNonce.value);

		var countrys = document.querySelectorAll('input[name="country[]"]');
		var locationSpace = document.querySelectorAll('input[name="location[]"]');
		var keyword = document.querySelector('input[name="keyword"]').value;

		// Get the values of the checked countrys and push them to the country array
		for (var i = 0; i < countrys.length; i++) {
			if (countrys[i].checked) {
				ajax.parameters.append('countrys[]', countrys[i].value);
			}
		}

		// Get the values of the checked physical spaces and push them to the locationSpace array
		for (var i = 0; i < locationSpace.length; i++) {
			if (locationSpace[i].checked) {
				ajax.parameters.append('locations[]', locationSpace[i].value);
			}
		}

	
		ajax.parameters.append('keyword', keyword);

		ajax.callbacks.success = function (response) {
			var entries = JSON.parse(response);

			removeMarkers();
			var hintElement = document.getElementById('hint');
			hintElement.classList.remove('empty');

			// empty the hint element
			while (hintElement.firstChild) {
				hintElement.removeChild(hintElement.firstChild);
			}

			if (entries.length > 0) {
				for (var i = 0; i < entries.length; i++) {
					entries[i].coordinates = [entries[i].latitud, entries[i].longitud];

					addCentreMarker(entries[i], true);
				}
			} else {
				hintElement.classList.add('empty');
				hintElement.innerHTML = '<p>No se encontraron resultados.</p>';
			}
		};

		ajax.send();
	});

	let defaultCentres = centresAll || [];

	for (var i = 0; i < defaultCentres.length; i++) {
		defaultCentres[i].coordinates = [defaultCentres[i].latitud, defaultCentres[i].longitud];

		addCentreMarker(defaultCentres[i]);
	}


	function addCentreMarker(centre, addToWindow = false) {
		var marker = L.marker(centre.coordinates).addTo(map);

		var centreTitle           = null;
		var centrelocationSpace   = null;
		var centreCountry         = null;
		var centreDescription     = null;
		var centreLink     		  = null;
		var centreOtherLink       = null;
		

		if (centre.name) {
			centreTitle = document.createElement('h4');
			centreTitle.innerText = centre.name;
		}

		if (centre.link) {
			centreLink = document.createElement('a');
			centreLink.classList.add('see-more');
			centreLink.innerText = 'Read more';
			centreLink.href = centre.link;
			centreLink.target = '_blank';
		}

	
		if (centre.other_link) {
			centreOtherLink = document.createElement('a');
			centreOtherLink.classList.add('see-more');
			centreOtherLink.innerText = 'Read more 2';
			centreOtherLink.href = centre.other_link;
			centreOtherLink.target = '_blank';

	
		}

		if (centre.location) {
			if (centre.location.indexOf('No es un espacio') === -1) {
				centrelocationSpace = document.createElement('span');
				centrelocationSpace.innerText = centre.location;
			}
		}

		//other_projects
		if (centre.other_projects) {

			if ( centrelocationSpace ) {
				centrelocationSpace.innerText += ' - ' + centre.other_projects;
			} else {
				centrelocationSpace = document.createElement('span');
				centrelocationSpace.innerText = centre.other_projects;
			}
		}

		if (centre.country) {
			centreCountry = document.createElement('p');
			centreCountry.innerText = 'Country: ' + centre.country;
		}


		if (centre.description) {
			centreDescription = document.createElement('p');
			centreDescription.innerText = 'Description: ' + centre.description;
		}

		// use marker.bindPopup to add the popup to the marker with the outerHTML of the elements that are not null
		marker.bindPopup(
			(centreTitle ? centreTitle.outerHTML : '') +
			(centrelocationSpace ? centrelocationSpace.outerHTML : '') +
			(centreCountry ? centreCountry.outerHTML : '') +
			(centreDescription ? centreDescription.outerHTML : '') +
			(centreLink ? centreLink.outerHTML : '') +
			(centreOtherLink ? centreOtherLink.outerHTML : '') 
			
		);

		markers.push(marker);

		if (addToWindow) {
			var hintElement = document.getElementById('hint');

			if ( hintElement ) {
				var article = document.createElement('article');

				article.innerHTML +=
					(centreTitle ? centreTitle.outerHTML : '') +
					(centrelocationSpace ? centrelocationSpace.outerHTML : '') +
					(centreCountry ? centreCountry.outerHTML : '') +
					(centreDescription ? centreDescription.outerHTML : '') +
					(centreLink ? centreLink.outerHTML : '') +
					(centreOtherLink ? centreOtherLink.outerHTML : '') 
				
			}

			hintElement.appendChild(article);
		}

	}

	// Function to remove all markers from the map
	function removeMarkers() {
		for (var i = 0; i < markers.length; i++) {
			map.removeLayer(markers[i]);
		}
		markers = [];
	}

	const clearFiltersButton = document.getElementById('clear-filters');

	if (clearFiltersButton) {
		clearFiltersButton.addEventListener('click', function () {
			// get all checkboxes with class map-sff-filter
			let checkboxes = document.querySelectorAll('.map-sff-filter');

			// uncheck all checkboxes
			checkboxes.forEach(checkbox => {
				checkbox.checked = false;

				if ( checkbox.type === 'text' ) {
					checkbox.value = '';
				}
			});

			// loadMapButton.click();

			removeMarkers();
			let hintElement = document.getElementById('hint');

			// empty the hint element
			while (hintElement.firstChild) {
				hintElement.removeChild(hintElement.firstChild);
			}

			hintElement.classList.add('empty');
			hintElement.innerHTML = '<p>Usa los filtros para buscar los proyectos</p>';

			let defaultCentres = centresAll || [];

			for (var i = 0; i < defaultCentres.length; i++) {
				defaultCentres[i].coordinates = [defaultCentres[i].latitud, defaultCentres[i].longitud];

				addCentreMarker(defaultCentres[i]);
			}
		});

	}
});
