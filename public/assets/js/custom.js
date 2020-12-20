function clearForm() {
   $("#inv_form").trigger('reset');
}

function numberFormat(number = 0) {
   return new Intl.NumberFormat().format(number)
}

function floatval(number) {
   return parseFloat(number.replace(/,/g, ""));
}