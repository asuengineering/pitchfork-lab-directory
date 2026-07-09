(function () {
	'use strict';

	function initDirectory(block) {
		if (block.dataset.pfldInitialized) {
			return;
		}

		block.dataset.pfldInitialized = 'true';

		var items = Array.prototype.slice.call(block.querySelectorAll('[data-pfld-lab]'));
		var searchInput = block.querySelector('.pfld-search');
		var areaInputs = Array.prototype.slice.call(block.querySelectorAll('.pfld-area-filter'));
		var recruitingInputs = Array.prototype.slice.call(block.querySelectorAll('.pfld-recruiting-filter'));
		var filterForm = block.querySelector('.pfld-filter-form');
		var resetButton = block.querySelector('.pfld-reset');
		var visibleCount = block.querySelector('.pfld-visible-count');
		var noResults = block.querySelector('.pfld-no-results');

		function getSelectedArea() {
			var selected = areaInputs.find(function (input) {
				return input.checked;
			});

			return selected ? selected.value : '';
		}

		function recruitingIsChecked() {
			return recruitingInputs.some(function (input) {
				return input.checked;
			});
		}

		function syncRecruitingInputs(source) {
			recruitingInputs.forEach(function (input) {
				if (input !== source) {
					input.checked = source.checked;
				}
			});
		}

		function matchesArea(item, selectedArea) {
			if (!selectedArea) {
				return true;
			}

			var itemAreas = (item.dataset.areas || '').split(/\s+/).filter(Boolean);

			return itemAreas.indexOf(selectedArea) !== -1;
		}

		function applyFilters() {
			var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
			var selectedArea = getSelectedArea();
			var recruitingOnly = recruitingIsChecked();
			var count = 0;

			items.forEach(function (item) {
				var searchText = item.dataset.search || '';
				var matchesSearch = !query || searchText.indexOf(query) !== -1;
				var matchesRecruiting = !recruitingOnly || item.dataset.recruiting === '1';
				var isVisible = matchesSearch && matchesRecruiting && matchesArea(item, selectedArea);

				item.hidden = !isVisible;

				if (isVisible) {
					count += 1;
				}
			});

			if (visibleCount) {
				visibleCount.textContent = count;
			}

			if (noResults) {
				noResults.hidden = count !== 0;
			}
		}

		if (searchInput) {
			searchInput.addEventListener('input', applyFilters);
		}

		areaInputs.forEach(function (input) {
			input.addEventListener('change', applyFilters);
		});

		recruitingInputs.forEach(function (input) {
			input.addEventListener('change', function () {
				syncRecruitingInputs(input);
				applyFilters();
			});
		});

		if (filterForm) {
			filterForm.addEventListener('submit', function (event) {
				event.preventDefault();
			});
		}

		if (resetButton) {
			resetButton.addEventListener('click', function (event) {
				event.preventDefault();

				if (searchInput) {
					searchInput.value = '';
				}

				areaInputs.forEach(function (input) {
					input.checked = input.value === '';
				});

				recruitingInputs.forEach(function (input) {
					input.checked = false;
				});

				applyFilters();

				if (searchInput) {
					searchInput.focus();
				}
			});
		}

		applyFilters();
	}

	function init() {
		document.querySelectorAll('[data-pfld-directory]').forEach(initDirectory);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
}());
