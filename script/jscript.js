var dateArrival;
var dateDeparture;
var totalDaysStay;
var stayWeekdayDays;
var stayWeekendDays;
var stayWeekdayNights; // for gettting total
var stayWeekendNights; // for getting total

function getCheckInOrCheckOutDate(dateToCheck){
	var date = ("0" + dateToCheck.getDate()).slice(-2)
	var month = ("0" + (dateToCheck.getMonth() + 1)).slice(-2);
	var yr = dateToCheck.getFullYear();

	console.log(yr + '-' + month + '-' + date);

	return yr + '-' + month + '-' + date;
}



function goBack() {
	window.history.back(-1);
	console.log("ss");
}

function reloadPg() {
	location.reload();
}

function login_open(){
	location.href = 'login_pg.php';
}

function register_open(){
	location.href = 'register.php';
}

function log_user_out(){
	location.href = 'logout.php';
}

function todayValid(){
	//changing to current timezone of Today's date
	var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
	var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
	var today = localISOTime.split('T')[0];
	document.getElementsByName("check_in_date")[0].setAttribute('min', today);

	//changing to current timezone of Tomorrows date 
	var tomorrowDate = new Date();
	tomorrowDate.setDate(tomorrowDate.getDate() + 1);     
    var tzoffsetTmrrw = (tomorrowDate).getTimezoneOffset() * 60000; //offset in milliseconds
    var localISOTimeTmrrw = (new Date(tomorrowDate.getTime() - tzoffsetTmrrw)).toISOString().slice(0, -1);
    var tomorrow = localISOTimeTmrrw.split('T')[0];

    document.getElementsByName("check_out_date")[0].setAttribute('min', tomorrow);

   /*if(dateArrival != undefined){
    	var nextDay = new Date(dateArrival);
    	nextDay.setDate(nextDay.getDate() + 1);
    	var nextDatISOString = nextDay.toISOString().split('T')[0];
    	document.getElementsByName("check_out_date")[0].setAttribute('min', nextDatISOString);
    }*/
}

function arrivalDateSet(selectdate){
	dateArrival = new Date(selectdate.value);
	dateArrival = new Date(dateArrival.setDate(dateArrival.getDate() + 1)); // somehow I get date - 1 so this is solution
	console.log("Date arrival : " + dateArrival);
	//console.log(new Date(dateArrival));
}

function departureDateSet(selectdate){
	//dateDeparture = selectdate.value;
	dateDeparture = new Date(selectdate.value);
	dateDeparture = new Date(dateDeparture.setDate(dateDeparture.getDate() + 1)); // somehow I get date - 1 so this is solution
	console.log("Date Departure : " + dateDeparture);
	console.log();
	
}

function getHowManyDays(){
	var oneDay = 1000*60*60*24;
	//var a = new Date(dateArrival.setDate(dateArrival.getDate() + 1));
	//var d = new Date(dateDeparture.setDate(dateDeparture.getDate() + 1));

	var a = dateArrival;
	var d = dateDeparture;

	console.log("");
	console.log(dateArrival);
	console.log(dateDeparture);
	console.log("");
	console.log(a);
	console.log(d);

	var arrDate_ms = a.getTime();	
	var depDate_ms = d.getTime();

	var timeDiff = Math.abs(depDate_ms-arrDate_ms);
	var dateDiff = Math.ceil(timeDiff/oneDay);

	console.log(dateDiff + " : Total days of stay");

	stayWeekdayDays = getTotalWeekdaysDays(a,d);
	stayWeekendDays = getTotalWeekendDays(a,d);

	console.log(stayWeekdayDays + " : Weekday days");
	console.log(stayWeekendDays + " : Weekend days");

	getCheckInOrCheckOutDate(dateArrival);
	getCheckInOrCheckOutDate(dateDeparture);
	return dateDiff;
}

