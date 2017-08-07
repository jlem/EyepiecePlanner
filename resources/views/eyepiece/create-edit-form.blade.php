{{ csrf_field() }}


<!-- Product Line Dropdown -->

<div class="form-group{{ $errors->has('product_line_id') ? ' has-error' : '' }}">
    <label for="product_line_id" class="col-md-4 control-label">Product Line</label>

    <div class="col-md-6">
        <select id="product_line_id" name="product_line_id" required>
            <option value="">Please select a product line...</option>
            @foreach($manufacturers as $manufacturer)
                <optgroup label="{{ $manufacturer->getName() }}">
                    @foreach($manufacturer->getProductLines() as $product_line)
                        @if(Session::has('add-eyepiece') && (int)Session::get('add-eyepiece.product_line_id') === $product_line->getID())
                            <option selected="selected" value="{{ $product_line->getID() }}">{{  $manufacturer->getName() . ' ' . $product_line->getName() }}</option>
                        @elseif (isset($eyepiece) && $product_line->getID() === $eyepiece->getProductLine()->getID())
                            <option selected="selected" value="{{ $product_line->getID() }}">{{  $manufacturer->getName() . ' ' . $product_line->getName() }}</option>
                        @else
                            <option value="{{ $product_line->getID() }}">{{  $manufacturer->getName() . ' ' . $product_line->getName() }}</option>
                        @endif
                    @endforeach
                </optgroup>
            @endforeach
        </select>

        @if ($errors->has('product_line_id'))
            <span class="help-block">
                <strong>{{ $errors->first('product_line_id') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Focal Length Input -->

<div class="form-group{{ $errors->has('focal_length') ? ' has-error' : '' }}">
    <label for="focal_length" class="col-md-4 control-label">Focal Length (mm)</label>

    <div class="col-md-6">
        <input autocomplete="off" id="focal_length" type="text" class="form-control" name="focal_length" value="{{ old('focal_length', isset($eyepiece) ? $eyepiece->getFocalLength() : null) }}" required>

        @if ($errors->has('focal_length'))
            <span class="help-block">
                <strong>{{ $errors->first('focal_length') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Apparent Field Input -->

<div class="form-group{{ $errors->has('apparent_field') ? ' has-error' : '' }}">
    <label for="apparent_field" class="col-md-4 control-label">Apparent Field (deg)</label>

    <div class="col-md-6">
        <input autocomplete="off" id="apparent_field" type="text" class="form-control" name="apparent_field" value="{{ old('apparent_field', isset($eyepiece) ? $eyepiece->getApparentField() : Session::get('add-eyepiece.apparent_field')) }}">

        @if ($errors->has('apparent_field'))
            <span class="help-block">
                <strong>{{ $errors->first('apparent_field') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Eye Relief Input -->

<div class="form-group{{ $errors->has('eye_relief') ? ' has-error' : '' }}">
    <label for="eye_relief" class="col-md-4 control-label">Eye Relief (mm)</label>

    <div class="col-md-6">
        <input autocomplete="off" id="eye_relief" type="text" class="form-control" name="eye_relief" value="{{ old('eye_relief', isset($eyepiece) ? $eyepiece->getEyeRelief() : null) }}">

        @if ($errors->has('eye_relief'))
            <span class="help-block">
                <strong>{{ $errors->first('eye_relief') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Field Stop Input -->

<div class="form-group{{ $errors->has('field_stop') ? ' has-error' : '' }}">
    <label for="field_stop" class="col-md-4 control-label">Field Stop (mm)</label>

    <div class="col-md-6">
        <input autocomplete="off" id="field_stop" type="text" class="form-control" name="field_stop" value="{{ old('field_stop', isset($eyepiece) ? $eyepiece->getFieldStop() : null) }}">

        @if ($errors->has('field_stop'))
            <span class="help-block">
                <strong>{{ $errors->first('field_stop') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Barrel Size Input -->

<div class="form-group{{ $errors->has('barrel_size') ? ' has-error' : '' }}">
    <label for="barrel_size" class="col-md-4 control-label">Barrel Size (inches)</label>

    <div class="col-md-6">
        <select id="barrel_size" name="barrel_size" required>
            <option @if(old('barrel_size') === '1.25' || (isset($eyepiece) && $eyepiece->getBarrelSize() === '1.25')) selected="selected" @endif value="1.25">1.25</option>
            <option @if(old('barrel_size') === '1.25 & 2' || (isset($eyepiece) && $eyepiece->getBarrelSize() === '1.25 & 2')) selected="selected" @endif value="1.25 & 2">1.25 & 2</option>
            <option @if(old('barrel_size') === '2' || (isset($eyepiece) && $eyepiece->getBarrelSize() === '2')) selected="selected" @endif value="2">2</option>
            <option @if(old('barrel_size') === '3' || (isset($eyepiece) && $eyepiece->getBarrelSize() === '3')) selected="selected" @endif value="3">3</option>
        </select>

        @if ($errors->has('barrel_size'))
            <span class="help-block">
                <strong>{{ $errors->first('barrel_size') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Price Input -->

<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="col-md-4 control-label">Price ($)</label>

    <div class="col-md-6">
        <input autocomplete="off" id="price" type="text" class="form-control" name="price" value="{{ old('price', isset($eyepiece) ? $eyepiece->getPrice() : null) }}">

        @if ($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
</div>


<!-- Region Input -->

<div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
    <label for="region" class="col-md-4 control-label">Region</label>

    <div class="col-md-6">
        <select id="region" name="region" required>
            @foreach($regions as $value => $label)
                <option @if(old('region') === $value || (isset($eyepiece) && $eyepiece->getRegion() === $value)) selected="selected" @endif value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        @if ($errors->has('region'))
            <span class="help-block">
                <strong>{{ $errors->first('region') }}</strong>
            </span>
        @endif
    </div>
</div>
