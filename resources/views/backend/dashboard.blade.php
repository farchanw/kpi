@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<style>
/* Rescoped CSS for .form-wizard-container children */

/* 1. Basic Reset and Layout */
.form-wizard-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: Arial, sans-serif;
}

/* 2. Step Visibility */
.form-wizard-container .form-step {
    display: none; /* Hide all steps by default */
    padding: 20px 0;
}

.form-wizard-container .form-step.active {
    display: block; /* Show the active step */
}

/* 3. Progress Indicator Styling */
.form-wizard-container .progress-indicator {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.form-wizard-container .step-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #ddd;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.form-wizard-container .step-circle.active {
    background-color: #007bff;
}

.form-wizard-container .step-circle.done {
    background-color: #28a745;
}

/* 4. Input and Button Styling */
.form-wizard-container input[type="text"], 
.form-wizard-container input[type="email"], 
.form-wizard-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-wizard-container .btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
}

.form-wizard-container .next-btn, 
.form-wizard-container .submit-btn {
    background-color: #007bff;
    color: white;
}

.form-wizard-container .prev-btn {
    background-color: #6c757d;
    color: white;
}
</style>


<div class="pc-container">
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        Hi, <b>{{ Auth::user()->name }} </b>
                        @if(config('idev.enable_role',true))
                        You are logged in as <i>{{ Auth::user()->role->name }}</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body p-3">




                        <div class="form-wizard-container">
                            <div class="progress-indicator">
                                </div>

                            <section id="multiStepForm">
                                <div class="form-step active" data-step="1">
                                    <h2>Input Signature</h2>
                                    <form id="signatureForm">
                                        <div class="mb-3">
                                            <label for="signatureCanvas" class="form-label">Sign Here</label>
                                            <div class="border border-dark rounded" id="signature-pad-container">
                                                <canvas id="signatureCanvas" style="width: 100%; height: 200px;"></canvas>
                                            </div>
                                            <input type="hidden" name="signatureData" id="signatureData">
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <button type="button" class="btn btn-secondary" id="clear">Clear</button>
                                            <button type="submit" class="btn btn-primary" id="save">Save Signature</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="form-step" data-step="2">
                                    <h2>Submit Present</h2>
                                    <button type="button" class="btn  next-btn" id="submitPresentBtn">Submit Present</button>
                                </div>

                                <div class="form-step" data-step="3">
                                    <h2>Start Pre-test</h2>
                                    <button type="button" class="btn  next-btn" id="submitPresentBtn">Pre-test</button>
                                </div>
                                
                                <div class="navigation-buttons">
                                    <button type="button" id="prevBtn" class="btn prev-btn" disabled>Previous</button>
                                    <button type="button" id="nextBtn" class="btn next-btn">Next</button>
                                    <button type="submit" id="submitBtn" class="btn submit-btn" style="display: none;">Submit</button>
                                </div>
                            </section>
                        </div>
















                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Get all step divs and navigation elements
    const formSteps = document.querySelectorAll('.form-step');
    const progressIndicator = document.querySelector('.progress-indicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Auto-count the total number of steps
    const totalSteps = formSteps.length;
    let currentStepIndex = 0;

    // 2. Function to generate and update the progress indicator
    function updateProgressIndicator() {
        // Clear previous indicators
        progressIndicator.innerHTML = ''; 

        for (let i = 0; i < totalSteps; i++) {
            const stepCircle = document.createElement('div');
            stepCircle.classList.add('step-circle');
            stepCircle.textContent = i + 1; // Step number

            if (i < currentStepIndex) {
                stepCircle.classList.add('done'); // Previous steps are 'done'
            } else if (i === currentStepIndex) {
                stepCircle.classList.add('active'); // Current step is 'active'
            }

            progressIndicator.appendChild(stepCircle);
        }
    }

    // 3. Function to display the correct step and manage buttons
    function showStep(stepIndex) {
        // Hide all steps
        formSteps.forEach(step => {
            step.classList.remove('active');
        });

        // Show the current step
        formSteps[stepIndex].classList.add('active');
        currentStepIndex = stepIndex;

        // Update progress bar
        updateProgressIndicator();

        // Button Logic
        // Previous button is disabled on the first step
        prevBtn.disabled = currentStepIndex === 0;

        // On the last step, show Submit button and hide Next button
        if (currentStepIndex === totalSteps - 1) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
        }
    }

    // 4. Navigation Event Listeners
    nextBtn.addEventListener('click', () => {
        // Optional: Add validation before moving to the next step here
        if (currentStepIndex < totalSteps - 1) {
            showStep(currentStepIndex + 1);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStepIndex > 0) {
            showStep(currentStepIndex - 1);
        }
    });

    // 5. Form Submission (only on the last step)
    document.getElementById('multiStepForm').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Form Submitted! (In a real application, you would send this data to a server)');
        // Add your actual form submission logic here (e.g., fetch API call)
    });

    // Initialize the form wizard to the first step
    showStep(0);
});
</script>
@endsection
