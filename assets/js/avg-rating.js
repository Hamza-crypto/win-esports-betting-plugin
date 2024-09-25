jQuery.noConflict()(function ($) { 
    $(document).ready(function() {
        // List of field names to be included in the average calculation
        var ratingFieldNames = [
            '_websf_rat_bf',
            '_websf_rat_ux',
            '_websf_rat_pm',
            '_websf_rat_cs',
            '_websf_rat_ls',
            '_websf_rat_rlp'
        ];

        // Function to calculate and update the overall rating
        function calculateAndSetOverallRating() {
            var sum = 0;
            var count = 6;

            // Iterate over the list of field names
            ratingFieldNames.forEach(function(fieldName) {
                var inputField = $('input[name="carbon_fields_compact_input[' + fieldName + ']"]');
                var value = parseFloat(inputField.val());

                if (!isNaN(value)) {
                    sum += value;
                }
            });

            // Calculate the average of the selected fields
            var average = sum / count;

            // Update the overall rating field with the calculated average
            var overallRatingInput = $('input[name="carbon_fields_compact_input[_websf_rat_overall]"]');
            overallRatingInput.val(average.toFixed(1));  // Set the value with one decimal place
            console.log("Overall rating updated to: " + overallRatingInput.val());
        }

        // Trigger the calculation after 5 seconds on page load
        setTimeout(function() {
            $('input[type="number"]').on('blur', function () {
                calculateAndSetOverallRating();
            });

            calculateAndSetOverallRating();
            

        }, 5000); // 5000ms = 5 seconds
        
    });
});
