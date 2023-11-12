<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Establish a connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the 'country' parameter is set in the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // Use a prepared statement with a LIKE clause for partial searches
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the lookup parameter is set to cities
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    // Output HTML based on the lookup parameter
    if ($lookup === 'cities') {
        // Code to handle city lookup
        $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population FROM cities 
                               JOIN countries ON cities.country_code = countries.code 
                               WHERE countries.name LIKE :country");

        $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output HTML for city information
        if (count($results) > 0) {
            echo '<table>';
            echo '<tr><th>Name</th><th>District</th><th>Population</th></tr>';
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . $row['city_name'] . '</td>';
                echo '<td>' . $row['district'] . '</td>';
                echo '<td>' . $row['population'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No cities found for the specified country.';
        }
    } else {
        // Output an HTML table for country information
        echo '<table>';
        echo '<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>';
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['continent'] . '</td>';
            echo '<td>' . $row['independence_year'] . '</td>';
            echo '<td>' . $row['head_of_state'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
