<div class="row">
    <div class="col-md-9">
        <div class="col-md-4">
            <div class="form-group remove-date">
                <label>Tỉnh</label>
                <select class="form-control select2" id="province" name="province_id" onchange="return filterArea($(this).val(),'district', 'province', '{{ old('district_id') }}')">
                    <option value="">--Tất cả--</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" <?php echo ($province->id == old('province_id'))? "selected" : "";?>>{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group no-margin remove-date">
                <label>Tên khách hàng</label>
                <input id="name" name="customer_name" type="text" class="form-control" value="{{ Request::get('name') }}" >
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group no-margin remove-date">
                <label>Ngày tạo</label>
                <div class='input-group date'>
                    <input type='text' class="form-control" id="datetimepicker1" name="published_at"  value="{{ Request::get('published_at') }}" onchange="return filter()" />
                    <label class="input-group-addon btn" for="date">
                        <span class="fa fa-calendar open-datetimepicker"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3 pull-right">
        <div class="form-group">
            <label style="visibility: hidden">TK</label>
            <button type="submit" class="btn btn-primary btn-block" onclick="return filter()"><span class="glyphicon glyphicon-search" aria-hidden="true" ></span> Search</button>
        </div>
    </div>
</div>
