<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>

    <x-slot name="pageTitle">
        Invoice - Receipts
    </x-slot>

    <x-slot name="content">
    <div class="row">
        {{-- Upload Form --}}
        <div class="col-12">
            <div class="card card-primary card-outline mb-4">

                <div class="card-header">
                    <h3 class="card-title">Add Payment Receipt</h3>
                </div>

                <div class="card-body">
                <form action="{{ route('invoices.store', $purchaseOrderItem->id) }}" method="POST" >
                    @csrf
                    <div class="col-md-6">
                        {{-- File Description --}}
                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input type="text" name="invoice_number" id="invoice_number" class="form-control"
                                placeholder="Enter Invoice Number">
                            <span class="text-danger error">{{$errors->first('invoice_number')}}</span>
                        </div>
                        <div class="form-group">
                            <label for="invoice_amount">Receipt Amount</label>
                            <input type="text" name="invoice_amount" id="invoice_amount" class="form-control"
                                placeholder="Enter Receipt Amount">
                            <span class="text-danger error">{{$errors->first('invoice_amount')}}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
    
                        {{-- Buttons --}}
                        <div class="form-group mt-3">
                            <button type="reset" class="btn btn-outline-secondary form-btn-cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary ml-2" >Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- Document List Table --}}
        <div class="col-md-12">
            <h5 class="mb-3 text-center"><strong>Uploaded Payments</strong></h5>
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th>Invoice Number</th>
                        <th >Receipt Amount</th>
                        <th >Added By</th>
                        <th >Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($invoices) > 0)
                        @foreach ($invoices as $invoice )
                            <tr >
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ number_format($invoice->invoice_amount, 2) }}</td>
                                <td>{{ $invoice->created_user->firstname}} {{ $invoice->created_user->lastname}}</td>
                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <td colspan="6" class="text-center">No Data Result...</td>
                            </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-slot>

@section("scripts")
        <script src="{{ asset('assets/custom/js/pages/projects/tabs/project-file.js') }}"></script>
@endsection


</x-app-layout>
