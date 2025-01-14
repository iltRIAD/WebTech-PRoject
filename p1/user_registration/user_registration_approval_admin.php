<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <title>User Registration Approval</title>
    <style>
        /* Temporary inline styling; replace with style.css */
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .pending-list, .log-section {
            margin-top: 20px;
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
            margin: 0 5px;
            cursor: pointer;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        .log-section {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>User Registration Approval</h1>
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
        <!-- Pending Approval List -->
        <section class="pending-list">
            <h2>Pending Approval List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="pending-users">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </section>

        <!-- System Logs Section -->
        <section class="log-section">
            <h2>Approval/Rejection Logs</h2>
            <div id="system-logs">
                <!-- Logs will appear here -->
            </div>
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
        // Fetch and display pending users
        function fetchPendingUsers() {
            fetch('getPendingUsers.php')
                .then(response => response.json())
                .then(data => {
                    const userRows = data.map(user => `
                        <tr>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.registration_date}</td>
                            <td>
                                <button class="btn btn-approve" onclick="approveUser('${user.id}')">Approve</button>
                                <button class="btn btn-reject" onclick="rejectUser('${user.id}')">Reject</button>
                            </td>
                        </tr>`).join('');
                    document.getElementById('pending-users').innerHTML = userRows;
                })
                .catch(error => console.error('Error fetching users:', error));
        }

        // Approve a user
        function approveUser(userId) {
            fetch(`approveUser.php?id=${userId}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchPendingUsers();
                    fetchSystemLogs();
                })
                .catch(error => console.error('Error approving user:', error));
        }

        // Reject a user
        function rejectUser(userId) {
            const reason = prompt('Enter rejection reason:');
            if (reason) {
                fetch(`rejectUser.php?id=${userId}&reason=${encodeURIComponent(reason)}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchPendingUsers();
                        fetchSystemLogs();
                    })
                    .catch(error => console.error('Error rejecting user:', error));
            }
        }

        // Fetch and display system logs
        function fetchSystemLogs() {
            fetch('getSystemLogs.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('system-logs').innerHTML = data;
                })
                .catch(error => console.error('Error fetching logs:', error));
        }

        function approveUser(userId) {
            fetch(`approveUser.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchPendingUsers();
                    fetchSystemLogs();
                })
                .catch(error => console.error('Error approving user:', error));
        }

                function rejectUser(userId) {
            const reason = prompt('Enter rejection reason:');
            if (reason) {
                fetch(`rejectUser.php?id=${userId}&reason=${encodeURIComponent(reason)}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchPendingUsers();
                        fetchSystemLogs();
                    })
                    .catch(error => console.error('Error rejecting user:', error));
            }
        }

                function fetchSystemLogs() {
            fetch('getSystemLogs.php')
                .then(response => response.json())
                .then(data => {
                    const logsHTML = data.map(log => `
                        <div>${log.timestamp} - User ID: ${log.user_id} - ${log.action}</div>
                    `).join('');
                    document.getElementById('system-logs').innerHTML = logsHTML;
                })
                .catch(error => console.error('Error fetching logs:', error));
        }

        // Initialize page
        fetchPendingUsers();
        fetchSystemLogs();
       // rejectUser();
        //approveUser();
    </script>
</body>
</html>
