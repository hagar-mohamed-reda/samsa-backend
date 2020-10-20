<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> طلب الحصول على خصم رقم {{ $resource->id }}</title>
</head>
<body>
    <div style="width: 100%;direction: rtl!important;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;border: 1px dashed gray"  >
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
        <div style="width: 100%;border-bottom: 2px solid black;margin: auto" ></div>
                <br>
                <div style="width: 100%;text-align: center" >
                    <b style="font-size: 16px" >طلب الحصول على خصم رقم </b>
                    <span id="resourceId" >{{ $resource->id }}</span>
                </div>
                <br>
                <div style="text-align: right;" >
                    <div>السيد الاستاذ / رئيس مجلس الادارة</div>

                    <div style="text-align: center;" >تحية طيبة وبعد....</div>
                    <br>
                    <div>ارجو من سيادتكم التفضل بالموافقة على اعفائى من جزء من الرسوم الدراسية المقررة حيث اننى</div>

                    <div>
                        <table  style="width: 100%;" >
                            <tr>
                                <td>مقيد بالمستوى: <span>{{ optional(optional($resource->student)->level)->name }}</span></td>
                                <td>الشعبة: <span>{{ optional(optional($resource->student)->division)->name }}</span></td>
                                <td>كود: <span>{{ optional($resource->student)->code }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div>وذلك بسبب: <span>{{ $resource->reason }}</span></div>
                    <br>
                    <div>
                        <table  style="width: 100%;" >
                            <tr>
                                <td>مقدم لسيادتكم الطالب: <span>{{ optional($resource->student)->name }}</span></td>
                                <td>الجنسية: <span>{{ optional(optional($resource->student)->nationality)->name }}</span></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div style="text-align: center" >مع قبول وافر التحية</div>

                    <table  style="width: 100%;" >
                        <tr>
                            <td style="width: 33%" ></td>
                            <td style="width: 33%"></td>
                            <td>
                                <div style="text-align: right" >
                                    <div>الاسم: </div>
                                    <div>التوقيع: </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div>

                    </div>
                    <br>

                    <div style="width: 100%;border-bottom: 1px solid gray" ></div>
                    <div>
                        <b style="font-size: 14px;border-bottom: 1px solid black" >شئون الطلاب:</b>
                        <br>

                        <table  style="width: 100%;" >
                            <tr>
                                <td>نوع الخصم: <span>{{ optional($resource->discountType)->name }}</span></td>
                                <td></td>
                                <td>حالة القيد: <span>{{ optional(optional($resource->student)->caseContraint)->name }}</span></td>
                            </tr>
                        </table>
                    </div>

                    <div style="width: 100%;border-bottom: 1px solid gray" ></div>
                    <div>
                        <b style="font-size: 14px;border-bottom: 1px solid black" >البيانات المالية:</b>
                        <br>
                        <span>ملخص موقف الطالب</span>
                        <table  style="width: 100%;border: 1px solid black;border-collapse: collapse;text-align: center" >
                            <tr style="width: 100%;border: 1px solid black;border-collapse: collapse;" >
                                <td style="border: 1px solid black;border-collapse: collapse;">رصيد سابق</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->old_balance }}</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">رسوم حالية</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->current_balance }}</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">اجمالى المطالبة</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->current_balance_total }}</td>
                            </tr>
                            <tr style="width: 100%;border: 1px solid black;border-collapse: collapse;" >
                                <td style="border: 1px solid black;border-collapse: collapse;">اجمالى المسدد</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->paids }}</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">منح وخصومات</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->discount_total }}</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">رصيد الطالب</td>
                                <td style="border: 1px solid black;border-collapse: collapse;">{{ optional($resource->student)->student_balance }}</td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 100%;border-bottom: 1px solid gray" ></div>
                    <br>
                    <div>
                        <b style="font-size: 14px;border-bottom: 1px solid black" >خاص بالشؤن الاجتماعية:</b>
                        <br>
                        <span>{{ $resource->student_affairs_notes }}</span>
                    </div>
                </div>
        </div>
</div>

    <script type="text/javascript" src="{{ url('/js/jquery-3.2.1.min.js') }}" ></script>

    <script type="text/javascript">

    </script>
</body>
</html>
