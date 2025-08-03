@php
$shipping_details = "<br>";
$totalAmt = 0;
$paidAmt = 0;
$dueAmt = 0;

$shipping_details .= 'الاسم الكامل: ' . ($fullName ?? 'غير متوفر') . '<br>';
$shipping_details .= 'رقم الهاتف: ' . ($phoneNo ?? 'غير متوفر') . '<br>';
@endphp


@foreach ($orders as $order)
    <table border="1" cellspacing="0" cellpadding="15" style="width:100%; margin:20px 0;direction:rtl;text-align:right;">
        <thead>
            <tr>
                <th>{{translate('م')}}</th>
                <th>{{translate('رقم الحجز')}}</th>
                <th>{{translate('الخدمة')}}</th>
                <th>{{translate('التاريخ والوقت')}}</th>
                <th>{{translate('السعر')}}</th>
                <th>{{translate('المبلغ المدفوع')}}</th>
                <th>{{translate('المبلغ المستحق')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->serviceBookinges as $key => $details)
                @php
                    $totalAmt += $details->service_amount;
                    $paidAmt += $details->paid_amount;
                    $dueAmt += $details->due ?? ($details->service_amount - $details->paid_amount);
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $details->id }}</td>
                    <td>{{ $details->name ?? 'الخدمة' }}</td>
                    <td>
                        {{ $details->pivot->date ?? '—' }}<br>
                        @if(!empty($details->pivot->start_time))
                            من {{ \Carbon\Carbon::parse($details->pivot->start_time)->format('h:i A') }}<br>
                            إلى {{ \Carbon\Carbon::parse($details->pivot->end_time)->format('h:i A') }}
                        @endif
                    </td>
                  
                    <td>{{ $details->service_amount }}</td>
                    <td>{{ $details->paid_amount }}</td>
                    <td>{{ $details->due ?? ($details->service_amount - $details->paid_amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

<div style="width:100%;float:right;">
    <div style="float:right;width:100%;text-align:right;padding-top:10px;">{{translate('إجمالي المبلغ')}}: {{round($totalAmt,2)}}</div>
    <div style="float:right;width:100%;text-align:right;padding-top:10px;">{{translate('الخصم')}}: {{round($orders[0]->coupon_discount ?? 0,2)}}</div>
    <div style="float:right;width:100%;text-align:right;padding-top:10px;">{{translate('المبلغ المستحق بعد الخصم')}}: {{round($totalAmt - ($orders[0]->coupon_discount ?? 0),2)}}</div>
    <div style="float:right;width:100%;text-align:right;padding-top:10px;">{{translate('المبلغ المدفوع')}}: {{round($paidAmt,2)}}</div>
    <div style="float:right;width:100%;text-align:right;padding-top:10px;">{{translate('باقي')}}: {{round(($totalAmt - ($orders[0]->coupon_discount ?? 0)) - $paidAmt,2)}}</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    window.onload = function () {
        var element = document.getElementById('invoice-container');
        var opt = {
            margin:       0.5,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().from(element).set(opt).outputPdf('bloburl').then(function (pdfUrl) {
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = pdfUrl;
            document.body.appendChild(iframe);
            iframe.onload = function () {
                iframe.contentWindow.print();
            };
        });
    };
</script>

