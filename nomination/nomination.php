<?php include 'session.php'
checkSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.1/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Nominate</title>
    <style>

    </style>
</head>
<body class="bg-light">

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg bg-blue-600 fixed-top shadow-md topnav">
        <div class="container-fluid">
            <!-- Brand and logo -->
            <!-- <a class="navbar-brand text-white d-flex align-items-center" href="index" style="margin-left: 0;"> -->
                <img src="assets/img/logocu.jpeg" alt="Logo" class="img-fluid rounded-circle" width="40" height="40">
                <span class="ms-2">JKUATCU</span>
            </a>

            <!-- Toggle button for mobile view -->
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Profile dropdown -->
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/user.jpeg" alt="User" class="rounded-circle border-2 border-white me-2" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">Account</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar bg-yellow-500">
        <ul class="nav flex-column">
            <!-- Dynamic positions will be inserted here -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
    <div class="container">
    <div class="declaration" id= fullPagePrompt>
    <h2>Declaration for the Nomination of Leadership Positions</h2>
    <p>I, as a nominator for the Christian Union, hereby declare my commitment to the nomination and appointment of members for leadership positions within our Union.</p>

    <h3>1. Declaration of Understanding and Commitment</h3>
    <p>By submitting this declaration, I confirm that:</p>
    <ul>
        <li>The nominee is a born-again Christian and a member of the Christian Union.</li>
        <li>The nominee is of sound mind and fully understands the roles and responsibilities associated with the leadership position for which they are being nominated, as detailed in the Constitution of J.K.U.A.T.C.U.</li>
    </ul>

    <h3>Duties and Responsibilities:</h3>

    <h4>Chairperson</h4>
    <ul>
        <li>Preside over all General and Executive Committee meetings.</li>
        <li>Coordinate the work of other Executive Committee members.</li>
        <li>Foster the realization of the Union’s vision, mission, and objectives.</li>
        <li>Serve as the official representative of the Christian Union in all interactions.</li>
    </ul>

    <h4>Vice Chairperson</h4>
    <ul>
        <li>Perform the duties of the Chairperson in their absence or upon delegation.</li>
        <li>Link the Discipleship Committee, First Year Induction Committee, and Nurturing Sub-Committee to the Executive Committee.</li>
        <li>Oversee the smooth running of Wednesday and Sunday services and other assigned services.</li>
    </ul>

    <h4>Secretary</h4>
    <ul>
        <li>Record the minutes of Executive and General Meetings.</li>
        <li>Handle correspondence of the Union, except for those falling under other offices.</li>
        <li>In urgent situations, consult the Chairperson for decisions to be ratified in the next meeting.</li>
    </ul>

    <h4>Jewels Head</h4>
    <ul>
        <li>Assist and carry out the duties of the Secretary in their absence.</li>
        <li>Oversee the nurture, mentorship, and welfare of sisters (Jewels) in the Union.</li>
        <li>Link the Hospitality Sub-Committee and Décor to the Executive Committee.</li>
    </ul>

    <h4>Manifest Head</h4>
    <ul>
        <li>Assist and carry out the duties of the Secretary in their absence.</li>
        <li>Oversee the nurture, mentorship, and welfare of men (Manifest) in the Union.</li>
        <li>Link Sunday School, Sports Ministry, and the Welfare Committee to the Executive Committee.</li>
    </ul>

    <h4>Treasurer</h4>
    <ul>
        <li>Receive and deposit all funds in an approved bank account.</li>
        <li>Maintain proper records of all financial transactions.</li>
        <li>Prepare financial reports for Executive Committee approval and Union presentation.</li>
        <li>Safeguard and update records of Union assets.</li>
        <li>Link the Ushering Sub-Committee to the Executive Committee.</li>
        <li>Chair the Finance Committee.</li>
    </ul>

    <h4>Literature Secretary</h4>
    <ul>
        <li>Link the Library Sub-Committee and Creative Arts Sub-Committee to the Executive Committee.</li>
        <li>Approve all books and literature used by Union members.</li>
        <li>Oversee the Union’s office and manage leadership transition.</li>
        <li>Compile official reports on behalf of the Executive Committee.</li>
    </ul>

    <h4>Music Director</h4>
    <ul>
        <li>Link the Choir, Instrumentalists, and Praise and Worship teams to the Executive Committee.</li>
        <li>Oversee the Praise and Worship Teams.</li>
        <li>Chair the Music Committee.</li>
    </ul>

    <h4>Missions' Coordinator</h4>
    <ul>
        <li>Coordinate evangelism activities within and outside the university.</li>
        <li>Chair the Missions’ and Evangelistic Committees.</li>
        <li>Oversee Evangelistic Teams and harmonize their programs with the Union’s.</li>
        <li>Link the High School Ministry and Hands of Compassion Ministry to the Executive Committee.</li>
    </ul>

    <h4>Organizing Secretary</h4>
    <ul>
        <li>Book venues for all Union activities.</li>
        <li>Arrange transportation for Union events.</li>
        <li>Link the Associates’ Fellowship and Elders’ Committee to the Executive Committee.</li>
    </ul>

    <h4>Bible Study and Prayer Secretary</h4>
    <ul>
        <li>Monitor Bible study groups through Coordinators and leaders.</li>
        <li>Select and distribute Bible Study material.</li>
        <li>Link the Bible Study Committee to the Executive Committee.</li>
        <li>Organize training for Bible Study leaders and Union members.</li>
        <li>Oversee prayer activities and manage the Powerhouse.</li>
        <li>Link Christian Medics and Dentists Association (C.M.D.A) to the Executive Committee.</li>
    </ul>

    <h4>Media and Publicity Secretary</h4>
    <ul>
        <li>Link the Sound and Lighting and ED-IT Sub-Committees to the Executive Committee.</li>
        <li>Custodian of all Union official documents, including the Constitution, Gazette, calendar, and policy documents.</li>
        <li>Manage the registration of Union members.</li>
    </ul>

    <h3>2. Prayerful Decision-Making</h3>
    <p>I affirm that the decision to nominate the individuals for these leaderships role has been made prayerfully and with earnest consideration for the well-being of the Union, its members, and the body of Christ. I have known the nominees and feel they are the best for the roles I am nominating them for.
    <!-- Confirmation Button -->
    <button id="chairpersonButton" class="btn btn-primary btn-lg">
    Confirm and Proceed to Chairperson Selection
