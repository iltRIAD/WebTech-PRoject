<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Management</title>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>User Management System</h1>
        <div class="flex items-center" style="margin-left: 1220px;">
            <div style="margin-left: 1rem;">
                    <button id="button" onclick="goToHome()" style="color: rgb(1, 10, 10);">Home</button>
                    <button id="button" onclick="goToProfile()" style="color: rgb(1, 10, 10);" >Profile</button>
                    <button id="button" onclick="goToLogout()" style="color: rgb(1, 10, 10);" >Logout</button>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Search Section -->
        <div class="search-container">
            <input type="text" id="search-bar" class="form-control" placeholder="Search Users by Name...">
            <button id="search-button" class="btn btn-success">Search</button>
        </div>

        <!-- Button Section -->
        <div class="button-container">
            <button id="user-info-btn" class="btn btn-primary">User Information</button>
        </div>

        <!-- User Information Section -->
        <div id="user-info" class="user-info-container">
            <!-- User data will appear here -->
        </div>

        <!-- Add User Form Section -->
        <div class="add-user-container">
            <h2>Add New User</h2>
            <form action="addUser.php" method="POST" onsubmit="return validateForm();">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>
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
        // Fetch and display all users
        function fetchUsers(searchQuery = '') {
            let url = searchQuery ? `getUsers.php?search=${searchQuery}` : 'getUsers.php';
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    if (data) {
                        document.getElementById('user-info').innerHTML = data;
                    } else {
                        document.getElementById('user-info').innerHTML = `<p>No users found.</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('user-info').innerHTML = `<p>Error fetching users: ${error.message}</p>`;
                });
        }

        // Event listener for "User Information" button
        document.getElementById('user-info-btn').addEventListener('click', function () {
            fetchUsers();
        });

        // Event listener for the search button
        document.getElementById('search-button').addEventListener('click', function () {
            const searchQuery = document.getElementById('search-bar').value;
            fetchUsers(searchQuery);
        });

        // Validate Add User Form
        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            if (!name || !email || !username || !password) {
                alert('All fields are required!');
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }

            return true;
        }

        function fetchUsers(searchQuery = '') {
            let url = searchQuery ? `getUsers.php?search=${searchQuery}` : 'getUsers.php';
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('user-info').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('user-info').innerHTML = `<p>Error fetching users: ${error.message}</p>`;
                });
        }

        // Delete user by ID
        function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch('deleteUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${userId}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Show success or error message
                    fetchUsers(); // Refresh the user list
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            }
        }

    // Event listener for the search button
    document.getElementById('search-button').addEventListener('click', function () {
        const searchQuery = document.getElementById('search-bar').value;
        fetchUsers(searchQuery);
    });

        
    </script>
</body>
</html>
