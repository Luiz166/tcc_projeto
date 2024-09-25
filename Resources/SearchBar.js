document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search').addEventListener('keyup', function() {
        var searchQuery = this.value;

        if (typeof searchQuery === 'string' && searchQuery.trim() !== "") {
            searchQuery = searchQuery.toLowerCase();
            fetch('../Resources/search.php?search=' + encodeURIComponent(searchQuery))
            .then(res => res.text())
            .then(body => {
                document.querySelector('#history').innerHTML = body;
                console.log(body);
            } )
        }
    });
});