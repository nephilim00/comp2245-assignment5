document.addEventListener('DOMContentLoaded', function () {
    var lookupButton = document.getElementById('lookup');
    var lookupCitiesButton = document.getElementById('lookupCities');
    var resultDiv = document.getElementById('result');

    lookupButton.addEventListener('click', function () {
        var countryInput = document.getElementById('country').value;
        fetchData(countryInput, 'countries');
    });

    lookupCitiesButton.addEventListener('click', function () {
        var countryInput = document.getElementById('country').value;
        fetchData(countryInput, 'cities');
    });

    function fetchData(country, lookupType) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText;
            }
        };

        // Adjust the URL based on the lookup type
        var url = 'world.php?country=' + encodeURIComponent(country);
        if (lookupType === 'cities') {
            url += '&lookup=cities';
        }

        xhr.open('GET', url, true);
        xhr.send();
    }
});
