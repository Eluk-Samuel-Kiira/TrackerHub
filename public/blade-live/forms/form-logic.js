// form-logic.js
import LiveBladeResponse from '../responses/liveblade-responses.js';


const formLogic = {
    load(routeName, method = 'GET', data = {}, targetSelector, componentToReload='') {

        const url = window.routes[routeName];
        // console.log(method);
    
        if (!url) {
            console.error(`Route "${routeName}" not found.`);
            return;
        }
    
        // Prepare fetch options
        const options = {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        };
    
        // If the method is POST, PUT, PATCH, or DELETE, add the data as a JSON string in the body
        if (['POST', 'PUT', 'PATCH', 'DELETE'].includes(method.toUpperCase())) {
            options.body = JSON.stringify(data);
        }

        // Fetch content and delegate response handling to LiveBladeResponse
        fetch(url, options)
            .then(response => {
                // If the response is not successful (like 422 Unprocessable Entity), throw the error
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData; // Throw the error data to be caught by .catch()
                    });
                }
                // If response is successful, return the data as JSON
                return response.json();
            })
            .then(data => {
                // Delegate response handling to LiveBladeResponse
                LiveBladeResponse.processResponse(data, document.querySelector(targetSelector), componentToReload);
            })
            .catch(error => {
                // Handle validation errors (422 response)
                if (error.errors) {
                    LiveBladeResponse.displayValidationErrors(error.errors);
                    return;
                }

                // Display error with detailed information
                formLogic.handleError(error);
            });
    },

    handleError(error) {
        let errorMessage = `
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;text-align:left;">
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                    border: 1px solid #ddd;
                    vertical-align: top; /* Ensure content aligns properly */
                }
                th {
                    background-color: #f8f8f8;
                    color: #333;
                    font-weight: bold;
                    width: 20%; /* Set the width for the first column */
                }
                td {
                    background-color: #fafafa;
                    color: #555;
                    width: 80%; /* Set the width for the second column */
                }
                tr:nth-child(even) td {
                    background-color: #f2f2f2; /* Lighter background for even rows */
                }
                
                /* Styling for the inner trace table */
                table.trace-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px; /* Add a margin between inner and outer tables */
                }
                table.trace-table th, table.trace-table td {
                    padding: 8px; /* Adjust padding to be smaller for trace table */
                    border: 1px solid #ddd;
                    text-align: left;
                    vertical-align: top;
                }
                table.trace-table th {
                    background-color: #e8e8e8;
                    color: #000;
                    font-weight: bold;
                }
                table.trace-table td {
                    background-color: #f9f9f9;
                    color: #555;
                }
                table.trace-table tr:nth-child(even) td {
                    background-color: #f0f0f0; /* Lighter background for even rows */
                }
                
                /* Set column widths for the inner trace table */
                table.trace-table th:nth-child(1),
                table.trace-table td:nth-child(1) {
                    width: 5%; /* Index */
                }
                table.trace-table th:nth-child(2),
                table.trace-table td:nth-child(2) {
                    width: 60%; /* File path */
                }
                table.trace-table th:nth-child(3),
                table.trace-table td:nth-child(3) {
                    width: 10%; /* Line number */
                }
                table.trace-table th:nth-child(4),
                table.trace-table td:nth-child(4) {
                    width: 25%; /* Function name */
                }
            </style>

        `;
    
        // Check for various properties and build the error message in table rows
        if (error.message) {
            errorMessage += `<tr><th>Message</th><td>${error.message}</td></tr>`;
        }
        if (error.exception) {
            errorMessage += `<tr><th>Exception</th><td>${error.exception}</td></tr>`;
        }
        if (error.file) {
            errorMessage += `<tr><th>File</th><td>${error.file}</td></tr>`;
        }
        if (error.line) {
            errorMessage += `<tr><th>Line</th><td>${error.line}</td></tr>`;
        }
        
        // Handle trace array of objects in a separate table section
        if (error.trace && Array.isArray(error.trace)) {
            errorMessage += `
                <tr><th>Trace</th><td>
                    <table class="trace-table" border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th>#</th>
                            <th>File</th>
                            <th>Line</th>
                            <th>Function</th>
                        </tr>
            `;
    
            error.trace.forEach((traceObj, index) => {
                errorMessage += `
                    <tr>
                        <td>${index}</td>
                        <td>${traceObj.file || 'unknown file'}</td>
                        <td>${traceObj.line || 'unknown line'}</td>
                        <td>${traceObj.function || 'unknown function'}</td>
                    </tr>
                `;
            });
    
            errorMessage += `</table></td></tr>`;
        }
        
        errorMessage += `</table>`;
    
        // Display the constructed error message using SweetAlert2
        LiveBladeResponse.displayErrorMessage(errorMessage);
    },
    
    
    loopDeleteForms(deleteUrl)  {
        // Send AJAX request to delete the role
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display success message using Swal
                Swal.fire({
                    title: 'Success!',
                    text: data.message,  // Display the message from the server
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reload the component or remove the row dynamically
                    const componentToReload = data.component;
                    LiveBladeResponse.loadComponent('', data.redirect, data.component, componentToReload, data.message);
                });
            } else {
                // Display error message using Swal
                Swal.fire({
                    toast: true,
                    position: 'top-end',  // Places the alert at the top-right corner
                    icon: 'error',        // Error icon
                    title: `<span style="color: red;">${data.message}</span>`,       // The message to display
                    showConfirmButton: false,
                    timer: 5000,          // Auto close after 5 seconds
                    timerProgressBar: true, // Show a progress bar
                    customClass: {
                        popup: 'swal2-show', // Adds a fade-in effect for the popup
                    }
                });
                console.log('Failed to delete');
            }
        })
        .catch(error => {
            formLogic.handleError(error);
            console.log('An error occurred. Please try again.', error);
        });
        
    },

    getLastSegment(url) {
        const segments = url.split('/').filter(segment => segment.length > 0);
        return segments[segments.length - 1];
    },

    loopUpdateForms(data, updateUrl, componentToReload) {
        const uniqueId = formLogic.getLastSegment(updateUrl);
        
        // Return a promise
        return new Promise((resolve, reject) => {
            $.ajax({
                url: updateUrl, // Use the provided update URL
                type: data._method, // Extract the method from the data object (PUT, POST, etc.)
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token for security
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(data), // Send the entire data object as JSON
                success: function(response) {
                    if (response.success) {
                        // If the request is successful
                        componentToReload = response.component;
                        LiveBladeResponse.loadComponent('', response.redirect, response.component, componentToReload, response.message);
                        resolve(true); // Resolve the promise with true on success
                    } else {
                        // Show error message for failed requests
                        Swal.fire({
                            toast: true,
                            position: 'top-end',  // Places the alert at the top-right corner
                            icon: 'error',        // Error icon
                            title: `<span style="color: red;">${response.message}</span>`,       // The message to display
                            showConfirmButton: false,
                            timer: 5000,          // Auto close after 5 seconds
                            timerProgressBar: true, // Show a progress bar
                            customClass: {
                                popup: 'swal2-show', // Adds a fade-in effect for the popup
                            }
                        });
                        resolve(false); // Resolve with false if the response indicates an error
                    }
                },
                error: function(xhr, status, error) {
                    // Handle validation errors
                    if (xhr.status === 422) { // HTTP 422 corresponds to validation errors
                        const response = xhr.responseJSON; // Extract the response containing validation errors
                
                        if (response && response.errors) {
                            LiveBladeResponse.displayValidationErrorsForInstances(response.errors, uniqueId); // Display validation errors
                        }// Resolve with false for validation errors
                    } else if (xhr.status >= 500 && xhr.status < 600) { // Only handle server-side errors (HTTP 500 and above)
                        const response = xhr.responseJSON || {};
                        // console.log(response)
                        const errorMessage = response.message || 'An unexpected error occurred.';
                        formLogic.handleError(response);
                    } else {
                        const response = xhr.responseJSON || {};
                        // console.log(response)
                        const errorMessage = response.message || 'An unexpected error occurred.';
                        formLogic.handleError(response);
                    }
                    resolve(false); 
                }
                
            });
        });
    },

    
    submitFormEntities(data) {
        // console.log(data);
        
        // Return a promise
        return new Promise((resolve, reject) => {
            $.ajax({
                url: data.routeName, 
                type: data._method,
                headers: {
                    'X-CSRF-TOKEN': data._token, // Include CSRF token for security
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(data), // Send the entire data object as JSON
                success: function(response) {
                    if (response.success) {
                        LiveBladeResponse.reloadOrRedirect(response);
                        resolve(true);
                    } else {
                        // Show error message for failed requests
                        Swal.fire({
                            toast: true,
                            position: 'top-end',  
                            icon: 'error',     
                            title: `<span style="color: red;">${response.message}</span>`,     
                            showConfirmButton: false,
                            timer: 5000,        
                            timerProgressBar: true, 
                            customClass: {
                                popup: 'swal2-show', 
                            }
                        });
                        resolve(false); 
                    }
                },
                error: function(xhr, status, error) {
                    // Handle validation errors
                    if (xhr.status === 422) { 
                        const response = xhr.responseJSON; 
    
                        if (response && response.errors) {
                            LiveBladeResponse.displayValidationErrors(response.errors); // Display validation errors
                        }// Resolve with false for validation errors
                    } else if (xhr.status >= 500 && xhr.status < 600) { // Only handle server-side errors (HTTP 500 and above)
                        const response = xhr.responseJSON || {};
                        // console.log(response)
                        const errorMessage = response.message || 'An unexpected error occurred.';
                        formLogic.handleError(response);
                    } else {
                        const response = xhr.responseJSON || {};
                        // console.log(response)
                        const errorMessage = response.message || 'An unexpected error occurred.';
                        formLogic.handleError(response);
                    }
                    resolve(false); 
                }
                
            });
        });
    },

    beginTableSearch(inputId, tableId) {
        const inputElement = document.getElementById(inputId);
        if (!inputElement) return; // Exit if input element is not found

        inputElement.addEventListener('keyup', function() {
            let searchQuery = this.value.toLowerCase();
            let rows = document.querySelectorAll(`#${tableId} tbody tr`);

            rows.forEach(row => {
                let rowData = row.textContent.toLowerCase();
                row.style.display = rowData.includes(searchQuery) ? '' : 'none'; // Show or hide row
            });
        });
    },

    beginUploadImage(file, uploadRoute, fileInputName) {
        const formData = new FormData();
        formData.append(fileInputName, file); // Append the file to the FormData object

        fetch(uploadRoute, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to upload image');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',  
                    icon: 'success',        // Error icon
                    title: `<span style="color: green;">${data.message}</span>`, 
                    showConfirmButton: false,
                    timer: 5000,          
                    timerProgressBar: true, // Show a progress bar
                    customClass: {
                        popup: 'swal2-show', // Adds a fade-in effect for the popup
                    }
                });
            }
        })
        .catch(error => {
            formLogic.handleError(error);
            console.log('An error occurred. Please try again.', error);
        });
    },

    loopUpdateStatusForms(updateUrl, selectedStatus) {
        
        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: {
                status: selectedStatus,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',  
                        icon: 'success',        // Error icon
                        title: `<span style="color: green;">${response.message}</span>`, 
                        showConfirmButton: false,
                        timer: 5000,          
                        timerProgressBar: true, // Show a progress bar
                        customClass: {
                            popup: 'swal2-show', // Adds a fade-in effect for the popup
                        }
                    });
                } else {
                    // Show error message for failed requests
                    Swal.fire({
                        toast: true,
                        position: 'top-end',  // Places the alert at the top-right corner
                        icon: 'error',        // Error icon
                        title: `<span style="color: red;">${response.message}</span>`,       // The message to display
                        showConfirmButton: false,
                        timer: 5000,          // Auto close after 5 seconds
                        timerProgressBar: true, // Show a progress bar
                        customClass: {
                            popup: 'swal2-show', // Adds a fade-in effect for the popup
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                formLogic.handleError(error);
                console.log('An error occurred. Please try again.', error);
            }
        });
    }
    
};

// Export the implementation for internal use
export default formLogic;
