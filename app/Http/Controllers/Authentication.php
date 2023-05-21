<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use App\Mail\RecoverPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authentication extends BaseController
{
    public $fm;

    public function __construct()
    {
        # OBJ MODEL FM
        $this->fm = new RestFM;
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

    public function returnLogin(Request $request)
    {
        Auth::logout();

        # CLEAR SESSION
        $request->session()->put('status', 0);
        $request->session()->put('recordID', '');
        $request->session()->put('user', '');
        $request->session()->put('type', '');

        $request->session()->invalidate();
        $request->session()->regenerate();

        return view('authentication.index');
    }

    public function returnRecoverPassword()
    {
        return view('authentication.recoverPassword.mainRecoverPassword');
    }

    public function login(Request $request)
    {
        $formData = $request->input('post');

        $result = $this->verifyCredentials($formData['user'], $formData['password']);

        if($result['error'] === 0) // SUCCESS AUTHENTICATION
        {
            # CREATE SESSION
            $request->session()->put('status', 1);
            $request->session()->put('recordID', $result['data'][0]['recordID']);
            $request->session()->put('contactID', $result['data'][0]['contactID']);
            $request->session()->put('companyID', $result['data'][0]['companyID']);
            $request->session()->put('peopleID', $result['data'][0]['peopleID']);
            $request->session()->put('qboID', $result['data'][0]['qboID']);
            $request->session()->put('staffID', $result['data'][0]['staffID']);
            $request->session()->put('NCPDP', $result['data'][0]['NCPDP']);
            $request->session()->put('organizationsRecordID', $result['data'][0]['organizationsRecordID']);
            $request->session()->put('organizationsID', $result['data'][0]['organizationsID']);
            $request->session()->put('user', $result['data'][0]['user']);
            $request->session()->put('type', $result['data'][0]['type']);
            $request->session()->put('accessAPI', $result['data'][0]['accessAPI']);
            $request->session()->put('role', $result['data'][0]['role']);

            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Welcome!';
            $response['devMsg'] = 'Success authentication';
            $response['token'] = $_SESSION['fmtoken1'];

            return json_encode($response);
        }
        else // FAIL
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = $result['msg'];
            $response['devMsg'] = $result;

            return json_encode($response);
        }
    }

    public function verifyCredentials($user, $password)
    {
        $request = array();
        $request['WebPortal_Username'] = "==". $user;

        $query = array($request);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0) // SUCCESS
        {
            if(password_verify($password , $result ['response']['data'][0]['fieldData']['WebPortal_Password']))
            {
                if($result['response']['data'][0]['fieldData']['WebPortal_isActive'] == 1) // ACTIVE
                {
                    $record = array();
                    $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
                    $record['contactID'] = (string)$result['response']['data'][0]['fieldData']['__kp_CONTACT_ID'];
                    $record['companyID'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::__kp_COMPANY_ID'];
                    $record['peopleID'] = (string)$result['response']['data'][0]['fieldData']['_kf_PEOPLE_ID'];
                    $record['qboID'] = (string)$result['response']['data'][0]['fieldData']['_kf_QBO_ID'];
                    $record['staffID'] = (string)$result['response']['data'][0]['fieldData']['_kf_STAFF_ID'];
                    $record['NCPDP'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::NCPDP'];
                    $record['organizationsRecordID'] = (string)$result['response']['data'][0]['fieldData']['Organizations::recordID'];
                    $record['organizationsID'] = (string)$result['response']['data'][0]['fieldData']['Organizations::OrganizationID'];
                    $record['user'] = (string)$user;
                    $record['status'] = (string)$result['response']['data'][0]['fieldData']['WebPortal_isActive'];
                    $record['type'] = (string)$result['response']['data'][0]['fieldData']['Type'];
                    $record['accessAPI'] = (string)$result['response']['data'][0]['fieldData']['Organizations::accessAPI'];

                    if($result['response']['data'][0]['fieldData']['PHP_People::IsMainContact'] == 1)
                        $record['role'] = 'admin';
                    else
                        $record['role'] = 'user';

                    $records = array();
                    $records[0] = $record;

                    $return = array();
                    $return['error'] = 0;
                    $return['data'] = $records;

                    return $return;
                }
                else // INACTIVE
                {
                    $return = array();
                    $return['error'] = 1;
                    $return['msg'] = 'User inactive';
                    $return['metod'] = '';
                    $return['fmError'] = '';

                    return $return;
                }
            }
            else
            {
                $return = array();
                $return['error'] = 1;
                $return['msg'] = 'Invalid password';
                $return['metod'] = '';
                $return['fmError'] = '';

                return $return;
            }
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'User not found';
            $return['metod'] = '';
            $return['fmError'] = '';

            return $return;
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'verifyCredentials';
            $return['fmError'] = $this->error($result);
            $return['token'] = $_SESSION['fmtoken1'];

            return $return;
        }
    }

    public function sendEmailRecoverPassword(Request $request)
    {
        $formData = $request->input('post');

        $result = $this->verifyEmailExistInDB($formData['email']);

        if($result['error'] === 0)
        {
            $recordID = $result['data'][0]['recordID'];

            $fieldData = array();
            $fieldData['WebPortal_PasswordTemp'] = md5(uniqid());

            $data = array();
            $data['fieldData'] = $fieldData;

            $resultSetPasswordTemp = $this->fm->editRecord($recordID, $data, 'PHP_Contacts');

            if($this->error($resultSetPasswordTemp) === 0)
            {
                $link = route('newPassword').'?token='.$fieldData['WebPortal_PasswordTemp'];
                Mail::to($formData['email'])->send(new RecoverPasswordMail($link));

                $response = array();
                $response['error'] = 0;
                $response['userMsg'] = 'Go to your email to continue with the recovery process';
                $response['devMsg'] = 'success';

                return json_encode($response);
            }
            else
            {
                $response = array();
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'resultSetPasswordTemp';
                $response['devMsg'] = $resultSetPasswordTemp;

                return json_encode($response);
            }
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = $result['msg'];
            $response['devMsg'] = $result;

            return json_encode($response);
        }
    }

    public function verifyEmailExistInDB($email)
    {
        $request = array();
        $request['PHP_People::Email'] = "==". $email;

        $query = array($request);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0) // SUCCESS
        {
            if($result['response']['data'][0]['fieldData']['WebPortal_isActive'] == 1) // USER ACTIVE
            {
                $record = array();
                $record['recordID'] = $result['response']['data'][0]['fieldData']['RecordID'];

                $records = array();
                $records[0] = $record;

                $return = array();
                $return['error'] = 0;
                $return['data'] = $records;

                return $return;
            }
            else // INACTIVE
            {
                $return = array();
                $return['error'] = 1;
                $return['msg'] = 'User inactive';

                return $return;
            }
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'Email not found';

            return $return;
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'verifyEmailExistInDB';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function newPassword(Request $request)
    {
        if(empty($request->input('token')))
        {
            $data = array();
            $data['msg'] = "Opps, token not found in url";

            return view('error.template', $data);
        }

        $contact = $this->getContactByToken($request->input('token'));

        if($contact['error'] === 0)
        {
            $fieldData = array();
            $fieldData['WebPortal_PasswordTemp'] = '';

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->editRecord($contact['data'][0]['recordID'], $data, 'PHP_Contacts');

            if($this->error($result) === 0)
                return view('authentication.recoverPassword.mainResetPassword', $contact['data'][0]);
            else
            {
                $data = array();
                $data['msg'] = 'An error has ocurred';

                return view('error.template', $data);
            }
        }
        else
        {
            $data = array();
            $data['msg'] = $contact['msg'];

            return view('error.template', $data);
        }
    }

    public function setNewPassword(Request $request)
    {
        $formData = $request->input('post');

        $fieldData = array();
        $fieldData['WebPortal_Password'] = password_hash($formData['password'], PASSWORD_DEFAULT);

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm->editRecord($formData['recordID'], $data, 'PHP_Contacts');

        if($this->error($result) === 0)
        {
            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Your password has been successfully updated.';

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'setNewPassword';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    public function newUser(Request $request)
    {
        if(empty($request->input('token')))
        {
            $data = array();
            $data['msg'] = "Opps, token not found in url";

            return view('error.template', $data);
        }

        $contact = $this->getContactByToken($request->input('token'));

        if($contact['error'] === 0)
        {
            $fieldData = array();
            $fieldData['WebPortal_PasswordTemp'] = '';

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->editRecord($contact['data'][0]['recordID'], $data, 'PHP_Contacts');

            if($this->error($result) === 0)
            {
                $dataView = array();
                $dataView['contactRecordID'] = $contact['data'][0]['recordID'];
                $dataView['people'] = $contact['data'][0]['peopleFullName'];

                return view('authentication.newUser.mainNewUser', $dataView);
            }
            else
            {
                $data = array();
                $data['msg'] = 'An error has ocurred';

                return view('error.template', $data);
            }
        }
        else
        {
            $data = array();
            $data['msg'] = $contact['msg'];

            return view('error.template', $data);
        }
    }

    public function createCredentials(Request $request)
    {
        $response = array();
        $formData = $request->input('post');

        $verifyUserName = $this->verifyUserName($formData['user']);

        if($verifyUserName['error'] == 0)
        {
            $fieldData = array();
            $fieldData['WebPortal_Username'] = $formData['user'];
            $fieldData['WebPortal_Password'] = password_hash($formData['password'], PASSWORD_DEFAULT);
            $fieldData['WebPortal_isActive'] = 1;
            $fieldData['WebPortal_PasswordTemp'] = '';

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->editRecord($formData['contactRecordID'], $data, 'PHP_Contacts');

            if($this->error($result) === 0)
            {
                $response['error'] = 0;
                $response['userMsg'] = 'Credentials created successfully';

                return json_encode($response);
            }
            else
            {
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'createCredentials';
                $response['fmError'] = $this->error($result);

                return json_encode($response);
            }
        }
        else
        {
            $response['error'] = 1;
            $response['userMsg'] = $verifyUserName['msg'];
            $response['method'] = 'createCredentials';
            $response['errorDetail'] = $verifyUserName;

            return json_encode($response);
        }
    }

    public function getContactByToken($token)
    {
        $request = array();
        $request['WebPortal_PasswordTemp'] = "==". $token;

        $query = array($request);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0) // SUCCESS
        {
            $record = array();
            $record['recordID'] = $result['response']['data'][0]['fieldData']['RecordID'];
            $record['peopleFullName'] = $result['response']['data'][0]['fieldData']['PHP_People::NameFull'];
            $record['status'] = $result['response']['data'][0]['fieldData']['WebPortal_isActive'];

            $records = array();
            $records[0] = $record;

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

            return $return;
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'Token Expired';

            return $return;
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getContactByToken';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function verifyUserName($user)
    {
        $request = array();
        $request['WebPortal_Username'] = "==". $user;

        $query = array($request);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0) // SUCCESS
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'It username already exists';

            return $return;
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND
        {
            $return = array();
            $return['error'] = 0;
            $return['msg'] = 'Success';
            return $return;
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'verifyUserName';
            $return['fmError'] = $this->error($result);

            return $return;
        }

    }
}
