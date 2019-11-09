<div class="row">
    <div class="col-md-5">
        <div class="form-group no-margin remove-date">
            <label>Trạng thái</label>
            <select class="form-control select2" id="status" name="status" data-placeholder="All status" onchange="return filter()">
                <option value="-1">Tất cả</option>
                @foreach(\Modules\Orders\Entities\Orders::listStatus() as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
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

    <div class="col-md-3 pull-right">
        <div class="form-group">
            <label style="visibility: hidden">TK</label>
            <button type="submit" class="btn btn-primary btn-block" onclick="return filter()"><span class="glyphicon glyphicon-search" aria-hidden="true" ></span> Search</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="form-group no-margin remove-date">
            <label for="username">Tên khách hàng</label>
            <input class="form-control select2" id="customer_name" name="customer_name" data-placeholder="Tên khách hàng" onchange="return filter()"/>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group no-margin remove-date">
            <label for="username">Số điện thoại</label>
            <input class="form-control select2" id="phone" name="phone" data-placeholder="Số điện thoại" onchange="return filter()"/>
        </div>

    </div>
</div>