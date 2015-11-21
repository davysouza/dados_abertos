/*  ==========  CHOICE SEARCH  ==========  */
function hideAll () {
    $(".s1").hide();
    $(".s2").hide();
    $(".s3").hide();
    $(".s4").hide();

    $("#link1").removeClass("clicked");
    $("#link2").removeClass("clicked");
    $("#link3").removeClass("clicked");
    $("#link4").removeClass("clicked");
}

$("#link1").click(function () {
    hideAll();
    $("#link1").addClass("clicked");
    $(".s1").show(300);
});
$("#link2").click(function () {
    hideAll();
    $("#link2").addClass("clicked");
    $(".s2").show(300);
});
$("#link3").click(function () {
    hideAll();
    $("#link3").addClass("clicked");
    $(".s3").show(300);
});
$("#link4").click(function () {
    hideAll();
    $("#link4").addClass("clicked");
    $(".s4").show(300);
});

/*  ==========  VALIDATE PASSWORD  ==========  */
var password = $('#signup-password')[0];
var confirm_password = $('#signup-password-confirm')[0];
function validatePassword() {
	if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Senhas não combinam.");
	} else {
		confirm_password.setCustomValidity('');
	}
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

/*  ==========  ACCOORDION  ==========  */
$(function() {
    $("#accordion").accordion();
});

/*  ==========  DIALOG FORM  ==========  */
$(function() {
	var dialog = $("#dialog-form").dialog({
		autoOpen: false,
		height: 'auto',
		width: 290,
		modal: true,
        fluid: true
	});

	$("#btn_salvar").click(function() {
		dialog.dialog("open");
	});
});
