console.log("Profile JS loaded");

$(document).ready(function () {
  const token = localStorage.getItem('session_token');
  const email = localStorage.getItem('email');

  if (!token || !email) {
    alert("Unauthorized! Please login.");
    window.location.href = "login.html";
    return;
  }

 
  $.ajax({
    url: "php/profile.php",
    method: 'POST',
    data: { email, action: 'get' },
    success: function (res) {
      const data = JSON.parse(res);
      if (data.status === 'success') {
        $('#name').val(data.profile.name);
        $('#email').val(data.profile.email);
        $('#age').val(data.profile.age);
        $('#dob').val(data.profile.dob);
        $('#contact').val(data.profile.contact);
      }
    }
  });

  
  $('#saveBtn').click(function () {
    const age = $('#age').val();
    const dob = $('#dob').val();
    const contact = $('#contact').val();

    $.ajax({
      url: 'php/profile.php',
      method: 'POST',
      data: {
        email,
        action: 'update',
        age,
        dob,
        contact
      },
      success: function (res) {
        const data = JSON.parse(res);
        if (data.status === 'success') {
          alert("Profile updated!");
        } else {
          alert("Update failed!");
        }
      }
    });
  });

 
  $('#logout').click(function () {
    localStorage.clear();
  });
});