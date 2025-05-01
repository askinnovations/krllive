<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Freight Bill</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 20px;
      font-family: 'Segoe UI', sans-serif;
      background: #f2f2f2;
    }

    .print-btn {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .print-btn:hover {
      background-color: #0056b3;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: #fff;
      padding: 20px 25px;
      /* border-radius: 8px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.15); */
    }

    .title {
      text-align: center;
      font-weight: bold;
      font-size: 22px;
      margin-bottom: 20px;
      text-transform: uppercase;
      border-bottom: 2px solid #000;
      padding-bottom: 8px;
    }

    .section {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      margin-bottom: 15px;
    }

    .box {
      border: 1px solid #ccc;
      padding: 12px;
      /* border-radius: 6px; */
      background-color: #fcfcfc;
    }

    .left-box {
      flex: 1.5;
    }

    .right-box {
      flex: 1;
    }

    .half-box {
      flex: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14 px;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #888;
      padding: 6px;
      text-align: center;
    }

    th {
      background-color: #f0f0f0;
    }

    .total-in-words {
      margin-top: 15px;
      font-weight: 600;
    }

    .footer-section {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      margin-top: 25px;
    }

    .terms {
      flex: 1.5;
      border: 1px solid #000;
      padding: 12px;
      /* border-radius: 6px; */
    }

    .gst-box {
      flex: 1;
      border: 1px solid #000;
      padding: 12px;
      /* border-radius: 6px; */
    }

    .gst-box strong {
      display: block;
      margin-bottom: 8px;
    }

    .grand-total {
      margin-top: 12px;
      text-align: right;
      font-weight: bold;
      font-size: 16px;
      border-top: 2px solid #000;
      padding-top: 8px;
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
    }

    .print-btn:hover {
      background-color: #a71f2e;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }

    th {
      background-color: #fff;
    }
  </style>
</head>

<body>



  <div class="container">
    <div class="title">FREIGHT BILL – SINGLE LR OR MULTIPLE LR</div>

    <div class="section">
      <div class="box left-box">
        <strong>BILL TO / CONSIGNMENT SENT TO:</strong><br>
        [Party Name & Address Here]<br>
        <strong>Freight Type:</strong> {{ $order->order_method }}
      </div>
      <div class="box right-box">
        <strong>Bill No.:</strong>{{ $freightBill->freight_bill_number ?? '-' }}<br>
        <strong>Date:</strong>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}
      </div>
    </div>


    @foreach ($matchedEntries as $entry)
    <div class="section">
      <div class="box half-box">
        <strong>From:</strong><br>
        {{ $entry['destination'] }}
      </div>

      <div class="box half-box">
        <strong>To:</strong><br>
        {{ $entry['destination'] }}
      </div>
    </div>
  @endforeach


    

<table id="freightTable" class="table table-bordered">
  <thead>
      <tr>
          <th>S. No.</th>
          <th>LR No.</th>
          <th>LR Date</th>
          <th>Particulars</th>
          <th>Freight Type</th>
          <th>Weight / Quantity</th>
          <th>Rate</th>
          <th>Amount</th>
      </tr>
  </thead>
  <tbody>
  @foreach($matchedEntries as $index => $entry)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $entry['lr_number'] }}</td>
        <td>{{ \Carbon\Carbon::parse($entry['lr_date'])->format('Y-m-d') }}</td>
        <td>{{ $entry['cargo'][0]['package_description'] ?? '-' }}</td>
        <td>{{ $entry['freight_type'] ?? '-' }}</td>
        <td>{{ $entry['cargo'][0]['weight'] ?? '-' }}</td>
        <td>{{ $entry['rate'] ?? '-' }}</td>
        <td>{{ $entry['amount'] ?? '-' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>


    <div class="total-in-words">
      Total in Words: ____________________________________________
    </div>
    <form action="" method="POST">
      
    @csrf
    @method('PUT')
    <div class="footer-section">
      <div class="terms">
        <strong>Terms & Conditions:</strong><br>
        1. Payment due within 15 days.<br>
        2. Goods transported at owner's risk.<br>
        3. Subject to jurisdiction of Indore court.<br>
        4. No liability for delays due to unforeseen events.
        5. <textarea
              name="notes"
              class="form-control"
              rows="3"
              placeholder="Enter your custom note here…"
          >{{ old('notes', $firstBill->notes) }}</textarea>
      </div>

      <div class="gst-box">
        <strong>GST Breakdown:</strong>
        IGST @ 12%: ₹ _______<br>
        CGST @ 6%: ₹ _______<br>
        SGST @ 6%: ₹ _______

        <div class="grand-total">
          GRAND TOTAL: ₹ ____________
        </div>
      </div>
    </div>

  </div>
  <button class="print-btn">Update Freight Bill</button>
</form>
</body>

</html>