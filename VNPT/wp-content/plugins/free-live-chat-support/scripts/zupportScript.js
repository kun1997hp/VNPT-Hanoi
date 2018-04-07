$( document ).ready(function() {

	// login form
	$('#zupportform').submit(function() {
		var EmailId=$('#username').val();
		var Password=$('#password').val();
		var email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var password_re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;

		if(EmailId=='')
		{
			$('#null-password-error-message').addClass('hide');
			$('#invalid-email-error-message').addClass('hide');
			$('#invalid-password-error-message').addClass('hide');
			$('#null-email-error-message').removeClass('hide');
			return false;
		}
		if(!email_re.test(EmailId)){
			$('#null-password-error-message').addClass('hide');
			$('#invalid-email-error-message').removeClass('hide');
			$('#invalid-password-error-message').addClass('hide');
			$('#null-email-error-message').addClass('hide');
			return false;
		}
		if(Password=='')
		{
			$('#null-password-error-message').removeClass('hide');
			$('#invalid-email-error-message').addClass('hide');
			$('#invalid-password-error-message').addClass('hide');
			$('#null-email-error-message').addClass('hide');
			return false;
		}
		if(!password_re.test(Password))
		{
			$('#null-password-error-message').addClass('hide');
			$('#invalid-email-error-message').addClass('hide');
			$('#invalid-password-error-message').removeClass('hide');
			$('#null-email-error-message').addClass('hide');
			return false;
		}
	});
	
	// company select form
	$('#CompanySelectForm').submit(function() {
		var companyId=$('#selectedCompanyId').val();
		if(companyId=='')
		{
			$('#company-error-message').removeClass('hide');
			return false;
		}
	});
	
	// widget select form
	$('#WidgetSelect').submit(function() {
		var widgetId=$('#selectedWeigetID').val();
		if(widgetId=='')
		{
			$('#widget-error-message').removeClass('hide');
			return false;
		}
	});

	$(".table_tr").click(function(){
		$(".table_tr").removeClass('arrow-right');
		$('#selectedCompanyId').val(this.id);
		$('#'+this.id).addClass('arrow-right');
	});
	
	// save widget id
	$(".table_tr_weidget").click(function(){
		$(".table_tr_weidget").removeClass('arrow-right');
		$('#selectedWeigetID').val(this.id);
		$('#'+this.id).addClass('arrow-right');
	});
});
