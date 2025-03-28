// validateImage.js

// Function to check if the selected file is an image (JPG, PNG, GIF)
function validateImageFile() {
  const fileInput = document.getElementById('cover_image');
  const file = fileInput.files[0]; // Get the selected file
  const allowedExtensions = ['image/jpeg', 'image/png', 'image/gif']; // Allowed MIME types

  // If no file is selected, exit the function
  if (!file) {
    return;
  }

  const fileType = file.type; // Get the MIME type of the selected file

  // Get the alert container element (or create it if it doesn't exist)
  let alertContainer = document.getElementById('alert-container');

  // If alert container doesn't exist, create it
  if (!alertContainer) {
    alertContainer = document.createElement('div');
    alertContainer.id = 'alert-container'; // Give it an ID
    alertContainer.classList.add('mt-2'); // Add some margin-top for spacing
    fileInput.parentNode.insertBefore(alertContainer, fileInput.nextSibling); // Insert it after the file input
  }

  // Clear any previous alerts
  alertContainer.innerHTML = '';

  // Check if the file type is allowed
  if (!allowedExtensions.includes(fileType)) {
    // Create a new Bootstrap alert element
    const alert = document.createElement('div');
    alert.classList.add('alert', 'alert-danger');
    alert.role = 'alert';
    alert.textContent = 'Error: Please upload a valid image (JPG, PNG, or GIF).';

    // Append the alert to the container
    alertContainer.appendChild(alert);

    // Clear the file input
    fileInput.value = '';
  }
}

// Attach the validateImageFile function to the file input change event
document.addEventListener('DOMContentLoaded', function () {
  const fileInput = document.getElementById('cover_image');
  fileInput.addEventListener('change', validateImageFile); // Trigger validation when a file is selected
});
