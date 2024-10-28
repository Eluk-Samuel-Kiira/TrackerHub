
const LiveBladeResponse = {
    processResponse: function(data, targetSelector, componentToReload) {
        if (data.success) {
            if(data.reload && data.redirect){
                // reload the page component
                // if (componentToReload === 'DELETE') {
                //     componentToReload = data.component;
                // }
                this.loadComponent(targetSelector, data.redirect, data.component, componentToReload, data.message);
            } else if (data.redirect && !data.reload) {
                // Load the new page content in the background
                this.loadPage(data.redirect);
            } else {
                // Handle other success cases if necessary
                this.displaySuccessMessage(data.html || data.message || 'Success!');
            }
        } else if (data.errors) {
            // Handle Laravel validation errors
            this.displayValidationErrors(data.errors);
        } else if (data.message) {
            // Display an error message if returned
            this.displayErrorMessage(data.message);
        } else {
            // Handle unexpected responses
            this.displayErrorMessage('An unexpected error occurred.');
        }
    },

    loadPage: function(url) {
        // reload the next page
        window.location.href = url;
    },

    loadComponent: function(component, routeName, viewBlade, componentToReload, message) {
        // console.log(message);
        // Clear previous status messages
        if (component) {
            const statusDiv = component.querySelector('#status');
            // include "<div id="status"></div>" in your blade files to display the error message
            if (statusDiv) {
                statusDiv.innerHTML = ''; // Clear previous status messages
            }
        }
    
        // Define the success message
        let successMessage;

        if (message) {        
            successMessage = message;
        } else {
            successMessage = 'Operation Successfully!';
        }

    
        // Construct the URL by appending the viewBlade query parameter
        const url = `${routeName}?viewBlade=${viewBlade}`;
    
        // Fetch new content from the server
        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Add CSRF token if needed
            },
            credentials: 'same-origin', // Ensure CSRF token works in some browsers
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Get the response as HTML
        })
        .then(html => {
            // Replace the inner HTML of the component with the new form content
            // console.log(componentToReload)
            if (componentToReload && componentToReload.trim() !== "") {
                // Find the component by its ID and replace its inner HTML
                const pageComponent = document.getElementById(componentToReload);
                
                if (pageComponent) {
                    // Replace the entire component with the new HTML
                    pageComponent.innerHTML = html; // Assuming `html` contains the entire component HTML
                
                    // check if a table is a datatale and destroy it
                    // This shall be done in the future
                    
                    // Hide any modal with the class 'modal'
                    if (typeof $ !== 'undefined') {
                        $('.modal').modal('hide');
                    }


                    console.log('component reloaded.');
                } else {
                    console.error('Component to reload not found.');
                }
                              
            } else {
                // back to the same id, html here is returned from the specific view in the switch cases in your cotroller
                // especial for displayers like update profiles
                component.innerHTML = html;
                console.log('component reloaded.');
            }
    
            // Display the success message
            this.displaySuccessMessage(successMessage);
        })
        .catch(error => {
            console.error('Error fetching new content:', error);
            this.displayErrorMessage('Component Not Found.');
        });
    },


    reloadOrRedirect: function(response) {
        console.log(response);
        if (response.redirect === '/dashboard') {
            return true;
        }



        if (response.success) {
            this.displaySuccessMessage(response.message);
            return true;
        }
    },


    
    displayErrorMessage: function(message) {
        const swalMessage = ''
        if (message){
            swalMessage = message;
        } else {
            swalMessage = 'Operations Failed';
        }
        Swal.fire({
            toast: true,
            position: 'top-end',  // Places the alert at the top-right corner
            icon: 'error',        // Error icon
            title: `<span style="color: red;">${swalMessage}</span>`,       // The message to display
            showConfirmButton: false,
            timer: 5000,          // Auto close after 5 seconds
            timerProgressBar: true, // Show a progress bar
            customClass: {
                popup: 'swal2-show', // Adds a fade-in effect for the popup
            }
        });

        const statusDiv = document.getElementById('status');
        statusDiv.innerHTML = `<div class="alert alert-danger">${message}</div>`;
        
        // Optionally, remove the message after a few seconds
        setTimeout(() => {
            statusDiv.innerHTML = '';
        }, 5000);
    },
    

    displaySuccessMessage: function(message) {
        let swalMessage = 'Operation Successful!';  // Default message
    
        if (message != null) {
            swalMessage = message;
        }
        
        Swal.fire({
            toast: true,
            position: 'top-end',  // Places the alert at the top-right corner
            icon: 'success',      // Success icon
            title: `<span style="color: green;">${swalMessage}</span>`,       // The message to display
            showConfirmButton: false,
            timer: 5000,          // Auto close after 5 seconds
            timerProgressBar: true, // Show a progress bar
            customClass: {
                popup: 'swal2-show', // Adds a fade-in effect for the popup
            }
        });

        // Incase swal fire is not called
        const statusDiv = document.getElementById('status');
        if (statusDiv) {
            statusDiv.innerHTML = `<div class="alert alert-success">${swalMessage}</div>`;
        }
        
        // Optionally, remove the message after a few seconds
        setTimeout(() => {
            statusDiv.innerHTML = '';
        }, 5000); 
    },
    

    displayValidationErrors: function(errors) {
        // Clear previous error messages
        const existingErrors = document.getElementsByClassName('text-danger');
        Array.from(existingErrors).forEach(error => error.remove());
    
        // Loop through each error field and display the error
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                // Use getElementById to directly target the input field by its id
                const inputElement = document.getElementById(field);
                // console.log(inputElement)
                if (inputElement) {
                    const errorMessage = errors[field][0]; // Get the first error message
    
                    // Create a new span element to display the error message
                    const errorSpan = document.createElement('span');
                    errorSpan.classList.add('text-danger');
                    errorSpan.textContent = errorMessage;
    
                    // Append the error span after the input element
                    inputElement.parentNode.insertBefore(errorSpan, inputElement.nextSibling);
                    this.displayValidationMessage();
                }
            }
        }
    },    

    displayValidationErrorsForInstances: function(errors, userId) {
        // Clear previous error messages
        const existingErrors = document.getElementsByClassName('text-danger');
        Array.from(existingErrors).forEach(error => error.remove());
    
        // Loop through each error field and display the error
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                // Construct the input field's ID by appending the userId
                const inputElement = document.getElementById(field + userId); // e.g., 'edit_name1', 'edit_email1'
    
                if (inputElement) {
                    const errorMessage = errors[field][0]; // Get the first error message
    
                    // Create a new span element to display the error message
                    const errorSpan = document.createElement('span');
                    errorSpan.classList.add('text-danger');
                    errorSpan.textContent = errorMessage;
    
                    // Append the error span after the input element
                    inputElement.parentNode.insertBefore(errorSpan, inputElement.nextSibling);
                    this.displayValidationMessage();
                }
            }
        }
    },
    

    displayErrorMessage: function(message) {
        // Use SweetAlert2 to display a general error message with larger size
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `<div style="max-height: 500px; overflow-y: auto;">${message}</div>`, // Increase the max-height to make it more scrollable
            confirmButtonText: 'OK',
            showCloseButton: false,
            allowOutsideClick: false,
            width: '90%',
        });
    },

    displayValidationMessage: function() {
        const swalMessage = 'Validation Errors!'
        Swal.fire({
            toast: true,
            position: 'top-end',  // Places the alert at the top-right corner
            icon: 'error',        // Error icon
            title: `<span style="color: red;">${swalMessage}</span>`,       // The message to display
            showConfirmButton: false,
            timer: 5000,          // Auto close after 5 seconds
            timerProgressBar: true, // Show a progress bar
            customClass: {
                popup: 'swal2-show', // Adds a fade-in effect for the popup
            }
        });
    },
    
    
};
export default LiveBladeResponse;
