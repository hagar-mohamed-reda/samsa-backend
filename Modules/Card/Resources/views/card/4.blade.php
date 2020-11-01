<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> </title>
</head>
<body style="margin: 0px;padding: 0px;" >
    
    <div style="width: 50%;direction: rtl!important;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;padding: 5px;background-image: url({{ url('/footer.png')  }});background-size: 100%;background-position: bottom;background-repeat: no-repeat;height: 250px"  >
       
         <table style="width: 100%"  >
                    <tr style="width: 100%" >
                        <td  style="position: relative;color: darkblue;width: 50%" >
                            <table style="width: 100%" >
                                <tr style="width: 100%" >
                                    <td style="width: 10%" >
                                        <img src="{{ url('/logo.png') }}"  alt="" style="width: 55px" >
                                    </td>
                                    <td style="width: 50%" >
                                        <span style="text-align: right;color: orange;font-size: 12px"  >
                                            <b>المعهد العالى للعلوم الأدارية</b><br>
                                            <b>ببنى سويف</b>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            
                            
                        </td>

                        <td style="width: 50%;text-align: left">
                            <div style="text-align: center;color: orange;font-size: 12px"  >
                                <img src="{{ $student->personal_photo_url }}" style="width: 50px;height: 50px;border-radius: 5em;" >
                            </div>
                        </td>
                    </tr>
                </table>

        <div style="position: relative;content: "";display: table;clear: both;"  >
            <div style="width: 80%;float: right" >
               

                    <table style="width: 100%"  >
                        <tr style="width: 100%" >
                            <td style="color: orange" >
                               <b>الاســــــــم : </b>
                            </td>
                            <td>
                                <div style="font-size: 14px" >{{ $student->name }}</div>
                            </td>
                        </tr>
                         <tr style="width: 100%" >
                            <td style="color: orange" >
                               <b> الشـــعبـة : </b>
                            </td>
                            <td>
                                <div style="font-size: 14px" >{{ optional($student->division)->name }}</div>
                            </td>
                        </tr>
                         <tr style="width: 100%" >
                            <td style="color: orange" >
                               <b> المستوي : </b>
                            </td>
                            <td>
                                <div style="font-size: 14px" >{{ optional($student->level)->name }}</div>
                            </td>
                        </tr>
                         <tr style="width: 100%" >
                            <td style="color: orange" >
                               <b> الـــــكــــود : </b>
                            </td>
                            <td>
                                <div style="font-size: 14px" >{{ $student->code }}</div>
                            </td>
                        </tr>
                    </table>
                <div style="text-align: center;font-size: 14px" >
                    <b>الفصل الدراسى الاول</b>
                </div>
            </div>

            <div style="width: 20%;float: right;text-align: center" >
                 
                <div style="margin: auto;margin-top: 30%" id="qrcodePlace" >
                    
                </div>
            </div>
        </div>
         

        
    </div>

    <script type="text/javascript" src="{{ url('/js/jquery-3.2.1.min.js') }}" ></script>

    <script type="text/javascript" src="{{ url('/js/qrcode.min.js') }}" ></script>
    <script type="text/javascript">
        var qrcode = new QRCode("qrcodePlace", {
            text: "{{ $student->national_id }}",
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
