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
		var resetButton = block.querySelector('.pfld-reset');
		var visibleCount = block.querySelector('.pfld-visible-count');
		var noResults = block.querySelector('.pfld-no-results');

		function getSelectedAreas() {
			return areaInputs
				.filter(function (input) {
					return input.checked;
				})
				.map(function (input) {
					return input.value;
				});
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

		function matchesAreas(item, selectedAreas) {
			if (!selectedAreas.length) {
				return true;
			}

			var itemAreas = (item.dataset.areas || '').split(/\s+/).filter(Boolean);

			return selectedAreas.some(function (area) {
				return itemAreas.indexOf(area) !== -1;
			});
		}

		function applyFilters() {
			var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
			var selectedAreas = getSelectedAreas();
			var recruitingOnly = recruitingIsChecked();
			var count = 0;

			items.forEach(function (item) {
				var searchText = item.dataset.search || '';
				var matchesSearch = !query || searchText.indexOf(query) !== -1;
				var matchesRecruiting = !recruitingOnly || item.dataset.recruiting === '1';
				var isVisible = matchesSearch && matchesRecruiting && matchesAreas(item, selectedAreas);

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

		if (resetButton) {
			resetButton.addEventListener('click', function () {
				if (searchInput) {
					searchInput.value = '';
				}

				areaInputs.forEach(function (input) {
					input.checked = false;
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
