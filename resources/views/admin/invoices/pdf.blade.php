<!doctype html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        .page-break {
            page-break-after: always;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: #007bff;
            color: #fff;
            padding: 10px 15px;
            font-size: 18px;
        }

        .card-title {
            display: flex;
            justify-content: space-between;
        }

        .card-body {
            padding: 15px;
        }

        .details-container {
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .info {
            flex: 0 0 33.33%;
            max-width: 33.33%;
            padding: 10px;
            box-sizing: border-box;
        }

        .info .title {
            font-weight: bold;
            margin: 0 5px 0 0;
            color: #333;
        }

        .info .text {
            margin: 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #f8f9fa;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        .price {
            border-bottom: 2px solid #000;
            margin-top: 20px;
            padding-bottom: 10px;
        }

        .price .info {
            width: 33.3%;
            margin-bottom: 10px;
        }

        .price .title,
        .price .text {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    @foreach ($bookings as $booking)
        @if ($booking->invoice)
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span>{{ __('admin.invoice_number') }}: {{ $booking->invoice->invoice_number }}</span>
                            <span>{{ __('main.date') }} : {{ $booking->invoice->created_at }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="info">
                                <p class="title">{{ __('main.company') }} :</p>
                                <p class="text">{{ $booking->company->name }}</p>
                            </div>

                            <div class="info">
                                <p class="title">{{ __('admin.responsible_employee') }} :</p>
                                <p class="text">{{ $booking->employee_name }}</p>
                            </div>

                            <div class="info">
                                <p class="title">{{ __('main.Navigation_line') }} :</p>
                                <p class="text">{{ $booking->shippingAgent->title }}</p>
                            </div>

                            <div class="info">
                                <p class="title">{{ __('admin.booking_number') }} :</p>
                                <p class="text">{{ $booking->booking_number }}</p>
                            </div>

                            <div class="info">
                                <p class="title">{{ __('main.Certificate_Number') }} :</p>
                                <p class="text">{{ $booking->certificate_number }}</p>
                            </div>

                            <div class="info">
                                <p class="title">{{ __('admin.tax_no') }} :</p>
                                <p class="text">{{ $booking->company->tax_no }}</p>
                            </div>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.general_details') }}</th>
                                    <th>{{ __('admin.price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking->bookingContainers as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="details-container">
                                                <div class="info">
                                                    <p class="title">رقم الحاوية :</p>
                                                    <p class="text">{{ $item->container_no }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">مقاس ونوع :</p>
                                                    <p class="text">{{ $item->container->full_name }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">تاريخ :</p>
                                                    <p class="text">{{ $item->arrival_date }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">اسم المصنع :</p>
                                                    <p class="text">{{ $item->branch?->factory->name }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">خروج :</p>
                                                    <p class="text">{{ $item->departure?->title }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">وجهة :</p>
                                                    <p class="text">{{ $item->loading?->title }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">تعتيق :</p>
                                                    <p class="text">{{ $item->aging?->title }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->price }}</td>
                                    </tr>

                                    @if ($key == count($booking->bookingContainers) - 1)
                                        @php
                                            $lastKey = $key + 1;
                                        @endphp
                                    @endif
                                @endforeach

                                @foreach ($booking->bookingServices as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $lastKey }}</td>
                                        <td>
                                            <div class="details-container">
                                                <div class="info">
                                                    <p class="title">الخدمة :</p>
                                                    <p class="text">{{ $item->full_name }}</p>
                                                </div>
                                                <div class="info">
                                                    <p class="title">ملاحظات :</p>
                                                    <p class="text">{{ $item->note }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="price">
                            <div class="info">
                                <p class="title">{{ __('main.Value_added_tax') }} ({{ $booking->invoice->value_added_tax }}%) :</p>
                                <p class="text">{{ $booking->invoice->value_added_tax_amount }}</p>
                            </div>
                            <div class="info">
                                <p class="title">{{ __('main.General_tax') }} ({{ $booking->invoice->sales_tax }}%) :</p>
                                <p class="text">{{ $booking->invoice->sales_tax_amount }}</p>
                            </div>
                            <div class="info">
                                <p class="title">{{ __('main.Total_invoice_before_tax') }} :</p>
                                <p class="text">{{ $booking->invoice->booking->invoice_total_before_tax }}</p>
                            </div>
                            <div class="info">
                                <p class="title">{{ __('main.Total_invoice_after_tax') }} :</p>
                                <p class="text">{{ $booking->invoice->invoice_total_after_tax }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
