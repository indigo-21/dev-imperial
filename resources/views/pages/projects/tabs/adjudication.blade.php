@extends('pages.projects.form')
@section("adjudication-tab")
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <strong>SUMMARY SHEET</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Section</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Mark Up</th>
                            <th class="text-right">Profit</th>
                            <th class="text-right">Gross Profit %</th>
                            <th class="text-right">Total ex. VAT</th>
                            <th>PO Number</th>
                            <th class="text-right">PO Amount</th>
                            <th>Invoice Ref</th>
                            <th class="text-right">Inv Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.00</td>
                            <td>DECONSTRUCT / STRIP OUT</td>
                            <td class="text-right">6,000.00</td>
                            <td class="text-right">900.00</td>
                            <td class="text-right">900.00</td>
                            <td class="text-right">15%</td>
                            <td class="text-right">6,900.00</td>
                            <td>PO-001</td>
                            <td class="text-right">5,800.00</td>
                            <td>INV-001</td>
                            <td class="text-right">6,900.00</td>
                        </tr>

                        <tr>
                            <td>2.00</td>
                            <td>SUBFLOOR</td>
                            <td class="text-right">5,800.00</td>
                            <td class="text-right">870.00</td>
                            <td class="text-right">870.00</td>
                            <td class="text-right">15%</td>
                            <td class="text-right">6,670.00</td>
                            <td>PO-002</td>
                            <td class="text-right">5,600.00</td>
                            <td>INV-002</td>
                            <td class="text-right">6,670.00</td>
                        </tr>

                        <tr>
                            <td>3.00</td>
                            <td>CEILINGS</td>
                            <td class="text-right">6,200.00</td>
                            <td class="text-right">1,240.00</td>
                            <td class="text-right">1,240.00</td>
                            <td class="text-right">20%</td>
                            <td class="text-right">7,440.00</td>
                            <td>PO-003</td>
                            <td class="text-right">6,000.00</td>
                            <td>INV-003</td>
                            <td class="text-right">7,440.00</td>
                        </tr>

                        <tr>
                            <td>4.00</td>
                            <td>PARTITIONS</td>
                            <td class="text-right">6,500.00</td>
                            <td class="text-right">975.00</td>
                            <td class="text-right">975.00</td>
                            <td class="text-right">15%</td>
                            <td class="text-right">7,475.00</td>
                            <td>PO-004</td>
                            <td class="text-right">6,200.00</td>
                            <td>INV-004</td>
                            <td class="text-right">7,475.00</td>
                        </tr>

                        <!-- CONTINGENCY -->
                        <tr>
                            <td colspan="7"><strong>CONTINGENCY</strong></td>
                            <td colspan="4" class="text-right">
                                <strong>1,200.00</strong>
                            </td>
                        </tr>

                        <!-- BUILD TOTAL -->
                        <tr class="table-success">
                            <td colspan="7"><strong>Build Total ex. VAT</strong>
                            </td>
                            <td></td>
                            <td class="text-right"><strong>26,000.00</strong></td>
                            <td></td>
                            <td class="text-right"><strong>29,960.00</strong></td>
                        </tr>

                        <!-- VARIATIONS -->
                        <tr>
                            <td colspan="11"><strong>Variations</strong></td>
                        </tr>

                        <tr>
                            <td colspan="2">VO01 POST CONTRACT VARIATIONS</td>
                            <td class="text-right">6,000.00</td>
                            <td class="text-right">900.00</td>
                            <td class="text-right">900.00</td>
                            <td class="text-right">15%</td>
                            <td class="text-right">6,900.00</td>
                            <td>PO-005</td>
                            <td class="text-right">5,800.00</td>
                            <td>INV-005</td>
                            <td class="text-right">6,900.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
