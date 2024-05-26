@extends('layouts.layoutmaster')
@section('content')
<form action="{{ route('scheduling_form.delete') }}" method="DELETE">
    @csrf

    <button type="submit" class="btn btn-danger">Xóa toàn bộ giỏ hàng</button>
</form>
@endsection