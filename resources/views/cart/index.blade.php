@extends('layouts.app')

@section('title', '购物车列表')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">我的购物车</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>商品信息</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="product_list">
                        @foreach($cartItems as $item)
                            <tr data-id="{{ $item->productSku->id }}">
                                <td>
                                    <input type="checkbox" name="select"
                                           value="{{ $item->productSku->id }}" {{ $item->productSku->product->on_sale ? 'checked' : 'disabled' }}>
                                </td>
                                <td class="product_info">
                                    <div class="preview">
                                        <a target="_blank"
                                           href="{{ route('products.show', [$item->productSku->product_id]) }}">
                                            <img alt="" src="{{ $item->productSku->product->image_url }}">
                                        </a>
                                    </div>
                                    <div @if(!$item->productSku->product->on_sale) class="not_on_sale" @endif>
              <span class="product_title">
                <a target="_blank"
                   href="{{ route('products.show', [$item->productSku->product_id]) }}">{{ $item->productSku->product->title }}</a>
              </span>
                                        <span class="sku_title">{{ $item->productSku->title }}</span>
                                        @if(!$item->productSku->product->on_sale)
                                            <span class="warning">该商品已下架</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="price">￥{{ $item->productSku->price }}</span></td>
                                <td>
                                    <input type="text" class="form-control form-control-sm amount"
                                           @if(!$item->productSku->product->on_sale) disabled @endif name="amount"
                                           value="{{ $item->amount }}">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-remove"
                                            data-href="{{ route('cart.remove',[$item->id]) }}">移除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>
                        <form class="form-horizontal" role="form" id="order-form">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-3 text-md-right">选择收货地址</label>
                                <div class="col-sm-9 col-md-7">
                                    <select class="form-control" name="address">
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->full_address }} {{ $address->contact_name }} {{ $address->contact_phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-3 text-md-right">备注</label>
                                <div class="col-sm-9 col-md-7">
                                    <textarea name="remark" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="offset-sm-3 col-sm-3">
                                    <button type="button" class="btn btn-primary btn-create-order">提交订单</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        $(function () {
            //移除购物车商品
            $('.btn-remove').click(function () {
                var href = $(this).data('href');

                swal({
                    title: '确定移除吗？',
                    icon: 'warning',
                    buttons: ['取消', '确定'],
                    dangerMode: true
                }).then(function (willDelete) {
                    if (!willDelete) {
                        return;
                    }
                    axios.delete(href).then(function () {
                        location.reload();
                    })
                })
            });

            //全选
            $('#select-all').change(function () {
                var checked = $(this).prop('checked');

                $('.product_list input[type=checkbox]:not([disabled])').each(function () {
                    $(this).prop('checked', checked);
                })
            });

            //提交订单
            $('.btn-create-order').click(function () {
                var $form = $('#order-form');
                var req = {
                    address_id: $form.find('select[name=address]').val(),
                    remark: $form.find('textarea[name=remark]').val(),
                    items: [],
                };

                $('table tr[data-id]').each(function () {
                    // 获取当前行的单选框
                    var $checkbox = $(this).find('input[name=select][type=checkbox]');
                    // 如果单选框被禁用或者没有被选中则跳过
                    if ($checkbox.prop('disabled') || !$checkbox.prop('checked')) {
                        return;
                    }
                    // 获取当前行中数量输入框
                    var $input = $(this).find('input[name=amount]');
                    // 如果用户将数量设为 0 或者不是一个数字，则也跳过
                    if ($input.val() == 0 || isNaN($input.val())) {
                        return;
                    }

                    req.items.push({
                        sku_id: $(this).data('id'),
                        amount: $input.val(),
                    })
                });
                axios.post('{{ route('orders.store') }}', req)
                    .then(function (response) {
                        swal('订单提交成功', '', 'success');
                    }, function (error) {
                        if (error.response.status === 422) {
                            // http 状态码为 422 代表用户输入校验失败
                            var html = '<div>';
                            _.each(error.response.data.errors, function (errors) {
                                _.each(errors, function (error) {
                                    html += error + '<br>';
                                })
                            });
                            html += '</div>';
                            swal({content: $(html)[0], icon: 'error'})
                        } else {
                            // 其他情况应该是系统挂了
                            swal('系统错误', '', 'error');
                        }
                    });

            })

        });
    </script>
@endsection