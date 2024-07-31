@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Show School Year</h1>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Study:</strong>
                {{ $study->study }}
            </div>
        </div>
    </div>
</div>
@endsection
