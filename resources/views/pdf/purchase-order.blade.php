<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $purchaseOrder->id }}</title>

    <style>
        @page { margin: 20mm; }
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
            background-color: #cce5ff; /* light blue */
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
    <h1>CONSTRUCTION PURCHASE ORDER - {{ $purchaseOrder->id }}</h1>
    
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
                         style="height:50px; width:auto; display:block; margin-bottom:5px;">
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

</body>
</html>
