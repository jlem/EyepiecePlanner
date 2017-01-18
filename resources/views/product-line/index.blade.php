@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Product Lines
                        <div class="pull-right">
                            <a class="btn btn-primary btn-xs" href="/product-line/create">Add Product Line</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Manufacturer</th>
                                <th>Name</th>
                            </tr>
                            @foreach($productLines as $productLine)
                                <tr>
                                    <td width="25%"><a href="/manufacturer/{{ $productLine->getManufacturer()->getID() }}">{{ $productLine->getManufacturer()->getName() }}</a></td>
                                    <td width="75%">{{ $productLine->getName() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
