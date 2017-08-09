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
                        @foreach($manufacturers as $manufacturer)
                            <h2 class="manufacturer-name">
                                <a href="/manufacturer/{{ $manufacturer->getID() }}">{{ $manufacturer->getName() }}</a>
                            </h2>
                            @foreach($manufacturer->getProductLines() as $productLine)
                                <div>
                                    <a href="/product-line/{{ $productLine->getID() }}">{{ $productLine->getName() }}</a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
