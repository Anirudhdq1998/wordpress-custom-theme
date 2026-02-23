(function () {


	function getInitialState() {
		var wrapper = document.querySelector('.cars-filter-section');
		return {
			category: wrapper ? wrapper.getAttribute('data-category') : '',
			paged:    wrapper ? parseInt(wrapper.getAttribute('data-paged'), 10) || 1 : 1,
		};
	}


	function loadCars(page, category) {
		var grid       = document.getElementById('cars-grid');
		var pagination = document.getElementById('cars-pagination');
		var info       = document.getElementById('pagination-info');

		if (!grid) return;

		grid.innerHTML       = '<div class="cars-loading">Loading</div>';
		pagination.innerHTML = '';
		info.innerHTML       = '';

		var xhr = new XMLHttpRequest();
		xhr.open('POST', CARS_AJAX.ajaxurl, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		xhr.onload = function () {
			if (xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);
				if (response.success) {
					var data = response.data;

					grid.innerHTML = data.html;
					buildPagination(data.paged, data.total_pages, category);

					if (data.total_pages > 1) {
						info.innerHTML = 'Page ' + data.paged + ' of ' + data.total_pages + ' (' + data.total_posts + ' cars total)';
					} else {
						info.innerHTML = 'Showing all ' + data.total_posts + ' car' + (data.total_posts !== 1 ? 's' : '');
					}

					// Smooth scroll to grid
// 					grid.scrollIntoView({ behavior: 'smooth', block: 'start' });

					// Update URL
					var params = new URLSearchParams(window.location.search);
					page > 1  ? params.set('car_page', page)     : params.delete('car_page');
					category  ? params.set('car_cat', category)  : params.delete('car_cat');
					var newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
					window.history.pushState({ page: page, category: category }, '', newUrl);
				}
			}
		};

		xhr.onerror = function () {
			grid.innerHTML = '<div class="no-cars"><p>Failed to load cars. Please try again.</p></div>';
		};

		xhr.send(
			'action=cars_load_page'
			+ '&nonce='    + encodeURIComponent(CARS_AJAX.nonce)
			+ '&paged='    + encodeURIComponent(page)
			+ '&category=' + encodeURIComponent(category || '')
		);
	}
// pagenation

function buildPagination(current, total, category) {
    var nav = document.getElementById('cars-pagination');
    nav.innerHTML = '';
    if (total <= 1) return;

    var range = 2;

    var prev = document.createElement('button');
    prev.className = 'page-arrow prev-arrow' + (current <= 1 ? ' disabled' : '');
    prev.innerHTML = `
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="30" cy="30" r="30" transform="matrix(-1 0 0 1 60 0)" fill="${current <= 1 ? '#444' : '#A91919'}"/>
            <path d="M34.75 39.5L25.25 30L34.75 20.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="page-arrow-label">Back</span>
    `;
    if (current > 1) {
        prev.onclick = function () { loadCars(current - 1, category); };
    }
    nav.appendChild(prev);

 
    var numbersWrap = document.createElement('div');
    numbersWrap.className = 'page-numbers-wrap';

    for (var i = 1; i <= total; i++) {
        var show = (i === 1 || i === total || Math.abs(i - current) <= range);

        if (!show) {
            if (i === 2 || i === total - 1) {
                var dots = document.createElement('span');
                dots.className = 'page-dot-ellipsis';
                dots.innerHTML = '···';
                numbersWrap.appendChild(dots);
            }
            continue;
        }

        if (i === current) {
            var active = document.createElement('span');
            active.className = 'page-num active-num';
            active.textContent = i;
            numbersWrap.appendChild(active);
        } else {
            (function (pageNum) {
                var btn = document.createElement('button');
                btn.className = 'page-num';
                btn.textContent = pageNum;
                btn.onclick = function () { loadCars(pageNum, category); };
                numbersWrap.appendChild(btn);
            })(i);
        }
    }

    nav.appendChild(numbersWrap);


    var next = document.createElement('button');
    next.className = 'page-arrow next-arrow' + (current >= total ? ' disabled' : '');
    next.innerHTML = `
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="30" cy="30" r="30" fill="${current >= total ? '#444' : '#A91919'}"/>
            <path d="M25.25 39.5L34.75 30L25.25 20.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="page-arrow-label">Next</span>
    `;
    if (current < total) {
        next.onclick = function () { loadCars(current + 1, category); };
    }
    nav.appendChild(next);
}

window.filterCars = function () {
    var select   = document.getElementById('car-category-select');
    var category = select ? select.value : '';
    loadCars(1, category);
    toggleClearButton(category);
};


window.clearFilter = function () {
    var select = document.getElementById('car-category-select');
    if (select) select.value = '';
    loadCars(1, '');
    toggleClearButton('');
};


	window.addEventListener('popstate', function (e) {
		if (e.state) {
			loadCars(e.state.page, e.state.category);
			var select = document.getElementById('car-category-select');
			if (select) select.value = e.state.category || '';
		}
	});


	document.addEventListener('DOMContentLoaded', function () {
		var state = getInitialState();
		loadCars(state.paged, state.category);
	});
	function toggleClearButton(category) {
    var clearBtn     = document.getElementById('cars-clear-filter');
    var currentLabel = document.getElementById('cars-current-filter');
    var select       = document.getElementById('car-category-select');

    if (category && clearBtn) {
        // Get selected option label
        var label = select.options[select.selectedIndex].text;

        if (currentLabel) currentLabel.textContent = 'Showing: ' + label;
        clearBtn.style.display = 'flex';

      
        clearBtn.classList.remove('filter-tag--hide');
        clearBtn.classList.add('filter-tag--show');
    } else if (clearBtn) {
       
        clearBtn.classList.remove('filter-tag--show');
        clearBtn.classList.add('filter-tag--hide');
        setTimeout(function () {
            clearBtn.style.display = 'none';
        }, 300);
    }
}

})();


