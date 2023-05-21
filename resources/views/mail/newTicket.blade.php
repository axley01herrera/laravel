<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Si Client</title>
    </head>
    <body style="margin:0px; background: #f8f8f8; ">
        <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
            <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="background:#038edc; color:#fff; text-align:center;">
                            <p style="font-size: 20px"><strong>{{ $emailData['title'] }}</strong></p>
                        </td>
                    </tr>
                </tbody>
                </table>
                <div style="padding: 40px; background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tbody>
                    <tr>
                        <td>
                            <p>
                                <strong>Ticket #:</strong> {{ $emailData['number'] }}
                            </p>
                            <p>
                                <strong>Description:</strong>
                                <br>
                                {{ $emailData['description'] }}
                            </p>
                            <p>
                                <strong>Contact:</strong><br>

                                @if (!empty($emailData['companyID']))
                                    Company Name: {{ $emailData['contact']['companyName'] }} <br>
                                @endif

                                @if (!empty($emailData['peopleID']))
                                    Person: {{ $emailData['contact']['peopleNameFullTitle'] }} <br>
                                    Email: {{ $emailData['contact']['peopleEmail'] }} <br>
                                    Phone: {{ $emailData['contact']['peoplePhone'] }} <br>
                                @endif                               
                                
                            </p>
                            <p>
                                <strong>Creation Date:</strong> {{ $emailData['creationDate'] }}
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Powered by Isak Computing, LLC</p>
                </div>
            </div>
        </div>
    </body>
</html>