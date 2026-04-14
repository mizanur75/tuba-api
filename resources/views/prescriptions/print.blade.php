<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "SolaimanLipi", sans-serif;
            font-size: 14px;
        }

        .prescription {
            width: 1000px;
            margin: auto;
            border: 1px solid #999;
            page-break-inside: avoid;
        }

        /* HEADER */
        .top-header {
            padding: 10px;
            border-bottom: 2px solid #2e7d32;
        }

        .hospital-name {
            color: #2e7d32;
            font-size: 26px;
            font-weight: bold;
        }

        .doctor-info {
            text-align: right;
        }

        .green-badge {
            background: #2e7d32;
            color: #fff;
            padding: 3px 12px;
            border-radius: 15px;
            font-size: 13px;
            display: inline-block;
        }

        /* PATIENT BAR */
        .patient-bar {
            border-top: 1px solid #2e7d32;
            border-bottom: 1px solid #2e7d32;
            padding: 5px 10px;
            font-size: 13px;
        }

        /* BODY */
        .left-box {
            border-right: 1px solid #2e7d32;
            padding: 10px;
            min-height: 600px;
        }

        .right-box {
            padding: 10px;
            min-height: 600px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            border-bottom: 1px solid #ccc;
        }

        .rx {
            font-size: 28px;
            font-weight: bold;
        }

        .medicine {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .medicine small {
            display: block;
            margin-left: 20px;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        @media print {

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .prescription {
                width: 100% !important;
                border: 1px solid #999 !important;
            }

            .top-header {
                border-bottom: 2px solid #2e7d32 !important;
            }

            .patient-bar {
                border-top: 1px solid #2e7d32 !important;
                border-bottom: 1px solid #2e7d32 !important;
            }

            .left-box {
                border-right: 1px solid #2e7d32 !important;
            }

            .no-print {
                display: none !important;
            }

            .row {
                display: flex !important;
            }

            .col-md-4 {
                width: 33.33% !important;
                float: left;
            }

            .col-md-8 {
                width: 66.66% !important;
                float: left;
            }
        }
    </style>
</head>

<body>

<div class="text-center my-2 no-print">
    <button onclick="window.print()" class="btn btn-dark">🖨 Print</button>
</div>

<div class="prescription">

    <!-- HEADER -->
    <div class="top-header d-flex justify-content-between align-items-center">

        <div>
            <div class="hospital-name">Dip Hospital</div>
            <div>ঠিকানা: Dhaka</div>
            <div>মোবাইল: 01642134702</div>
        </div>

        <div class="text-center">
            <div class="green-badge">রোগী দেখার সময়ঃ</div>
            <div>Monday, Tuesday, Thursday, Friday (4pm-8pm)</div>
            <div>সিরিয়ালের জন্যঃ 01710472020</div>
        </div>

        <div class="doctor-info">
            <strong>Demo Doctor</strong><br>
            MBBS (Reg: A-123456)<br>
            Specialist in Medicine
        </div>

    </div>

    <!-- PATIENT INFO BAR -->
    <div class="patient-bar d-flex justify-content-between flex-wrap">
        <div>Name: {{ $history->patient_name }}</div>
        <div>Age: 30 Y</div>
        <div>Sex: Male</div>
        <div>Addr: Dhaka</div>
        <div>PT. ID: {{ $history->id }}</div>
        <div>Date: {{ date('d M Y') }}</div>
    </div>

    <div class="row g-0">

        <!-- LEFT -->
        <div class="col-md-4 left-box">

            <div class="section-title">Chief Complaint:</div>
            @php
            $complaints = json_decode($history->chief_complaint, true);
            @endphp

            <ul>
            @foreach($complaints as $c)
                <li>{{ $c }}</li>
            @endforeach
            </ul>

            <div class="section-title">Diagnosis:</div>
            <p>{{ $history->diagnosis }}</p>

        </div>

        <!-- RIGHT -->
        <div class="col-md-8 right-box">

            <div class="rx">R<sub>x</sub></div>

            @foreach($history->prescriptions as $key => $item)
                <div class="medicine">
                    <strong>{{ $key+1 }}. Tab.</strong>
                    {{ $item->medicine_name }}

                    <small>
                        • {{ $item->dose }} — {{ $item->duration }}
                    </small>
                </div>
            @endforeach

            <!-- Advice -->
            <div class="mt-4">
                <strong>উপদেশ:</strong>
                <ul>
                    <li>{{ $history->advice }}</li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div></div>

                <div>
                    <div>__________________</div>
                    <strong>Signature</strong><br><br>

                    <strong>Demo Doctor</strong><br>
                    MBBS<br>
                    Specialist in Medicine<br>
                    BM&DC Reg. No: A-123456
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>