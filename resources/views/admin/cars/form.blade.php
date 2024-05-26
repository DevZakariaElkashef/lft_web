@if($method == 'POST')
    {!! Form::open(['url' => $action, 'method' => $method, 'enctype'=>'multipart/form-data', 'files' => true]) !!}
@elseif ($method == 'PUT')
    {!! Form::model($car, ['url' => [$action], 'method'=>$method , 'enctype'=>'multipart/form-data', 'files' => true]) !!}
@endif
        <div class="card-body">
            <div class="row">
                <!-- For loop this div -->
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        {!! Form::label("input_name", __('admin.car_number')) !!}
                        {!! Form::text('car_number' , old('car_number'), ["class" => "form-control", "id" => "input_name", "placeholder"=> __('admin.car_number')]) !!}
                        @error('car_number')
                            <small class="aleart text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    .<div class="form-group">
                        <label for="walletInput">{{ __('admin.wallet') }}</label>
                        <input id="walletInput" class="form-control" type="number" name="wallet" value="{{ isset($car) ? (old('wallet') ?? $car->wallet) : old('wallet') }}">
                    </div>
                </div>
                <!-- For loop this div -->

             

        
             
            </div>
        </div>

        <div class="card-footer">
            @if($method == 'POST')
                    {!! Form::submit(__('admin.save'), ["class"=>"btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6"]) !!}
                @elseif ($method == 'PUT')
                    {!! Form::submit(__('admin.update'), ["class"=>"btn btn-primary"]) !!}
                @endif
        </div>

</form>
{!! Form::close() !!}
<!-- /.card-body -->

