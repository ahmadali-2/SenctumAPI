
$(document).ready(function () {
    $("#createProjectButton").click(function (e) {
        e.preventDefault();
        let token = "14|FQXS9SlQVzONlGAWKzyX40fLYn5E0DV8W413jEdD";
        // var person = new Object();
        // person.name = $('#name').val();
        // person.surname = $('#surname').val();
        var project = new Object();
        project.name = "Mars Management System";
        project.description = "This project is designed for students of school who want to learn etc."
        project.duration = "10"

        $.ajax({
            url: 'http://localhost:8000/api/create-project',
            headers: {
                Authorization: 'Bearer '+token,
            },
            data: project,
            type: 'POST',
            success: function (data, textStatus, xhr) {
                console.log(data);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error in Operation');
            }
        });
    });
});

$(document).ready(function () {
    $("#showProfile").click(function (e) {
        e.preventDefault();
        let token = "14|FQXS9SlQVzONlGAWKzyX40fLYn5E0DV8W413jEdD";
        $.ajax({
            url: 'http://localhost:8000/api/student-profile',
            contentType: "application/json",
            headers: {
                Authorization: 'Bearer '+token
            },
            type: 'GET',
            success: function (data, textStatus, xhr) {
                console.log(data);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error in Operation');
            }
        });
    });
});