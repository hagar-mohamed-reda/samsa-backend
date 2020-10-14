<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>ايصال رقم {{ $payment->id }}</title>
</head>
<body> 
    @php
        $copies = 1;
        $service = null;
        if ($payment->model_type == 'service')
            $service = \Modules\Account\Entities\Service::find($payment->model_id);

        if ($service) {
            if ($service->type == 'in')
                $copies = 2;
        }     @endphp
    @for($count = 0; $count < $copies; $count ++)
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
                <div style="width: 100%;border-bottom: 2px dashed black;margin: auto" ></div>
                <br>
                    @if ($count == 0)
                <div style="width: 100%;text-align: center" >
                    <b style="font-size: 16px" >رقم القسيمة</b>

                        <span id="paymentId" >{{ $payment->id }}</span>
                </div>
                @else
                <br>
                    @endif
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
                               <span class="payment-value" >{{ number_format($payment->value) }}</span> جنيه
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;padding: 5px" >
                              <b>ســــــداد عن :</b>
                            </td>
                            <td style="width: 60%;padding: 5px" >
                                @if ($payment->about)
                                    {{ $payment->about }}
                                @endif 

                                @if ($payment->model_type == 'old_academic_year_expense')
                                رسوم سابقة . {{ optional($payment->student)->old_balance_notes }}
                                @elseif($payment->model_type == 'service')
                                @php
                                    $service = \Modules\Account\Entities\Service::find($payment->model_id);

                                @endphp
                                خدمة {{ optional($service)->name }} - عدد النسخ {{ $payment->service_count }}
                                @elseif($payment->model_type == 'installment')
                                @php
                                    $installment = \Modules\Account\Entities\Installment::find($payment->installment_id);

                                @endphp
                                قسط
                                 ({{ optional($installment)->type == "new"? 'رسوم حاليه' : 'رسوم سابقه' . ' - ' . optional($payment->student)->old_balance_notes }})
                                @elseif($payment->model_type == 'refund')
                                @php
                                    $payment = \Modules\Account\Entities\Payment::find($payment->model_id);

                                @endphp
                                رد رسوم عن قسيمة رقم ({{ optional($payment)->id }}) 
                                @else 
                                 @if (!$payment->is_pr)
                                    {{ optional($payment->model_object)->name }}
                                @endif
                                @endif
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
                                    <span class="payment-value" >{{ number_format($payment->value) }}</span>
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
                                {{ optional($payment->user)->name }}
                            </div>
                    </td>
                </tr>
            </table>
    </div>
</div>
    <br>  
    @endfor

    <script type="text/javascript" src="{{ url('/js/jquery-3.2.1.min.js') }}" ></script>
    <script type="text/javascript" src="{{ url('/js/tafgeetjs.min.js') }}" ></script>

    <script type="text/javascript"> 

        $('.payment-value').each(function(){
            $(this).html(new Tafgeet($(this).text(), 'EGP').parse());
        });  
        if (confirm('يتم طباعة الوصل برقم ' + {{ $payment->id }})) {
            window.print();
        } else {
            var id = prompt('اعد ادخال رقم القسيمة');

            if (!id)
                id = prompt('اعد ادخال رقم القسيمة');
            
            document.getElementById('paymentId').innerHTML = id;
            window.print();
        }
        
    </script>
</body>
</html>
