{{ csrf_field() }}

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') || isset($telescope) ? $telescope->getName() : null }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('aperture') ? ' has-error' : '' }}">
    <label for="aperture" class="col-md-4 control-label">Aperture (mm)</label>

    <div class="col-md-6">
        <input id="aperture" type="text" class="form-control" name="aperture" value="{{ old('aperture') || isset($telescope) ? $telescope->getAperture() : null }}" required>

        @if ($errors->has('aperture'))
            <span class="help-block">
            <strong>{{ $errors->first('aperture') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('focal_length') ? ' has-error' : '' }}">
    <label for="focal_length" class="col-md-4 control-label">Focal Length (mm)</label>

    <div class="col-md-6">
        <input id="focal_length" type="text" class="form-control" name="focal_length" value="{{ old('focal_length') || isset($telescope) ? $telescope->getFocalLength() : null }}" required>

        @if ($errors->has('focal_length'))
            <span class="help-block">
            <strong>{{ $errors->first('focal_length') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('max_eyepiece_size') ? ' has-error' : '' }}">
    <label for="max_eyepiece_size" class="col-md-4 control-label">Max Supported Eyepiece Size</label>

    <div class="col-md-6">
        <select class="form-control" id="max_eyepiece_size" name="max_eyepiece_size" required>
            <option @if(old('max_eyepiece_size') === '1.25' || (isset($telescope) && $telescope->getMaxEyepieceSize() === '1.25')) selected="selected" @endif value="1.25">1.25"</option>
            <option @if(old('max_eyepiece_size') === '2' || (isset($telescope) && $telescope->getMaxEyepieceSize() === '2')) selected="selected" @endif value="2">2"</option>
            <option @if(old('max_eyepiece_size') === '3' || (isset($telescope) && $telescope->getMaxEyepieceSize() === '3')) selected="selected" @endif value="3">3"</option>
        </select>

        @if ($errors->has('max_eyepiece_size'))
            <span class="help-block">
                <strong>{{ $errors->first('max_eyepiece_size') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            @if (isset($telescope))
                Edit Telescope
            @else
                Add Telescope
            @endif
        </button>
    </div>
</div>
