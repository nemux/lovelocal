function formatCurrency(strValue){
	strValue = strValue.toString().replace(/\$|\,/g,'');
	dblValue = parseFloat(strValue);
	
	if(isNaN(dblValue)) { dblValue = 0.00; }
	
	blnSign = (dblValue == (dblValue = Math.abs(dblValue)));
	dblValue = Math.floor(dblValue*100+0.50000000001);
	intCents = dblValue%100;
	strCents = intCents.toString();
	dblValue = Math.floor(dblValue/100).toString();
	if(intCents<10)
		strCents = "0" + strCents;
	for (var i = 0; i < Math.floor((dblValue.length-(1+i))/3); i++)
		dblValue = dblValue.substring(0,dblValue.length-(4*i+3))+','+
		dblValue.substring(dblValue.length-(4*i+3));
	return (((blnSign)?'':'-') + dblValue + '.' + strCents);
}
function formatCurrency2(strValue){
	strValue = strValue.toString().replace(/\$|\,/g,'');
	dblValue = parseFloat(strValue);
	
	if(isNaN(dblValue)) { dblValue = 0.00; }
	
	blnSign = (dblValue == (dblValue = Math.abs(dblValue)));
	dblValue = Math.floor(dblValue*100+0.50000000001);
	intCents = dblValue%100;
	strCents = intCents.toString();
	dblValue = Math.floor(dblValue/100).toString();
	if(intCents<10)
		strCents = "0" + strCents;
	for (var i = 0; i < Math.floor((dblValue.length-(1+i))/3); i++)
		dblValue = dblValue.substring(0,dblValue.length-(4*i+3))+','+
		dblValue.substring(dblValue.length-(4*i+3));
	return (((blnSign)?'':'-') + '$' + dblValue + '.' + strCents);
}

function formatCurrency3(num) {
  num = isNaN(num) ? 0 : num;
  var rounded = round(num, 2).toFixed(4);
  
  var parts = rounded.match(/^(-?)([0-9]+)(.[0-9]+)$/);
  var sign = parts[1];
  var integer = parts[2];
  var fraction = parts[3];
  
  var thousands = [];
  while (integer.length > 3) {
    thousands.unshift( integer.substr(integer.length - 3, 3) );
    integer = integer.substr(0, integer.length - 3);
  }
  thousands.unshift(integer);
  
  return sign + "$" + thousands.join(",") + fraction;
}

function round(nr, digits) {
  digits = digits || 0;
  var multiplier = Math.pow(10, digits);
  return Math.round(nr * multiplier) / multiplier;
};