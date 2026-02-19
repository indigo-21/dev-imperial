<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $purchaseOrder->id }}</title>

    <style>
        @page { margin: 15mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; position: relative; min-height: 100vh; }

        .header { margin-bottom: 20px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        h1 { font-size: 20px; margin: 0 0 5px 0; }

        .section { margin-top: 20px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 5px 0; }

        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th, .items-table td { border: 1px solid #000; padding: 6px; }

        /* Table header colors and alignment */
        .items-table th { 
            text-align: center; 
            background-color: #11e9b6; /* light blue */
        }
        .text-center {
            text-align: center;
        }

        .terms {
            background: #000;
            color: #FFF;
        }

        /* Column alignment */
        .items-table td.qty, .items-table th.qty { text-align: center; }
        .items-table td.ref, .items-table th.ref { text-align: center; }
        .items-table td.description { text-align: left; }
        .items-table td.unit_price, .items-table td.total { text-align: right; }

        /* Sticky footer */
        .footer { 
            position: absolute; 
            bottom: 0; 
            width: 100%; 
            border-top: 1px solid #000; 
            padding: 10px 0;
        }

        /* Grand total styling */
        .grand-total td { font-weight: bold; }

    </style>
</head>
<body>

    {{-- HEADER --}}
    <h2>CONSTRUCTION PURCHASE ORDER - {{ $purchaseOrder->id }}</h2>
    
    <div class="header">

        <table class="header-table" width="100%">
            <tr>
                {{-- Left column: PO Number --}}
                <td style="width:50%; text-align:left; vertical-align:top;">
                    <strong>PO Number:</strong> PO-{{ str_pad($purchaseOrder->id, 5, '0', STR_PAD_LEFT) }}
                    <br>
                    <strong>Supplier:</strong><br>
                    {{ $purchaseOrder->supplier->business_name ?? 'N/A' }}<br>
                    {{ $purchaseOrder->supplier->business_address ?? '' }}<br>
                </td>
        
                <td style="width:50%; vertical-align:top; text-align:right;">
                    {{-- Logo on top --}}
                    <img src="{{ public_path('assets/images/imperial-logo.png') }}" 
                         alt="Logo" 
                         style="height:65px; width:auto; display:block; margin-bottom:5px;">
                        <br>
                
                    {{-- Date & Project Ref under logo --}}
                    <strong>Date:</strong> {{ $purchaseOrder->created_at->format('F d, Y') }}<br>
                    <strong>Project Ref:</strong> {{ $project_reference ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- LINE ITEMS --}}
    <div class="section">
        <strong>Purchase Order Line Items</strong>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="qty">Qty</th>
                    <th class="ref" width="25">Ref</th>
                    <th class="description">Description</th>
                    <th class="unit_price" width="60">Unit Price</th>
                    <th class="total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->po_items as $item)
                <tr>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="ref">{{ $item->item_code }}</td>
                    <td class="description">{{ $item->description }}</td>
                    <td class="unit_price">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="total">{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach

                {{-- Grand Total --}}
                <tr class="grand-total">
                    <td colspan="4" class="text-right">Grand Total</td>
                    <td class="total">{{ number_format($purchaseOrder->po_items->sum('total'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Business:</strong> Imperial Building Solutions Ltd<br>
                    <strong>Address:</strong>  15 Clerkenwell Close, London, EC1R 0AA<br>
                    <strong>Phone:</strong> 0203 375 9075
                </td>
            </tr>
        </table>
    </div>

    <div style="page-break-before: always;"></div>
    <div style = "text-align:right;"> <img src="{{ public_path('assets/images/imperial-logo.png') }}" 
        alt="Logo" 
        style="height:40px; width:auto; display:block;"></div>
   
   <br>
    <div class="terms">
        <h3 style="margin-bottom: 10px; margin-top: -15px;" class="text-center">Terms & Conditions</h3>
    </div>

    <p>
    <i>
    All works executed under this Purchase Order (“PO”) are subject to 
    <strong>Imperial Building Solutions Ltd Subcontract Terms & Conditions</strong>.  
    <br>
    <br>
    By accepting this PO or commencing works, the Subcontractor confirms agreement to the following key terms.
    </i>
    </p>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tbody>
    
            <tr>
                <td width="30" valign="top"><strong>1.</strong></td>
                <td>
                    <strong>Scope of Works</strong><br>
                    The Subcontractor shall carry out and complete the Works described in this PO in accordance with all drawings, specifications, programme and written instructions issued by Imperial.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>2.</strong></td>
                <td>
                    <strong>Subcontract Sum</strong><br>
                    The Subcontract Sum shall be the value stated on this PO and may only be varied by written instruction from Imperial.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>3.</strong></td>
                <td>
                    <strong>Payment</strong><br>
                    Payment shall be made by interim valuations every 4 weeks, commencing from the Project Start Date and continuing until Practical Completion of the Subcontractor’s Works.
                    <ul style="margin: 5px 0 5px 15px;">
                        <li>Valuations to be submitted every 4 weeks</li>
                        <li>Payment Due Date: Date of valuation submission</li>
                        <li>Final Date for Payment: 30 days from Due Date</li>
                        <li>Imperial may issue a Pay Less Notice up to 5 days before the Final Date for Payment</li>
                    </ul>
                    A 5% retention applies to all payments (2.5% released at Practical Completion, 2.5% upon expiry of the Defects Liability Period).
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>4.</strong></td>
                <td>
                    <strong>Programme</strong><br>
                    The Subcontractor shall comply with the project programme and shall not cause delay or disruption.
                    Imperial reserves the right to recover losses caused by subcontractor delay.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>5.</strong></td>
                <td>
                    <strong>Variations</strong><br>
                    No variation shall be valid unless instructed in writing by Imperial.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>6.</strong></td>
                <td>
                    <strong>Health & Safety</strong><br>
                    The Subcontractor shall comply fully with CDM Regulations and Imperial’s Construction Phase Plan and site safety procedures.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>7.</strong></td>
                <td>
                    <strong>Insurance</strong><br>
                    The Subcontractor must maintain:
                    <ul style="margin: 5px 0 5px 15px;">
                        <li>Public Liability: £10,000,000</li>
                        <li>Employers Liability: £10,000,000</li>
                        <li>Professional Indemnity (if design): £5,000,000</li>
                    </ul>
                    Evidence to be provided on request.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>8.</strong></td>
                <td>
                    <strong>Defects</strong><br>
                    A 6-month Defects Liability Period applies.
                    All defects due to workmanship, materials or design shall be rectified at the Subcontractor’s cost.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>9.</strong></td>
                <td>
                    <strong>Termination</strong><br>
                    Imperial may terminate the subcontract for breach, delay, safety failure or insolvency.
                </td>
            </tr>
    
            <tr>
                <td valign="top"><strong>10.</strong></td>
                <td>
                    <strong>Dispute Resolution</strong><br>
                    Disputes shall be referred to Adjudication (RICS or TECSA) under the Scheme for Construction Contracts and governed by the laws of England & Wales.
                </td>
            </tr>

          
        </tbody>
    </table>
    

    <p><i>  All works are governed by Imperial Building Solutions Ltd Subcontract Terms & Conditions. Acceptance or commencement of works constitutes
        full agreement </i> </p>        

</body>
</html>
