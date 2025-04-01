// imageController.js
//   -- validate image gracefullly
//   -- handle delete image checkbox

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
    alert.id = 'image-validation-alert';
    alert.textContent = 'Error: Please upload a valid image (JPG, PNG, or GIF).';

    // Append the alert to the container
    alertContainer.appendChild(alert);

    // Clear the file input
    fileInput.value = '';
  }
}



document.addEventListener('DOMContentLoaded', function () {
  // Get the file input element and the delete image checkbox
  let fileInput = document.getElementById('cover_image');
  let imageContainer = document.getElementById('image_container');
  let deleteCheckbox = document.getElementById('delete_image');
  let preview = document.getElementById('preview_image');

  // Validate image gracefullly
  validateImageFile();

  // Attach the image file validation function to the file input's change event
  fileInput.addEventListener('change', (e) => {

    let file = e.target.files[0];

    if (file) {
      let reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result; // Read file and give it to img
        preview.style.display = 'block'; // display
        // If cover_image is loaded, display deleteCheckbox
        deleteCheckbox.parentNode.style.display = 'block';
      };

      reader.readAsDataURL(file);
    } else {
      preview.src = "";
      preview.style.display = 'none';
    }


  });

  // If there is no cover image, don't show deleteCheckbox and its parent
  deleteCheckbox.parentNode.style.display
    = preview.height == 0 ? 'none' : 'block';


  // Add an event listener to the delete image checkbox
  deleteCheckbox.addEventListener('change', function () {
    if (this.checked) {
      // When checked, clear the file input value and hide the file input element
      fileInput.value = "";
      fileInput.parentNode.style.display = "none";
      imageContainer.style.display = "none";

      // Clear all alert messages
      let alertContainer = document.getElementById('image-validation-alert');
      if (alertContainer) {
        alertContainer.remove();
      }

    } else {
      // When unchecked, show the file input element
      fileInput.parentNode.style.display = "block";
      imageContainer.style.display = "block";
    }
  });
});







