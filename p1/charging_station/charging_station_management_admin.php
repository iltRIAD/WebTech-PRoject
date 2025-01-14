<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <title>Charging Station Management</title>
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
        }
        .btn-update {
            background-color: #ffc107;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Charging Station Management</h1>
            <div class="flex items-center" style="margin-left: 1220px; ">
                <div style="margin-left: 1rem;">
                    <button id="button" onclick="goToHome()" style="color: rgb(1, 10, 10);">Home</button>
                    <button id="button" onclick="goToProfile()" style="color: rgb(1, 10, 10);" >Profile</button>
                    <button id="button" onclick="goToLogout()" style="color: rgb(1, 10, 10);" >Logout</button>
     
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Add New Charging Station -->
        <section>
            <h2>Add New Charging Station</h2>
            <form id="add-station-form">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
                <label for="capacity">Capacity:</label>
                <input type="number" id="capacity" name="capacity" required>
                <label for="availability">Availability:</label>
                <select id="availability" name="availability" required>
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
                <button type="submit" class="btn btn-add">Add Station</button>
            </form>
        </section>

        <!-- Charging Stations List -->
        <section>
            <h2>Existing Charging Stations</h2>
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="station-list">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </section>
    </div>

    <script>

            function goToHome() {
                window.location.href = '../view/home.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
            function goToProfile() {
                window.location.href = '../view/homview_users.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
            function goToLogout() {
                window.location.href = '../view/logout.php';
                //fetch('../view/home.php') // Replace 'home.php' with the actual PHP file you want to navigate to
            }
        // Fetch and display charging stations
        function fetchStations() {
            fetch('getStations.php')
                .then(response => response.json())
                .then(data => {
                    const rows = data.map(station => `
                        <tr>
                            <td>${station.location}</td>
                            <td>${station.capacity}</td>
                            <td>${station.availability}</td>
                            <td>
                                <button class="btn btn-update" onclick="updateStation('${station.id}')">Update</button>
                                <button class="btn btn-delete" onclick="deleteStation('${station.id}')">Delete</button>
                            </td>
                        </tr>`).join('');
                    document.getElementById('station-list').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching stations:', error));
        }

        

        // Add new station
        document.getElementById('add-station-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            fetch('addStation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchStations();
            })
            .catch(error => console.error('Error adding station:', error));
        });

        // Update station
        function updateStation(stationId) {
            const newLocation = prompt('Enter new location:');
            const newCapacity = prompt('Enter new capacity:');
            const newAvailability = prompt('Enter new availability (Available/Unavailable):');
            if (newLocation && newCapacity && newAvailability) {
                fetch(`updateStation.php?id=${stationId}&location=${encodeURIComponent(newLocation)}&capacity=${newCapacity}&availability=${newAvailability}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchStations();
                })
                .catch(error => console.error('Error updating station:', error));
            }
        }

        // Delete station
        function deleteStation(stationId) {
            if (confirm('Are you sure you want to delete this station?')) {
                fetch(`deleteStation.php?id=${stationId}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchStations();
                    })
                    .catch(error => console.error('Error deleting station:', error));
            }
        }

        // Initialize page
        fetchStations();
    </script>
</body>
</html>
