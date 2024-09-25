document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search').addEventListener('keyup', function() {
        var searchQuery = this.value;

        if (typeof searchQuery === 'string' && searchQuery.trim() !== "") {
            searchQuery = searchQuery.toLowerCase();

            // Envio da requisição AJAX
            // var xhr = new XMLHttpRequest();
            // xhr.open('GET', '../Resources/search.php?search=' + encodeURIComponent(searchQuery), true);
            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState === 4 && xhr.status === 200) {
            //         document.getElementsByClassName('transactions').innerHTML = xhr.responseText;
            //     }
            // };
            // xhr.send();

            fetch('../Resources/search.php?search=' + encodeURIComponent(searchQuery))
            .then(res => res.text())
            .then(body => {
                document.querySelector('#history').innerHTML = body;
                console.log(body);
            } )
        }
    });
});