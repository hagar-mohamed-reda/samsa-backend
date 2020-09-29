<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>ايصال رقم {{ $payment->id }}</title>
</head>
<body>
    <div style="width: 100%;direction: rtl!important;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"  >
    <table  style="width: 100%;text-align: center" >
        <tr>
            <td style="width: 50%" >
                <div style="text-align: center;font-size: 18px" >
                    <b>وزارة التعليم العالى</b>
                    <br>
                    <b>المعهد العالى للعلوم الادراية</b>
                    <br>
                    <b>ببنى سويف</b>
                </div>
            </td>
            <td style="width: 50%" >
            <img src="{{ url('/logo.png') }}" width="80px" alt=""> 
            </td>
        </tr>
    </table> 
    <div style="padding: 20px" >
            <div style="width: 100%;border-bottom: 2px dashed black;margin: auto" ></div>
            <br>
            <div style="width: 100%;text-align: center" >
                <b style="font-size: 16px" >رقم القسيمة</b>
             
              {{ $payment->id }}
            </div> 
            <table  style="width: 100%;" >
                <td style="width: 50%" >
                    <table  style="width: 100%;" >
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                               <b>تاريخ السداد :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                                {{ $payment->date }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                               <b>وصلنــــا من :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                                {{ optional($payment->student)->name }}
                            </td>
                        </tr> 
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                                <b>المستــــــوى :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                                {{ optional(optional($payment->student)->level)->name }}
                            </td>
                        </tr> 
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                               <b>مبلـغ وقــدره :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                               {{ number_format($payment->value) }} جنيه
                            </td>
                        </tr> 
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                              <b>ســــــداد عن :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                               {{ optional($payment->model_object)->name }}  
                            </td>
                        </tr> 
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                                <b>ملاحظــــات :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                               {{ "" }}  
                            </td>
                        </tr> 
                    </table>
                </td>
                <td style="width: 50%" >
                        <table  style="width: 100%;" > 
                            <tr >
                                <td colspan="2" style="width: 40%;padding: 5px" >
                                <div style="text-align: center" >
                                    <b>المبلغ</b>
                                    <br>
                                    {{ number_format($payment->value) }} جنيه
                                </div>
                                </td> 
                            </tr> 
                            <tr>
                                <td style="width: 40%;padding: 5px" >
                                <b>الكــود :</b>
                                </td>
                                <td style="width: 60%;padding: 5px" >
                                 {{ optional($payment->student)->code }}
                                </td>
                            </tr> 
                            <tr>
                                <td style="width: 40%;padding: 5px" >
                                    <b>الشعبه :</b>
                                </td>
                                <td style="width: 60%;padding: 5px" >
                                   {{ optional(optional($payment->student)->division)->name }}
                                </td>
                            </tr> 
                        </table>
                </td>
            </table>
            <br> 
            <table  style="width: 100%;" >
                <tr>
                    <td style="width: 50%" ></td>
                    <td style="width: 50%;text-align: center";padding: 5px >
                            <div style="text-align: center" >
                                <b>الخزنية</b>
                                <br>
                                {{ optional($payment->store)->name }}
                            </div>
                    </td>
                </tr>
            </table>
    </div>
</div>
</body>
</html>