<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\People;
use App\Http\Controllers\Contact;
use App\Http\Controllers\Company;
use App\Http\Controllers\Invoices;
use App\Http\Controllers\Payment;

class Nav extends BaseController
{
    public $fm;
    public $peopleController;
    public $contactController;
    public $companyController;

    public function __construct()
    {
        # OBJ MODELS
        $this->fm = new RestFM;

        # OBJ CONTROLLERS
        $this->peopleController = new People;
        $this->contactController = new Contact;
        $this->companyController = new Company;
    }

    public function error($result)
    {
        if(isset($result["messages"][0]["code"]))
        {

            if ($result["messages"][0]["code"] == 0)
                return 0;
            elseif($result["messages"][0]["code"] == '401')
                return 401;
            else
                return '('.$result["messages"][0]["code"].') '.$result["messages"][0]["message"];
        }
        else
            return $result;
    }

    public function indexApp()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return redirect(route('login'));

        return view('app.index');
    }

    public function getNotifications()
    {
        $invoiceController = new Invoices;
        $data = array();
        $unpaidInvoices['data'] = array();

        if(session('role') == 'admin')
        {
            $unpaidInvoices = $invoiceController->getUnpaidInvoices();

            if($unpaidInvoices['error'] <> 0)
            {
                $data['error'] = json_encode($unpaidInvoices);
                return view('app.errorLoadContent', $data);
            }
        }

        $flag = 0;

        $data['unpaidInvoices'] = $unpaidInvoices['data'];
        $data['countUnpaidInvoices'] = sizeof($unpaidInvoices['data']);

        if($data['countUnpaidInvoices'] > 0)
            $flag = 1;

        $data['flag'] = $flag;

        return view('app.menu.notifications', $data);
    }

    # NAV APP MENU
    public function dashboard()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.dashboard.mainDashboard');
    }

    public function ticket()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');
        if($resultVerifySession == NULL || $resultVerifySession == 0) return view('app.logout');

        return view('app.ticket.mainTicket');
    }

    public function contracts()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.billing.contracts.mainContracts');
    }

    public function invoices()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.billing.invoices.mainInvoices');
    }

    public function profile()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');
        if($resultVerifySession == NULL || $resultVerifySession == 0) return view('app.logout');

        $data = array();
        $data['people'] = array();
        $data['contact'] = array();
        $data['company'] = array();

        if(!empty(session('peopleID')))
        {
            $people = $this->peopleController->getPeople();

            if($people['error'] <> 0)
            {
                $data = array();
                $data['error'] = json_encode($people);

                return view('app.errorLoadContent', $data);
            }

            $data['people'] = $people['data'][0];
        }

        if(!empty(session('contactID')))
        {
            $contact = $this->contactController->getContact();

            if($contact['error'] <> 0)
            {
                $data = array();
                $data['error'] = json_encode($contact);

                return view('app.errorLoadContent', $data);
            }

            $data['contact'] = $contact['data'][0];
        }

        if(session('role') == 'admin')
        {
            if(!empty(session('companyID')))
            {
                $company = $this->companyController->getCompany();

                if($company['error'] <> 0)
                {
                    $data = array();
                    $data['error'] = json_encode($company);

                    return view('app.errorLoadContent', $data);
                }

                $data['company'] = $company['data'][0];
            }
        }

        return view('app.account.profile.mainProfile', $data);
    }

    public function returnCompanyProfile()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.account.companyProfile.mainCompanyProfile');
    }

    public function logs()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.api.logs.mainLogs');
    }

    public function settings()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.api.settings.mainSettings');
    }

    public function getContentConfigApi()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $contact = $this->contactController->getContact();

        if($contact['error'] <> 0)
        {
            $data = array();
            $data['error'] = json_encode( $contact);

            return view('app.errorLoadContent', $data);
        }

        $data = array();
        $data['contact'] = $contact['data'][0];

        return view('app.api.settings.content', $data);
    }

    public function payments()
    {
        $paymentController = new Payment;

        # VERIFY SESSION
        $resultVerifySession = session('status');
        if($resultVerifySession == NULL || $resultVerifySession == 0) return view('app.logout');

        $data = array();

        $payments = $paymentController->getPayments();

        if($payments['error'] <> 0)
        {
            $data['error'] = json_encode($payments);
            return view('app.errorLoadContent', $data);
        }

        $data['payments'] = $payments['data'];
        $data['countPayments'] = sizeof($payments['data']);

        return view('app.billing.payment.mainPayment', $data);
    }

    public function contacts()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        return view('app.account.contacts.mainContacts');
    }

    public function logOut(Request $request)
    {
        Auth::logout();

        # CLEAR SESSION
        $request->session()->put('status', 0);
        $request->session()->put('recordID', '');
        $request->session()->put('user', '');
        $request->session()->put('type', '');

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect(route('login'));
    }

}