</button>

</div>



            <!-- Main Content Area -->
            <div class="main-content mt-4">
                <div id="nomineeSection" class="mb-4">
                    <!-- Dynamic content for nominees will be inserted here -->
                </div>
                <div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Your Selections</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Confirmation content will be inserted here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitSelections()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Top Section (replacing Sidebar Right) -->
            <div class="top-profile-bar">
                <h4>Your selections appear here</h4>
                <div class="selected-profile-card-container" id="selectedProfiles">
                    <!-- Selected nominees will be dynamically updated here -->

                </div>
                <div class="submit-btn-container text-center mt-2">
                    <button id="submitBtn" class="btn btn-primary" onclick="showConfirmation()" disabled>Confirm Selections</button>
                </div>
            </div>


        </div>
    </div>
<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const selectedNominees = {};
    const positionsUrl = 'positions.json';  // URL to fetch positions
    const nomineesUrl = 'backend/get_members.php';  // URL to fetch nominees

    // Load positions dynamically
    function loadPositions() {
        fetch(positionsUrl)
            .then(response => response.json())
            .then(data => {
                const positionsDiv = document.querySelector('.sidebar .nav');
                positionsDiv.innerHTML = data.positions.map(position => `
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" onclick="showNomineeSelection('${position}')">${position}</a>
                    </li>
                `).join('');

                // Link the button to the "Chairperson" position
                const chairpersonButton = document.getElementById('chairpersonButton');
                if (chairpersonButton) {
                    chairpersonButton.addEventListener('click', () => {
                        showNomineeSelection('Chairperson');
                    });
                }
            });
    }

    function showNomineeSelection(position) {
        document.getElementById('fullPagePrompt').style.display = 'none'; // Hide prompt

        // Show the topnav once nominees are being selected
        document.querySelector('.top-profile-bar').style.display = 'block'; // Show topnav

        fetch(nomineesUrl)
            .then(response => response.json())
            .then(data => {
                const nomineeSection = document.getElementById('nomineeSection');
                nomineeSection.innerHTML = `<h2>${position}</h2>
                    <input type="text" id="searchBox" class="form-control mb-3" placeholder="Search nominees...">`;

                let nominees;

                // Special handling for Chairperson position
                if (position === 'Chairperson') {
                    nominees = data.chairpersons;  // Use only chairpersons data for this position
                } else if (position === 'Manifest Head') {
                    nominees = data.members.filter(member => member.gender === 'male');
                } else if (position === 'Jewels Head') {
                    nominees = data.members.filter(member => member.gender === 'female');
                } else {
                    nominees = data.members; // Default for other positions
                }

                // Render the nominees as profile cards
                nomineeSection.innerHTML += `<div class="profile-card-container" id="profileCards">` +
                    nominees.map(nominee => `
                        <div class="profile-card">
                            <img src="${nominee.image || 'assets/img/defaultprofile.jpeg'}" alt="${nominee.first_name}">
                            <h5>${nominee.first_name} ${nominee.surname}</h5>
                            <p>Ministry: ${nominee.ministry || 'N/A'}</p>
                            <p>ET: ${nominee.det || 'N/A'}</p>
                            <p>Year: ${nominee.year_of_study || 'N/A'}</p>
                            <button class="btn btn-primary btn-sm" onclick="selectNominee('${position}', '${nominee.id}', '${nominee.first_name}', '${nominee.surname}', '${nominee.member_id}')">Select</button>
                        </div>
                    `).join('') + `</div>`;

                // Add search functionality
                document.getElementById('searchBox').addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    document.querySelectorAll('#profileCards .profile-card').forEach(card => {
                        const name = card.querySelector('h5').textContent.toLowerCase();
                        card.style.display = name.includes(query) ? 'block' : 'none';
                    });
                });
            });
    }

    function selectNominee(position, id, firstName, surname, member_id) {
        // Ensure only one nominee per position
        if (selectedNominees[position]) {
            alert(`You have already selected a nominee for ${position}. Please deselect before choosing a new one.`);
            return;
        }

        // Prepare data according to position
        selectedNominees[position] = {
            id: id,               // Use id for the position
            member_id: member_id, // Use member_id for Chairperson
            firstName: firstName,
            surname: surname
        };
        updateSelectionSummary();
    }

    function updateSelectionSummary() {
        const summaryDiv = document.getElementById('selectedProfiles');
        summaryDiv.innerHTML = '';

        Object.keys(selectedNominees).forEach(position => {
            const nominee = selectedNominees[position];
            summaryDiv.innerHTML += `
                <div class="selected-profile-card ">
                  <img src="assets/img/defaultprofile.jpeg" alt="${nominee.firstName}">
                    <p>${nominee.firstName} ${nominee.surname}</p>
                    <p>${position}</p> <!-- Position name added here -->
                    <button class="btn btn-danger btn-sm" onclick="removeNominee('${position}')">Remove</button>
                </div>
            `;
        });

        // Enable submit button if all positions are selected
        const allPositionsSelected = document.querySelectorAll('.sidebar .nav a').length === Object.keys(selectedNominees).length;

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = !allPositionsSelected;  // Enable or disable the button
    }

    function removeNominee(position) {
        delete selectedNominees[position];
        updateSelectionSummary();
    }

    function showConfirmation() {
        const positions = Array.from(document.querySelectorAll('.sidebar .nav a')).map(el => el.textContent); // Convert NodeList to an array
        const missingPositions = positions.filter(position => !selectedNominees[position]);

        if (missingPositions.length > 0) {
            showPopup(`Please select nominees for the following positions before confirming: ${missingPositions.join(', ')}`, "warning");
            return;
        }

        const confirmationModalBody = document.querySelector('#confirmationModal .modal-body');
        confirmationModalBody.innerHTML = `<h2>Confirm Your Selections:</h2>`;
        Object.keys(selectedNominees).forEach(position => {
            const nominee = selectedNominees[position];
            confirmationModalBody.innerHTML += `
                <div class="profile-card">
                    <img src="assets/img/defaultprofile.jpeg" alt="${nominee.firstName}">
                    <p>${position}: ${nominee.firstName} ${nominee.surname}</p>
                </div>
            `;
        });
        new bootstrap.Modal(document.getElementById('confirmationModal')).show();
    }

    function submitSelections() {
        // Prepare the payload by modifying the selected nominees for Chairperson
        const payload = {};

        Object.keys(selectedNominees).forEach(position => {
            const nominee = selectedNominees[position];

            // If the position is Chairperson, send member_id instead of id
            if (position === 'Chairperson') {
                payload[position] = {
                    member_id: nominee.member_id,  // Use member_id for Chairperson
                    firstName: nominee.firstName,
                    surname: nominee.surname
                };
            } else {
                payload[position] = {
                    id: nominee.id,  // Use id for other positions
                    firstName: nominee.firstName,
                    surname: nominee.surname
                };
            }
        });

        // Send the modified payload via fetch
        fetch('backend/nominate.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)  // Send the modified payload
        })
        .then(response => response.text())
        .then(message => {
            showPopup(message, "success");
            document.getElementById('confirmationModal').innerHTML = '';  // Clear modal
        })
        .catch(error => {
            console.error("Error submitting selections:", error);
            showPopup("An error occurred while submitting your selections. Please try again.", "danger");
        });
    }

    function showPopup(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);

        // Automatically remove the popup after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);

        // After 30 seconds, redirect to index.php
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 30000);
    }

    // Initialize page
    window.onload = function() {
        loadPositions();
        document.querySelector('.top-profile-bar').style.display = 'none'; // Hide topnav initially
    };
</script>

</body>
</html>