// getting days stay
function getTotalWeekdaysDays(startDate, endDate) {
    var weekday_days = 0;
    var temp_check_curDate = new Date(startDate);
    while (temp_check_curDate <= endDate) {
        var dayOfWeek = temp_check_curDate.getDay();
        if(!((dayOfWeek == 6) || (dayOfWeek == 0))){
           weekday_days++;
        }
        temp_check_curDate.setDate(temp_check_curDate.getDate() + 1);
    }
    
    return weekday_days;
}

function getTotalWeekendDays(startDate, endDate){
	var weekendday_days = 0;
    var temp_check_curDate =new Date(startDate);
    while (temp_check_curDate <= endDate) {
        var dayOfWeek = temp_check_curDate.getDay();
        if(((dayOfWeek == 6) || (dayOfWeek == 0))){
            weekendday_days++;
        }
        temp_check_curDate.setDate(temp_check_curDate.getDate() + 1);
    }

    return weekendday_days;
}

////


function showCity(str) {
	if(str <= 3){
		document.getElementById("search").disabled = false;
	}else{
		document.getElementById("search").disabled = true;
		alert("No Cities availble for this provience with availble hotels \nPlease choose another city.");
	}	
		
	document.getElementById("prov_empty_opt").disabled = true;
	document.getElementById("resultProvinceValue").innerHTML = str;
	if (str=="") {
		document.getElementById("resultProvinceValue").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest) {
       		 // code for IE7+, Firefox, Chrome, Opera, Safari
       		 xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			document.getElementById("resultProvinceValue").innerHTML=this.responseText;
		}
	}
	xmlhttp.open("GET","getcity.php?q="+str,true);
	xmlhttp.send();
}

function cityChange() {
	document.getElementById("city_empty_opt").disabled = true;
}

