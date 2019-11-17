<tr>
        <td>#{{ $index }}</td>
        <td>
            <select class="form-control select2" required name="category[]" id="type_{{ strtotime('now') . $index }}"
                onchange="return filterProduct($(this).val(), '{{ strtotime('now') . $index }}')">
                <option value="">--Chọn loại sp--</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->cate_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control select2" required name="product_id[]" id="product_id_{{ strtotime('now') . $index }}"
                onchange="return filterSize('{{ strtotime('now') . $index }}')">
                <option value="">--Chọn sản phẩm--</option>
            </select>
        </td>
        <td>
            <select class="form-control select2" required name="size[]" id="size_{{ strtotime('now') . $index }}"
            onchange="return filterColor('{{ strtotime('now') . $index }}')">
                <option value="">--Kích cỡ--</option>
            </select>
        </td>
        <td>
            <select class="form-control select2" required name="color[]" id="color_{{ strtotime('now') . $index }}">
                <option value="">--Màu sắc--</option>
            </select>
        </td>
        <td id="amount">
            <input type="number" id="amount_{{ strtotime('now') . $index }}" value="1" min="1" name="amount[]" max="9" required onchange="return changeAmount('{{ strtotime('now') . $index }}')">
        </td>
        <td id="sell_price_{{ strtotime('now') . $index }}">
            <input type="hidden" id="price_hidden_{{ strtotime('now') . $index }}">
            <span>0</span>
        </td>
        <td id="tt_{{ strtotime('now') . $index }}">
                <input type="hidden" id="tt_hidden_{{ strtotime('now') . $index }}">
                <span>0</span>
            </td>

        {{-- <td id="sum_price_{{ strtotime('now') . $index }}">0</td> --}}
        <td id="td-{{ strtotime('now') . $index }}">
            <button type="button" class="btn btn-danger btn-xs" onclick="deleteRow($(this))"><i
                    class="fa fa-minus">Xoá</i></button>
        </td>
    </tr>