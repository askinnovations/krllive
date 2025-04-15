<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khandelwal Roadlines LR</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f7f7f7;
            color: #17356e;
        }

        .container {
            max-width: 1000px;
            margin: auto;

            padding: 10px;
            background-color: #fff;
            position: relative;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .bill-section {
            width: 74%;
        }

        .freight-section {
            width: 25%;
        }

        .left-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .left-header img {
            height: auto;
            margin-right: 10px;
        }

        .left-header-content {
            flex: 1;
        }

        .left-header-content p,
        .left-header-content small {
            margin: 0;
            font-size: 14px;
        }

        .coly {
            /* border: 2px solid #002366; */
            padding: 5px;
            font-size: 14px;
            /* background-color: #eef2ff; */
            width: 220px;
            margin-left: 10px;
        }

        .coly strong {
            display: block;
            text-align: center;
            margin-bottom: 4px;
            font-size: 12px;
            color: #e90a0a;
        }

        .right-header {
            width: 100%;
            font-size: 14px;
            border: 2px solid #002366;
            padding: 5px;
            margin-top: 10px;
        }

        .right-header p {
            margin: 4px 0;
        }

        h1 {
            color: red;
            font-size: 20px;
            margin: 5px 0;
        }

        .notice {
            border: 2px solid #002366;
            margin: 10px 0;
            padding: 6px;
            font-size: 14px;
            /* background-color: #eef2ff; */
        }

        .notice label {
            margin-right: 10px;
        }

        .consignor-consignee {
            display: flex;
            justify-content: space-between;
            border: 2px solid #002366;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            gap: 10px;
        }

        .consignor-consignee .box {
            width: 49%;
            border: 1px solid #002366;
            padding: 10px;
            box-sizing: border-box;
            min-height: 150px;
        }

        .consignor-consignee .box p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 10px;
        }

        td,
        th {
            border: 2px solid #002366;
            padding: 4px;
        }

        .freight-box {
            width: 100%;
            border: 2px solid #002366;
            font-size: 14px;
            background: #f9f9f9;
            margin-top: 12px;
        }

        .freight-box h4 {
            margin: 0;
            padding: 5px;
            text-align: center;
            border-bottom: 2px solid #002366;
            background-color: snow;
            font-size: 16px;
        }

        .freight-box .section {
            display: flex;
            justify-content: space-between;
            padding: 4px;
            border-bottom: 2px solid #002366;
        }

        .e-way {
            font-size: 14px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #002366;
        }

        .signature {
            text-align: right;
            font-size: 14px;
            margin-top: 20px;
            font-weight: bold;
        }

        .terms {
            margin-top: 40px;
            font-size: 16px;
            padding: 35px 70px;
            /* border: 2px solid #002366; */
            width: 1000px;
            margin: auto;
            background: #fff;
            margin-top: 13px;
        }

        .terms h3 {
            text-align: center;

            margin-bottom: 10px;
            font-size: 24px;
            padding-bottom: 18px;
        }

        .terms ol {
            padding-left: 20px;
            line-height: 1.6;
        }

        .terms li {
            padding-bottom: 10px;
        }

        .print-btn {

            padding: 12px 28px;
            background-color: #ca2639;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
            z-index: 1000;
            margin: auto;
            margin-top: 2%;
            margin-bottom: 1%;
            text-align: center;
            display: block;
        }

        .print-btn:hover {
            background-color: #a71f2e;
        }

        .tr1 {
            border-bottom: 2px solid #002366;
            width: 67%;
            text-align: center;
            margin: auto;
            margin-top: 4%;
            padding-bottom: 5px;
        }

        .tr2 {
            font-weight: 600 !important;
            font-size: 16px !important;
            color: inherit !important;
        }

        .pan {
            border: 2px solid #002366;
            text-align: center;
            padding: 5px;
        }

        .consignor-consignee-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .consignor-consignee-table td {
      border: 2px solid #002366;
      padding: 0;
      vertical-align: top;
      width: 50%;
    }

    .section-wrapper {
      padding: 10px;
    }

    .section-heading {
      /* background-color: #e6f0ff; */
      color: #002366;
      font-weight: bold;
      padding: 8px 10px;
      border-bottom: 2px solid #002366;
    }

    .address-line {
      padding: 4px 10px;
    }
    .date{
        font-size: 16px;
    border-bottom: 2px solid;
    padding-bottom: 11px !important;
    margin-bottom: 13px !important;
    }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
<!-- @php
    $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
