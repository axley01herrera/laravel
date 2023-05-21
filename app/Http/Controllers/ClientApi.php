<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Mail\SendInvitation;
use Illuminate\Support\Facades\Mail;
use App\Models\RestFM;

class ClientApi extends BaseController
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

    public function sendInvitation(Request $request)
    {
        if(empty($request))
        {
            $response = array();
            $response['error'] = 1;
            $response['msg'] = 'Empty request';

            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }
        elseif(empty($request['email']))
        {
            $response = array();
            $response['error'] = 1;
            $response['msg'] = 'Bad request';

            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }

        $people = $this->getPeopleByEmail($request['email']);

        if($people['error'] === 0)
        {
            $contact = $this->getContactByPeopleID($people['data'][0]['peopleID']);

            if($contact['error'] === 0)
            {
                $link = route('newUser').'?token='.$contact['data'][0]['token'];

                Mail::to($request['email'])->send(new SendInvitation($link));

                $response = array();
                $response['error'] = 0;
                $response['msg'] = 'Success send invitation';

                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }
            else
                return response()->json($contact, 200, [], JSON_PRETTY_PRINT);
        }
        else
            return response()->json($people, 200, [], JSON_PRETTY_PRINT);
    }

    public function getPeopleByEmail($email)
    {
        $requestFM = array();
        $requestFM['Email'] = "==". $email;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_People'); // FIND

        if($this->error($result) === 0) // SUCCESS
        {
            $record = array();
            $record['peopleID'] = (string)$result['response']['data'][0]['fieldData']['__kp_PEOPLE_ID'];
            $record['name'] = (string)$result['response']['data'][0]['fieldData']['NameFirst'];
            $record['lastName'] = (string)$result['response']['data'][0]['fieldData']['NameLast'];

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
            $return['msg'] = 'People not found';

            return $return;
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getPeopleByEmail';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function getContactByPeopleID($peopleID)
    {
        $requestFM = array();
        $requestFM['_kf_PEOPLE_ID'] = "==". $peopleID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts'); // FIND

        if($this->error($result) === 0) // SUCCESS IS RESEND INVITATION UPDATE TOKEN
        {
            $fieldData = array();
            $fieldData['WebPortal_PasswordTemp'] = md5($peopleID.uniqid());

            $data = array();
            $data['fieldData'] = $fieldData;

            $updateContact = $this->fm->editRecord($result['response']['data'][0]['fieldData']['RecordID'], $data, 'PHP_Contacts');

            if($this->error($updateContact) === 0)
            {
                $record = array();
                $record['token'] = $fieldData['WebPortal_PasswordTemp'];

                $records = array();
                $records[0] = $record;

                $return = array();
                $return['error'] = 0;
                $return['data'] = $records;

                return $return;
            }
            else
            {
                $return = array();
                $return['error'] = 1;
                $return['msg'] = 'An error has ocurred';
                $return['metod'] = 'updateContact in getContactByPeopleID';
                $return['fmError'] = $this->error($updateContact);

                return $return;
            }
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND IS FIRST INVITATION CREATE CONTACT AND INSERT TOKEN
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'Contact not found';

            $fieldData = array();
            $fieldData['_kf_PEOPLE_ID'] = $peopleID;
            $fieldData['WebPortal_PasswordTemp'] = md5($peopleID.uniqid());

            $data = array();
            $data['fieldData'] = $fieldData;

            $createContact = $this->fm->createRecord($data, 'PHP_Contacts');

            if($this->error($createContact) === 0)
            {
                $record = array();
                $record['token'] = $fieldData['WebPortal_PasswordTemp'];

                $records = array();
                $records[0] = $record;

                $return = array();
                $return['error'] = 0;
                $return['data'] = $records;

                return $return;
            }
            else
            {
                $return = array();
                $return['error'] = 1;
                $return['msg'] = 'An error has ocurred';
                $return['metod'] = 'createContact in getContactByPeopleID';
                $return['fmError'] = $this->error($createContact);

                return $return;
            }
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getContactByPeopleID';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    // ONLY TO DEV

    public function getLayout()
    {
        /* $request = array();
         $request['recordID'] = "*";  // PHP_Contacts

        /* $request = array();
         $request['RecordID'] = "*"; */ // PHP_ValueList

        /* $request = array();
         $request['RecordID'] = "*"; */ // $layout = 'PHP_Tickets';

        /* $request = array();
         $request['__kp_DOCUMENT_ID'] = "*"; */ // $layout = 'PHP_Documents';

        /* $request = array();
         $request['Type'] = "*"; */ // $layout = 'PHP_People';

        /* $request = array();
         $request['__kp_COMPANY_ID'] = "*"; */ // $layout = 'PHP_Company';

        /* $request = array();
         $request['CreatedBy'] = "*"; */ // PHP_OrganizationLogs

        /* $request = array();
         $request['InvoiceNumber'] = "=11179"; */ // PHP_Invoice

        /* $request = array();
        $request['_kf_COMPANY_ID'] = "*"; */ // PHP_Company_People

        /* $request = array();
        $request['RecordID'] = "*"; */ // PHP_Payment_Methods

        /* $request = array();
        $request['RecordID'] = "*"; */ // PHP_Time

        $request = array();
        $request['__kp_CUSTCONTRACT_ID'] = "*";  // PHP_Contracts

        $query = array($request);

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['limit'] = 1;

        // $layout = 'PHP_Contacts';
        // $layout = 'PHP_ValueList';
        // $layout = 'PHP_Tickets';
        // $layout = 'PHP_Documents';
        // $layout = 'PHP_People';
        // $layout = 'PHP_Company';
        // $layout = 'PHP_OrganizationLogs';
        // $layout = 'PHP_Invoice';
        // $layout = 'PHP_Company_People';
        // $layout = 'PHP_Payment_Methods';
        // $layout = 'PHP_Time';
        $layout = 'PHP_Contracts';

        $result = $this->fm->findRecords($criteria, $layout);

        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    }

    public function deleteRecord(Request $request)
    {
        $formData = $request->input();

        for($i = 0; $i < 10 ; $i++) {
            $result = $this->fm->deleteRecord($i, 'PHP_Payment_Methods');
        }

        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    }

    public function updateUserTest()
    {
        $fieldData['PHP_People::Email'] = 'do.not.reply.the.msg@gmail.com';
        $data['fieldData'] = $fieldData;

        $result = $this->fm->editRecord('1055', $data, 'PHP_Contacts');

        return response()->json($result, 200, [], JSON_PRETTY_PRINT);
    }
}
