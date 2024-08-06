    function liveSearch() {
        var filter = document.getElementById('spterm').value.toUpperCase();
        var searchViews = document.getElementsByClassName('search-view');

        Array.from(searchViews).forEach(view => {
            var value = view.getAttribute('data-value').toUpperCase();
            var parentDiv = view.closest('#skrivat'); // Получаем ближайший родительский элемент с id="skrivat"
            if (parentDiv) {
                parentDiv.style.display = value.includes(filter) ? '' : 'none';
            }
        });
    }