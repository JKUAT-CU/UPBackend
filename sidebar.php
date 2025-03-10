
<link rel="stylesheet" href="assets/css/style.css">
    <!-- Sidebar -->
    <div class="sidebar bg-yellow-500">
        <ul class="nav flex-column">
            <!-- Dynamic positions will be inserted here -->
        </ul>
    </div>
                <!-- Right Sidebar -->
                <div class="sidebar-right">
                <h4>Your selections appear here</h4>
                <div class="selected-profile-card" id="selectedProfiles">
                    <!-- Selected nominees will be dynamically updated here -->
                </div>
                <div class="submit-btn-container text-center mt-4">
                    <button id="submitBtn" class="btn btn-primary" onclick="showConfirmation()" disabled>Confirm Selections</button>
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
                    <div class="profile-card">
                        <h4>${position}</h4> <!-- Position name added here -->
                        <img src="assets/img/defaultprofile.jpeg" alt="${nominee.firstName}">
                        <h5>${nominee.firstName} ${nominee.surname}</h5>
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
        function showPopup(type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        Nomination Successful
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Automatically remove the popup after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
    
    // After 30 seconds, redirect to index.php
    setTimeout(() => {
        window.location.href = '';
    }, 30000);
}


        // Initialize page
        window.onload = function() {
    loadPositions();
    // Ensure the button is available in the DOM before attaching the event listener
    const chairpersonButton = document.getElementById('chairpersonButton');
    if (chairpersonButton) {
        chairpersonButton.addEventListener('click', () => {
            console.log('Chairperson button clicked');
            showNomineeSelection('Chairperson');
        });
    } else {
        console.error('Chairperson button not found');
    }
};


    </script>