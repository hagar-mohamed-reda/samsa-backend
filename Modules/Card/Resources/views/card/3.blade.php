<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> </title>
</head>
<body style="margin: 0px;padding: 0px;background-image: url({{ url('/footer.png')  }});background-size: 100%;background-position: bottom;background-repeat: no-repeat;" >
    <div style="width: 100%;direction: rtl!important;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;padding: 5px"  >
       
        <table style="width: 100%"  >
            <tr style="width: 100%" >
                <td  style="position: relative;color: darkblue;width: 50%" >
                    <b style="position: absolute;top: 10%;right: 0px;font-size: 14px" >وزارة التعليم العالى </b>
                    <img src="{{ url('/logo.png') }}"  alt="" style="margin-right: 116px;width: 54px" >
                </td>

                <td style="width: 50%">
                    <div style="text-align: center;color: orange;font-size: 12px"  >
                        <b>المعهد العالى للعلوم الأدارية</b><br>
                        <b>ببنى سويف</b>
                    </div>
                </td>
            </tr>
        </table>

        <div style="position: relative;content: "";display: table;clear: both;"  >
            <div style="width: 75%;float: right" >
                <div style="text-align: center;color: green;font-size: 14px" >
                        <b>Higher Institude of Management</b> <br>
                        <b>Sciences</b>
                    </div>

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

            <div style="width: 25%;float: right;text-align: center" >
                <img src="{{ $student->personal_photo_url }}" style="width: 95%;height: 105px" >
                <br>
                <div style="text-align: center;font-size: 14px" >
                    <b>عميد الكلية</b>
                </div>
                <div style="text-align: center;" >
                    <img src="{{ url('/signiture.png') }}" style="width: 60px;margin: auto" >
                </div>
                <div style="text-align: center;font-size: 10px" >
                    <b>أ.د/احمد ابو القمصان</b>
                </div>
            </div>
        </div>
         

        
    </div>

    <script type="text/javascript" src="{{ url('/js/jquery-3.2.1.min.js') }}" ></script>

    <script type="text/javascript">

        window.print();
    </script>
</body>
</html>
