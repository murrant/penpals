@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @error('error')
    <script>
        toastr.error('{{ $message }}')
    </script>
    @enderror

    <form action="{{ route('address-request.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row justify-content-center">
            <div class="form-group col-md-6 col-sm-10">
                <label for="proof">Proof of previous letters</label>
                <input type="file" class="form-control-file {{ $errors->has('proof') ? 'is-invalid' : ''}}" name="proof" id="proof" placeholder="Image" aria-describedby="fileHelpId">
                <small id="fileHelpId" class="form-text text-muted">Add an image of previously sent letters or other proof.</small>
                <div class="invalid-feedback">
                    {{ $errors->first('proof') }}
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-6 col-sm-10">
                <label for="amount">Number of addresses</label>
                <input type="number"
                       class="form-control" name="amount" id="amount" aria-describedby="amount-help" value="10">
                <small id="amount-help" class="form-text text-muted {{ $errors->has('amount') ? 'is-invalid' : ''}}">Amount of new addresses, may not be the amount you receive.</small>
                <div class="invalid-feedback">
                    {{ $errors->first('amount') }}
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-6 col-sm-10">
                <label for="note">Note to Moderator</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : ''}}" name="note" id="note" rows="3"></textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('note') }}
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-6 col-sm-10 align-self-center">
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </form>
@endsection
