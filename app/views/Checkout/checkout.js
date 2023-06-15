// Get the selected value from the radio buttons
const paymentOption = document.querySelector('input[name="paymentOption"]:checked').value;

// Assign the selected value to a hidden input field in the form
const paymentOptionInput = document.querySelector('#paymentOptionInput');
paymentOptionInput.value = paymentOption;