function submit(){
	if(validation()){
		totalDaysStay = getHowManyDays();

		var getCitySelectedId = document.getElementById("city_select");
		var city = getCitySelectedId.options[getCitySelectedId.selectedIndex].value;
		//location.href = 'gethotelDetails.php?htl=' + city;
		//consle.log("hh");
		if (window.XMLHttpRequest) {
	       		 // code for IE7+, Firefox, Chrome, Opera, Safari
	       		 xmlhttp=new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("section_3").innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","gethotelDetails.php?htl=" + city,true);
		xmlhttp.send();
	}

}

function updateSessionWithDates(hotelId){
	var room = 'room=' + hotelId;
	var checkIn = 'checkIn=' + getCheckInOrCheckOutDate(dateArrival);
	var checkOut = 'checkOut=' + getCheckInOrCheckOutDate(dateDeparture);;
	var pageToSendTo = 'updateSession.php?';

	var weekdayStay = 'weekday_days=' + stayWeekdayDays;
	var weekendStay = 'weekend_days=' + stayWeekendDays;

	location.href = pageToSendTo + room + '&' + checkIn + '&' + checkOut + '&' + weekdayStay + '&' + weekendStay;
}

function viewHtlDetails(hotelId, weekDays, weeknd){
	var pageToSendTo = 'showhotel_pg.php?';
	var room = 'room=' + hotelId;
	var weekdayStay = 'weekday_days=' + weekDays;
	var weekendStay = 'weekend_days=' + weeknd;
	location.href = pageToSendTo + room + '&' + weekdayStay + '&' + weekendStay;	
}


function validateForm(isFieldValid){
	var isValid;
	for (var i = 0; i < isFieldValid.length; i++) {
		if(!isFieldValid[i]){
			isValid = false;
			break;
		} else{
			isValid = true;
		}
	}

	return isValid;
}

function validation(){
	var isAllValid;
	var isFieldValid = new Array(4);
	for (var i = 0; i < isFieldValid.length; i++) { isFieldValid[i] = false; }

		var selectedProv =  document.getElementById("select_province");
	var selectedCity =  document.getElementById("city_select");
	var selectedDateChIn = document.getElementById("check_in_date");
	var selectedDateChOut = document.getElementById("check_out_date");

	if(selectedProv.selectedIndex < 1){
		document.getElementById("prov_valid").className = 'fieldNotValid';
		isFieldValid[0] = false;
	}else{
		document.getElementById("prov_valid").className = 'fieldValid';
		isFieldValid[0] = true;
	}

	if(selectedCity){
		if(selectedCity.selectedIndex < 1 ){
			document.getElementById("city_valid").className = 'fieldNotValid';
			isFieldValid[1] = false;
		}else{
			document.getElementById("city_valid").className = 'fieldValid';
			isFieldValid[1] = true;
		}
	}
	
	if(!selectedDateChIn.value){
		document.getElementById("check_in").className = 'fieldNotValid';
		isFieldValid[2] = false;
	}else{
		document.getElementById("check_in").className = 'fieldValid';
		isFieldValid[2] = true;
	}

	if(!selectedDateChOut.value){
		document.getElementById("check_out").className = 'fieldNotValid';
		isFieldValid[3] = false;
	}else{
		document.getElementById("check_out").className = 'fieldValid';
		isFieldValid[3] = true;
	}


	isAllValid = validateForm(isFieldValid);
	return isAllValid;
}

//register validation
////////////////////////////////////////////////////////////////////////////

function registerButton(){
	console.log("sadsadsadasdsadsad");
	if(registerValidate()){
		if(!checkSameInDataBase()){
			//document.getElementById("reg_form").submit();
			console.log("registered");
			return true;			
		}else {
			return false;
		}
	}else{
		return false;
	}
}

function checkSameInDataBase(){ // checks if email nd user r not same in the database
	var checkUNameDBase = js_array_database_username;
	var checkEmailDBase = js_array_database_email;

	var entEmailVal = document.getElementById("email").value;
	var entUserNameVal = document.getElementById("username").value;

	var bothFieldSame = true;

	var sameFoundInDatbase = false;
	x:
	for(i = 0; i < checkUNameDBase.length ; i++){
		for(j = 0; j < checkEmailDBase.length ; j++){
			if(entUserNameVal == checkUNameDBase[i] && entEmailVal == checkEmailDBase[j]){
				bothFieldSame = true;
				sameFoundInDatbase = true;
				alert("Username and Email Already Exist in database...\nPlease Enter a different email and username.");
				break x;									
			}else if(i == checkUNameDBase.length - 1 && j == checkEmailDBase.length - 1){
				bothFieldSame = false;
			}
		}
	}

	for(i = 0; i < checkUNameDBase.length ; i++){
		if(!bothFieldSame){
			if(entUserNameVal == checkUNameDBase[i]){
				sameFoundInDatbase = true;
				alert("Username Already Exist in database...\nPlease Enter another username.");
				break ;
			}else if(entEmailVal == checkEmailDBase[i]){
				sameFoundInDatbase = true;
				alert("Email Already Exist in database...\nPlease Enter a new Email.");
				break ;
			}else{
				sameFoundInDatbase = false;
			}
		}
	}

	if(sameFoundInDatbase){
		console.log("same found");
	}else if(!sameFoundInDatbase){
		console.log("same not found");
	}

	console.log("sdfd" + sameFoundInDatbase);
		
	return sameFoundInDatbase;
	
}

function registerValidate(){
	var isAllValid;
	var isFieldValid = new Array(6);
	for (var i = 0; i < isFieldValid.length; i++) { isFieldValid[i] = false; }

	var entFName = document.getElementById("first_name");
	var entLName = document.getElementById("last_name");
	var entEmail = document.getElementById("email");
	var entUserName = document.getElementById("username");
	var entPass = document.getElementById("password");
	var entRePass = document.getElementById("re_password");

	if(!entFName.checkValidity()){
		document.getElementById("fname_valid").className = 'fieldNotValid';
		if(hasNumber(entFName.value)){
			document.getElementById("fname_valid").innerHTML = "* Required. Enter 3-10 Letters only";
		}
		isFieldValid[0] = false;
	}else{
		document.getElementById("fname_valid").className = 'fieldValid';
		isFieldValid[0] = true;
	}


	if(!entLName.checkValidity()){
		document.getElementById("lname_valid").className = 'fieldNotValid';
		if(hasNumber(entLName.value)){
			document.getElementById("lname_valid").innerHTML = "* Required. Enter 3-10 Letters only";
		}
		isFieldValid[1] = false;
	}else{
		document.getElementById("lname_valid").className = 'fieldValid';
		isFieldValid[1] = true;
	}


	if(!entEmail.checkValidity()){
		document.getElementById("email_valid").className = 'fieldNotValid';		
		//document.getElementById("email_valid").innerHTML = "* Required. Enter your email, E.x. unknown@ree.com";
		isFieldValid[2] = false;
	}else{
		document.getElementById("email_valid").className = 'fieldValid';
		isFieldValid[2] = true;
	}


	if(!entUserName.checkValidity()){
		document.getElementById("username_valid").className = 'fieldNotValid';		
		isFieldValid[3] = false;
	}else{
		document.getElementById("username_valid").className = 'fieldValid';
		isFieldValid[3] = true;
	}


	if(!entPass.checkValidity()){
		document.getElementById("pass_valid").className = 'fieldNotValid';		
		isFieldValid[4] = false;
	}else{
		document.getElementById("pass_valid").className = 'fieldValid';
		isFieldValid[4] = true;
	}


	if(!entRePass.checkValidity()){
		document.getElementById("repass_valid").className = 'fieldNotValid';		
		isFieldValid[5] = false;
	}else{
		if (entRePass.value == entPass.value) {
			document.getElementById("repass_valid").className = 'fieldValid';
			isFieldValid[5] = true;
		}else{
			entRePass.value = '';
			document.getElementById("repass_valid").className = 'fieldNotValid';
			document.getElementById("repass_valid").innerHTML = "*Required. Passwords must be same";
			isFieldValid[5] = false;
		}
		
	}

	isAllValid = validateForm(isFieldValid);
	return isAllValid;
}

function hasNumber(myString) {
	return /\d/.test(myString);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////


function confirmButton(logged_email){
	console.log("sadsadsadasdsadsad");
	console.log(logged_email);
	console.log(emailEnteredSame(logged_email));

	if(validateAndCheckEmail() && emailEnteredSame(logged_email)){
		console.log("same nd valid");
		return true;
	}else{
		return false;
	}
}

function validateAndCheckEmail(){
	var isFieldValid;

	var entEmail = document.getElementById("confirm_email");

	if(!entEmail.checkValidity()){
		document.getElementById("confirm_email_valid").className = 'fieldNotValid';		
		console.log("required");
		//document.getElementById("confirm_email_valid").innerHTML = "* Required. Enter your email, E.x. unknown@ree.com";
		isFieldValid = false;
	}else{
		document.getElementById("confirm_email_valid").className = 'fieldValid';
		isFieldValid = true;
	}

	return isFieldValid;
}

function emailEnteredSame(logged_email){
	var entEmail = document.getElementById("confirm_email").value;

	if(entEmail == logged_email){
		return true;
	}else{
		document.getElementById("confirm_email_valid").innerHTML = "* Required. Email doesn't match with current user";
		document.getElementById("confirm_email_valid").className = 'fieldNotValid';		
		return false;
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////

function confirmStay(roomid, htlId, totalPrice){
	var pageToSendTo = 'confirmation_pg.php?';
	var room = 'room=' + roomid;
	var hotelStay = 'htl=' + htlId;
	var price = 'totPrice=' + totalPrice;

	location.href = pageToSendTo + room + '&' + hotelStay + '&' + price;	
}

function confirmStayButNotLoggedIn(roomid, htlId, totalPrice){
	var pageToSendTo = 'login_pg.php?';
	var room = 'room=' + roomid;
	var hotelStay = 'htl=' + htlId;
	var price = 'totPrice=' + totalPrice;
	var loggedInAfterReserve = 'loggedInAfterReserve=' + true;

	location.href = pageToSendTo + room + '&' + hotelStay + '&' + price + '&' + loggedInAfterReserve;	
}