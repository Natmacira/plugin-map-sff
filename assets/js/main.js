window.addEventListener('load', function () {


	const filterButton = document.querySelector('.filter-btn');

	if (filterButton) {
		filterButton.addEventListener('click', function () {
			document.body.classList.add('filters-open');
		});
	}

	const filterButtonClose = document.querySelector('.close-img');

	if (filterButtonClose) {
		filterButtonClose.addEventListener('click', function () {
			document.body.classList.remove('filters-open');
		});
	}

	const loadMapButton = document.getElementById('load-map');

	if (loadMapButton) {
		loadMapButton.addEventListener('click', function () {
			document.body.classList.remove('filters-open');
		});
	}

	let counters = document.querySelectorAll('.centre-count');
	let interval = 1000;

	function startCounter(element) {
		let startValue = 0;
		let endValue = parseInt(element.getAttribute('data-val'));
		let duration = Math.floor(interval / endValue);

		let counter = setInterval(function () {
			startValue += 1;
			element.textContent = startValue;
			if (startValue == endValue) {
				clearInterval(counter);
			}
		}, duration);
	}

	counters.forEach((counter) => {
		let position = counter.getBoundingClientRect();

		if (position.top <= window.innerHeight) {
			startCounter(counter);
		}
	});

	window.addEventListener('scroll', function () {
		counters.forEach((counter) => {
			let position = counter.getBoundingClientRect();

			if (position.top <= window.innerHeight && counter.textContent == 0) {
				startCounter(counter);
			}
		});
	});
});
