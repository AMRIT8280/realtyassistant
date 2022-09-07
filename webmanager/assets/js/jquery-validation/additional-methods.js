$.validator.addMethod("email", function(value) {
  return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
});

$.validator.addMethod("checklower", function(value) {
  return /[a-z]/.test(value);
});

$.validator.addMethod("checkupper", function(value) {
  return /[A-Z]/.test(value);
});

$.validator.addMethod("checkdigit", function(value) {
  return /[0-9]/.test(value);
});