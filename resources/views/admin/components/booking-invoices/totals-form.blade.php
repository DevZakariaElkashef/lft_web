@if ($method == 'POST')
    {!! Form::open(['url' => $action, 'method' => $method, 'enctype' => 'multipart/form-data', 'files' => true]) !!}
@elseif ($method == 'PUT')
    {!! Form::model($invoice, [
        'url' => [$action],
        'method' => $method,
        'enctype' => 'multipart/form-data',
        'files' => true,
    ]) !!}
@endif


{{-- ================== ================== ====== ================== ================== --}}
{{-- ================== ================== TOTALS ================== ================== --}}
{{-- ================== ================== ====== ================== ================== --}}


<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h2>
                {{ __('admin.totals') }}
            </h2>
        </div>
    </div>
    <div class="card-body">
        {{-- ================== ================== INVOICE TOTALS ================== ================== --}}
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h4>{{ __('admin.transportation_total') }}</h4>
                <h4>{{ $transportation_total }}</h4>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h4>{{ __('admin.taxed_service_total') }}</h4>
                <h4>{{ $taxed_services_total }}</h4>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h4>{{ __('admin.invoice_total') }}</h4>
                <h4>{{ $transportation_total + $taxed_services_total }}</h4>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group{{ $errors->has('value_added_tax') ? ' has-error' : '' }}">
                    {!! Form::label('value_added_tax', __('admin.value_added_tax')) !!}
                    {!! Form::number('value_added_tax', old('value_added_tax', 0), [
                        'class' => 'form-control',
                        'required' => 'required',
                    ]) !!}
                    <small class="text-danger">{{ $errors->first('value_added_tax') }}</small>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group{{ $errors->has('sales_tax') ? ' has-error' : '' }}">
                    {!! Form::label('sales_tax', __('admin.sales_tax')) !!}
                    {!! Form::number('sales_tax', old('sales_tax', 0), ['class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('sales_tax') }}</small>
                </div>
            </div>
            <div class="col-sm-12">
                <h4>{{ __('admin.invoice_total_after_tax') }}</h4>
                <h4 id="invoice_total_after_tax"></h4>
            </div>
        </div>
        {{-- ================== ================== END INVOICE TOTALS ================== ================== --}}

        <hr size="12" width="95%">

        {{-- ================== ================== ATTACHMENT TOTALS ================== ================== --}}
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h4>{{ __('admin.attachments_total') }}</h4>
                <h4></h4>
            </div>
        </div>
        {{-- ================== ================== END ATTACHMENT TOTALS ================== ================== --}}

        <hr size="12" width="95%">

        {{-- ================== ================== REQUIRED TO BE PAID TOTAL ================== ================== --}}
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h4>{{ __('admin.required_to_be_paid') }}</h4>
                <h4 id="required_to_be_paid"></h4>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                    {!! Form::label('discount', __('admin.discount')) !!}
                    {!! Form::number('discount', old('discount', 0), ['class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('discount') }}</small>
                </div>
            </div>
            <div class="col-sm-12">
                <h4>{{ __('admin.required_to_be_paid_after_discount') }}</h4>
                <h4 id="required_to_be_paid_after_discount"></h4>
            </div>
        </div>
    </div>
    {{-- ================== ================== END BILL TOTAL ================== ================== --}}
</div>

{{-- ================== ================== ================ ================== ================== --}}
{{-- ================== ================== END TOTALS ================== ================== --}}
{{-- ================== ================== ================ ================== ================== --}}


{{-- ================== ================== SUBMIT BUTTON ================== ================== --}}
<div class="card-footer">
    @if ($method == 'POST')
        {!! Form::submit(__('admin.save'), [
            'class' => 'btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6',
        ]) !!}
    @elseif ($method == 'PUT')
        {!! Form::submit(__('admin.update'), ['class' => 'btn btn-primary']) !!}
    @endif
</div>
{{-- ================== ================== END SUBMIT BUTTON ================== ================== --}}

</form>
{!! Form::close() !!}
<!-- /.card-body -->
@push('js')
    <script>
        function getInvoiceTotalAfterTax() {
            // setting variables
            var invoice_total_before_tax = {{ $transportation_total + $taxed_services_total }};
            var value_added_tax = $('#value_added_tax').val() || 0;
            var sales_tax = $('#sales_tax').val() || 0;

            // setting defaults
            if (!value_added_tax) value_added_tax = 0;
            if (!sales_tax) sales_tax = 0;

            // calculations
            var tax_amount =
                invoice_total_before_tax * (
                    value_added_tax / 100 -
                    sales_tax / 100
                );
            return invoice_total_before_tax + tax_amount;
        }

        function updateInvoiceTotalAfterTax() {


            $('#invoice_total_after_tax').text(

                (getInvoiceTotalAfterTax()).toLocaleString(
                    'en-US', {
                        minimumFractionDigits: 2
                    })

            );
            updateRequiredToBePaidBeforeDiscount();
        }
        updateInvoiceTotalAfterTax();
        $('#value_added_tax').on('change', updateInvoiceTotalAfterTax);
        $('#sales_tax').on('change', updateInvoiceTotalAfterTax);


        function getBillable() {
            var invoice_total_after_tax = getInvoiceTotalAfterTax();
            var untaxed_services_total = {{ $untaxed_services_total }};
            return invoice_total_after_tax + untaxed_services_total;
        }

        function updateRequiredToBePaidBeforeDiscount() {
            $('#required_to_be_paid').text(

                (getBillable()).toLocaleString(
                    'en-US', {
                        minimumFractionDigits: 2
                    })

            );
            updateTotalBillableAfterDiscount();
        }
        updateRequiredToBePaidBeforeDiscount();

        function getBillableAfterDiscount() {
            var required_to_be_paid = getBillable();
            var discount = $('#discount').val() || 0;
            var discount_amount = required_to_be_paid * (discount / 100);
            return required_to_be_paid - discount_amount;
        }

        function updateTotalBillableAfterDiscount() {
            $('#required_to_be_paid_after_discount').text(

                (getBillableAfterDiscount()).toLocaleString(
                    'en-US', {
                        minimumFractionDigits: 2
                    })

            );
        }
        updateTotalBillableAfterDiscount();
        $('#discount').on('change', updateTotalBillableAfterDiscount);
    </script>
@endpush
