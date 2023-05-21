<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nav;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Company;
use App\Http\Controllers\People;
use App\Http\Controllers\Ticket;
use App\Http\Controllers\Contact;
use App\Http\Controllers\Logs;
use App\Http\Controllers\Organizations;
use App\Http\Controllers\Contracts;
use App\Http\Controllers\Invoices;
use App\Http\Controllers\Payment;

/* LOGIN */
Route::get('/', [Authentication::class, 'returnLogin'])->name('login');
Route::get('/login', [Authentication::class, 'returnLogin']);
Route::post('/newLogin', [Authentication::class, 'login'])->name('newLogin');

/* RECOVER PASSWORD */
Route::post('/recoverPassword', [Authentication::class, 'returnRecoverPassword'])->name('recoverPassword');
Route::post('/recoverPassword/sendemail', [Authentication::class, 'sendEmailRecoverPassword'])->name('sendEmailRecoverPassword');
Route::get('/newPassword', [Authentication::class, 'newPassword'])->name('newPassword');
Route::post('/setNewPassword', [Authentication::class, 'setNewPassword'])->name('setNewPassword');

/* NEW USER */
Route::get('/newUser', [Authentication::class, 'newUser'])->name('newUser');
Route::post('/createCredentials', [Authentication::class, 'createCredentials'])->name('createCredentials');

