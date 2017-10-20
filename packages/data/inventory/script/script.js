var url_str = window.location.href;

//var url = new URL(url_str);

var get = window.location.search;

var query = get.substring(6);

var pageArray = query.split("&",1);

var page = pageArray.toString();

// Filter Handler
function filterHandler() {
	var element = document.getElementById('cmbFilter');
	var filter = element.options[element.selectedIndex].value;
	location.replace("?page="+page+"&filter="+filter);
}
// End of Filter Handler

// Form Submit on filter change
function filterPeriod() {
	var form = document.getElementById('filter');
	var dateFrom = document.forms['filter']['dateFrom'].value;
	var dateUntil = document.forms['filter']['dateUntil'].value;
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth()+1;
	var year = date.getFullYear();
	if (day<10) {
		day = '0'+day;
	}
	if (month<10) {
		month = '0'+month;
	}
	var today = year+"-"+month+"-"+day;
	if(dateUntil < dateFrom) {
		alert('Invalid period range!');
		if(dateFrom > today) {
			document.getElementById('dateFrom').value = today;
		} else {
			document.getElementById('dateUntil').value = today;
		}
		return false;
	}
	if(dateFrom != "" && dateUntil != "") {
		if (dateFrom > today || dateUntil > today) {
			if(dateFrom > today){
				var input = document.getElementById('dateFrom');
			}
			if(dateUntil > today) {
				var input = document.getElementById('dateUntil');
			}
			alert('Period filter should not beyond today '+today);
			input.value = today;
			return false;
		} else {
			form.submit();
		}
	} else {
		var inputFrom = document.getElementById('dateFrom');
		var inputUntil = document.getElementById('dateUntil');
		inputFrom.value = today;
		inputUntil.value = today;
		return false;
	}
}
// End of form submit on filter change

function search() {
var a = document.getElementById('cmbSearch');
var combo = a.options[a.selectedIndex].value;
var query = document.getElementById('query').value;
var array = get.split("&");
var length = array.length;
for (x=0;x<array.length;x++) {
	var string = array[x].toString();
	if (string.substring(0,4) == "last") {
		var last = string.substring(5);
	}
}
location.replace('?page='+page+'&last='+last+'&query='+query+'&cmbSearch='+combo);
}

// Print
function cetak() {
	var content = document.getElementById("print");
	var winprint = window.open('','','left=0, top=0, width=800, height=900, toolbar=0, scrollbars=0,status=0');
	winprint.document.write(content.innerHTML);
	winprint.document.close();
	winprint.focus();
	winprint.print();
	winprint.close();
}