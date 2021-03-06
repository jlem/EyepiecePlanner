@extends('layouts.app')

@section('content')
    <a href="/eyepiece/create" class="btn btn-primary">Add Eyepiece</a>
    <table width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Focal Length</th>
                <th>Apparent Field</th>
                <th>Discontinued?</th>
            <tr>
        </thead>
        <tbody>
            @foreach($eps as $eyepiece)
                <tr>
                    <td>{{ $eyepiece->getID() }}</td>
                    <td>
                        <a href="/eyepiece/{{ $eyepiece->getID() }}/edit">{{ $eyepiece->getProductName() }}</a>
                    </td>
                    <td>{{ $eyepiece->getFocalLength() }} mm</td>
                    <td>{{ $eyepiece->getApparentField() }}°</td>
                    <td>{{ $eyepiece->isDiscontinued() ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
