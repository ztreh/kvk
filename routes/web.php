<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/', 'HomeController@index')->name('home');  
    Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('salarymonth', 'SalaryMonthController');
	Route::resource('holiday', 'HolidayController');
	Route::resource('designation', 'DesignationController');
	Route::resource('employee', 'EmployeeController');
	Route::resource('leave', 'LeaveController');
	Route::resource('attendance', 'AttendanceController');
	Route::resource('commision', 'CommissionController');
	Route::resource('servicecommision', 'ServiceCenterController');
	Route::resource('labour', 'LabourController');
	Route::resource('workplace', 'WorkPlaceController');
	Route::resource('device', 'DeviceController');

	Route::get('serviceCenterCreate', 'CommissionController@serviceCenterCreate');
	Route::get('getEmployeeNames', 'CommissionController@getEmployeeNames');
	Route::get('getCategoryNames', 'CommissionController@getCategoryNames');
	Route::resource('advance', 'AdvanceController');
	Route::resource('loan', 'LoanController');
	Route::post('/employeeImageUpload', 'EmployeeController@uploadImage');
	Route::post('/employeeimagedel', 'EmployeeController@employeeImageDelete');
	Route::get('/searchempname', 'AutocompleteController@searchEmpName');    
	Route::get('/workpalces', 'AutocompleteController@getWorkPlaceList');    
	Route::get('/emplist', 'AutocompleteController@getEmployeeNameList');    
	Route::get('/deslist', 'AutocompleteController@getDesignationList');    
	Route::get('/salmonthlist', 'AutocompleteController@salaryMonthList');    
	
	Route::get('/viewfreelanceslips', 'SlipController@viewFreelancePaySlips');    
	Route::post('/viewfreelanceslips', 'SlipController@viewFreelancePaySlips');    
	
	Route::get('/viewepfreport', 'SlipController@viewEPFPayReport');    
	Route::post('/viewepfreport', 'SlipController@viewEPFPayReport');    
	
	Route::get('/viewslips', 'SlipController@viewPaySlips');    
	Route::post('/viewslips', 'SlipController@viewPaySlips');    
	
	Route::get('/viewepfslips', 'SlipController@viewEPFPaySlips');    
   
	Route::get('/printslip/{employeeid}/{salarymonthid}', 'SlipController@printSlips');    
	Route::post('/viewepfslips', 'SlipController@viewEPFPaySlips');    
	
	
	Route::get('/viewattendance', 'AttendanceController@viewAttendance');  
	Route::post('/viewattendance', 'AttendanceController@viewAttendance');  
	Route::post('/addattendance', 'AttendanceController@addManualEntry');  
	
	Route::post('/addslipfeatures', 'SlipController@addSlipFeatures');  
	
	
	Route::get('/epfetfreport', 'ReportController@epfEtfReport');
	Route::post('/epfetfreport', 'ReportController@epfEtfReport');
	
	Route::get('/freelancepayreport', 'ReportController@freelancePaymentReport');
	Route::post('/freelancepayreport', 'ReportController@freelancePaymentReport');
	
	Route::get('/advancepayreport', 'ReportController@advancePaymentReport');
	Route::post('/advancepayreport', 'ReportController@advancePaymentReport');
	
	Route::get('/attendancereport', 'ReportController@attendanceSummaryReport');
	Route::post('/attendancereport', 'ReportController@attendanceSummaryReport');
	
	Route::get('/leavereport', 'ReportController@leaveSummaryReport');
	Route::get('/loanreport', 'ReportController@loanSummaryReport');
	
	Route::get('/monthlysalaryreport', 'ReportController@monthlySalarySummaryReport');
	Route::post('/monthlysalaryreport', 'ReportController@monthlySalarySummaryReport');
	
	Route::get('/editslip/{empid}/{salid}', 'SlipController@editSlip');
	Route::get('/markpaid/{empid}/{salid}/{ispaid}', 'SlipController@markPaidSlip');
	Route::post('/editloanpay/{empid}/{salid}', 'SlipController@editLoanPay');
	Route::get('/deletefeature/{empid}/{salid}/{featureid}', 'SlipController@deleteSlipFeature');

	Route::get('/loanaccount', 'LoanController@loanAccount');
	Route::get('/loanpaylist', 'LoanController@loanPaymentList');
	Route::delete('/loanpaydelete/{id}', 'LoanController@deletePayment');
	
	Route::get('/welfareaccount', 'WelfareController@welfareAccount');
	Route::get('/welfarepaylist', 'WelfareController@welfarePaymentList');
	Route::post('/welfarepaydelete/{id}', 'WelfareController@deletePayment');
	
	Route::post('/addloancreditdebit', 'LoanController@addLoanCreditDebit');  
	
	Route::post('/addwelfarecreditdebit', 'WelfareController@addWelfareCreditDebit');
    

});