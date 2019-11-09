<div id="addCat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div id="alert-cat-add"></div>
        <!-- Modal content-->
        <form class="form-horizontal" id="form-add-cat">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm danh mục</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Tên danh mục (*)</label>
                        <div class="col-sm-10">
                            <input name="name"  type="text" value="{{ old('name') }}" class="form-control" placeholder="Nhập vào tên danh mục" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Tên trên URL (*)</label>
                        <div class="col-sm-10">
                            <input name="slug" id="prefix" type="text" value="{{ old('prefix') }}" class="form-control slug" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Danh muc cha (*)</label>
                        <div class="col-sm-10">
                            <select id="parent_cat" name="parent_id" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Ảnh cover</label>
                        <div class="col-sm-10">
                            <input name="cover" value="{{ old('cover') }}" type="text" class="form-control" placeholder="Nhập vào link ảnh cover">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Mô tả</label>
                        <div class="col-sm-10">
                            <textarea name="summary" class="form-control" placeholder="Nhập vào mô tả">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Vị trí</label>
                        <div class="col-sm-10">
                            <input name="position" type="number" value="{{ !empty(old('position')) ? old('position') : 0 }}" class="form-control" placeholder="Nhập vào thứ tự hiển thị">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>
            </div>
        </form>
    </div>
</div>