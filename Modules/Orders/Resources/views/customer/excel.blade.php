
<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th>Mã khách hàng</th>
        <th>Tên khách hàng</th>
        <th>Loại khách hàng</th>
        <th>Số điện thoại</th>
        <th>Tỉnh</th>
        <th>Địa chỉ</th>
        <th>Ngày tạo</th>
    </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>#{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ ($customer->type == 1) ? "Công ty" : "Cá nhân" }}</td>
                <td>{{ $customer->mobile }}</td>
                <td>{{ $customer->province_name }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


