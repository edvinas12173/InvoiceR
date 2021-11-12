@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit a Invoice
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <form action="{{ route('invoices.update', $invoice->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer</label>
                                <select name="customer_id" class="form-control">
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{$customer->id == $invoice->customer->id  ? 'selected' : ''}}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Invoice Date</label>
                                <input name="invoice_date" type="text" class="form-control" value="{{ $invoice->invoice_date }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Invoice No.</label>
                                <input name="invoice_no" type="text" class="form-control" value="{{ $invoice->invoice_no }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Due date <small class="font-weight-bold">(After created date)</small></label>
                                <select name="invoice_due_date" class="form-control">
                                    @foreach($days as $day)
                                        <option
                                            value="{{ \Carbon\Carbon::parse($invoice->invoice_date)->addDay($day->day)->format('Y-m-d') }}"
                                            {{\Carbon\Carbon::parse( $invoice->invoice_date )->diffInDays( $invoice->invoice_due_date) == $day->day  ? 'selected' : ''}}>
                                            After {{ $day->day }} days
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Payment status</label>
                                <select name="status" class="form-control">
                                    <option value="Paid" {{$invoice->status == 'Paid'  ? 'selected' : ''}}>Paid</option >
                                    <option value="Unpaid" {{$invoice->status == 'Unpaid'  ? 'selected' : ''}}>Unpaid</option >
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="tab_logic">
                                    <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td hidden>
                                                <input type="text" name="id[]" value="{{$item->id}}">
                                            </td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                <input type="text" name='product[]'  placeholder='Enter Product Name' value="{{ $item->name }}"  class="form-control"/>
                                            </td>
                                            <td>
                                                <input type="number" name='qty[]' placeholder='Enter Qty' value="{{ $item->quantity }}" class="form-control qty" step="0" min="0"/>
                                            </td>
                                            <td>
                                                <input type="number" name='price[]' placeholder='Enter Unit Price' value="{{ $item->price }}"  class="form-control price" step="0.00" min="0"/>
                                            </td>
                                            <td>
                                                <input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix pt-4">
                        <div class="col-md-12">
                            <div class="col-md-5 float-right">
                                <table class="table table-bordered table-hover" id="tab_logic_total">
                                    <tbody>
                                    <tr>
                                        <th class="text-center">Sub Total</th>
                                        <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Tax</th>
                                        <td class="text-center">
                                            <select name="tax_percent" id="tax" class="form-control">
                                                @foreach($taxs as $tax)
                                                    <option value="{{ $tax->tax_percent }}" {{$tax->tax_percent == $invoice->tax_percent  ? 'selected' : ''}}>{{ $tax->tax_percent }} %</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Tax Amount</th>
                                        <td class="text-center">
                                            <input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Grand Total</th>
                                        <td class="text-center">
                                            <input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success float-right">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('#tab_logic tbody').on('keyup change',function(){
                calc();
            });
            $('#tax').on('keyup change',function(){
                calc_total();
            });
        });

        function calc()
        {
            $('#tab_logic tbody tr').each(function(i, element) {
                var html = $(this).html();
                if(html!='')
                {
                    var qty = $(this).find('.qty').val();
                    var price = $(this).find('.price').val();
                    $(this).find('.total').val(qty*price);
                    calc_total();
                }
            });
        }

        function calc_total()
        {
            total=0;
            $('.total').each(function() {
                total += parseInt($(this).val());
            });
            $('#sub_total').val(total.toFixed(2));
            tax_sum=total/100*$('#tax').val();
            $('#tax_amount').val(tax_sum.toFixed(2));
            $('#total_amount').val((tax_sum+total).toFixed(2));
        }
    </script>
@endsection
