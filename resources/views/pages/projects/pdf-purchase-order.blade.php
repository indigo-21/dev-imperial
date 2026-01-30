<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order</title>

    <style>
        @page { margin: 20mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
        .header { margin-bottom: 20px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        h1 { font-size: 20px; margin: 0 0 5px 0; }
        .section { margin-top: 20px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 5px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th, .items-table td { border: 1px solid #000; padding: 6px; }
        .items-table th { background: #f2f2f2; text-align: left; }
        .text-right { text-align: right; }
        .footer { margin-top: 40px; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <h1>CONSTRUCTION PURCHASE ORDER</h1>
                    <strong>PO Number:</strong> PO-00001<br>
                </td>
                <td class="text-right">
                    <strong>Date:</strong> January 30, 2026<br>
                    <strong>Project Ref:</strong> PRJ-001
                </td>
            </tr>
        </table>
    </div>

    {{-- SUPPLIER & META --}}
    <div class="section">
        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Supplier</strong><br>
                    Sample Supplier Co.<br>
                    123 Supplier Street, City<br>
                    supplier@example.com
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
                    <th width="60">Qty</th>
                    <th width="60">Ref</th>
                    <th>Description</th>
                    <th width="100">Unit Price</th>
                    <th width="100">Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- Static sample items with Ref --}}
                <tr>
                    <td class="text-right">2</td>
                    <td>5.01</td>
                    <td>Sample description for item 001</td>
                    <td class="text-right">£100.00</td>
                    <td class="text-right">£200.00</td>
                </tr>
                <tr>
                    <td class="text-right">3</td>
                    <td>5.02</td>
                    <td>Sample description for item 002</td>
                    <td class="text-right">£150.00</td>
                    <td class="text-right">£450.00</td>
                </tr>
                <tr>
                    <td class="text-right">1</td>
                    <td>5.03</td>
                    <td>Sample description for item 003</td>
                    <td class="text-right">£250.00</td>
                    <td class="text-right">£250.00</td>
                </tr>

                <tr>
                    <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                    <td class="text-right"><strong>£900.00</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <table class="info-table">
            <tr>
                 {{-- SUPPLIER & META --}}
                <div class="section">
                    <table class="info-table">
                        <tr>
                            <td width="50%">
                                <strong>Business:</strong> Imperial Building Solutions Ltd<br>
                                <strong>Name:</strong> Danny Hakimi - 07946581842<br>
                                <strong>Address:</strong> 5 Chancery Lane, London, EC4A 1BL<br>
                                <strong>Phone:</strong> 0203 375 9075
 
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
        </table>
    </div>

</body>
</html>
