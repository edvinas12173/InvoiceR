@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Add a Invoice
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-dark float-right">Back</a>
        </div>
        <form action="{{ route('invoices.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer</label>
                                <select name="customer_id" class="form-control">
                                    <option selected>Choose...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Invoice Date</label>
                                <input name="invoice_date" type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Invoice No.</label>
                                <input name="invoice_no" type="text" class="form-control" value="INV-****" readonly>
                            </div>
                            <div class="form-group">
                                <label>Due date</label>
                                <select name="invoice_due_date" class="form-control">
                                    <option selected>Choose...</option>
                                    <option value="{{ \Carbon\Carbon::now()->addDay(15)->format('Y-m-d') }}">After 15 days</option>
                                    <option value="{{ \Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}">After 1 month</option>
                                    <option value="{{ \Carbon\Carbon::now()->addMonth(2)->format('Y-m-d') }}">After 2 months</option>
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
                                    <tr id='addr0'>
                                        <td>
                                            1
                                        </td>
                                        <td>
                                            <input type="text" name='product[]'  placeholder='Enter Product Name' class="form-control"/>
                                        </td>
                                        <td>
                                            <input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/>
                                        </td>
                                        <td>
                                            <input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/>
                                        </td>
                                        <td>
                                            <input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/>
                                        </td>
                                    </tr>
                                    <tr id='addr1'>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <a id="add_row" class="btn btn-sm btn-primary float-left">Add Row</a>
                            <a id='delete_row' class="btn btn-sm btn-danger float-right">Delete Row</a>
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
                                            <div class="input-group mb-2 mb-sm-0">
                                                <input name="tax_percent" type="number" class="form-control" id="tax" min="0" placeholder="0" aria-describedby="basic-addon">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
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
            var i=1;
            $("#add_row").click(function(){b=i-1;
                $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
                $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
                i++;
            });
            $("#delete_row").click(function(){
                if(i>1){
                    $("#addr"+(i-1)).html('');
                    i--;
                }
                calc();
            });

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
