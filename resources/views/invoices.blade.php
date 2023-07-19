<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}">
    <title>PDF Invoice</title>
    <style>
        body {font-family: DejaVu Sans, sans-serif;font-size:13px;}
        .container{max-width: 680px; margin:0 auto;}
        .logotype{color:#fff;width:200px;height:75px;  line-height: 75px; text-align: center; font-size:11px;}
        .column-title{background:#eee;text-transform:uppercase;padding:15px 5px 15px 15px;font-size:11px}
        .column-detail{border-top:1px solid #eee;border-bottom:1px solid #eee;}
        .column-header{background:#eee;text-transform:uppercase;padding:3px;font-size:11px;border-right:1px solid #eee;}
        .tdrow{background:#fff; text-align: center;}
        .alert{background: #ffd9e8;padding:20px;margin:20px 0;line-height:22px;color:#333}
        .socialmedia{background:#eee;padding:20px; display:inline-block}
    </style>
</head>
<body onload="window.print()"> 
<div class="container">

    <table width="100%">
        <tr>
            <td width="200px">
                <div class="logotype">
                    <img width="175" src="https://gsstations.ae/wp-content/uploads/2021/08/Grand-Service-Stations_logo-1.svg" alt="" />
                </div>
            </td>
            <td width="300px">
                <div style="background: #fff;border-left: 15px solid #fff;padding-left: 30px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 90px;line-height: 90px;">TAX INVOICE</div>
            </td>
            <td>
                @if($jobInvoiceDetails->payment_status==1)
                <img width="100" src="{{ asset('img/paid-invoice-sticker.png')}}">
                @endif
            </td>
        </tr>
    </table> 
    <br>
  
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td widdth="50%" style="background:#eee;padding:10px;">
                <strong>Grand Service Station (LL.C) (BR)</strong><br>
                Bur Dubai, Satwa<br>
                Tel: 04-3434333, Fax: 04-3431449<br>
                <strong>VAT Reg. No: 100066315100003</strong><br>
            </td>
            <td style="background:#eee;padding:10px;">
                <strong>Job No.: {{$jobInvoiceDetails->job_number}}</strong><br>
                <strong>Job Date: {{ \Carbon\Carbon::parse($jobInvoiceDetails->job_date_time)->format('dS M Y H:i A') }}</strong><br>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
            <table>
                <tr>
                    <td style="vertical-align: text-top;">
                        <div style="background: #ffb60061 url(https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>
                    </td>
                    <td>
                        <strong>{{$jobInvoiceDetails->customerInfo['name']}}</strong><br>
                        Email:{{$jobInvoiceDetails->customerInfo['email']}}<br>
                        Mob: {{$jobInvoiceDetails->customerInfo['mobile']}}9<br>
                        UAE<br>
                        <strong>Customer Type: {{$jobInvoiceDetails->customerInfo['customertype']->description}}</strong><br>
                    </td>
              </tr>
            </table>
          </td>
          <td>
            <table>
              <tr>
                <td style="vertical-align: text-top;">
                  <div style="background: #ffb60061 url(https://www.iconpacks.net/icons/2/free-car-icon-2897-thumb.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>   
                  
                </td>
                <td>
                  <strong>{{$jobInvoiceDetails->customerVehicle['make'].'/'.$jobInvoiceDetails->customerVehicle['model']}}</strong><br>
                  <span class="mb-2 text-xs text-dark font-weight-bold ms-2">{{$jobInvoiceDetails->customerVehicle['plate_state'].'/'.$jobInvoiceDetails->customerVehicle['plate_code'].'/'.$jobInvoiceDetails->customerVehicle['plate_number']}}</span><br>
                  <span class="mb-2 text-xs">Chaisis Number: <span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerVehicle['chassis_number']}}</span></span><br>
                  <span class="mb-2 text-xs">Vehicle KM: <span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerVehicle['vehicle_km']}}</span></span><br>
                  
                </td>
              </tr>
            </table>
          </td>
        </tr>
    </table>
    <table width="100%" style="border-top:0px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">
        <tr>
          <td><h3>Checkout details</h3>
            Payment Methode: <strong>{{config('global.payment.type')[$jobInvoiceDetails->payment_type]}}</strong><br>
        </tr>
    </table>
    
    <table width="100%" style="border-collapse: collapse;border:1px solid #FFF;">
        <tr style="border-bottom: 2px solid #000; ">
            <th class="column-header">Sl No. /<span style="direction: rtl; text-align: right;"> الرقم </span></th>
            <th class="column-header">Description /<span style="direction: rtl; text-align: right;"> الوصف</span></th>
            <th class="column-header">Unit Price Exl /<span style="direction: rtl; text-align: right;"> س</span></th>
            <th class="column-header">Discount % /<span style="direction: rtl; text-align: right;"> خصم</span></th>
            <th class="column-header">Tax % /<span style="direction: rtl; text-align: right;"> الضريبة</span></th>
            <th class="column-header">Quantity /<span style="direction: rtl; text-align: right;"> الكمية</span></th>
            <th class="column-header">Unit Price Incl. /<span style="direction: rtl; text-align: right;"> سع</span></th>
            <th class="column-header">Amount Incl. Vat /<span style="direction: rtl; text-align: right;"> ا</span></th>
        </tr>
        @foreach($jobInvoiceDetails->customerJobServices as $keyno => $customerJobServices)
        <tr>
            <td class="tdrow">{{$keyno+1}}</td>
            <td class="tdrow">{{$customerJobServices->service_type_name}}({{$customerJobServices->service_group_name}})</td>
            <td class="tdrow">{{round($customerJobServices->total_price,2)}}</td>
            <td class="tdrow"></td>
            <td class="tdrow">{{round($customerJobServices->vat,2)}}</td>
            <td class="tdrow">{{$customerJobServices->quantity}}</td>
            <td class="tdrow">{{round(($customerJobServices->total_price+$customerJobServices->vat),2)}}</td>
            <td class="tdrow">{{round(($customerJobServices->total_price+$customerJobServices->vat)*$customerJobServices->quantity,2)}}</td>
        </tr>
        @endforeach
        <tr>
            <td  class="tdrow" colspan="6" align="right" style="text-align:right;">
            <strong>Discount/<span style="direction: rtl; text-align: right;"> الخصم</span></strong>
            </td>
            <td class="tdrow" colspan="2" style="float:right; text-align: right; padding-right: 5px;">
                <strong>0.00</strong>
            </td>
        </tr>
        <tr>
            <td  class="tdrow" colspan="6" align="right" style="text-align:right;">
                <strong>Total Before VAT/<span style="direction: rtl; text-align: right;">المجموغ </span></strong>
            </td>
            <td class="tdrow" colspan="2" style="float:right; text-align: right; padding-right: 5px;">
                <strong>{{round($jobInvoiceDetails->total_price,2)}}</strong>
            </td>
        </tr>
        <tr>
            <td  class="tdrow" colspan="6" align="right" style="text-align:right;">
            <strong>VAT Amount/<span style="direction: rtl; text-align: right;">قيمة الضريبة:</span> </strong>
            </td>
            <td class="tdrow" colspan="2" style="float:right; text-align: right; padding-right: 5px;">
                <strong>{{round($jobInvoiceDetails->vat,2)}}</strong><br>
            </td>
        </tr>
        <tr>
            <td class="tdrow" colspan="6" align="right" style="text-align:right; font-weight:bold;">
            <strong>Net Amount AED/<span style="direction: rtl; text-align: right;">السعر النهايء بالدرهم:</span></strong>
            </td>
            <td class="tdrow" colspan="2" style="float:right; text-align: right; padding-right: 5px; font-size: 14px; font-weight:bold;">
                <strong>{{round($jobInvoiceDetails->total_price,2)}}</strong><br>
            </td>
        </tr>
        <tr style="border-top:1px solid #000; ">
            <td class=""  class="" colspan="2" align="left">
                Cashier Name:
            </td>
            <td class=""  class="" colspan="6" align="left">
                Muhammad Faisal
            </td>
        </tr>
        <tr style="border-bottom:1px solid #000;">
            <td class=""  class="" colspan="2" align="left">
                Printed On /<span style="direction: rtl; text-align: right;"> طبعت بتاريخ</span>
            </td>
            <td class=""  class="" colspan="6" align="left">
                {{ \Carbon\Carbon::parse($jobInvoiceDetails->job_date_time)->format('dS M Y H:i A') }}
            </td>

        </tr>

    </table>
    <table width="100%">
        <tr>
            <td colspan="2" style="font-size:15px; border-bottom: 2px dotted #000; text-align: center;">Dubai, UNited Arab Emirates - P.O.Box 1715 - Tel: +9714 3434333 - Fax: +9714 3431449 - info@gsstations.ae</td>
        </tr>
        <tr>
            <td style="width:50%;">
                Management is not responsible for things left in the car. The above mentioned vehicle has been received in good condition and the receipt has been satisfactorily carried out.
            </td>
            <td style="width:50%;direction: rtl; text-align: right;">
                الإدارة ليست مسؤولة عن الأشياء التي تترك في السيارة. تم استلام السيارة المذكورة أعلاه بحالة جيدة وتم الاستلام بشكل مرضٍ.
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;"><br>Signature............................<span style="direction: rtl; text-align: right;">التوقيع</span></td>
        </tr>
    </table>
</div><!-- container -->
</body>
</html>