@endphp -->
    <div class="container">
        <div class="header-section">
            <div class="bill-section">
                <div class="left-header">

                    <div class="left-header-content">
                    <img src="{{ asset('backend/images/logo.jpg') }}" alt="logo" style="width: 100%;">
                        

                        <p>Head Office:  Khandelwal RoadLines, Opp. Abhinav Talkies, Ujjain Road, Dewas - 455001  </p>
                        <small>MOBILE – 9098733332, 9770533332</small><br>
                        <small>Offices - Mumbai: 9326145500, Indore: 9303188889</small><br>
                        <small>Email: krl@khandelwalroadlines.com</small><br>
                        <small>Website: www.khandelwalroadlines.com</small>
                    </div>
                    <div class="coly">

                        <strong class="tr1">CONSIGNEE COPY</strong>
                        <strong class="tr2">AT OWNER’S RISK</strong>
                        <div class="pan">
                            <div class="gst"> GSTIN / Transporter Id
                                for EWAY Bill 23AABFM6400F1ZX</div>
                            <div class="pan2"><strong>PAN:</strong> AABFM6400F</div>
                        </div>

                    </div>
                </div>



                <div class="notice" style="display: flex; gap: 12px;  font-size: 14px; align-items: stretch;">
                    <div style="align-self: center;">
                        <p style="margin: 0; font-weight: bold;">GST to be paid by</p>
                    </div>
                    <div style="display: flex; flex-direction: column; justify-content: space-between;">
                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox">
                            Consignor</label>
                        <span style="font-weight: bold; text-align: center;">OR</span>
                        <label style="display: flex; align-items: center; gap: 4px;"><input type="checkbox">
                            Consignee</label>
                    </div>

                    <span style="margin-left: auto; align-self: center; text-align: center !important;">
                        We are registered as GTA under sec 9 (3) of GST act 2017 & GST is 
                        liable to pay by recipient (consignor / consignee) under RCM 
                        notification No. 13/2017 CTR dated 28/06/2017 
                    </span>
                </div>

                <div>
                @php
    if (!function_exists('cleanAddress')) {
        function cleanAddress($address) {
            $clean = preg_replace('/(Address:\s*)+/i', '', $address);
            $clean = preg_replace('/,+/', ',', $clean);
            return trim($clean, ', ');
        }
    }

    $lr = $lrEntries; // a single LR entry
    $consignorUser = \App\Models\User::find($lr['consignor_id'] ?? null);
    $consigneeUser = \App\Models\User::find($lr['consignee_id'] ?? null);
@endphp

<table class="consignor-consignee-table">
    <tr>
        {{-- CONSIGNOR --}}
        <td>
            <div class="section-heading">CONSIGNOR'S NAME & ADDRESS</div>
            <div class="address-line">• {{ $consignorUser->name ?? '-' }}</div>
            <div class="address-line">
                {{ isset($lr['consignor_loading']) ? cleanAddress($lr['consignor_loading']) : '-' }}
            </div>
            <div class="address-line">GSTIN - {{ $lr['consignor_gst'] ?? '-' }}</div>
        </td>

        {{-- CONSIGNEE --}}
        <td>
            <div class="section-heading">CONSIGNEE'S NAME & ADDRESS</div>
            <div class="address-line">• {{ $consigneeUser->name ?? '-' }}</div>
            <div class="address-line">
                {{ isset($lr['consignee_unloading']) ? cleanAddress($lr['consignee_unloading']) : '-' }}
            </div>
            <div class="address-line">GSTIN - {{ $lr['consignee_gst'] ?? '-' }}</div>
        </td>
    </tr>
</table>

                    
                </div>

                <table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
    <thead>
        <tr>
            <th rowspan="2">No. of Packages</th>
            <th rowspan="2">Method of Packing</th>
            <th rowspan="2">Description Said to contain</th>
            <th colspan="2">Weight</th>
        </tr>
        <tr>
            <th>Actual Weight</th>
            <th>Charged Weight</th>
        </tr>
    </thead>
    <tbody>
    
    @foreach($lrEntries['cargo'] as $cargo)
    @php
        // Check if at least one field is filled
        $isValid = !empty($cargo['packages_no']) || !empty($cargo['package_type']) || !empty($cargo['package_description']) || !empty($cargo['actual_weight']) || !empty($cargo['charged_weight']);
    @endphp

    @if($isValid)
        <tr>
            <td>{{ $cargo['packages_no'] ?? '' }}</td>
            <td>{{ $cargo['package_type'] ?? '' }}</td>
            <td>{{ $cargo['package_description'] ?? '' }}</td>
            <td>{{ $cargo['actual_weight'] ?? '' }}</td>
            <td>{{ $cargo['charged_weight'] ?? '' }}</td>
        </tr>
    @endif
@endforeach

</tbody>

</table>


@php
    if (!function_exists('toArray')) {
        function toArray($value) {
            return is_array($value) ? $value : json_decode($value, true);
        }
    }

    $ewayBills = toArray($order->eway_bill ?? []);
    $validUpto = toArray($order->valid_upto ?? []);
    $declaredValue = $order->declared_value ?? '__________';
@endphp

<div class="e-way" style="margin-top: 20px; font-size: 16px;">
    @for ($i = 0; $i < max(count($ewayBills), count($validUpto)); $i++)
        <p style="margin-bottom: 8px;">
            <strong>E-WAY BILL NO:</strong> {{ $ewayBills[$i] ?? '__________' }} &nbsp;&nbsp;&nbsp;
            <strong>VALID UPTO:</strong> {{ $validUpto[$i] ?? '__________' }}
        </p>
    @endfor

    @php
    $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
