@if ($method == 'POST')
    {!! Form::open(['url' => $action, 'method' => $method, 'enctype' => 'multipart/form-data', 'files' => true]) !!}
@elseif ($method == 'PUT')
    {!! Form::model($bank, [
        'url' => [$action],
        'method' => $method,
        'enctype' => 'multipart/form-data',
        'files' => true,
    ]) !!}
@endif
<div class="card-body">
    <div class="row justify-content-center me-3">

        <div class="col-12">
            <div class="form-group">
                <label for="name">{{ __('main.operation_name') }}</label>
                <input id="name" value="{{ isset($bank) ? (old('name') ?? $bank->name) :old('name') }}" class="form-control" type="text" name="name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="amount">{{ __('main.amount') }}</label>
                <input id="amount" value="{{ isset($bank) ? (old('amount') ?? $bank->amount) :old('amount') }}" class="form-control" type="number" name="amount">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="type">{{ __('admin.type') }}</label>
                <select id="type"  class="form-control" name="type">
                    <option value="0" @if(old('type') == 0 || (isset($bank) && $bank->type == 0)) selected @endif>{{ __("main.debit") }}</option>
                    <option value="1" @if(old('type') == 1 || (isset($bank) && $bank->type == 1)) selected @endif>{{ __("main.credit") }}</option>
                </select>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="note">{{ __('admin.note') }}</label>
                <textarea id="note"  class="form-control" name="note">
                    {{ isset($bank) ? (old('note') ?? $bank->note) :old('note') }}
                </textarea>
                @error('note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <div class="row ">

        @if ($method == 'POST')
            {!! Form::submit(__('admin.save'), [
                'class' => 'btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6',
            ]) !!}
        @elseif ($method == 'PUT')
            {!! Form::submit(__('admin.update'), ['class' => 'btn btn-primary']) !!}
        @endif
    </div>
</div>

</form>
{!! Form::close() !!}
<!-- /.bankd-body -->
