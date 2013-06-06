
$(document).ready(function(){
	//form validation rules
    $(".form-horizontal").validate({
        rules: {
        	empid: "required",
        	firstname: "required",
        	lastname: "required",
            username: "required",
            password: "required",
            mobilenumber: "required",
            password_confirm:"required",
            datefrom: "required",
        	dateto: "required",
            phonenumber: "required",
            selectmonth: "required",
            file:"required",
            startdate:"required",
            noofdays:"required",
            
            email: {
                required: true,
                email: true
                
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirm: {
                required: true,
                equalTo: "#password", 
                minlength: 6
            },
            mobilenumber:{
                required:true,
                digits: true,
                minlength:10,
                maxlength:10
            },
            phonenumber:{
                required:true,
                digits: true,
                minlength:10,
                maxlength:10
            },
            agree: "required"
        },
        messages: {
        	empid: "Please enter your employee id",
        	firstname: "Please enter your firstname",
        	lastname: "Please enter your lastname",
        	username: "Please enter your username",
        	password: "Please enter your password",
            datefrom: "Select leave start date",
        	dateto: "Select leave end date",
        	daterange:"Select two dates to generate reports",
        	selectmonth:"You must select a month",
        	file:"You must select file",
        	startdate:"You must select start date",
        	noofdays:"You must enter the number of days dholidays",
        	
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password_confirm: {
                required: "Please confirm password",
                minlength: "Your confirm password must be at least 6 characters long"
            },
            mobilenumber: {
                required: "Enter 10 digits mobile number",
                minlength: "Your mobile number should be 10 digits long"
            },
            phonenumber: {
                required: "Enter 10 digits mobile number",
                minlength: "Your mobile number should be 10 digits long"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
        },
        submitHandler: function(form) {
            form.submit();
        }
});
});