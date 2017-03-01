/**
 * Created by adsal on 2/27/2017.
 */

//generated-standard formulas
$( document ).ready(function() {
    number_of_adults = 2;
    number_of_infants = 1;
    number_of_preschoolers = 1;
    number_of_schoolagers = 1;
    number_of_teenagers = 1;

    let parsedJSON;
    $.ajax({
        url: 'http://icarus.cs.weber.edu/~tg46219/cottages/api/v1/entry/',
        method: 'GET',
        success: function(response) {
            parsedJSON = $.parseJSON( response );
            for (let i = 0; i < parsedJSON.length; i++) {
                if (parsedJSON[i].entryName.includes("single_no_children")) {
                    credit_amount_single_0_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("single_one_child")) {
                    credit_amount_single_1_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("single_two_children")) {
                    credit_amount_single_2_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("single_three_children")) {
                    credit_amount_single_3_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("married_no_children")) {
                    credit_amount_married_filing_jointly_0_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("married_one_child")) {
                    credit_amount_married_filing_jointly_1_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("married_two_children")) {
                    credit_amount_married_filing_jointly_2_children_list.push(parsedJSON[i].entryValue);
                }
                if (parsedJSON[i].entryName.includes("married_three_children")) {
                    credit_amount_married_filing_jointly_3_children_list.push(parsedJSON[i].entryValue);
                }
            }
            console.log("Successfully retrieved EITC entries.");

            ehc_gross_income = ehcCalcGross();

            console.log("annualHousingCosts(): " + annualHousingCosts());
            console.log("annualChildcareCosts(): " + annualChildcareCosts());
            console.log("annualFoodCosts(): " + annualFoodCosts());
            console.log("annualCarInsurance(): " + annualCarInsurance());
            console.log("annualCarOwnership(): " + annualCarOwnership());
            console.log("annualPublicTransportation(): " + annualPublicTransportation());
            console.log("annualHealthInsurance(): " + annualHealthInsurance());
            console.log("annualOutOfPocketCosts(): " + annualOutOfPocketCosts());
            console.log("annualEntertainmentCosts(): " + annualEntertainmentCosts());
            console.log("annualMiscellaneousCosts(): " + annualMiscellaneousCosts());
            console.log("savingsYearly(): " + savingsYearly());
            console.log("netTaxesYearly(): " + netTaxesYearly());
            console.log("annualGrossIncome(): " + annualGrossIncome());
            console.log("annualNetIncome(): " + annualNetIncome());
            console.log("annualTotalExpenses(): " + annualTotalExpenses());
            console.log("grossHourlyIncome(): " + grossHourlyIncome());
            console.log("netHourlyIncome(): " + netHourlyIncome());

        }
    });


});


