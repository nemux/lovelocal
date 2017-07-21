var today = new Date();

$(function() {
	
	initPu();
	initDo();
	
	$('#dp_pu').datepicker({    
		prevText: prevText, nextText: nextText, 
		monthNamesShort: monthNamesShort,
		dayNamesMin: dayNamesMin, dayNames: dayNames,
		firstDay: firstDay,
		dateFormat: dateFormat,
		changeMonth: true, changeYear: true,  
		minDate: today, maxDate: today + '+18m',
		onSelect: function(date) { var d = $.datepicker.parseDate(dateFormat, date); setPuDate(d); },
		beforeShow: function() { var d = getPuDate(); $('#dp_pu').val( $.datepicker.formatDate(dateFormat, d) ); }
	});
	$('#dp_pu_img').click(function() { $('#dp_pu').datepicker('show'); });
	
	$('#dp_do').datepicker({    
		prevText: prevText, nextText: nextText, 
		monthNamesShort: monthNamesShort,
		dayNamesMin: dayNamesMin, dayNames: dayNames,
		firstDay: firstDay,
		dateFormat: dateFormat,
		changeMonth: true, changeYear: true,  
		minDate: today, maxDate: today + '+18m',
		onSelect: function(date) { var d = $.datepicker.parseDate(dateFormat, date); setDoDate(d); },
		beforeShow: function() { var d = getDoDate(); $('#dp_do').val( $.datepicker.formatDate(dateFormat, d) ); }
	});	
	$('#dp_do_img').click(function() { $('#dp_do').datepicker('show'); });	
	
	$('#puDay_select').change(function() {
		setPuDate( new Date( getPuDate().getFullYear() , getPuDate().getMonth(), $(this).val() ) );
	});
	
	$('#doDay_select').change(function() {
		setDoDate( new Date( getDoDate().getFullYear() , getDoDate().getMonth(), $(this).val() ) );		
	});
	
	$('#puMonth_select').change(function() {		
		var selectedMonth = $(this).val().split('-')[0];
		var selectedYear = $(this).val().split('-')[1];
		var newDate = new Date( selectedYear, selectedMonth-1, getPuDate().getDate() );		
		if( (newDate.getMonth()+1) != parseInt(selectedMonth) || newDate.getFullYear() != parseInt(selectedYear) ) {			
			var lastDay = 32 - new Date( selectedYear, selectedMonth-1, 32 ).getDate();			
			newDate = new Date( selectedYear, selectedMonth-1, lastDay );
		}
		setPuDate(newDate);		
	});
	
	$('#doMonth_select').change(function() {		
		var selectedMonth = $(this).val().split('-')[0];
		var selectedYear = $(this).val().split('-')[1];
		var newDate = new Date( selectedYear, selectedMonth-1, getDoDate().getDate() );		
		if( (newDate.getMonth()+1) != parseInt(selectedMonth) || newDate.getFullYear() != parseInt(selectedYear) ) {			
			var lastDay = 32 - new Date( selectedYear, selectedMonth-1, 32 ).getDate();			
			newDate = new Date( selectedYear, selectedMonth-1, lastDay );
		}
		setDoDate(newDate);		
	});
	
});

function initPu() {	
	var year = getPuDate().getFullYear();
	var month = parseInt(getPuDate().getMonth()) + 1;
	var day = getPuDate().getDate();
	var monthYear = month + '-' + year;
	$('#puMonth_select').val(monthYear);
		
	var foundDay = false;
	
	var firstDay = 1;
	var lastDay = 32 - new Date( year, month-1, 32 ).getDate();		 
	var dayTxt="día";
	
	$('#puDay_select option').remove();
	$('#puDay_select').append('<option value="-1" disabled="disabled">' + dayTxt + '</option>');
	
	var nextDay = new Date( year, month-1, 1 );	
	for(var i=firstDay; i<=lastDay; i++) {
		nextDay.setDate(i);
		var formattedDate = $.datepicker.formatDate('D d', nextDay, {dayNamesShort: dayNamesShort});
		$('#puDay_select').append('<option value="' + i + '">' + formattedDate + '</option>');
		if(i==day) foundDay = true;
	}
	
	if(foundDay) {		
		$('#puDay_select').val(day);
	} else {		
		$('input[name=puDay]').val( $('#puDay_select').val() );
	}
	
}

function initDo() {	
	var year = getDoDate().getFullYear();
	var month = parseInt(getDoDate().getMonth()) + 1;
	var day = getDoDate().getDate();
	var monthYear = month + '-' + year;
	$('#doMonth_select').val(monthYear);
		
	var foundDay = false;
	
	var firstDay = 1;
	var lastDay = 32 - new Date( year, month-1, 32 ).getDate();		 
	var dayTxt="día";	
	
	$('#doDay_select option').remove();
	$('#doDay_select').append('<option value="-1" disabled="disabled">' + dayTxt + '</option>');
	
	var nextDay = new Date( year, month-1, 1 );	
	for(var i=firstDay; i<=lastDay; i++) {
		nextDay.setDate(i);
		var formattedDate = $.datepicker.formatDate('D d', nextDay, {dayNamesShort: dayNamesShort});
		$('#doDay_select').append('<option value="' + i + '">' + formattedDate + '</option>');
		if(i==day) foundDay = true;
	}
	
	if(foundDay) {		
		$('#doDay_select').val(day);
	} else {		
		$('input[name=doDay]').val( $('#doDay_select').val() );
	}
	
}