Route::group(['middleware' => 'prevent-back-history'], function() {

    /* Nav */
    Route::get('/indexapp', [Nav::class, 'indexApp'])->name('app');
    Route::post('/getNotifications', [Nav::class, 'getNotifications'])->name('getNotifications');


    /******************************************           DASHBOARD              ***********************************************************/

    Route::post('/dashboard', [Nav::class, 'dashboard'])->name('dashboard');
    Route::post('/defaultPaymentMethod', [Payment::class, 'defaultPaymentMethod'])->name('defaultPaymentMethod');
    Route::post('/getOrderChartData', [Contact::class, 'getOrderChartData'])->name('getOrderChartData');
    Route::post('/getUnpaidInvoices', [Invoices::class, 'getUnpaidInvoicesDT'])->name('getUnpaidInvoices');
    Route::post('/getNewTicket', [Ticket::class, 'getNewTicketDT'])->name('getNewTicket');
    Route::post('/getChartBillData', [Invoices::class, 'getChartBillData'])->name('getChartBillData');

    /******************************************           SECTION TICKET              ******************************************************/

    Route::post('/ticket', [Nav::class, 'ticket'])->name('ticket');
    Route::post('/ticketDataTableOpen', [Ticket::class, 'ticketServerSideProcessingDataTableOpen'])->name('ticketDataTableOpen');
    Route::post('/ticketDataTableHistory', [Ticket::class, 'ticketServerSideProcessingDataTableHistory'])->name('ticketDataTableHistory');
    Route::post('/ticketCreate', [Ticket::class, 'modalCreateTicket'])->name('ticketCreate');
    Route::post('/ticketSubmit', [Ticket::class, 'ticketSubmit'])->name('ticketSubmit');
    Route::post('/ticketUploadScreemshot', [Ticket::class, 'ticketUploadScreemshot'])->name('ticketUploadScreemshot');
    Route::post('/ticketSendEmail', [Ticket::class, 'ticketSendEmailAfterCreate'])->name('ticketSendEmail');
    Route::post('/ticketDetail', [Ticket::class, 'ticketDetail'])->name('ticketDetail');
    Route::post('/modalNote', [Ticket::class, 'modalNote'])->name('modalNote');
    Route::post('/saveNote', [Ticket::class, 'saveNote'])->name('saveNote');

    /******************************************           SECTION BILLING              ******************************************************/

    Route::post('/invoices', [Nav::class, 'invoices'])->name('invoices');
    Route::post('/invoicesDataTable', [Invoices::class, 'invoiceServerSideProcessingDataTable'])->name('invoicesDataTable');
    Route::post('/invoiceDetail', [Invoices::class, 'invoiceDetail'])->name('invoiceDetail');

    Route::post('/payments', [Nav::class, 'payments'])->name('payments');
    Route::post('/modalCreatePayment', [Payment::class, 'modalCreatePayment'])->name('modalCreatePayment');
    Route::post('/saveCard', [Payment::class, 'saveCard'])->name('saveCard');
    Route::post('/setDefaultPayment', [Payment::class, 'setDefaultPayment'])->name('setDefaultPayment');

    Route::post('/contracts', [Nav::class, 'contracts'])->name('contracts');
    Route::post('/contractsDataTable', [Contracts::class, 'contractsServerSideProcessingDataTable'])->name('contractsDataTable');
    Route::post('/contractDetail', [Contracts::class, 'contractDetail'])->name('contractDetail');

    /******************************************           SECTION ACCOUNT              ******************************************************/

    Route::post('/profile', [Nav::class, 'profile'])->name('profile');
    Route::post('/editPeople', [People::class, 'returnModalEditPeople'])->name('editPeople');
    Route::post('/updatePersonalInformation', [People::class, 'updatePersonalInformation'])->name('updatePersonalInformation');
    Route::post('/resetPassword', [Contact::class, 'returnModalResetPassword'])->name('resetPassword');
    Route::post('/updatePassword', [Contact::class, 'updatePassword'])->name('updatePassword');
    Route::post('/editCompanyInfo', [Company::class, 'returnModalEditCompanyInfo'])->name('editCompanyInfo');
    Route::post('/editCompanyContactPerson', [Company::class, 'returnModalEditCompanyContactPerson'])->name('editCompanyContactPerson');
    Route::post('/editCompanyBilling', [Company::class, 'returnModalEditCompanyBilling'])->name('editCompanyBilling');
    Route::post('/editCompanyShipping', [Company::class, 'returnModalEditCompanyShipping'])->name('editCompanyShipping');
    Route::post('/updateCompany', [Company::class, 'updateCompany'])->name('updateCompany');

    Route::post('/contacts', [Nav::class, 'contacts'])->name('contacts');
    Route::post('/contactsDataTable', [Contact::class, 'contactsServerSideProcessingDataTable'])->name('contactsDataTable');
    Route::post('/contactCreate', [People::class, 'modalCreatePeople'])->name('contactCreate');
    Route::post('/contactDetail', [People::class, 'peopleDetail'])->name('contactDetail');
    Route::post('/sendInvitation', [Contact::class, 'sendInvitation'])->name('sendInvitation');
    Route::post('/activeInactiveUser', [Contact::class, 'activeInactiveUser'])->name('activeInactiveUser');
    Route::post('/actionAdminSwitch', [Contact::class, 'actionAdminSwitch'])->name('actionAdminSwitch');
    Route::post('/createPeople', [People::class, 'createPeople'])->name('createPeople');
    Route::post('/updatePeople', [People::class, 'updatePeople'])->name('updatePeople');

    /******************************************           SECTION API              ******************************************************/

    Route::post('/settings', [Nav::class, 'settings'])->name('settings');
    Route::post('/requestApiAccess', [Ticket::class, 'requestApiAccess'])->name('requestApiAccess');
    Route::post('/getContentConfigApi', [Nav::class, 'getContentConfigApi'])->name('getContentConfigApi');
    Route::post('/generateOrganizationsKeys', [Organizations::class, 'generateOrganizationsKeys'])->name('generateOrganizationsKeys');
    Route::post('/updateCredentials', [Organizations::class, 'updateCredentials'])->name('updateCredentials');
    Route::post('/getToken', [Organizations::class, 'getToken'])->name('getToken');
    Route::post('/tokensDataTable', [Organizations::class, 'tokensServerSideProcessingDataTable'])->name('tokensDataTable');
    Route::post('/revokeToken', [Organizations::class, 'revokeToken'])->name('revokeToken');

    Route::post('/logs', [Nav::class, 'logs'])->name('logs');
    Route::post('/logsList', [Logs::class, 'logsList'])->name('logsList');
    Route::post('/logsDataTable', [Logs::class, 'logsServerSideProcessingDataTable'])->name('logsDataTable');
    Route::post('/logDetail', [Logs::class, 'logDetail'])->name('logDetail');
    Route::get('/logDetailNewTab/{logRecordId}', [Logs::class, 'logDetailNewTab'])->name('logDetailNewTab');

});

/* LOGOUT */
Route::get('/logOut', [Nav::class, 'logOut'])->name('logOut');
