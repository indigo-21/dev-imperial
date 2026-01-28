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
                        @foreach ($cost_plan as $section )  
                            @if ($section->for_adjudication == "1")
                                @php
                                    $number_of_items = floatval($section->items->count());
                                    // $section_markup = 0;
                                    $section_rate = 0;
                                    $section_cost = 0;
                                    $section_total = 0;

                                    foreach ($section->items as $key => $item) {
                                        // $section_markup += floatval($item->mark_up);
                                        $section_rate += floatval($item->rate);
                                        $section_cost += floatval($item->cost);
                                        $section_total += floatval($item->total);
                                    }
                                    
                                    // $section_markup_amount = $section_total - $section_cost;
                                    // $average_markup = ($section_markup /$number_of_items );
                                    // $section_profit = $section_cost * ($average_markup / 100);

                                    $section_profit = $section_total - $section_cost;
                                    $section_markup = ($section_profit / $section_cost) * 100;
                                    $average_markup = ($section_markup /$number_of_items );
                                    $gross_profit = ($section_profit / $section_total) * 100    ;
                                    
                                    
                                @endphp  
                                <tr>
                                    <td>{{$section->section_code}}</td>
                                    <td>{{$section->section_name}}</td>
                                    <td class="text-right">{{ number_format($section_cost, 2, '.', ',') }}</td>
                                    <td class="text-right">{{ round($section_markup) }}%</td>
                                    <td class="text-right">{{ number_format($section_profit, 2, '.', ',') }}</td>
                                    <td class="text-right"> {{ round($gross_profit) }}% </td>
                                    <td class="text-right">{{number_format($section_total, 2, '.', ',') }}</td>
                                    <td class="text-center">
                                        <button 
                                            class="btn btn-sm btn-outline-primary view-purchase-order mr-3"  
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="text-right">5,800.00</td>
                                    <td class="text-center">                                       
                                         <button 
                                            class="btn btn-sm btn-outline-primary view-invoice-order mr-3"  
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="text-right">0.00</td>
                                </tr>
                            @endif
                        @endforeach

                        <!-- CONTINGENCY -->
                        <tr>
                            <td colspan="7"><strong>CONTINGENCY</strong></td>
                            <td colspan="4" class="text-right">
                                <strong>0.00</strong>
                            </td>
                        </tr>

                        <!-- BUILD TOTAL -->
                        <tr class="table-success">
                            <td colspan="7"><strong>Build Total ex. VAT</strong>
                            </td>
                            <td></td>
                            <td class="text-right"><strong>0.00</strong></td>
                            <td></td>
                            <td class="text-right"><strong>0.00</strong></td>
                        </tr>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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


@section("modal")
    <!-- Modal -->
    <div class="modal fade" id="purchaseOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="purchaseOrderModalTitle">List of Purchase Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        
                    </tr>
                </thead>

            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
@endsection

@section("scripts") 
        <script src="{{ asset('assets/custom/js/pages/projects/tabs/adjudication.js') }}"></script>
@endsection