function setPuDate(date) {		
	if( getDoDate() < date ) setDoDate(date);	
	var updateDays = false;	
	if( date.getMonth() != getPuDate().getMonth() || date.getFullYear() != getPuDate().getFullYear() ) updateDays = true;	
	$('input[name=puDay]').val( date.getDate() );
	$('input[name=puMonth]').val( date.getMonth() + 1 );
	$('input[name=puYear]').val( date.getFullYear() );	
	setPuDisplayDate(updateDays);	
}

function setDoDate(date) {
	var updateDays = false;	
	if( date.getMonth() != getDoDate().getMonth() || date.getFullYear() != getDoDate().getFullYear() ) updateDays = true;	
	$('input[name=doDay]').val( date.getDate() );
	$('input[name=doMonth]').val( date.getMonth() + 1 );
	$('input[name=doYear]').val( date.getFullYear() );	
	setDoDisplayDate(updateDays);	
}

function getPuDate() {	
	var returnValue = null;
	if( $('input[name=puYear]').val() != '' && $('input[name=puMonth]').val() != '' && $('input[name=puDay]').val() != '' ) {
		returnValue = new Date ( parseInt($('input[name=puYear]').val()), 
			parseInt($('input[name=puMonth]').val())-1, 
			parseInt($('input[name=puDay]').val()) );	
	} else {		
		returnValue = new Date ( today.getFullYear(),
			today.getMonth(),
			today.getDate() + 2);
		$('input[name=puDay]').val( returnValue.getDate() );
		$('input[name=puMonth]').val( returnValue.getMonth() + 1 );
		$('input[name=puYear]').val( returnValue.getFullYear() );
	}
	return returnValue;
	
	
}

function getDoDate() {	
	var returnValue = null;
	if( $('input[name=doYear]').val() != '' && $('input[name=doMonth]').val() != '' && $('input[name=doDay]').val() != '' ) {
		returnValue = new Date ( parseInt($('input[name=doYear]').val()), 
			parseInt($('input[name=doMonth]').val())-1, 
			parseInt($('input[name=doDay]').val()) );
	} else {
		returnValue = new Date ( today.getFullYear(),
			today.getMonth(),
			today.getDate() + 4);
		$('input[name=doDay]').val( returnValue.getDate() );
		$('input[name=doMonth]').val( returnValue.getMonth() + 1 );
		$('input[name=doYear]').val( returnValue.getFullYear() );
	}
	return returnValue;		
}

function setPuDisplayDate(updateDays) {
	var year = getPuDate().getFullYear();
	var month = parseInt(getPuDate().getMonth()) + 1;
	var day = getPuDate().getDate();
	var monthYear = month + '-' + year;
	if( updateDays ) {
		$('#puMonth_select').val(monthYear);
		
		var foundDay = false;
		
		var firstDay = 1;
		var lastDay = 32 - new Date( year, month-1, 32 ).getDate();		 
		
		$('#puDay_select option').remove();
		$('#puDay_select').append('<option value="-1" disabled="disabled">' + dayTxt + '</option>');
		
		var nextDay = new Date( year, month-1, 1 );	
		for(var i=firstDay; i<=lastDay; i++) {
			nextDay.setDate(i);
			var formattedDate = $.datepicker.formatDate('D d', nextDay, {dayNamesShort: dayNamesShort});
			$('#puDay_select').append('<option value="' + i + '">' + formattedDate + '</option>');
			if(i==day) foundDay = true;
		}
		
		if(foundDay) {
			$('#puDay_select').val(day);
		} else {
			$('input[name=puDay]').val( $('#puDay_select').val() );
		}
		
	} else {
		$('#puDay_select').val(day);		
	}
}

function setDoDisplayDate(updateDays) {
	var year = getDoDate().getFullYear();
	var month = parseInt(getDoDate().getMonth()) + 1;
	var day = getDoDate().getDate();
	var monthYear = month + '-' + year;
	if( updateDays ) {
		$('#doMonth_select').val(monthYear);
		
		var foundDay = false;
		
		var firstDay = 1;
		var lastDay = 32 - new Date( year, month-1, 32 ).getDate();		 
		
		$('#doDay_select option').remove();
		$('#doDay_select').append('<option value="-1" disabled="disabled">' + dayTxt + '</option>');
		
		var nextDay = new Date( year, month-1, 1 );	
		for(var i=firstDay; i<=lastDay; i++) {
			nextDay.setDate(i);
			var formattedDate = $.datepicker.formatDate('D d', nextDay, {dayNamesShort: dayNamesShort});
			$('#doDay_select').append('<option value="' + i + '">' + formattedDate + '</option>');
			if(i==day) foundDay = true;
		}
		
		if(foundDay) {
			$('#doDay_select').val(day);
		} else {
			$('input[name=doDay]').val( $('#doDay_select').val() );
		}
		
	} else {
		$('#doDay_select').val(day);		
	}
}