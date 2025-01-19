<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Frontend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5 mb-5">
        <h1 class="text-center">Database Management</h1>

        <!-- Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item"><a class="nav-link active" href="#professors" data-bs-toggle="tab">Professors</a></li>
            <li class="nav-item"><a class="nav-link" href="#universities" data-bs-toggle="tab">Universities</a></li>
            <li class="nav-item"><a class="nav-link" href="#organizations" data-bs-toggle="tab">Organizations</a></li>
            <li class="nav-item"><a class="nav-link" href="#affiliations" data-bs-toggle="tab">Affiliations</a></li>
        </ul>

        <div class="tab-content">
            <!-- Professors -->
            <div class="tab-pane fade show active" id="professors">
                <h2>Professors</h2>
                <form id="professorsForm" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="university_id" placeholder="University ID"
                                required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="organization_id" placeholder="Organization ID"
                                required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Insert</button>
                            <button type="button" class="btn btn-warning" onclick="updateRecord('professors')">Update</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>University ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="professorsTable"></tbody>
                </table>
            </div>

            <!-- Universities -->
            <div class="tab-pane fade" id="universities">
                <h2>Universities</h2>
                <form id="universitiesForm" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="university" placeholder="University Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="university_city" placeholder="City" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Insert</button>
                            <button type="button" class="btn btn-warning" onclick="updateRecord('universities')">Update</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>University</th>
                            <th>University Short Name</th>
                            <th>City</th>
                            <th>Ation</th>
                        </tr>
                    </thead>
                    <tbody id="universitiesTable"></tbody>
                </table>
            </div>

            <!-- Organizations -->
            <div class="tab-pane fade" id="organizations">
                <h2>Organizations</h2>
                <form id="organizationsForm" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="organization" placeholder="Organization Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="organization_sector" placeholder="Sector" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Insert</button>
                            <button type="button" class="btn btn-warning" onclick="updateRecord('organizations')">Update</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Organization</th>
                            <th>Sector</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="organizationsTable"></tbody>
                </table>
            </div>

            <!-- Affiliations -->
            <div class="tab-pane fade" id="affiliations">
                <h2>Affiliations</h2>
                <form id="affiliationsForm" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="function" placeholder="Function" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="organization_id" placeholder="Organization ID" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Insert</button>
                            <button type="button" class="btn btn-warning" onclick="updateRecord('affiliations')">Update</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Processor ID</th>
                            <th>Function</th>
                            <th>Organization ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="affiliationsTable"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function fetchData(table, tableBody) {
            const response = await fetch("backend.php", {
                method: "POST",
                body: new URLSearchParams({
                    table,
                    action: "fetch"
                }),
            });
            const data = await response.json();

            tableBody.innerHTML = data
                .map(
                    (row) =>
                    `<tr>${Object.entries(row)
                    .map(([key, value]) => `<td>${value}</td>`)
                    .join("")}
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editRow('${table}', ${row.id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteRow('${table}', ${row.id})">Delete</button>
                    </td>
                </tr>`
                )
                .join("");
        }

        function editRow(table, id) {
            const form = document.getElementById(`${table}Form`);
            const fields = form.querySelectorAll("input[name]");

            fetch("backend.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        table,
                        action: "fetchSingle",
                        id
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    fields.forEach((field) => {
                        if (data[field.name]) field.value = data[field.name];
                    });
                    form.dataset.editId = id;
                });
        }

        function deleteRow(table, id) {
            if (!confirm("Are you sure you want to delete this record?")) return;

            fetch("backend.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        table,
                        action: "delete",
                        id
                    }),
                })
                .then((response) => response.json())
                .then((result) => {
                    alert(result.success || result.error);
                    const tableBody = document.getElementById(`${table}Table`);
                    fetchData(table, tableBody);
                });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const forms = document.querySelectorAll("form");
            const tables = document.querySelectorAll("tbody");

            tables.forEach((tableBody) => {
                const table = tableBody.id.replace("Table", "");
                fetchData(table, tableBody);
            });

            forms.forEach((form) => {
                form.addEventListener("submit", async (event) => {
                    event.preventDefault();
                    const formData = new FormData(form);
                    formData.append("action", "insert");
                    formData.append("table", form.id.replace("Form", ""));

                    const response = await fetch("backend.php", {
                        method: "POST",
                        body: formData,
                    });

                    const result = await response.json();
                    alert(result.success || result.error);

                    const tableBody = document.getElementById(`${form.id.replace("Form", "")}Table`);
                    fetchData(form.id.replace("Form", ""), tableBody);
                });
            });
        });
    </script>
</body>

</html>