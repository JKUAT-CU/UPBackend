<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <style>
    .card-text { font-weight: bold; }
    .alert-success { font-size: 1.2rem; }
    .btn-custom { display: inline-block; margin-top: 15px; text-decoration: none; }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <!-- Success Message -->
        <div id="success-message"></div>

        <!-- Mission Details -->
        <h5 class="card-title text-primary">UP</h5>
        <p class="card-text text-muted">Date: <strong>25th April 2025</strong></p>
        <p class="card-text">Paybill Number: <strong>921961</strong></p>
        <p class="card-text">Account Number: <strong id="account-number"><?= htmlspecialchars($accountNumber) ?></strong></p>
        <p class="card-text text-success">Amount Raised: <span id="total-amount">KES <?= number_format($totalAmount) ?></span></p>
                
        <!-- Buttons -->
        <a href="proforma.php" class="btn btn-primary btn-custom">Get Proforma</a>
        </div>
    </div>
  </div>

  <!-- Update Amount Modal -->
<!-- Update Amount Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Collection Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateForm">
          <div class="form-group">
            <label for="newAmount">New Amount (Must be > 1700)</label>
            <input type="number" class="form-control" id="newAmount" name="newAmount" required min="1701">
          </div>
          <div class="form-group">
            <div id="updateFeedback" class="text-danger"></div> <!-- Feedback area -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitUpdate">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>

// Handle form submission
document.getElementById('submitUpdate').addEventListener('click', function () {
  const newAmount = document.getElementById('newAmount').value;

  // Validate input
  if (!newAmount || newAmount <= 1700) {
    return; // Skip if validation fails, no action needed
  }

  // Send data to the backend
  fetch('dashboard.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ newAmount })
  })
    .catch(error => {
      console.error('Error:', error);
    })
    .finally(() => {
      // Close the modal
      $('#updateModal').modal('hide');
      // Reload the page to reflect any changes
      location.reload();
    });
});

</script>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>