@endphp

@php
    $lr = $lrEntries; // Single LR Entry already set from controller
@endphp

<p style="margin-top: 10px;">
    <strong>Declared Value Rs.</strong> {{ $lr['declared_value'] ?? '-' }}
</p>

</div>

            </div>

            <div class="freight-section">
                <div class="right-header">
                @php
    // Use single LR entry directly
    $lr = $lrEntries;

    // Find vehicle details
    $vehicle = collect($vehicles)->firstWhere('id', $lr['vehicle_id'] ?? null);
@endphp

<p><strong>L.R. No:</strong> {{ $lr['lr_number'] ?? '-' }}</p>

<p class="date" style="font-size: 16px;">
    <strong>Dated:</strong> {{ $lr['lr_date'] ?? '-' }}
</p>

<p><strong>Vehicle:</strong> {{ $vehicle->vehicle_no ?? 'N/A' }}</p>

<p><strong>Vehicle Type:</strong> {{ $vehicle->vehicle_type ?? 'N/A' }}</p>

<p><strong>Delivery Mode:</strong> {{ $lr['delivery_mode'] ?? 'N/A' }}</p>

<p><strong>From:</strong> {{ $lr['from_location'] ?? '-' }}</p>

<p><strong>To:</strong> {{ $lr['to_location'] ?? '-' }}</p>

<hr>



                </div>
                <div class="freight-box">
                <h4>FREIGHT</h4>

                @php
    $lr = $lrEntries; // Already a single LR entry
@endphp

<div class="section">
    <label><input type="checkbox" {{ ($lr['freight_type'] ?? '') == 'PAID' ? 'checked' : '' }}> PAID</label>
    <label><input type="checkbox" {{ ($lr['freight_type'] ?? '') == 'TO PAY' ? 'checked' : '' }}> TO PAY</label>
    <label><input type="checkbox" {{ ($lr['freight_type'] ?? '') == 'TO BE BILLED' ? 'checked' : '' }}> TO BE BILLED</label>
</div>

<div class="section"><span>FREIGHT</span> <span>{{ $lr['freight_amount'] ?? '-' }}</span></div>
<div class="section"><span>LR CHARGES</span> <span>{{ $lr['lr_charges'] ?? '-' }}</span></div>
<div class="section"><span>HAMALI</span> <span>{{ $lr['hamali'] ?? '-' }}</span></div>
<div class="section"><span>OTHER CHARGES</span> <span>{{ $lr['other_charges'] ?? '-' }}</span></div>
<div class="section"><span>GST</span> <span>{{ $lr['gst_amount'] ?? '-' }}</span></div>
<div class="section"><span>TOTAL FREIGHT</span> <span>{{ $lr['total_freight'] ?? '-' }}</span></div>
<div class="section"><span>LESS ADVANCE</span> <span>{{ $lr['less_advance'] ?? '-' }}</span></div>
<div class="section"><span>BALANCE FREIGHT</span> <span>{{ $lr['balance_freight'] ?? '-' }}</span></div>


                </div>
            </div>
        </div>

        <div class="signature">
            For: KHANDELWAL ROADLINES
        </div>

    </div>


    <div class="terms">
        <h3>TERMS & CONDITIONS</h3>
        <ol>
            <li>The company does not take responsibility for leakage, breakage, shortage or damage by rain, sun or
                weather and sender is responsible for proper packing.</li>
            <li>Fresh fruits are to be arrived at the risk of the consignor or consignee as they are apparently to
                be spoiled on the way.</li>
            <li>The company will send goods at earliest. Goods may be sent in one lot or parts, according to
                convenience.</li>
            <li>The goods will be delivered to the consignee or his agent against payment of all charges.</li>
            <li>The goods will be delivered at destination – company’s godown, only unless settled otherwise in
                writing.</li>
            <li>The delivery of the goods will have to be taken within seven days after its arrival at destination.
                Failing to the same will be liable to demurrage of Rs. 100/- per ton per day or Rs. 100/- per
                package per day and will be stored at owner’s risk.</li>
            <li>If there is any claim on a/c of this goods receipt, the same shall have to be informed within
                fifteen days, failing to same will be considered as no claim.</li>
            <li>The company takes absolutely no responsibility for delays or losses due to accident, strikes, fire
                or any other causes beyond our control and due to breakdown of vehicle en route and for the
                consequences thereof.</li>
            <li>Once the delivery is given against a receipt, no claim will be entertained after that.</li>
            <li>If any govt. authority assesses the goods wrongly, company will not be responsible for such faults
                and claim if any shall be made on such items from govt. authority themselves, is to be paid by
                consignee or consignor as the case may be.</li>
        </ol>
    </div>

    <!-- Print Button -->
  <button class="print-btn" onclick="window.print()">🖨️ Print LR-Consignment</button>


</body>

</html>