<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <title>Pricing Management</title>
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .btn-action {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Pricing Management</h1>
        <div class="flex items-center" style="margin-left: 1220px;">
            <div style="margin-left: 1rem;">
                    <button id="button" onclick="goToHome()" style="color: rgb(1, 10, 10);">Home</button>
                    <button id="button" onclick="goToProfile()" style="color: rgb(1, 10, 10);" >Profile</button>
                    <button id="button" onclick="goToLogout()" style="color: rgb(1, 10, 10);" >Logout</button>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Pricing Management Section -->
        <section>
            <h2>Pricing Management</h2>
            <form id="pricing-form">
                <label for="pricing-type">Pricing Model:</label>
                <select id="pricing-type" name="pricing-type" required>
                    <option value="fixed">Fixed</option>
                    <option value="dynamic">Dynamic</option>
                </select>
                <br><br>
                <label for="pricing-value">Pricing Value:</label>
                <input type="number" id="pricing-value" name="pricing-value" required>
                <br><br>
                <button type="submit" class="btn btn-action">Save Pricing</button>
            </form>

            <h3>Existing Pricing Rules</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pricing Model</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="pricing-data">
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
        // Fetch Existing Pricing Rules
        function fetchPricingRules() {
            fetch('getPricingRules.php')
                .then(response => response.json())
                .then(data => {
                    const rows = data.map(rule => `
                        <tr>
                            <td>${rule.model}</td>
                            <td>${rule.value}</td>
                            <td>
                                <button class="btn btn-action" onclick="editPricing(${rule.id})">Edit</button>
                                <button class="btn btn-action" onclick="deletePricing(${rule.id})">Delete</button>
                            </td>
                        </tr>`).join('');
                    document.getElementById('pricing-data').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching pricing rules:', error));
        }

        // Save Pricing Rule
        document.getElementById('pricing-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('savePricingRule.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchPricingRules();
                })
                .catch(error => console.error('Error saving pricing rule:', error));
        });


        // Delete Pricing Rule
        function deletePricing(id) {
            if (confirm('Are you sure you want to delete this pricing rule?')) {
                fetch(`deletePricingRule.php?id=${id}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchPricingRules();
                    })
                    .catch(error => console.error('Error deleting pricing rule:', error));
            }
        }

        // Edit Pricing Rule
        function editPricing(id) {
        // Fetch pricing rule details and populate the form
        fetch(`getPricingRule.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                // Pre-fill form fields with current pricing rule values
                document.getElementById('pricing-type').value = data.model;
                document.getElementById('pricing-value').value = data.value;

                // Change the form action to update instead of saving new rule
                const form = document.getElementById('pricing-form');
                form.onsubmit = function(event) {
                    event.preventDefault();
                    const formData = new FormData(form);
                    formData.append('id', id); // Append the ID to the data for update

                    fetch('editPricingRule.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        fetchPricingRules(); // Refresh the list
                    })
                    .catch(error => console.error('Error updating pricing rule:', error));
                };
            })
            .catch(error => console.error('Error fetching pricing rule details:', error));
        }

        // Initialize Page
        fetchPricingRules();
    </script>
</body>
</html>
